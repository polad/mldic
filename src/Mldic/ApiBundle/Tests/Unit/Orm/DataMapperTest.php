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
        $this->dataMapper = $this->getMockForAbstractClass('Mldic\ApiBundle\Orm\DataMapper',
                                                           array($this->dataAccess,
                                                                 $this->domainObjectBuilder,
                                                                 $this->queryFactory));
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
            ->method('getFindByIdQuery')
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
        $foundObject = $this->dataMapper->findById($objId);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Model\DomainObject', $foundObject);
        $this->assertEquals($objId, $foundObject->getId());
    }
    
    public function testShouldNotFindObjectById()
    {
        // Given
        $objId = 20;
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        $obj = $this->getMock('Mldic\ApiBundle\Model\DomainObject', null,
                              array($objId));
        
        $this->queryFactory->expects($this->once())
            ->method('getFindByIdQuery')
            ->with($objId)
            ->will($this->returnValue($query));
        
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->with($query)
            ->will($this->returnValue(array()));
        
        $this->domainObjectBuilder->expects($this->never())
            ->method('build');
        
        // When
        $foundObject = $this->dataMapper->findById($objId);
        
        // Then
        $this->assertNull($foundObject);
    }
}
