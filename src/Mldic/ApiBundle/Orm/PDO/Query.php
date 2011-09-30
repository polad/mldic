<?php
/**
 * @package orm
 * @subpackage pdo
 */
namespace Mldic\ApiBundle\Orm\PDO;

use Mldic\ApiBundle\Orm\QueryInterface;

class Query implements QueryInterface
{
    private $sql;
    private $parameters = array();
    
    public function __construct($sql, array $parameters = array())
    {
        $this->sql = $sql;
        $this->parameters = $parameters ?: array();
    }
    
    public function getSql()
    {
        return $this->sql;
    }
    
    public function getParameters()
    {
        return $this->parameters;
    }
}
