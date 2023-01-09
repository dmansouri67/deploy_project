<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 * 
 * @ORM\Entity
 * @ORM\Table(name="Client")
 */

class Client
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="ID_Client", type="integer")
     * @ORM\GeneratedValue(strategy="Identity")
     */
    private $idClient;

    /**
     * @var string
     * @ORM\Column(name="lastName", type="string", length=255, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     * @ORM\Column(name="firstName", type="string", length=255, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="userName", type="string", length=255, nullable=false)
     */
    private $userName;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * @var string
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     */
    private $city;

    /**
     * @var string
     * @ORM\Column(name="zipCode", type="string", length=255, nullable=false)
     */
    private $zipCode;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", length=255, nullable=false)
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(name="country", type="string", length=255, nullable=false)
     */
    private $country;

    /**
     * @var string
     * @ORM\Column(name="civility", type="string", length=255, nullable=false)
     */
    private $civility;

    /**
     * Get idClient
     * 
     * @return int
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * Set lastName
     * 
     * @param string $lastName
     * @return Client
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     * 
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     * 
     * @param string $firstName
     * @return Client
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     * 
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set userName
     * 
     * @param string $userName
     * @return Client
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     * 
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set email
     * 
     * @param string $email
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     * 
     * @param string $password
     * @return Client
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     * 
     * @return string
     */

    public function getPassword()

    {

        return $this->password;

    }

    /**
     * Set address
     * 
     * @param string $address
     * @return Client
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     * 
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     * 
     * @param string $city
     * @return Client
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     * 
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set zipCode
     * 
     * @param string $zipCode
     * @return Client
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     * 
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set phone
     * 
     * @param string $phone
     * @return Client
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     * 
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set country
     * 
     * @param string $country
     * @return Client
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     * 
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set civility
     * 
     * @param string $civility
     * @return Client
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;

        return $this;
    }

    /**
     * Get civility
     * 
     * @return string
     */
    public function getCivility()
    {
        return $this->civility;
    }

}