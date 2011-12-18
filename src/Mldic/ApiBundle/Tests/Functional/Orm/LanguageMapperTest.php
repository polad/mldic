<?php
namespace Mldic\ApiBundle\Tests\Functional\Orm;

use Mldic\ApiBundle\Tests\Functional\TestCase;
use Mldic\ApiBundle\Orm\PDO\DataAccess;
use Mldic\ApiBundle\Orm\LanguageBuilder;
use Mldic\ApiBundle\Orm\PDO\LanguageQueryFactory;
use Mldic\ApiBundle\Orm\LanguageMapper;

class LanguageMapperTest extends TestCase
{
    private $languageMapper;
    
    public function setUp()
    {
        parent::setUp();
        $dbConnection = $this->getDatabaseConnection();
        $this->languageMapper = new LanguageMapper(new DataAccess($dbConnection),
                                                   new LanguageBuilder(),
                                                   new LanguageQueryFactory());
    }
    
    public function testShouldFindLanguageById()
    {
        // Given
        $languageId = 1;
        
        // When
        $result = $this->languageMapper->findById($languageId);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Language', $result);
        $this->assertEquals($languageId, $result->getId());
    }
    
    public function testShouldNotFindLanguageById()
    {
        // Given
        $languageId = 999999;
        
        // When
        $result = $this->languageMapper->findById($languageId);
        
        // Then
        $this->assertNull($result);
    }
    
    public function testShouldFindAllLanguages()
    {
        // When
        $result = $this->languageMapper->findAll();
        
        // Then
        $this->assertGreaterThan(0, count($result));
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Language', $result[0]);
    }
    
    public function testShouldFindLanguageByCode()
    {
        // Given
        $languageCode = 'en';
        
        // When
        $result = $this->languageMapper->findByCode($languageCode);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Language', $result);
        $this->assertEquals($languageCode, $result->getCode());
    }
    
    public function testShouldNotFindLanguageByCode()
    {
        // Given
        $languageCode = 'unknown';
        
        // When
        $result = $this->languageMapper->findByCode($languageCode);
        
        // Then
        $this->assertNull($result);
    }
}
