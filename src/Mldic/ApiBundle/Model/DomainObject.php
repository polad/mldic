<?php
/**
 * @package model
 */
namespace Mldic\ApiBundle\Model;

class DomainObject implements ConvertibleToArray
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
    
    public function toArray()
    {
        return array('id' => $this->getId());
    }
}
