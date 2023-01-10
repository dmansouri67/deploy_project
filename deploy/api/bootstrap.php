<?php

require_once "vendor/autoload.php";
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

date_default_timezone_set('Europe/Paris');
const JWT_SECRET = "makey1234567";

class Config {
    private static ?Config $instance = null; //peut être null
    public ?EntityManager $entityManager = null;
    public ?Mixed $options = null;

    private function _construct()
    {
        $isDevMode = true;
        $config = Setup::createYAMLMetadataConfiguration(array(__DIR__ . "/config/yaml"), $isDevMode);
        $conn = array(
            'host' => '127.0.0.1',
            'driver' => 'pdo_pgsql',
            'user' => 'root',
            'password' => '',
            'dbname' => 'cat\'shop_db',
            'port' => '3306'
        );
        $this->entityManager = EntityManager::create($conn, $config);

        $this->options = [
            "attribute" => "token",
            "header" => "Authorization",
            "regexp" => "/Bearer\s+(.*)$/i",
            "secure" => false,
            "algorithm" => ["HS256"],
            "secret" => JWT_SECRET,
            "path" => ["/api"],
            "ignore" => ["/api/login", "/api/register"],
            "error" => function ($response, $arguments) {
                $data["status"] = "error";
                $data["message"] = $arguments["message"];
                return $response
                    ->withHeader("Content-Type", "application/json")
                    ->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES));
            }
        ];
    }

    public static function getInstance() : Config {
        if (self::$instance == null) {
            self::$instance = new Config();
        }
        return self::$instance;
    }

    public function getEntityManager() : EntityManager {
        return $this->entityManager;
    }
}
