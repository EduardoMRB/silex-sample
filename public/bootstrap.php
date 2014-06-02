<?php

require __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

$isDevMode = false;

$paths = __DIR__ . '/../src/Seguranca/Entity';

$dbParams = [
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/../db/seguranca.db',
];

$config = Setup::createConfiguration($isDevMode);
$driver = new AnnotationDriver(new AnnotationReader, $paths);
$config->setMetadataDriverImpl($driver);

AnnotationRegistry::registerFile(
    __DIR__ . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
);

$entityManager = EntityManager::create($dbParams, $config);
