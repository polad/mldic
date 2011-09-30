<?php
/**
 * @package model
 */
namespace Mldic\ApiBundle\Model;

class DomainObject
{
    private $id;
    
    public function __construct($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
}
