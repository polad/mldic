<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

interface DomainObjectBuilderInterface
{
    public function build(array $data);
}
