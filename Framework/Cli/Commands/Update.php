<?php

namespace GrowBitTech\Framework\Cli\Commands;

use GrowBitTech\Framework\Cli\Command;
use GrowBitTech\Framework\Cli\Interface\CommandInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;

final class Update extends Command implements CommandInterface
{
    private $fs;

    public function validate(): CommandInterface
    {
        return $this;
    }

    public function run(): void
    {
        $path = dirname(__DIR__, 3).DIRECTORY_SEPARATOR.'Storage'.DIRECTORY_SEPARATOR.'.Update'.DIRECTORY_SEPARATOR;
        $this->deletePath($path );       

        echo "creating temp folder.\n\r";
        mkdir($path);

        $this->fs = new Filesystem(new LocalFilesystemAdapter($path));


        $author     = 'GrowBit-Tech';
        $repository = 'PhpThoughts';
        $branch     = 'master';

        $this->clone($author,$repository,$branch,$path);

        echo "\n\rremoving temp folder.";
        $this->deletePath($path );
    }

    private function deletePath(String $path): void{
        if (file_exists($path)) {
            $this->rrmdir($path);
        }
    }

    private function rrmdir($dir) { 
        if (is_dir($dir)) { 
          $objects = scandir($dir);
          foreach ($objects as $object) { 
            if ($object != "." && $object != "..") { 
              if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir.DIRECTORY_SEPARATOR.$object))
                $this->rrmdir($dir. DIRECTORY_SEPARATOR .$object);
              else
                unlink($dir. DIRECTORY_SEPARATOR .$object); 
            } 
          }
          rmdir($dir); 
        } 
      }

    /**
     * Download & unpack zip.
     *
     * @param String $author Github author
     * @param String $repo   Github repository
     * @param String $branch Repository branch
     *
     * @throws Exception ZipArchive failed
     *
     * @return String $absolute path to directory location.
     *
     * @see https://www.php.net/manual/en/function.fopen
     * @see https://stackoverflow.com/a/2174899/19052212
     * @see https://www.php.net/manual/en/function.stream-context-create.php
     * @see https://www.php.net/manual/en/ziparchive.open.php
     * @see https://www.php.net/manual/en/zip.constants.php#ziparchive.constants.rdonly
     * @see https://www.php.net/manual/en/ziparchive.extractto.php
     */
    private function clone(String $author, String $repo, String $branch, String $dir): String
    {
        $url = 'https://github.com/' . $author . '/' . $repo . '/archive/refs/heads/' . $branch . '.zip';

        $relative = $repo . '.zip';//$author . DIRECTORY_SEPARATOR . $repo . '.zip';
        $absolute = $dir;//. DIRECTORY_SEPARATOR . $author . DIRECTORY_SEPARATOR . $repo;
        echo $absolute;
        $resource = @fopen($url, 'rb');

        // Downloads the zipfile to the local filesystem.
        $this->fs->has($relative) && $this->fs->delete($relative);
        $this->fs->writeStream($relative, $resource);

        // Extracts the zipfile.
        $zip = new \ZipArchive;
        $status = $zip->open($absolute . $relative, \ZipArchive::CHECKCONS);
        if (true === $status) $status = $zip->extractTo(dirname($absolute .DIRECTORY_SEPARATOR . 'ere' ));
        $zip->close();

        // $status = false when extractTo() failed.
        // Otherwise $status has one of the error code constants:
        // https://www.php.net/manual/en/ziparchive.open.php
        if ($status !== true) throw new \Exception('ZipArchive failed', $status);

        // Removes the zipfile.
        $this->fs->delete($relative);
    
        return $absolute;
    }
}
