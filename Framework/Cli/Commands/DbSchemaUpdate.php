<?php

namespace GrowBitTech\Framework\Cli\Commands;

use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use GrowBitTech\Framework\Cli\Command;
use GrowBitTech\Framework\Cli\Interface\CommandInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

final class DbSchemaUpdate extends Command implements CommandInterface
{
    private SchemaTool $schemaTool;
    private array $classes;

    public function run(): void
    {
        $cache = $this->settings->get('DevMode') ?
            DoctrineProvider::wrap(new ArrayAdapter()) :
            DoctrineProvider::wrap(new FilesystemAdapter(directory: $this->settings->get('CacheDir')));

        $paths = [];

        echo 'Reading Schema .....'.PHP_EOL;

        foreach (scandir($path = dirname(__DIR__, 3).DIRECTORY_SEPARATOR.'Modules') as $dir) {
            if ($dir == '.' || $dir == '..' || $dir == 'Socket') {
                continue;
            }
            $paths[] = $path.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.'Domain'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR;
        }

        $config = Setup::createAttributeMetadataConfiguration(
            $paths,
            $this->settings->get('DevMode'),
            null,
            $cache
        );

        $entityManager = EntityManager::create($this->settings->get('db'), $config);

        $this->schemaTool = new SchemaTool($entityManager);
        $this->classes = $entityManager->getMetadataFactory()->getAllMetadata();
        echo 'Reading Schema Completed'.PHP_EOL;

        if (isset($this->argv['update'])) {
            echo 'Updating Database Schema .....'.PHP_EOL;
            $this->schemaTool->updateSchema($this->classes);
            echo 'Update Database Schema Completed'.PHP_EOL;
        }

        if (isset($this->argv['create'])) {
            echo 'Creating Database Schema .....\n';
            $this->schemaTool->createSchema($this->classes);
            echo 'Create Database Schema Completed'.PHP_EOL;
        }
    }
}
