<?php
/**
 * @package orm
 * @subpackage pdo
 */
namespace Mldic\ApiBundle\Orm\PDO;

use Mldic\ApiBundle\Orm\DataAccessInterface;
use Mldic\ApiBundle\Orm\QueryInterface;

class DataAccess implements DataAccessInterface
{
    private $dbh;
    
    public function __construct(\PDO $dbh)
    {
        $this->dbh = $dbh;
    }
    
    public function execute(QueryInterface $query)
    {
        $strSql = $query->getSql();
        $params = $query->getParameters();
        $stmt = $this->dbh->prepare($strSql);
        $stmt->execute($params);
        $dataSet = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $dataSet[] = $row;
        }
        return $dataSet;
    }
}
