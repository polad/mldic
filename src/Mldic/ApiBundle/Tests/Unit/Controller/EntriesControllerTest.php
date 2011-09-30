<?php
namespace Mldic\ApiBundle\Tests\Unit\Controller;

use Mldic\ApiBundle\Controller\EntriesController;
use Symfony\Component\DependencyInjection\Container;

class EntriesControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller;
    private $datamapper;
    
    public function setUp()
    {
        $this->datamapper = $this->getMockBuilder('Mldic\ApiBundle\Orm\DataMapper')
            ->disableOriginalConstructor()->getMock();
        
        $container = new Container();
        $container->set('datamapper.entry', $this->datamapper);
        
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
        
        $this->datamapper->expects($this->once())
            ->method('all')
            ->with(array('phrase' => $searchPhrase))
            ->will($this->returnValue($entries));
        
        // When
        $foundEntries = $this->controller->searchByPhraseAction($searchPhrase);
        
        // Then
        $this->assertGreaterThanOrEqual(1, count($foundEntries));
        // And
        $this->assertEquals($entries, $foundEntries);
    }
    
    public function testShouldNotFindEntriesByPhrase()
    {
        // Given
        $searchPhrase = 'abdomen';
        
        $this->datamapper->expects($this->once())
            ->method('all')
            ->with(array('phrase' => $searchPhrase))
            ->will($this->returnValue(array()));
        
        // When
        $entries = $this->controller->searchByPhraseAction($searchPhrase);
        
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
        
        $this->datamapper->expects($this->once())
            ->method('all')
            ->with(array('phrase' => $phrase, 'language' => $language))
            ->will($this->returnValue(array($entry)));
        
        // When
        $foundEntry = $this->controller->searchByPhraseAndLanguageAction($phrase, $language);
        
        // Then
        $this->assertSame($entry, $foundEntry);
    }
    
    public function testShouldNotFindEntryByPhraseAndLanguage()
    {
        // Given
        $phrase = 'abdomen';
        $language = 'en';
        
        $this->datamapper->expects($this->once())
            ->method('all')
            ->with(array('phrase' => $phrase, 'language' => $language))
            ->will($this->returnValue(array()));
        
        $this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
        
        // When
        $foundEntry = $this->controller->searchByPhraseAndLanguageAction($phrase, $language);
    }
}
