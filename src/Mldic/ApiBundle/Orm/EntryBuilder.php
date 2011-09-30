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
     */
    public function build(array $attributes = null)
    {
        if (isset($attributes['language'])) {
            $language = $this->languageMapper->get($attributes['language']);
        } else {
            $language = $this->languageMapper->build();
        }
        if (isset($attributes['created_by'])) {
            $createdBy = $this->userMapper->get($attributes['created_by']);
        } else {
            $createdBy = $this->userMapper->build();
        }
        if (isset($attributes['modified_by'])) {
            $modifiedBy = $this->userMapper->get($attributes['modified_by']);
        } else {
            $modifiedBy = $this->userMapper->build();
        }
        return new Entry($attributes['id'], $attributes['phrase'], $language,
                         $createdBy, $attributes['created_date'],
                         $modifiedBy, $attributes['modified_date']);
    }
}
