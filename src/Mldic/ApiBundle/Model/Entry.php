<?php
/**
 * @package model
 */
namespace Mldic\ApiBundle\Model;

class Entry extends DomainObject
{
    private $phrase;
    private $language;
    private $createdBy;
    private $createdDate;
    private $modifiedBy;
    private $modifiedDate;
    
    public function __construct($id, $phrase, Language $language, User $createdBy,
                                $createdDate, User $modifiedBy = null, $modifiedDate = null)
    {
        parent::__construct($id);
        $this->phrase = $phrase;
        $this->language = $language;
        $this->createdBy = $createdBy;
        $this->createdDate = $createdDate;
        $this->modifiedBy = $modifiedBy;
        $this->modifiedDate = $modifiedDate;
    }
    
    public function getPhrase()
    {
        return $this->phrase;
    }
    
    public function getLanguage()
    {
        return $this->language;
    }
    
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    public function getCreatedDate()
    {
        return $this->createdDate;
    }
    
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }
    
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }
}
