<?php
namespace Mldic\ApiBundle\Tests\Unit\Orm\PDO;

use Mldic\ApiBundle\Orm\PDO\Query;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldInstantiateQuery()
    {
        // Given
        $sql = 'SELECT * FROM sometable WHERE somecolumn=:somecolumn';
        $parameters = array('somecolumn' => 'somevalue');
        
        // When
        $query = new Query($sql, $parameters);
        
        // Then
        $this->assertEquals($sql, $query->getSql());
        $this->assertEquals($parameters, $query->getParameters());
    }
}
