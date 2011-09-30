<?php
namespace Mldic\ApiBundle\Tests\Unit\Orm;

use Mldic\ApiBundle\Orm\LanguageBuilder;

class LanguageBuilderTest extends \PHPUnit_Framework_TestCase
{
    private $languageBuilder;
    
    public function setUp()
    {
        $this->languageBuilder = new LanguageBuilder();
    }
    
    public function testShouldBuildLanguageObject()
    {
        // Given
        $attributes = array('id' => 1,
                            'code' => 'en',
                            'name' => 'English');
        
        //When
        $language = $this->languageBuilder->build($attributes);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Language', $language);
        $this->assertEquals($attributes['id'], $language->getId());
        $this->assertEquals($attributes['code'], $language->getCode());
        $this->assertEquals($attributes['name'], $language->getName());
    }
    
    public function testShouldBuildEmptyLanguageObjectIfNoAttributesProvided()
    {
        // When
        $language = $this->languageBuilder->build();
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Language', $language);
        $this->assertNull($language->getId());
        $this->assertNull($language->getCode());
        $this->assertNull($language->getName());
    }
}
