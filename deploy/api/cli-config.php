<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
require_once 'bootstrap.php';
$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));
return $helperSet;
// return ConsoleRunner::createHelperSet(Config::getInstance()->entityManager);