<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

interface QueryFactoryInterface
{
    public function getFindByIdQuery($id);
}
