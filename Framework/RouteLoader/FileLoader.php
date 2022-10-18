<?php

namespace App\Framework\RouteLoader;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use SplFileObject;

class FileLoader
{
    /**
     * @var string[]
     */
    protected array $paths;

    protected string $extension;

    public function __construct(array $paths, string $extension = 'php')
    {
        $this->paths = $paths;
        $this->extension = $extension;
    }

    /**
     * getFiles.
     *
     * Searches filesystem recursively and returns all found files matching self::$extension
     * as an array of SplFileObjects
     *
     * @return SplFileObject[]
     */
    public function getFiles(): array
    {
        clearstatcache(true);
        $actionFiles = [];

        foreach ($this->paths as $dir) {
            // Get a list of all files present inside of this directory (recursively)
            /** @var SplFileInfo[] $filesystemDir */
            $filesystemDir = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST,
                RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
            );

            // Only store php files
            foreach ($filesystemDir as $fileInfo) {
                if ($fileInfo->isDir() === false && $fileInfo->getExtension() === $this->extension) {
                    $splFileObject = new SplFileObject($fileInfo->getPathname(), 'r', false);
                    $splFileObject->setFlags(
                        SplFileObject::READ_AHEAD |
                        SplFileObject::SKIP_EMPTY |
                        SplFileObject::DROP_NEW_LINE
                    );

                    $actionFiles[$fileInfo->getPathname()] = $splFileObject;
                }
            }
        }

        return $actionFiles;
    }
}
