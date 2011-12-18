<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

use Mldic\ApiBundle\Model\User;

class UserBuilder implements DomainObjectBuilderInterface
{
    public function build(array $attributes = array())
    {
        return new User(isset($attributes['id']) ? $attributes['id'] : null,
                        isset($attributes['username']) ? $attributes['username'] : null,
                        isset($attributes['first_name']) ? $attributes['first_name'] : null,
                        isset($attributes['last_name']) ? $attributes['last_name'] : null);
    }
}
