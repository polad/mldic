<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

use Mldic\ApiBundle\Model\Language;

class LanguageBuilder implements DomainObjectBuilderInterface
{
    public function build(array $attributes = null)
    {
        return new Language($attributes['id'],
                            $attributes['code'],
                            $attributes['name']);
    }
}
