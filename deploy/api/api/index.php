<?php

    use Slim\Factory\AppFactory;
    use Doctrine\ORM\EntityManager;

    require __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../bootstrap.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
    $dotenv->load();

    $containerBuilder = new DI\ContainerBuilder();
    $containerBuilder->useAutowiring(true);
    $container = $containerBuilder->build();
    $container->set(EntityManager::class, function($container) use($entityManager) { 
        return $entityManager; 
    });

    AppFactory::setContainer($container);

    $app = AppFactory::create();
    
    $app->addErrorMiddleware(true, true, true);
    
    $routes = require __DIR__ . '/../routes.php';
    $routes($app);
    
    $app->run();