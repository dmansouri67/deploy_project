<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 * 
 * @ORM\Entity
 * @ORM\Table(name="products")
 */

class Products
{
    /**
     * @var int
     * 
     * @ORM\Id
     * @ORM\Column(name="ID_Produit", type="integer")
     * @ORM\GeneratedValue(strategy="Identity")
     */
    private $idProduit;

    /**
     * @var string
     * 
     * @ORM\Column(name="Reference", type="string", length=20, nullable=false)
     */
    private $reference;

    /**
     * @var string
     * 
     * @ORM\Column(name="Nom", type="string", length=72, nullable=false)
     */
    private $nom;

    /**
     * @var string
     * 
     * @ORM\Column(name="Description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var float
     * 
     * @ORM\Column(name="Prix", type="float", precision=10, scale=0, nullable=true)
     */
    private $prix;

    /**
     * @var string
     * 
     * @ORM\Column(name="Image", type="string", length=85, nullable=true)
     */
    private $image;

    /**
     * @var string
     * 
     * @ORM\Column(name="Type", type="string", length=20, nullable=true)
     */
    private $type;

    /**
     * @var string
     * 
     * @ORM\Column(name="Etat", type="string", length=20, nullable=true)
     */
    private $etat;

    /**
     * Get idProduit
     * 
     * @return int
     */
    public function getIdProduit(){
        return $this->idProduit;
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
     * @return Products
     */
    public function setReference($reference){
        $this->reference = $reference;
        return $this;
    }

    /**
     * Get nom
     * 
     * @return string
     */
    public function getNom(){
        return $this->nom;
    }

    /**
     * Set nom
     * 
     * @param string $nom
     * @return Products
     */
    public function setNom($nom){
        $this->nom = $nom;
        return $this;
    }

    /**
     * Get description
     * 
     * @return string
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * Set description
     * 
     * @param string $description
     * @return Products
     */
    public function setDescription($description){
        $this->description = $description;
        return $this;
    }

    /**
     * Get prix
     * 
     * @return float
     */
    public function getPrix(){
        return $this->prix;
    }

    /**
     * Set prix
     * 
     * @param float $prix
     * @return Products
     */
    public function setPrix($prix){
        $this->prix = $prix;
        return $this;
    }

    /**
     * Get image
     * 
     * @return string
     */
    public function getImage(){
        return $this->image;
    }

    /**
     * Set image
     * 
     * @param string $image
     * @return Products
     */
    public function setImage($image){
        $this->image = $image;
        return $this;
    }

    /**
     * Get type
     * 
     * @return string
     */
    public function getType(){
        return $this->type;
    }

    /**
     * Set type
     * 
     * @param string $type
     * @return Products
     */
    public function setType($type){
        $this->type = $type;
        return $this;
    }

    /**
     * Get etat
     * 
     * @return string
     */
    public function getEtat(){
        return $this->etat;
    }

    /**
     * Set etat
     * 
     * @param string $etat
     * @return Products
     */
    public function setEtat($etat){
        $this->etat = $etat;
        return $this;
    }
}