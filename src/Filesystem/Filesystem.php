<?php

namespace Src\Filesystem;

class Filesystem
{
    public function mkdir(string $directoryPath, $permissions = null, $recursive = false): void 
    {
        $permissions = $permissions ?? 0777;

        if(!file_exists($directoryPath)) {
            mkdir($directoryPath, $permissions, $recursive);
        } 
    }

    public function readFile(string $file): string
    { 
        // TODO: exception at file not found exception;
     
        return file_get_contents($file);
    }

    public function writeFile(string $filename, string $data, $append = false)
    {
        return file_put_contents($filename, $data, $append? FILE_APPEND : 0);
    }

    public function modificationTime(string $file): int|false
    {
        return filemtime($file);
    }

    public function dir(string $path)
    {
        return dirname($path);
    }
}

