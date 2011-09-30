<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

interface QueryFactoryInterface
{
    public function findAll();
    public function findWithConditions(array $conditions);
    public function findById($id);
}
