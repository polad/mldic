<?php
namespace Mldic\ApiBundle\Tests\Unit\Orm\PDO;

use Mldic\ApiBundle\Orm\PDO\DataAccess;

class DataAccessTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldExecuteQuery()
    {
        // Given
        $query = $this->getMockBuilder('Mldic\ApiBundle\Orm\PDO\Query')
            ->disableOriginalConstructor()->getMock();
        $dbh = $this->getMock('Mldic\ApiBundle\Tests\Unit\Orm\PDO\MockPDO');
        $dataAccess = new DataAccess($dbh);

        $stmt = $this->getMock('\PDOStatement');
        
        $query->expects($this->once())
            ->method('getSql');
        
        $dbh->expects($this->once())
            ->method('prepare')
            ->will($this->returnValue($stmt));
        
        $query->expects($this->once())
            ->method('getParameters');
        
        $stmt->expects($this->once())
            ->method('execute');
        
        $stmt->expects($this->exactly(3))
            ->method('fetch')
            ->will($this->onConsecutiveCalls(array('id'), array('id'), null));
        
        // When
        $dataSet = $dataAccess->execute($query);
    }
}
