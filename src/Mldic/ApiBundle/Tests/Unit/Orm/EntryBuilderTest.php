<?php
namespace Mldic\ApiBundle\Tests\Unit\Orm;

use Mldic\ApiBundle\Orm\EntryBuilder;

class EntryBuilderTest extends \PHPUnit_Framework_TestCase
{
    private $entryBuilder;
    private $languageMapper;
    private $userMapper;
    
    public function setUp()
    {
        $this->languageMapper = $this->getMockBuilder('Mldic\ApiBundle\Orm\LanguageMapper')
            ->disableOriginalConstructor()->getMock();
        $this->userMapper = $this->getMockBuilder('Mldic\ApiBundle\Orm\UserMapper')
            ->disableOriginalConstructor()->getMock();
        $this->entryBuilder = new EntryBuilder($this->languageMapper, $this->userMapper);
    }
    
    public function testShouldBuildEntryObject()
    {
        // Given
        $attributes = array('id' => 1,
                      'phrase' => 'abdomen',
                      'language' => 1,
                      'created_by' => 1,
                      'created_date' => null,
                      'modified_by' => 1,
                      'modified_date' => null);
        
        $language = $this->getMockBuilder('Mldic\ApiBundle\Model\Language')
            ->disableOriginalConstructor()->getMock();
        $user = $this->getMockBuilder('Mldic\ApiBundle\Model\User')
            ->disableOriginalConstructor()->getMock();
        
        $this->languageMapper->expects($this->once())
            ->method('get')
            ->with($attributes['language'])
            ->will($this->returnValue($language));
        
        $this->userMapper->expects($this->exactly(2))
            ->method('get')
            ->will($this->returnValue($user));
        
        // When
        $entry = $this->entryBuilder->build($attributes);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Entry', $entry);
        $this->assertEquals($attributes['id'], $entry->getId());
        $this->assertEquals($attributes['phrase'], $entry->getPhrase());
    }
    
    public function testShouldBuildEmptyEntryObjectIfNoAttributesProvided()
    {
        // Given
        $language = $this->getMockBuilder('Mldic\ApiBundle\Model\Language')
            ->disableOriginalConstructor()->getMock();
        $user = $this->getMockBuilder('Mldic\ApiBundle\Model\User')
            ->disableOriginalConstructor()->getMock();
        
        $this->languageMapper->expects($this->once())
            ->method('build')
            ->will($this->returnValue($language));
        
        $this->userMapper->expects($this->exactly(2))
            ->method('build')
            ->will($this->returnValue($user));
        
        // When
        $entry = $this->entryBuilder->build();
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Entry', $entry);
        $this->assertNull($entry->getId());
        $this->assertNull($entry->getPhrase());
    }
}
