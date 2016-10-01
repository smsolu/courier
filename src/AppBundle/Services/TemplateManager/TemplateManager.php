<?php
namespace AppBundle\Services\TemplateManager;//HACER: chequear esto


use AppBundle\Entity\ExpedienteDocumento;
use AppBundle\Entity\ExpedienteDocumentoFile;
use AppBundle\Entity\Plantilla;
use AppBundle\Exception\CheckPermissionsException;
use AppBundle\Exception\DeleteException;
use AppBundle\Exception\EditExcepton;
use AppBundle\Exception\EstudioInvalidoException;
use AppBundle\Exception\FilesystemManagerDeleteExcepton;
use AppBundle\Exception\SavePlantillaFileExcepton;
use AppBundle\Exception\UndoDeleteException;
use AppBundle\Form\Type\Plantilla\PlantillaType;
use AppBundle\Services\Manager;
use DateTime;
use Doctrine\DBAL\DBALException;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
/**
 * Se encarga de administrar las plantillas y crear documentos en base a las mismas
 *
 * @author Niko
 */
class TemplateManager extends Manager{
    const DOCUMENT_FOLDER = 'documents';
    const TEMPLATE_FOLDER = 'templates';
    
    private $allowVariablesExtensions = array('docx');
    private $estudio;
    private $user;
    private $em;
    private $fsm;
    private $templateFolder = 'templates';
    private $documentFolder = 'documents';
    private $formFactory;
    
    public function __construct($entityManager, $filesystemManager, TokenStorage $tokenStorage, $formFactory) {
        $this->user = $tokenStorage->getToken()->getUser();
        $this->estudio = $this->user->getEstudio();
        $this->em = $entityManager;
        $this->fsm = $filesystemManager;
        $this->formFactory = $formFactory;
    }
    
    
    
    public function getList($folder,$order_col, $order_status, $page = 1, $resultpage= 10, $filtro = array('')){
        $queryBuilder = $this->em->getRepository("AppBundle:Plantilla")->getPlantillas($this->estudio, $folder);
        $queryBuilder->OrderBy("e.tipo", "ASC");
        $list = new ListView();
        $list
            ->setTitle("Plantillas")
//            HACER: esto se setea para el translator, inyectarlo desde el service
//            ->setControllerParent($this)
            ->addColumn('', 'id',array(
                'type' => 'link',
                'route' => new LinkColumn('plantilla_show', array('id'=> 'getId')),
                'value' => '<span class="glyphicon glyphicon-file"></span>'
                )
            )
//            ->addColumn('', 'id',array(
//                'type' => 'link',
//                'route' => new LinkColumn('plantilla_newDocument', array('id'=> 'getId')),
//                'value' => '<span class="glyphicon glyphicon-save-file"></span>'
//                )
//            )
            ->addColumn("Nombre", 'nombre',array(
                'type' => 'string',
                ))                
            ->addColumn("Descripcion", 'descripcion',array(
                'type' => 'string',
                ))
            ->setPage($page)
            ->setResultPage($resultpage)
            ->setQueryBuilder($queryBuilder)
            ->setOrderCol($order_col, $order_status);        
        return $list;
        
    }
    
    public function doNew($plantilla){
        try{
            $filename = $this->savePlantillaFile($plantilla);
            $plantilla->setFilename($filename)
                  ->setEstudio($this->estudio);
            $this->em->persist($plantilla);
            $this->em->flush();    
        }catch(SavePlantillaFileExcepton $e){
            //HACER:No pudo grabar el nuevo archivo, reintentar
            throw new NewExcepton("",0,$e);
        }catch(Exception $e){
            $this->fsm->delete($filename,self::TEMPLATE_FOLDER);
            throw new NewExcepton("",0,$e);
        }
        return $plantilla;
    }
    public function doEdit($plantilla){
        try{
            if($plantilla->getFile()!== null){
                $oldFilename = $plantilla->getFilename();
                $filename = $this->savePlantillaFile($plantilla);
                $plantilla->setFilename($filename);
            }
            $this->em->persist($plantilla);
            $this->em->flush();        
            if(isset($oldFilename)){   
                $this->fsm->delete($oldFilename,self::TEMPLATE_FOLDER);
            }
        }catch(DBALException $e){    
            //Hacer:fallo doctrine, reintentar
            throw new EditExcepton("",0,$e);
        }catch(SavePlantillaFileExcepton $e){
            //HACER:No pudo grabar el nuevo archivo, reintentar
            throw new EditExcepton("",0,$e);
        }catch(FilesystemManagerDeleteExcepton $e){    
            //Hacer:no pudo borrar el archivo, reintentar o ponerse en una lista de pendientes de borrar
            //No tiro excepcion, no es un fallo invalidante
        }catch(\Exception $e){
            //CUalquier otro
            throw new EditExcepton("",0,$e);
        }
        return $plantilla;
    }
    
    public function doDelete($plantilla){
        try{
            $plantilla->setStatus(Plantilla::STATUS_DELETED);
            $plantilla->setFechaEliminacion(new DateTime("now"));
            $this->em->flush();        
        }catch(\Exception $e){
            throw new DeleteException("",0,$e);
        }
        return $this;
    }
    
    public function doUndoDelete($plantilla){
        try{
            $plantilla->setStatus(Plantilla::STATUS_NO_DELETED);
            $this->em->flush();        
        }catch(\Exception $e){
            throw new UndoDeleteException("",0,$e);
        }
        return $this;
    }
    
    public function doCheckPermissions($plantilla=null, $operation = self::DO_LIST){
        try{
            if($operation != self::DO_UNDODELETE){
                if($plantilla){
                    $this->validate($plantilla);
                }
            }
//        Hacer: Cuando este bien definido como tratar los errores de estudio activar
//        }catch(EstudioInvalidoException $e){
//            throw $e;
        }catch(\Exception $e){
            throw new CheckPermissionsException("No tiene permisos",0,$e);
        }
        return $this;
    }
    private function validate($plantilla){
        if($plantilla->getStatus() != Plantilla::STATUS_NO_DELETED){
            throw new \Exception("Status de plantilla =  -1");
        }
        if($plantilla->getEstudio() != $this->estudio){
            //Hacer, cambiar a la excepcion de estudio invalido
            throw new EstudioInvalidoException("Estudio invalido");
        }
        return true;
    }    
   
    private function savePlantillaFile($plantilla){
        try{
            $fileClientExtension = $plantilla->getFile()->getClientOriginalExtension();
            $filePathname = $plantilla->getFile()->getPathname();
            $filename = $this->fsm->write($filePathname,$fileClientExtension,self::TEMPLATE_FOLDER);

            if(in_array($fileClientExtension, $this->allowVariablesExtensions)){
                $phpWord = new TemplateProcessor($filePathname);
                $plantilla->setVariables($phpWord->getVariables());
            }
        }catch(Exception $e){
            throw new SavePlantillaFileExcepton("",0,$e);
        }
        return $filename;
    }
    
    
    public function getForm($plantilla, $disabled = false, $options= array()){
        $options['disabled'] = $disabled;
        return $this->formFactory->create(PlantillaType::class, $plantilla,$options);
    }
    
    
    
    /**
     * Almacena la plantilla en el filesystem y persiste la entidad
     * 
     * @param Plantilla $template
     * @return TemplateManager
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
