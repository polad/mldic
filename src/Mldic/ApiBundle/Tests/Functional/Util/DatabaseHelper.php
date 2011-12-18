<?php
namespace Mldic\ApiBundle\Tests\Functional\Util;

class DatabaseHelper
{
    private $pathToTestDbSql;
    private $dbCredentials;
    private $dbConnection;
    
    public function __construct($pathToTestDbSql, DatabaseCredentials $dbCredentials)
    {
        $this->pathToTestDbSql = $pathToTestDbSql;
        $this->dbCredentials = $dbCredentials;
    }
    
    public function loadTestDatabase()
    {
        exec('mysql -u '.$this->dbCredentials->getUser().
             ' -p'.$this->dbCredentials->getPassword().
             ' < '.$this->pathToTestDbSql);
    }
    
    public function getDatabaseConnection()
    {
        if (!isset($this->dbConnection)) {
            $this->dbConnection = new \PDO('mysql:host='.$this->dbCredentials->getHost().';'.
                                           'dbname='.$this->dbCredentials->getName(),
                                           $this->dbCredentials->getUser(),
                                           $this->dbCredentials->getPassword());
        }
        return $this->dbConnection;
    }
}
