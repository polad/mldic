<?php
/**
 * @package model
 */
namespace Mldic\ApiBundle\Model;

class User extends DomainObject
{
    private $username;
    private $firstName;
    private $lastName;
    private $password;
    
    public function __construct($id, $username, $firstName = null,
                                $lastName = null, $password = null)
    {
        parent::__construct($id);
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    public function getLastName()
    {
        return $this->lastName;
    }
}
