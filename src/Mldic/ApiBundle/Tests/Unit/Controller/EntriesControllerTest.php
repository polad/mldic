<?php
namespace Mldic\ApiBundle\Tests\Unit\Controller;

use Mldic\ApiBundle\Controller\EntriesController;
use Symfony\Component\DependencyInjection\Container;

class EntriesControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller;
    private $dataMapper;
    
    public function setUp()
    {
        $this->dataMapper = $this->getMockBuilder('Mldic\ApiBundle\Orm\EntryMapper')
            ->disableOriginalConstructor()->getMock();
        
        $container = new Container();
        $container->set('datamapper.entry', $this->dataMapper);
        
        $this->controller = new EntriesController();
        $this->controller->setContainer($container);
    }
    
    public function testShouldFindEntriesByPhrase()
    {
        // Given
        $searchPhrase = 'abdomen';
        $entry = $this->getMockBuilder('Mldic\ApiBundle\Model\Entry')
            ->disableOriginalConstructor()
            ->getMock();
        $entries = array($entry);
        
        $this->dataMapper->expects($this->once())
            ->method('findByPhrase')
            ->with($searchPhrase)
            ->will($this->returnValue($entries));
        
        // When
        $foundEntries = $this->controller->findByPhraseAction($searchPhrase);
        
        // Then
        $this->assertGreaterThanOrEqual(1, count($foundEntries));
        // And
        $this->assertEquals($entries, $foundEntries);
    }
    
    public function testShouldNotFindEntriesByPhrase()
    {
        // Given
        $searchPhrase = 'abdomen';
        
        $this->dataMapper->expects($this->once())
            ->method('findByPhrase')
            ->with($searchPhrase)
            ->will($this->returnValue(array()));
        
        // When
        $entries = $this->controller->findByPhraseAction($searchPhrase);
        
        // Then
        $this->assertEmpty($entries);
    }
    
    public function testShouldFindEntryByPhraseAndLanguage()
    {
        // Given
        $phrase = 'abdomen';
        $language = 'en';
        $entry = $this->getMockBuilder('Mldic\ApiBundle\Model\Entry')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->dataMapper->expects($this->once())
            ->method('findByPhraseAndLanguage')
            ->with($phrase, $language)
            ->will($this->returnValue($entry));
        
        // When
        $foundEntry = $this->controller->findByPhraseAndLanguageAction($phrase, $language);
        
        // Then
        $this->assertSame($entry, $foundEntry);
    }
    
    public function testShouldNotFindEntryByPhraseAndLanguage()
    {
        // Given
        $phrase = 'abdomen';
        $language = 'en';
        
        $this->dataMapper->expects($this->once())
            ->method('findByPhraseAndLanguage')
            ->with($phrase, $language)
            ->will($this->returnValue(null));
        
        $this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
        
        // When
        $foundEntry = $this->controller->findByPhraseAndLanguageAction($phrase, $language);
    }
}
