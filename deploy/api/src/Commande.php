<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 * 
 * @ORM\Entity
 * @ORM\Table(name="commande")
 */

class Commande
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="ID", type="integer")
     * @ORM\GeneratedValue(strategy="Identity")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="ID_Client", type="integer", nullable=false)
     */
    private $idClient;

    /**
     * @var string
     * @ORM\Column(name="Reference", type="string", length=20, nullable=false)
     */
    private $reference;

    /**
     * Get id
     * 
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Get idClient
     * 
     * @return int
     */
    public function getIdClient(){
        return $this->idClient;
    }

    /**
     * Set idClient
     * 
     * @param int $idClient
     * @return Commande
     */
    public function setIdClient($idClient){
        $this->idClient = $idClient;
        return $this;
    }

    /**
     * Get reference
     * 
     * @return string
     */
    public function getReference(){
        return $this->reference;
    }

    /**
     * Set reference
     * 
     * @param string $reference
     * @return Commande
     */
    public function setReference($reference){
        $this->reference = $reference;
        return $this;
    }
}