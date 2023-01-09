<?php

namespace App\Controllers;

use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;

class JWTController
{
    public static function createJWT(Response $response, String $user) : Response
    {
        $issuedAt = time();

        $payload = array(
            'user' => $user,
            'iat' => $issuedAt,
            'exp' => $issuedAt + 3600
        );

        $token_jwt = JWT::encode($payload, $_ENV["JWT_SECRET"], "HS256");
        $response = $response->withHeader("Authorization", "Bearer {$token_jwt}");

        return $response;
    }

    // Check if the JWT Token is valid and not expire
    public static function isGoodJWT(Request $request) : bool
    {
        $token = explode("Bearer", $request->getHeader("Authorization")[0])[1];

        return JWTController::isGoodUser($token) && JWTController::isExpired($token);
    }

    private static function isGoodUser(string $token) : bool
    {
        global $entityManager;
        $payload = JWTController::getPayload($token);
        $user = $payload['user'];

        if($user)
        {
            $utilisateurRepository = $entityManager->getRepository('client');
            $utilisateur = $utilisateurRepository->findOneBy(array('username' => $user));

            if($utilisateur->getUsername() == $user)
            {
                return true;
            } else 
            {
                return false;
            }
        }
        return false;
    }

    public static function getUserID(Request $request):int
    {
        $token = explode("Bearer", $request->getHeader("Authorization")[0])[1];

        global $entityManager;
        $payload = JWTController::getPayload($token);
        $user = $payload['user'];
        
        if($user)
        {
            $utilisateurRepository = $entityManager->getRepository('client');
            $utilisateur = $utilisateurRepository->findOneBy(array('nom' => $user));
            
            if($utilisateur->getUsername() == $user)
            {
                return $utilisateur->getIdClient();
            } else 
            {
                return -1;
            }
        }
        return -1;
    }

    private static function getPayload($token)
    {
        $payloadToken = explode('.', $token);
        
        try {
            $payload = json_decode(base64_decode($payloadToken[1]), true);
        } catch (Exception $e) {
            return false;
        }

        return $payload;
    }

    private static function isExpired(string $token): bool
    {
        $payload = JWTController::getPayload($token);

        $now = time();
        
        return true;
    }
}