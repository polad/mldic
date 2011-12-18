<?php
namespace Mldic\ApiBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Mldic\ApiBundle\Tests\Functional\Util\DatabaseCredentials;
use Mldic\ApiBundle\Tests\Functional\Util\DatabaseHelper;

class WebTestCase extends BaseWebTestCase
{
    private $dbHelper;
    protected $client;
    
    public function setUp()
    {
        $this->initializeDbHelper();
        $this->loadTestDatabase();
        $this->client = static::createClient();
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
    
    protected function getResponseContent()
    {
        $response = $this->client->getResponse()->getContent();
        return json_decode($response, true);
    }
}
