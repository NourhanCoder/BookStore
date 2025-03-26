<?php

namespace Database;

class MigrationManager
{
    static function getMigration() {
        $files = glob(__DIR__ . "/migrations/*.php");
        sort($files);

        $migration = [];

        foreach($files as $file){
            $fileName = basename($file,".php");
            $migration[] = $fileName;
        }

        return $migration;
    }


    public static function runMigrations()
    {
        
        $conn = DatabaseManager::getConnection();
        
        $migrations = self::getMigration();
        
        foreach($migrations as $migration){
            require_once __DIR__ . "/migrations/{$migration}.php";
            $text =  preg_replace("/^\d+/","",$migration);
            $text = str_replace("_",' ',$text);
            $text = ucwords($text);
            $className = str_replace(" ",'',$text);
            if(class_exists($className)){
                (new $className())->up($conn);
            }
        }
    }
}