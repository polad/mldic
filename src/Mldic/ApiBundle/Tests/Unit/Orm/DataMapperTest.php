<?php
namespace Mldic\ApiBundle\Tests\Unit\Orm;

use Mldic\ApiBundle\Orm\DataMapper;

class DataMapperTest extends \PHPUnit_Framework_TestCase
{
    private $dataMapper;
    private $dataAccess;
    private $domainObjectBuilder;
    private $queryFactory;
    
    public function setUp()
    {
        $this->dataAccess = $this->getMock('Mldic\ApiBundle\Orm\DataAccessInterface');
        $this->domainObjectBuilder = $this->getMock('Mldic\ApiBundle\Orm\DomainObjectBuilderInterface');
        $this->queryFactory = $this->getMock('Mldic\ApiBundle\Orm\QueryFactoryInterface');
        $this->dataMapper = new DataMapper($this->dataAccess,
                                           $this->domainObjectBuilder,
                                           $this->queryFactory);
    }
    
    public function testShouldFindAllObjects()
    {
        // Given
        $dataSet = array(array('id' => 1), array('id' => 2));
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        $obj1 = $this->getMock('Mldic\ApiBundle\Model\DomainObject', null,
                               array($dataSet[0]['id']));
        $obj2 = $this->getMock('Mldic\ApiBundle\Model\DomainObject', null,
                               array($dataSet[1]['id']));
        
        $this->queryFactory->expects($this->once())
            ->method('findAll')
            ->will($this->returnValue($query));
        
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->with($query)
            ->will($this->returnValue($dataSet));
        
        $this->domainObjectBuilder->expects($this->exactly(2))
            ->method('build')
            ->will($this->onConsecutiveCalls($obj1, $obj2));
        
        // When
        $foundObjects = $this->dataMapper->all();
        
        // Then
        $this->assertEquals(count($dataSet), count($foundObjects));
        $this->assertInstanceOf('Mldic\ApiBundle\Model\DomainObject', $foundObjects[0]);
    }
    
    public function testShouldFindObjectsWithConditions()
    {
        // Given
        $conditions = array('property' => 'value');
        $dataSet = array(array('id' => 1, 'property' => $conditions['property']));
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        $obj = $this->getMock('Mldic\ApiBundle\Model\DomainObject', null,
                              array($dataSet[0]['id']));
        
        $this->queryFactory->expects($this->once())
            ->method('findWithConditions')
            ->with($conditions)
            ->will($this->returnValue($query));
        
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->with($query)
            ->will($this->returnValue($dataSet));
        
        $this->domainObjectBuilder->expects($this->once())
            ->method('build')
            ->will($this->returnValue($obj));
        
        // When
        $foundObjects = $this->dataMapper->all($conditions);
        
        // Then
        $this->assertGreaterThanOrEqual(1, count($foundObjects));
        $this->assertInstanceOf('Mldic\ApiBundle\Model\DomainObject', $foundObjects[0]);
    }
    
    public function testShouldFindObjectById()
    {
        // Given
        $objId = 20;
        $dataSet = array(array('id' => $objId));
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        $obj = $this->getMock('Mldic\ApiBundle\Model\DomainObject', null,
                              array($objId));
        
        $this->queryFactory->expects($this->once())
            ->method('findById')
            ->with($objId)
            ->will($this->returnValue($query));
        
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->with($query)
            ->will($this->returnValue($dataSet));
        
        $this->domainObjectBuilder->expects($this->once())
            ->method('build')
            ->will($this->returnValue($obj));
        
        // When
        $foundObject = $this->dataMapper->get($objId);
        
        // Then
        $this->assertEquals($objId, $foundObject->getId());
    }
}
