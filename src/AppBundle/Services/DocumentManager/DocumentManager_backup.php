<?php
namespace LegalPro\Bundles\CommonBundle\Services\DocumentManager;
use PhpOffice\PhpWord\TemplateProcessor;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
//use LegalPro\Bundles\CommonBundle\Entity\ExpedienteDocumento;
//use LegalPro\Bundles\CommonBundle\Entity\ExpedienteDocumentoFile;
use LegalPro\Bundles\CommonBundle\Entity\Documento;
use LegalPro\Bundles\CommonBundle\Entity\DocumentoVersion;
use LegalPro\Bundles\CommonBundle\Constant\ConstDocumento;
use DateTime;//HACER: chequear esto
/**
 * Se encarga de administrar las plantillas y crear documentos en base a las mismas
 *
 * @author Niko
 */
class DocumentManager {
    const initialVersionCode = 0;
    const initialVersionString = "Version inicial";
    const notModifying = 0;
    const documentFolder = 'documents';
    const documentType = 0;
    
    private $estudio;
    private $user;
    private $em;
    private $fsm;
    private $templateFolder = 'templates';
    private $lastGeneratedDocument = '';
    
    public function __construct($entityManager, $filesystemManager, TokenStorage $tokenStorage) {
        $this->user = $tokenStorage->getToken()->getUser();
        $this->estudio = $this->user->getEstudio();
        $this->em = $entityManager;
        $this->fsm = $filesystemManager;
    }
    
    /**
     * Almacena el documento en el filesystem y persiste las entidades. 
     * Creando la version inicial
     * 
     * @param ExpedienteDocumento $document
     * @param Expediente $expediente
     * @return \LegalPro\Bundles\CommonBundle\Services\TemplateManager\TemplateManager
     * @throws \LegalPro\Bundles\CommonBundle\Services\TemplateManager\Exception
     */
    public function newDocument(Documento $document, $expediente){
        $filename = $this->fsm->writeDocument($document->getFile()->getPathname(),$document->getFile()->getClientOriginalExtension());
        try{
            //Documento
//            var_dump(get_class($document));die();
            $document->setExpediente($expediente)
                ->setEstudio($this->estudio)
                ->setFechaCreacion(new \DateTime('now'))
                ->setFechaModificacion(new \DateTime('now'))
                ->setTipo(ConstDocumento::TIPO_FILESYSTEM)
                ->setUltimaVersion(ConstDocumento::VERSION_INICIAL_INTEGER)
                ->setTotalSize(0);
        
                

            $documentVersion = new DocumentoVersion();
            $documentVersion->setDocumento($document)
                    ->setDescripcion(ConstDocumento::VERSION_INICIAL_STRING)
                    ->setFechaCreacion(new \DateTime('now'))
                    ->setFechaModificacion(new \DateTime('now'))
                    ->setEstudio($this->estudio)
                    ->setFilename($filename)
                    ->setFilesize(1)//HACER: poner el peso real
                    ->setVersion(ConstDocumento::VERSION_INICIAL_INTEGER);
            //CONTINUAR
            
            //DocumentoFile
//            $documentFile = new ExpedienteDocumentoFile();
//            $documentFile->setExpediente($document->getExpediente())
//                ->setFechayhora(new DateTime())
//                ->setTipo(ExpedienteDocumentoFile::TIPO_FILESYSTEM)
//                ->setModificando(ExpedienteDocumentoFile::MODIFICANDO_NO_MODIFICANDO)
//                ->setVersion(ExpedienteDocumentoFile::VERSION_INICIAL_INTEGER)
//                ->setEstudio($document->getEstudio())
////                ->setUsuario($document->getUsuario())
//                ->setNombre($document->getNombre())
//                ->setDescripcion(ExpedienteDocumentoFile::VERSION_INICIAL_STRING)
//                ->setFilename($filename)
//                ->setDocumento($document);
            
            $this->em->persist($document);
            $this->em->persist($documentVersion);
            $this->em->flush();
        } catch (Exception $e) {
            $this->fsm->delete($filename);
            throw $e;
        }
        $this->lastGeneratedDocument = $document;
        return $this;
    }
    public function newDocumentVersion($document, $documentFile, $isNewVersion = true){

        if($isNewVersion){
            $document->setMaxVersion($document->getMaxVersion() + 1);
            $filename = $this->fsm->writeDocument($documentFile->getFile()->getPathname(),$documentFile->getFile()->getClientOriginalExtension());
            //HACER: crear un metodo o meter en el constructor todo esto
            $documentFile->setExpediente($document->getExpediente())
                ->setFechayhora(new DateTime())
                ->setUsuario($this->user)                
                ->setModificando(ExpedienteDocumentoFile::MODIFICANDO_NO_MODIFICANDO)
                ->setVersion($document->getMaxVersion())
                ->setEstudio($document->getEstudio())
                ->setTipo(ExpedienteDocumentoFile::TIPO_FILESYSTEM)
                ->setNombre($document->getNombre())
                ->setFilename($filename)
                ->setDocumento($document)
                ->setExpediente($document->getExpediente());
        }else{
            $lastDocumentFile = $this->em->getRepository('CommonBundle:ExpedienteDocumentoFile')
                ->findOneBy(array("Documento" => $document, "Estudio"=> $this->estudio, "status"=>0),array("id"=>'desc')); 
            $filename = $this->fsm->replaceDocument($lastDocumentFile->getFilename(), $documentFile->getFile()->getPathname());
            $lastDocumentFile->setDescripcion($documentFile->getDescripcion())
                ->setUsuario($this->user)
                ->setFechayhora(new DateTime());
            $documentFile = $lastDocumentFile;
        }
        $document->setModificando(0);
        $document->setModificandoFechayhora(new DateTime());
        $document->setUsuarioModifica($this->user);

        $this->em->persist($document);
        $this->em->persist($documentFile);
        $this->em->flush();
        $this->lastGeneratedDocument = $document;
        
        echo "termine";die();
    }
    /**
     * 
     * @param ExpedienteDocumentoFile $documentFile
     * @return String
     * @throws Exception
     */
    public function getDocumentFileContent($documentFile){
        //HACER: centrar el control de seguridad en otro lado
        if(!($this->estudio === $documentFile->getEstudio())){
            throw new Exception("El documento no corresponde con el estudio");
        }
        return $this->fsm->readDocument($documentFile->getFilename());
    }
    public function rollback(){
        $this->fsm->delete($this->lastGeneratedDocument->getFilename());
        $this->em->remove($this->lastGeneratedDocument);
        $this->em->flush();
    }
    
}
