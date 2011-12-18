<?php
namespace Mldic\ApiBundle\Tests\Functional;

use Mldic\ApiBundle\Tests\Functional\Util\DatabaseCredentials;
use Mldic\ApiBundle\Tests\Functional\Util\DatabaseHelper;

class TestCase extends \PHPUnit_Framework_TestCase
{
    private $dbHelper;
    
    public function setUp()
    {
        $this->initializeDbHelper();
        $this->loadTestDatabase();
    }
    
    private function initializeDbHelper()
    {
        if (!isset($this->dbHelper)) {
            $dbCredentials = new DatabaseCredentials($_SERVER['SYMFONY__DATABASE__HOST'],
                                                     $_SERVER['SYMFONY__DATABASE__NAME'],
                                                     $_SERVER['SYMFONY__DATABASE__USER'],
                                                     $_SERVER['SYMFONY__DATABASE__PASSWORD']);

            $this->dbHelper = new DatabaseHelper(__DIR__.'/../../../../../'.TEST_DB_SQL_FILE,
                                                 $dbCredentials);
        }
    }
    
    protected function loadTestDatabase()
    {
        $this->dbHelper->loadTestDatabase();
    }
    
    protected function getDatabaseConnection()
    {
        return $this->dbHelper->getDatabaseConnection();
    }
}
