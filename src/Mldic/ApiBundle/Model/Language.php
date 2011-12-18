<?php
/**
 * @package model
 */
namespace Mldic\ApiBundle\Model;

class Language extends DomainObject
{
    private $code;
    private $name;
    
    public function __construct($id, $code, $name)
    {
        parent::__construct($id);
        $this->code = $code;
        $this->name = $name;
    }
    
    public function getCode()
    {
        return $this->code;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function toArray()
    {
        return array_merge(parent::toArray(),
                           array('code' => $this->getCode(),
                                 'name' => $this->getName()));
    }
}
