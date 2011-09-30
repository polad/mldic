<?php
/**
 * @package orm
 * @subpackage pdo
 */
namespace Mldic\ApiBundle\Orm\PDO;

use Mldic\ApiBundle\Orm\QueryFactoryInterface;

class EntryQueryFactory implements QueryFactoryInterface
{
    public function findAll()
    {
        return new Query('SELECT * FROM entries');
    }
    
    public function findWithConditions(array $conditions)
    {
        foreach ($conditions as $cond) {
            $this->parseCondition($cond);
        }
    }
    
    public function findById($id)
    {
        return new Query('SELECT * FROM entries WHERE id=:id',
                         array('id' => $id));
    }
    
    public function parseCondition($condition)
    {
        if (count($condition) == 3) {
            list($field, $comparator, $value) = $condition;
        } elseif (count($condition) == 2) {
            $comparator = 'eq';
            list($field, $value) = $condition;
        } elseif (count($condition) == 1) {
            $field = key($condition[0]);
            $relatedQueryFactory = $this->getRelatedQueryFactory($field);
            $relatedQueryFactory->parseCondition($condition);
        }
    }
    
    private function getRelatedQueryFactory($field)
    {
        switch ($field) {
        case 'language':
            return $this->languageQueryFactory;
        case 'created_by':
        case 'modified_by':
            return $this->userQueryFactory;
        }
    }
}
