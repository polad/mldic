<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

use Mldic\ApiBundle\Model\Language;

class LanguageBuilder implements DomainObjectBuilderInterface
{
    public function build(array $attributes = array())
    {
        return new Language(isset($attributes['id']) ? $attributes['id'] : null,
                            isset($attributes['code']) ? $attributes['code'] : null,
                            isset($attributes['name']) ? $attributes['name'] : null);
    }
}
