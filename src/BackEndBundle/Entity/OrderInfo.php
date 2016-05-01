<?php

namespace BackEndBundle\Entity;

/**
 * OrderInfo
 */
class OrderInfo
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $first_name;

    /**
     * @var string
     */
    private $last_name;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $postcode;

    /**
     * @var string
     */
    private $address_line;

    /**
     * @var string
     */
    private $email_address;

    /**
     * @var string
     */
    private $phone_number;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return OrderInfo
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return OrderInfo
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return OrderInfo
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
     * Set postcode
     *
     * @param string $postcode
     *
     * @return OrderInfo
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set addressLine
     *
     * @param string $addressLine
     *
     * @return OrderInfo
     */
    public function setAddressLine($addressLine)
    {
        $this->address_line = $addressLine;

        return $this;
    }

    /**
     * Get addressLine
     *
     * @return string
     */
    public function getAddressLine()
    {
        return $this->address_line;
    }

    /**
     * Set emailAddress
     *
     * @param string $emailAddress
     *
     * @return OrderInfo
     */
    public function setEmailAddress($emailAddress)
    {
        $this->email_address = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->email_address;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return OrderInfo
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phone_number = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }
}

