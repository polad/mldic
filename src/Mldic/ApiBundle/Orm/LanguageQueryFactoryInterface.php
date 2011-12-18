<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

interface LanguageQueryFactoryInterface extends QueryFactoryInterface
{
    public function getFindAllQuery();
    public function getFindByCodeQuery($code);
}
