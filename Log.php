<?php

namespace NCentral_GLPI\inc\Geracao;

class Log{    
    private string $logFile_dir = "log";
    private int $logFile_Delete_Days = 30;

    public function writeLog($msg){    
        $vendorDir = dirname(__DIR__);
        $baseDir = dirname($vendorDir);
        
        $logFile_dir = $baseDir . DIRECTORY_SEPARATOR . $this->logFile_dir;
        
        $logFile = $logFile_dir . DIRECTORY_SEPARATOR . "NCentral_Glpi-" . date("Y") . ".log";
        if(!file_exists($logFile_dir)){
            mkdir($logFile_dir, 0775, true);
        }

        file_put_contents($logFile, date("Y-m-d H:i:s"). " > ". $msg . "\n", FILE_APPEND | LOCK_EX);   
    }

    public function deleteLog(){
        $vendorDir = dirname(__DIR__);
        $baseDir = dirname($vendorDir);
        
        $logFile_dir = $baseDir . DIRECTORY_SEPARATOR . $this->logFile_dir;
        
        $files = glob($logFile_dir . DIRECTORY_SEPARATOR . "*.log");    
        $now = time();

        foreach($files as $file){
            if(is_file($file)){            
                if ($now - filemtime($file) >= 60 * 60 * 24 * $this->logFile_Delete_Days){
                    unlink($file);            
                }       
            }
        }  
    }
}