<?php

require_once "vendor/autoload.php";
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$conn;
$isDevMode = false;

$conn = array(
    'host' => 'dpg-ceu7atun6mpglqbvtjq0-a',
    'driver' => 'pdo_pgsql',
    'user' => 'catshop_bdd_user',
    'password' => 'Fu6Q8S2STfxvbioHJc85kpkcqk3PI8w4',
    'dbname' => 'catshop_bdd',
    'port' => '5432'
);

$config = Setup::createYAMLMetadataConfiguration(array(__DIR__ . "/config/yaml"), $isDevMode);
$entityManager = EntityManager::create($conn, $config);

