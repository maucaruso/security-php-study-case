<?php

class FileChecker
{
    private $files;

    public static $MIN_SIZE_BYTE = 1024 * 5; //5 KB
    public static $MAX_SIZE_BYTE = 10 * 1000000; // 10MB
    public static $TYPE_ALLOWED = array(
        'image/jpeg',
        'image/png'
    );
    public static $EXTENSION_ALLOWED = array(
        'jpeg',
        'jpg',
        'png'
    );

    public function __construct(array $files)
    {
        $this->files = $this->normalizeArray($files);
        
        if (!sizeof($this->files) > 0) {
            throw new \InvalidArgumentException("Um arquivo deve ser especificado.");
        }
        
        return $this;
    }

    public function validateType(array $types = null)
    {
        if (!$types) {
            $types = self::$TYPE_ALLOWED;
        }
        
        foreach ($this->files as $file) {
            $tmpName = $file['tmp_name'];
            
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $typeFile = finfo_file($finfo, $tmpName);
            finfo_close($finfo);
            $imageContent = file_get_contents($tmpName);
            if (!in_array($typeFile, self::$TYPE_ALLOWED)) {
                throw new \InvalidArgumentException("O arquivo fornecido não é compatível");
            }
            
            if (!in_array($typeFile, $types) || !in_array($extension, self::$EXTENSION_ALLOWED)) {
                throw new \InvalidArgumentException("O arquivo fornecido não é válido");
            }
            
            if (!is_array(getimagesize($tmpName)) || $this->hasXssAttack($imageContent)) {
                throw new \InvalidArgumentException("O arquivo fornecido está corrompido");
            }

            if (!$this->isValideSize($file['size'])) {
                throw new \InvalidArgumentException("Tamanho do arquivo fornecido está invalido, tamanho máximo ".(intval(self::$MAX_SIZE_BYTE / 1000000))."MB");
            }
        }

        return true;
    }

    function removeSpecialCharacters($string) {
        $specialCharacters = array(";", "<", ">", "/", "\\", ".", ":", "*", "%");
    
        $cleanString = preg_replace("/[" . preg_quote(implode('', $specialCharacters), '/') . "]/", '', $string);
    
        return $cleanString;
    }
    
    public function isValideSize($fileSize)
    {
        return !($fileSize > self::$MAX_SIZE_BYTE || $fileSize < self::$MIN_SIZE_BYTE);
    }
    
    public function checkDuplicated()
    {}
    
    public function uploadFile()
    {}

    private function hasXssAttack($string) {
        // Verificar tags HTML que podem conter código malicioso
        $htmlTags = array('script', 'iframe', 'object', 'embed', 'applet', 'meta', 'style', 'base', 'form');
        foreach ($htmlTags as $tag) {
            $pattern = "/<{$tag}\b[^>]*>(.*?)<\/{$tag}>/si";
            if (preg_match($pattern, $string)) {
                return true;
            }
        }
        
        // Verificar atributos HTML que podem conter código malicioso
        $htmlAttributes = array('onload', 'onunload', 'onclick', 'onmouseover', 'onmouseout', 'onerror');
        foreach ($htmlAttributes as $attribute) {
            $pattern = "/{$attribute}\s*=/i";
            if (preg_match($pattern, $string)) {
                return true;
            }
        }
        
        // Verificar código JavaScript que pode ser executado
        $javascriptKeywords = array('javascript', 'eval', 'expression', 'alert', 'prompt', 'confirm');
        foreach ($javascriptKeywords as $keyword) {
            $pattern = "/{$keyword}\s*:/i";
            if (preg_match($pattern, $string)) {
                return true;
            }
        }
        
        // Verificar comandos de sistema que podem ser executados
        $systemCommands = array('exec', 'system', 'shell_exec', 'passthru', 'popen');
        foreach ($systemCommands as $command) {
            $pattern = "/{$command}\s*\(/i";
            if (preg_match($pattern, $string)) {
                return true;
            }
        }
        
        // Verificar código PHP que pode ser executado
        $phpKeywords = array('php', 'eval', 'system', 'exec', 'passthru');
        foreach ($phpKeywords as $keyword) {
            $pattern = "/<\?php.*{$keyword}/is";
            if (preg_match($pattern, $string)) {
                return true;
            }
        }
        
        // Verificar código Node.js que pode ser executado
        $nodeKeywords = array('child_process', 'exec', 'spawn', 'require');
        foreach ($nodeKeywords as $keyword) {
            $pattern = "/{$keyword}\s*\(/i";
            if (preg_match($pattern, $string)) {
                return true;
            }
        }
        
        return false;
    }    
    

    private function normalizeArray(array $files)
    {
        $normalizedArray = [];
        
        foreach ($files as $file) {
            if (!is_array($file["type"])) {
                $normalizedArray[] = $file;
                continue;
            }
            
            foreach ($file["name"] as $index => $fileProperties) {
                $nameWithoutExtension = pathinfo($file["name"][$index], PATHINFO_FILENAME);

                $normalizedArray[] = [
                    "name" => $this->removeSpecialCharacters($nameWithoutExtension),
                    "type" => $file["type"][$index],
                    "tmp_name" => $file["tmp_name"][$index],
                    "error" => $file["error"][$index],
                    "size" => $file["size"][$index],
                ];
            }
        }
    
        return $normalizedArray;
    }
}