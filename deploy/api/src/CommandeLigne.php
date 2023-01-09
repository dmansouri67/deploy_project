<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * CommandeLigne
 * 
 * @ORM\Entity
 * @ORM\Table(name="commande_ligne")
 */

class CommandeLigne
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="ID", type="integer")
     * @ORM\GeneratedValue(strategy="Identity")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(name="Reference", type="string", length=20, nullable=false)
     */
    private $reference;

    /**
     * @var int
     * @ORM\Column(name="ID_Produit", type="integer", nullable=false)
     */
    private $idProduit;

    /**
     * @var int
     * @ORM\Column(name="Qte", type="integer", nullable=false)
     */
    private $qte;

    /**
     * Get id
     * 
     * @return int
     */
    public function getId(){
        return $this->id;
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
     * @return CommandeLigne
     */
    public function setReference($reference){
        $this->reference = $reference;
        return $this;
    }

    /**
     * Get idProduit
     * 
     * @return int
     */
    public function getIdProduit(){
        return $this->idProduit;
    }

    /**
     * Set idProduit
     * 
     * @param int $idProduit
     * @return CommandeLigne
     */
    public function setIdProduit($idProduit){
        $this->idProduit = $idProduit;
        return $this;
    }

    /**
     * Get qte
     * 
     * @return int
     */
    public function getQte(){
        return $this->qte;
    }

    /**
     * Set qte
     * 
     * @param int $qte
     * @return CommandeLigne
     */
    public function setQte($qte){
        $this->qte = $qte;
        return $this;
    }
}