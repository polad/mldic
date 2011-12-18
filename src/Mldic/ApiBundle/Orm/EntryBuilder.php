<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

use Mldic\ApiBundle\Model\Entry;

class EntryBuilder implements DomainObjectBuilderInterface
{
    private $languageMapper;
    private $userMapper;
    
    public function __construct(LanguageMapper $languageMapper, UserMapper $userMapper)
    {
        $this->languageMapper = $languageMapper;
        $this->userMapper = $userMapper;
    }
    
    /**
     * @return Entry
     * @throws RuntimeException
     */
    public function build(array $attributes = array())
    {
        return new Entry(isset($attributes['id']) ? $attributes['id'] : null,
                         isset($attributes['phrase']) ? $attributes['phrase'] : null,
                         $this->getLanguage($attributes),
                         $this->getCreatedBy($attributes),
                         isset($attributes['created_date']) ? $attributes['created_date'] : null,
                         $this->getModifiedBy($attributes),
                         isset($attributes['modified_date']) ? $attributes['modified_date'] : null);
    }
    
    private function isValidId($attributes, $idName)
    {
        return array_key_exists($idName, $attributes)
            && !empty($attributes[$idName]);
    }
    
    private function findByIdOrBuildEmptyObject($attributes, $idName, $mapper)
    {
        if ($this->isValidId($attributes, $idName)) {
            return $mapper->findById($attributes[$idName]);
        }
        return $mapper->build();
    }
    
    private function getLanguage(array $attributes)
    {
        if ($result = $this->findByIdOrBuildEmptyObject($attributes,
                                                        'language_id',
                                                        $this->languageMapper)) {
            return $result;
        }
        throw new \RuntimeException('Can not find Language with Id ' . $attributes['language_id']);
    }
    
    private function getCreatedBy(array $attributes)
    {
        if ($result = $this->findByIdOrBuildEmptyObject($attributes,
                                                        'created_by',
                                                        $this->userMapper)) {
            return $result;
        }
        throw new \RuntimeException('Can not find User with Id ' . $attributes['created_by']);
    }
    
    private function getModifiedBy(array $attributes)
    {
        if ($result = $this->findByIdOrBuildEmptyObject($attributes,
                                                        'modified_by',
                                                        $this->userMapper)) {
            return $result;
        }
        throw new \RuntimeException('Can not find User with Id ' . $attributes['modified_by']);
    }
}
