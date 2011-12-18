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
                            'language_id' => 1,
                            'created_by' => 1,
                            'created_date' => null,
                            'modified_by' => 1,
                            'modified_date' => null);
        
        $language = $this->getMockBuilder('Mldic\ApiBundle\Model\Language')
            ->disableOriginalConstructor()->getMock();
        
        $this->languageMapper->expects($this->once())
            ->method('findById')
            ->with($attributes['language_id'])
            ->will($this->returnValue($language));
        
        $user = $this->getMockBuilder('Mldic\ApiBundle\Model\User')
            ->disableOriginalConstructor()->getMock();
        
        $this->userMapper->expects($this->exactly(2))
            ->method('findById')
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
    
    public function testShouldThrowExceptionIfLanguageWithGivenIdCannotBeFound()
    {
        // Given
        $attributes = array('id' => 1,
                            'phrase' => 'some phrase',
                            'language_id' => 9999999,
                            'created_by' => 1,
                            'created_date' => null,
                            'modified_by' => null,
                            'modified_date' => null);
        
        $this->languageMapper->expects($this->once())
            ->method('findById')
            ->with($attributes['language_id'])
            ->will($this->returnValue(null));
        
        $this->setExpectedException('\RuntimeException');
        
        // When
        $entry = $this->entryBuilder->build($attributes);
    }
    
    public function testShouldThrowExceptionIfCreatedByWithGivenIdCannotBeFound()
    {
        // Given
        $attributes = array('id' => 1,
                            'phrase' => 'some phrase',
                            'language_id' => 1,
                            'created_by' => 9999999,
                            'created_date' => null,
                            'modified_by' => null,
                            'modified_date' => null);
        
        $language = $this->getMockBuilder('Mldic\ApiBundle\Model\Language')
            ->disableOriginalConstructor()->getMock();
        
        $this->languageMapper->expects($this->once())
            ->method('findById')
            ->with($attributes['language_id'])
            ->will($this->returnValue($language));
        
        $this->userMapper->expects($this->once())
            ->method('findById')
            ->with($attributes['created_by'])
            ->will($this->returnValue(null));
        
        $this->setExpectedException('\RuntimeException');
        
        // When
        $entry = $this->entryBuilder->build($attributes);
    }
    
    public function testShouldThrowExceptionIfModifiedByWithGivenIdCannotBeFound()
    {
        // Given
        $attributes = array('id' => 1,
                            'phrase' => 'some phrase',
                            'language_id' => 1,
                            'created_by' => 1,
                            'created_date' => null,
                            'modified_by' => 9999999,
                            'modified_date' => null);
        
        $language = $this->getMockBuilder('Mldic\ApiBundle\Model\Language')
            ->disableOriginalConstructor()->getMock();
        
        $this->languageMapper->expects($this->once())
            ->method('findById')
            ->with($attributes['language_id'])
            ->will($this->returnValue($language));
        
        $user = $this->getMockBuilder('Mldic\ApiBundle\Model\User')
            ->disableOriginalConstructor()->getMock();
        
        $this->userMapper->expects($this->at(0))
            ->method('findById')
            ->with($attributes['created_by'])
            ->will($this->returnValue($user));
        $this->userMapper->expects($this->at(1))
            ->method('findById')
            ->with($attributes['modified_by'])
            ->will($this->returnValue(null));
        
        $this->setExpectedException('\RuntimeException');
        
        // When
        $entry = $this->entryBuilder->build($attributes);
    }
}
