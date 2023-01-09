<?php

namespace App\Controllers;

use Commande;
use CommandeLigne;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Doctrine\ORM\EntityManager;
use Exception;

class OrderController
{
    private EntityManager $_entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->_entityManager = $entityManager;
    }

    public function postBuy(Request $request, Response $response, array $args): Response
    {
        if(!JWTController::isGoodJWT($request))
        {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        $body = $request->getParsedBody();
        $json = $body['order'] ?? "";

        try {
            $data = json_decode($json, true);
        } catch (Exception $e) {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
        
        $carts = $data['carts'];
        
        if(!$carts) {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $reference = time() . JWTController::getUserID($request);

        foreach($carts as $cart)
        {
            $product = $cart['product'];

            $commandeLigne = new CommandeLigne;
            $commandeLigne->setReference($reference);
            $commandeLigne->setIdProduit($product['ID_Produit']);
            $commandeLigne->setQte($cart['Qte']);

            $this->_entityManager->persist($commandeLigne);
            $this->_entityManager->flush();
        }

        $commande = new Commande;
        $commande->setIdClient(JWTController::getUserID($request));
        $commande->setReference($reference);

        $this->_entityManager->persist($commande);
        $this->_entityManager->flush();

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function getOrders(Request $request, Response $response, array $args):Response
    {
        if (!JWTController::isGoodJWT($request)) {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        $id = JWTController::getUserID($request);
        $repositoryCommande = $this->_entityManager->getRepository("Commande");
        $dbCommande = $repositoryCommande->findBy(array("idClient" => $id), array("id" => 'DESC'));

        if ($dbCommande == null) {
            $response->withHeader('Content-Type', 'application/json')->withStatus(204);
        }

        $carts = [];
        $cart = [];
        $product = null;
        $Qte = null;

        foreach($dbCommande as $commande)
        {
            $repositoryCommandeLine = $this->_entityManager->getRepository("CommandeLigne");
            $dbCommandeLine = $repositoryCommandeLine->findBy(array("reference" => $commande->getReference()));

            foreach($dbCommandeLine as $line)
            {
                $repositoryProduit = $this->_entityManager->getRepository("Products");
                $dbProduct = $repositoryProduit->findOneBy(array("idProduit" => $line->getIdProduit()));
                $product = array(
                    "ID_Produit" => $dbProduct->getIdProduit(),
                    "Reference" => $dbProduct->getReference(),
                    "Intitule" => $dbProduct->getIntitule(),
                    "Prix" => $dbProduct->getPrix(),
                    "CheminImage" => $dbProduct->getCheminImage(),
                    "Description" => $dbProduct->getDescription(),
                    "Note" => $dbProduct->getNote(),
                    "Type" => $dbProduct->getType(),
                    "Etat" => $dbProduct->getEtat(),
                );
                $Qte = $line->getQte();

                $cart[] = [
                    "product" => $product,
                    "Qte" => $Qte
                ];
                
            }
            $carts[] = [
                "Reference" => $commande->getReference(),
                "carts" => $cart
            ];
            
            $product = null;
            $Qte = null;
            $cart = null;
        }

        $response->getBody()->write(json_encode($carts));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}