<?php
/**
 * @package orm
 * @subpackage pdo
 */
namespace Mldic\ApiBundle\Orm\PDO;

class MySQL extends \PDO
{
    public function __construct($dsn, $username = null, $password = null, $options = array())
    {
        parent::__construct($dsn, $username, $password, $options);
        $this->exec('SET NAMES utf8');
    }
}
