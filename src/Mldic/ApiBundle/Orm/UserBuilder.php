<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

use Mldic\ApiBundle\Model\User;

class UserBuilder implements DomainObjectBuilderInterface
{
    public function build(array $attributes = null)
    {
        return new User($attributes['id'],
                        $attributes['username'],
                        $attributes['first_name'],
                        $attributes['last_name']);
    }
}
