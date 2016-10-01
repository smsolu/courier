<?php
namespace AppBundle\Services\FilesystemManager;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use AppBundle\Exception\FilesystemManagerDeleteExcepton;

class FilesystemManager {
    private $config;
    private $estudio;
    private $lastFileName;
    private $documentFolder;
    private $templateFolder;
    
    public function __construct($config, TokenStorage $tokenStorage) {
        $this->config =  $config;
        $this->estudio = $tokenStorage->getToken()->getUser()->getEstudio();
        $this->lastFileName = "";
        
        //HACER: parametrizar esto en la configuracion
        $this->documentFolder = 'documents';
        $this->templateFolder = 'templates';
    }
    public function write($path, $extension='', $folder='', $overwrite = false){
        if($extension==''){
            $extension = $this->getExtension($path);
        }
        $fileNameGen = $this->generateFilename($extension);
        $filesystem = $this->filesystem($folder);
        $filesystem->write($fileNameGen, file_get_contents($path), $overwrite);
        
        $this->lastFileName = $fileNameGen;
        return $fileNameGen;
    }
    public function read($key,$folder = ''){
        $filesystem = $this->filesystem($folder);
        return $filesystem->read($key);
    }
    public function get($key,$folder = ''){
        $filesystem = $this->filesystem($folder);
        return $filesystem->get($key);
    }
    private function keys($folder = ''){
        $filesystem = $this->filesystem($folder);
        return $filesystem->keys();
    }
    public function replace($key, $path, $folder= ''){
        $filesystem = $this->filesystem($folder);
        $filesystem->write($key, file_get_contents($path), true);
        $this->lastFileName = $key;
        return $key;
    }
    public function delete($key,$folder = ''){
        try{
            $filesystem = $this->filesystem($folder);
            $filesystem->delete($key);
        }catch(\Exception $e){
            throw new FilesystemManagerDeleteExcepton("",0,$e);
        }
        return $this;
    }
    //HACER: crear todas las funciones del filesystem
    private function filesystem($folder){
        if(!isset($this->config) || !isset($this->config['type'])){
            throw new \Exception('Error en FilesystemManager, no se encuentra bien configurado');
        }
        switch($this->config['type']){
            case 'Local':
                $adapter = new LocalAdapter($this->config['directory'].'/'.$this->estudio->getId().'/'. $folder, true, 0750);
                break;
        }
        return new Filesystem($adapter); 
    }
    /**
     * Obtiene el nombre generado para el ultimo archivo guardado
     * 
     * @return string
     */
    public function getLastFileName(){
        return $this->lastFileName;
    }
    public function getTemplate($filename){
        return $this->get($filename,$this->templateFolder);
    }
//    public function getDocument($filename){
//        return $this->get($filename,$this->documentFolder);
//    }
//    public function readDocument($filename){
//        return $this->read($filename,$this->documentFolder);
//    }
    /**
     * Guarda un archivo dentro de la carpeta templeates del estudio
     * 
     * @param file $file
     * @param boolean $overwrite
     * @return string
     */
    public function writeTemplate($path, $extension, $overwrite = false){
        $this->lastFileName = $this->write($path,$extension, $this->templateFolder, $overwrite);
        return $this->lastFileName;
    }
    /**
     * Guarda un archivo dentro de la carpeta documents del estudio
     * 
     * @param file $file
     * @param boolean $overwrite
     * @return string
     */
//    public function writeDocument($path,$extension, $overwrite = false){
//        $this->lastFileName = $this->write($path,$extension, $this->documentFolder, $overwrite);
//        return $this->lastFileName;
//    }
//    public function replaceDocument($key,$path){
//        $this->lastFileName = $this->replace($key,$path, $this->documentFolder);
//        return $this->lastFileName;
//    }
    /**
     * Genera un nombre de archivo unico y concatena con la extension.
     * Si la extension es nula o vacia coloca .tmp
     * 
     * @param string $extension
     * @return string
     */
    private function generateFilename($extension=''){
//        echo $filename;die();
//        $array =  explode('.', $filename);
//        $extension = end($array);
        if ($extension == ''){
            $extension = 'tmp';
        }
        return md5(uniqid()).'.'.$extension;
    }
    /**
     * Devuelve la extension correspondiente al nombre de un archivo
     * 
     * @param string $filename
     * @return string
     */
    private function getExtension($filename){
        $extension = '';
        $array =  explode('.', $filename);
        if(isset($array)){
            $extension = end($array);
        }
        return $extension;
    }
    public function copyToLocalTemp($key, $folder=''){
        
        $file = $this->get($key, $folder);
        $content = $file->getContent();
        $filename = tempnam("","");
        $temp = fopen($filename, "w+");
        
        
        for ($written = 0; $written < strlen($content); $written += $fwrite) {
            $fwrite = fwrite($temp, substr($content, $written));
            if ($fwrite === false) {
                throw new \Exception('No se pudo copiar el archivo temporal de la plantilla '.$key);
            }
        }
        return $filename;
    }
            
}

