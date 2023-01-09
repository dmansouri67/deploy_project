<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Doctrine\ORM\EntityManager;

class ProductController
{
    private EntityManager $_entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->_entityManager = $entityManager;
    }

    public function getProducts(Request $request, Response $response, array $args): Response
    {
        $repository = $this->_entityManager->getRepository('Products');
        $dbProducts = $repository->findAll();

        if (!$dbProducts == null) {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(204);
        }

        $products = [];

        foreach($dbProducts as $dbProduct)
        {
            $products = [
                'Reference' => $dbProduct->getReference(),
                'ID_Produit' => $dbProduct->getIdProduit(),
                'Nom' => $dbProduct->getNom(),
                'Description' => $dbProduct->getDescription(),
                'Prix' => $dbProduct->getPrix(),
                'Image' => $dbProduct->getImage(),
                'Type' => $dbProduct->getType(),
                'Etat' => $dbProduct->getEtat()
            ];    
        }

        $response->getBody()->write(json_encode($products));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function getProduct(Request $request, Response $response, array $args):Response
    {
        $Reference = $args["Reference"] ?? "";

        if (!$Reference)
        {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $repository = $this->_entityManager->getRepository('Products');
        $dbProduct = $repository->findOneBy(array("reference" => $Reference));

        if ($dbProduct == null) {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(204);
        }

        $product = [
            'Reference' => $dbProduct->getReference(),
            'ID_Produit' => $dbProduct->getIdProduit(),
            'Nom' => $dbProduct->getNom(),
            'Description' => $dbProduct->getDescription(),
            'Prix' => $dbProduct->getPrix(),
            'Image' => $dbProduct->getImage(),
            'Type' => $dbProduct->getType(),
            'Etat' => $dbProduct->getEtat()
        ];

        $response->getBody()->write(json_encode($product));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}