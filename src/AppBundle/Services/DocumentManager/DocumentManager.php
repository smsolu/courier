<?php
namespace AppBundle\Services\DocumentManager;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use AppBundle\Entity\Documento;
use AppBundle\Entity\DocumentoVersion;
//use AppBundle\Constant\ConstDocumento;
use DateTime;//HACER: chequear esto
/**
 * Se encarga de administrar las plantillas y crear documentos en base a las mismas
 *
 * @author Niko
 */
class DocumentManager {
    const EDIT_REPLACE_VERSION = 0;
    const EDIT_NEW_VERSION = 1;
    const DOCUMENT_FOLDER = 'documents';
    
    private $estudio;
    private $user;
    private $em;
    private $fsm;
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
     * @return \AppBundle\Services\TemplateManager\TemplateManager
     * @throws \AppBundle\Services\TemplateManager\Exception
     */
    public function newDocument(Documento $document, $expediente){
        $documentVersion = $document->getLastDocumentoVersion();
        if($documentVersion === null){
            throw new \Exception("No hay existe una version para crear el documento");
        }
        $file = $documentVersion->getFile();
        $filename = $this->fsm->write($file->getPathname(),$file->getClientOriginalExtension(),self::DOCUMENT_FOLDER);
        try{
            $document->setExpediente($expediente)
                ->setEstudio($this->estudio)
                ->setFechaCreacion(new \DateTime('now'))
                ->setFechaModificacion(new \DateTime('now'))
                ->setTipo(Documento::TIPO_FILESYSTEM)
                ->setUltimaVersion(DocumentoVersion::VERSION_INICIAL_INTEGER)
                ->setTotalSize($file->getClientSize());
            $documentVersion->setDocumento($document)
//                    ->setDescripcion(ConstDocumento::VERSION_INICIAL_STRING)
                    ->setFechaCreacion(new \DateTime('now'))
                    ->setFechaModificacion(new \DateTime('now'))
                    ->setEstudio($this->estudio)
                    ->setFilename($filename)
                    ->setFilesize($file->getClientSize())
                    ->setVersion(DocumentoVersion::VERSION_INICIAL_INTEGER);
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
    
    public function editDocument($document, $type = self::EDIT_REPLACE_VERSION){
        $document
                ->setFechaModificacion(new \DateTime('now'))
                ->setTotalSize(0);//HACER: poner peso real
        $documentVersion = $document->getLastDocumentoVersion();
        if($documentVersion === null){
            throw new \Exception("Documento corrupto. No tiene version asociada");
        }
        if($documentVersion->getFile() !== null){
            $file = $documentVersion->getFile();
            if($type == self::EDIT_NEW_VERSION){
                $filename = $this->fsm->write($file->getPathname(),$file->getClientOriginalExtension(), self::DOCUMENT_FOLDER);
                $this->em->detach($documentVersion);
                $this->em->persist($documentVersion);
                $document->setUltimaVersion($document->getUltimaVersion()+1);
            }else{
                $filename = $this->fsm->replace($documentVersion->getFilename(),$file->getPathname(), self::DOCUMENT_FOLDER);
            }
            $documentVersion->setDocumento($document)
                ->setFechaCreacion(new \DateTime('now'))
                ->setFechaModificacion(new \DateTime('now'))
                ->setEstudio($this->estudio)
                ->setFilename($filename)
                ->setFilesize($file->getClientSize())//HACER: poner el peso real
                ->setVersion($document->getUltimaVersion())
                ->setId(null);
        }
//        CONTINUAR ACA!!!! OJO DONDE Y COMO CALUCLA TAMAÑO
//        $document->calculateTotalSize();
        
        try{
            $this->em->flush();
        } catch (Exception $e) {
            if(isset($filename)){
                $this->fsm->delete($filename);
            }
            throw $e;
        }
        $this->lastGeneratedDocument = $document;
        $this->unlockDocument($document);
        return $this;
    }
    public function rollback(){
        $this->fsm->delete($this->lastGeneratedDocument->getFilename());
        $this->em->remove($this->lastGeneratedDocument);
        $this->em->flush();
    }
    public function lockDocument(Documento $document){
        $document->setBloqueado(Documento::BLOQUEADO_BLOQUEADO)
            ->setFechaBloqueo(new DateTime())
            ->setUsuarioBloqueo($this->user);
        $this->em->flush();
    }
    public function unlockDocument(Documento $document){
        $document->setBloqueado(Documento::BLOQUEADO_NO_BLOQUEADO);
        $document->setFechaBloqueo(null);
        $this->em->flush();
    }
    /**
     * 
     * @param DocumentoVersion $documentVersion
     * @return String
     * @throws Exception
     */
    public function getDocumentFileContent($documentVersion){
        //HACER: centrar el control de seguridad en otro lado
        if(!($this->estudio === $documentVersion->getEstudio())){
            throw new Exception("El documento no corresponde con el estudio");
        }
        return $this->fsm->read($documentVersion->getFilename(), self::DOCUMENT_FOLDER);
    }
    /**
     * Determina si un documento puede ser editado por el usuario
     * 
     * @param Documento $document
     * @return boolean
     */
    public function canEdit(Documento $document){
        if ($document->getBloqueado() === Documento::BLOQUEADO_NO_BLOQUEADO){
            return true;
        }
        if($this->user === $document->getUsuarioBloqueo()){
            return true;
        }
        return false;
    }
    public function deleteDocumentVersion(DocumentoVersion $documentVersion){
        $document = $documentVersion->getDocumento();
        if(count($document->getDocumentoVersiones())==1){
            return false;
        }
        $this->fsm->delete($documentVersion->getFilename(), self::DOCUMENT_FOLDER);
        $documentVersion->setStatus(-1);
        //calcular tamaño
//        $document->calculateTotalSize();
        $this->em->flush();
        return true;
        
    }
    
}
