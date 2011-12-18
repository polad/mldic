<?php
namespace Mldic\ApiBundle\Tests\Unit\Orm;

use Mldic\ApiBundle\Orm\LanguageMapper;

class LanguageMapperTest extends \PHPUnit_Framework_TestCase
{
    private $dataAccess;
    private $domainObjectBuilder;
    private $queryFactory;
    private $languageMapper;
    
    public function setUp()
    {
        $this->dataAccess = $this->getMock('Mldic\ApiBundle\Orm\DataAccessInterface');
        $this->domainObjectBuilder = $this->getMock('Mldic\ApiBundle\Orm\LanguageBuilder');
        $this->queryFactory = $this->getMock('Mldic\ApiBundle\Orm\LanguageQueryFactoryInterface');
        $this->languageMapper = new LanguageMapper($this->dataAccess,
                                                   $this->domainObjectBuilder,
                                                   $this->queryFactory);
    }
    
    public function testShouldFindAllLanguages()
    {
        // Given
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        
        $this->queryFactory->expects($this->once())
            ->method('getFindAllQuery')
            ->will($this->returnValue($query));
        
        $dataSet = array(array('id' => 1, 'code' => 'en', 'name' => 'English'),
                         array('id' => 3, 'code' => 'hu', 'name' => 'Hungarian'));
        
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($dataSet));
        
        $this->domainObjectBuilder->expects($this->exactly(count($dataSet)))
            ->method('build');
        
        // When
        $this->languageMapper->findAll();
    }
    
    public function testShouldFindLanguageByCode()
    {
        // Given
        $languageCode = 'en';
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        
        $this->queryFactory->expects($this->once())
            ->method('getFindByCodeQuery')
            ->with($languageCode)
            ->will($this->returnValue($query));
        
        $dataSet = array(array('id' => 1, 'code' => 'en', 'name' => 'English'));
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->with($query)
            ->will($this->returnValue($dataSet));
        
        $this->domainObjectBuilder->expects($this->exactly(count($dataSet)))
            ->method('build');
        
        // When
        $this->languageMapper->findByCode($languageCode);
    }
    
    public function testShouldNotFindLanguageByCode()
    {
        // Given
        $languageCode = 'unknown';
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        
        $this->queryFactory->expects($this->once())
            ->method('getFindByCodeQuery')
            ->with($languageCode)
            ->will($this->returnValue($query));
        
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(array()));
        
        $this->domainObjectBuilder->expects($this->never())
            ->method('build');
        
        // When
        $result = $this->languageMapper->findByCode($languageCode);
    }
}
