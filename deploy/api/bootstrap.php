<?php

require_once "vendor/autoload.php";
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$conn;
$isDevMode = false;

$conn = array(
    'host' => '127.0.0.1',
    'driver' => 'pdo_pgsql',
    'user' => 'root',
    'password' => '',
    'dbname' => 'cat\'shop_db',
    'port' => '3306'
);

$config = Setup::createYAMLMetadataConfiguration(array(__DIR__ . "/config/yaml"), $isDevMode);
$entityManager = EntityManager::create($conn, $config);




