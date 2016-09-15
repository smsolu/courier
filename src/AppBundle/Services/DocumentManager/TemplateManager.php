<?php
namespace AppBundle\Services\DocumentManager;
use PhpOffice\PhpWord\TemplateProcessor;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use AppBundle\Entity\ExpedienteDocumento;
use AppBundle\Entity\ExpedienteDocumentoFile;
use DateTime;//HACER: chequear esto
/**
 * Se encarga de administrar las plantillas y crear documentos en base a las mismas
 *
 * @author Niko
 */
class TemplateManager {
    private $estudio;
    private $user;
    private $em;
    private $fsm;
    private $templateFolder = 'templates';
    private $documentFolder = 'documents';
    
    public function __construct($entityManager, $filesystemManager, TokenStorage $tokenStorage) {
        $this->user = $tokenStorage->getToken()->getUser();
        $this->estudio = $this->user->getEstudio();
        $this->em = $entityManager;
        $this->fsm = $filesystemManager;
    }
    
    /**
     * Almacena la plantilla en el filesystem y persiste la entidad
     * 
     * @param Plantilla $template
     * @return \AppBundle\Services\TemplateManager\TemplateManager
     * @throws \AppBundle\Services\TemplateManager\Exception
     */
    public function newTemplate($template){
        $filename = $this->fsm->writeTemplate($template->getFile()->getPathname(),$template->getFile()->getClientOriginalExtension());
        $template->setFilename($filename);   
        try{
            $phpWord = new TemplateProcessor($template->getFile()->getPathname());
            $template->setVariables($phpWord->getVariables());
            $this->em->persist($template);
            $this->em->flush();
        } catch (Exception $e) {
            $this->fsm->delete($template->getFilename());
            throw $e;
        }
        return $this;
    }
    public function replaceTemplate($template){
        $this->fsm->replace($template->getFilename(),$template->getFile()->getPathname(),$this->templateFolder);
        try{
            $phpWord = new TemplateProcessor($template->getFile()->getPathname());
            $template->setVariables($phpWord->getVariables());
            $this->em->persist($template);
            $this->em->flush();
        } catch (Exception $e) {
            $this->fsm->delete($template->getFilename());
            throw $e;
        }
    }
    /**
     * Genera un documento a partir de una plantilla y los parametros, y lo
     * almacena en el filesystem
     * 
     * @param string $templateName
     * @param array $parameters
     */
    public function generateDocument($id_expediente, $templateName, $parameters = null){
        //HACER: parametrizar esto
        $docPath = $this->fsm->copyToLocalTemp($templateName,'templates');
        if(isset($parameters)){
            $tp = new TemplateProcessor($docPath);
            foreach ($parameters as $key => $value) {
                $tp->setValue($key,$value);
            }
            $tp->saveAs($docPath);
        }
        //HACER: Parametrizar esto
        $filename = $this->fsm->write($docPath,'docx', $this->documentFolder);
        unlink($docPath);
        
        //HACER: IDEA:, crear algun service o lo que fuera que le pueda pedir que
        // me cree una entidad ExpedienteDocumento de un expediente y la escupa
        // ya con el estudio, el expediente y demas datos cargados
        
        $repository = $this->em->getRepository('AppBundle:Expediente');
        $expediente = $repository->find($id_expediente);
        
        $documento = new ExpedienteDocumento();
        $documento->setDescripcion("Prueba Descripcion");
        $documento->setEstudio($this->estudio);
        $documento->setExpediente($expediente);
        $documento->setUsuario($this->user);
        $documento->setNombre("Prueba Nombre");

        $documento->setFechayhora(new DateTime());
        $documento->setModificando(0);
        $documento->setMaxVersion(1);



        //File
        $documentofile = new ExpedienteDocumentoFile();
        $documentofile->setExpediente($expediente);
        $documentofile->setEstudio($this->estudio);
        $documentofile->setUsuario($this->user);
        $documentofile->setDocumento($documento);


        $documentofile->setFechayhora(new DateTime());
        $documentofile->setTipo(4); //HACER sacar este hardcodeo
        $documentofile->setModificando(0); //NO SE ESTA MODIFICANDO
        $documentofile->setVersion(1);

        //HACER: parametrizar esto
//        $path = __DIR__.'/../../../../../data/';
//        $path = $path . 'documents/' . $estudio->getId() . '/';
        $documentofile->setFilename($filename);

//        $documentofile->setPath($path);

        $this->em->persist($documento);
        $this->em->persist($documentofile);
        $this->em->flush();
        
        
//        echo $filename;die();
        
        return $documento;
    }
}
