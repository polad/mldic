<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

interface DataAccessInterface
{
    public function execute(QueryInterface $query);
}
