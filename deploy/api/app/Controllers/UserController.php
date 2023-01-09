<?php

namespace App\Controllers;

use Client;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Doctrine\ORM\EntityManager;

class UserController
{
    private EntityManager $_entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->_entityManager = $entityManager;
    }

    public function postRegister(Request $request, Response $response, array $args): Response
    {
        $err = false;
        $body = $request->getParsedBody();
        
        $lastName = $body['lastName'] ?? "";
        $firstName = $body['firstName'] ?? "";
        $userName = $body['userName'] ?? "";
        $email = $body['email'] ?? "";
        $password = $body['password'] ?? "";
        $address = $body['address'] ?? "";
        $city = $body['city'] ?? "";
        $zipCode = $body['zipCode'] ?? "";
        $phone = $body['phone'] ?? "";
        $country = $body['country'] ?? "";
        $civility  = $body['civility'] ?? "";

        if(!$lastName || !$firstName || !$email || !$password || !$address || !$city || !$zipCode || !$phone || !$country || !$civility)
        {
            $err = true;
        }

        if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
            $err = true;
        }
        
        if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
            $err = true;
        }

        if (!preg_match("/^[a-zA-Z0-9 ]{1,}/",$userName)) {
            $err = true;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $err = true;
        }

        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/",$password)) {
            $err = true;
        }

        if (!preg_match("/^[a-zA-Z0-9 ]{1,}/",$address)) {
            $err = true;
        }

        if (!preg_match("/^[a-zA-Z ]{1,}/",$city)) {
            $err = true;
        }

        if (!preg_match("/^[0-9]{5}/",$zipCode)) {
            $err = true;
        }

        if (!preg_match("/^[0-9]{10}/",$phone)) {
            $err = true;
        }

        if(!preg_match("/^[a-zA-Z ]{1,}/",$country)) {
            $err = true;
        }

        if ($civility != "M" && $civility != "Mme") {
            $err = true;
        }

        if($err)
        {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $repository = $this->_entityManager->getRepository("Client");
        $dbUser = $repository->findOneBy(array("username" => $username));

        if ($dbUser == null) {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $client = new Client;
        $client->setLastName($lastName);
        $client->setFirstName($firstName);
        $client->setUserName($userName);
        $client->setEmail($email);
        $client->setPassword($password);
        $client->setAddress($address);
        $client->setCity($city);
        $client->setZipCode($zipCode);
        $client->setPhone($phone);
        $client->setCountry($country);
        $client->setCivility($civility);

        $this->_entityManager->persist($client);
        $this->_entityManager->flush();

        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function postLogin(Request $request, Response $response, array $args): Response
    {
        $err = false;
        $body = $request->getParsedBody();
        
        $username = $body['username'] ?? "";
        $password = $body['password'] ?? "";

        if(!$username || !$password)
        {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        if (!preg_match("/^[a-zA-Z0-9 ]{1,}/",$username)) {
            $err = true;
        }

        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/",$password)) {
            $err = true;
        }
        
        if($err)
        {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $repository = $this->_entityManager->getRepository("Client");
        $dbUser = $repository->findOneBy(array("username" => $username, "password" => $password));

        if ($dbUser == null) {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        if ($dbUser->getPassword() != $password and $dbUser->getUsername() != $username) {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $user = array(
            "Nomo" => $dbUser->getLastName(),
            "Prenom" => $dbUser->getFirstName(),
            "Login" => $dbUser->getUsername(),
            "Email" => $dbUser->getEmail(),
            "Adresse" => $dbUser->getAddress(),
            "Ville" => $dbUser->getCity(),
            "CP" => $dbUser->getZipCode(),
            "Tel" => $dbUser->getPhone(),
            "Ville" => $dbUser->getCountry(),
            "Civilite" => $dbUser->getCivility(),
            "Password" => $dbUser->getPassword(),
        );

        $response->getBody()->write(json_encode($user));
        $response = JWTController::createJWT($response, $username);

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}