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
        
        $this->dataMapper->expects($this->once())
            ->method('findByPhrase')
            ->with($searchPhrase);
        
        // When
        $this->controller->findByPhraseAction($searchPhrase);
    }
    
    public function testShouldFindUniqueEntryByPhraseAndLanguage()
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
            ->will($this->returnValue(array($entry)));
        
        // When
        $foundEntry = $this->controller->findUniqueByPhraseAndLanguageAction($phrase, $language);
        
        // Then
        $this->assertSame($entry, $foundEntry);
    }
    
    public function testShouldNotFindUniqueEntryByPhraseAndLanguage()
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
        $foundEntry = $this->controller->findUniqueByPhraseAndLanguageAction($phrase, $language);
    }
    
    public function testShouldFindEntriesByPartialPhrase()
    {
        // Given
        $phrase = 'abd*en';
        $normalizedPhrase = str_replace('*', '%', $phrase);
        
        $this->dataMapper->expects($this->once())
            ->method('findByPhrase')
            ->with($normalizedPhrase);
        
        // When
        $this->controller->findByPhraseAction($phrase);
    }
    
    public function testShouldFindEntriesByPartialPhraseAndLanguage()
    {
        // Given
        $phrase = 'abd*en';
        $normalizedPhrase = str_replace('*', '%', $phrase);
        $language = 'en';
        
        $this->dataMapper->expects($this->once())
            ->method('findByPhraseAndLanguage')
            ->with($normalizedPhrase, $language);
        
        // When
        $this->controller->findByPhraseAndLanguageAction($phrase, $language);
    }
    
    public function testShouldFindSimilarEntriesByPhrase()
    {
        // Given
        $phrase = '~abdumen';
        
        $this->dataMapper->expects($this->once())
            ->method('findByPhrase')
            ->with($phrase);
        
        // When
        $this->controller->findByPhraseAction($phrase);
    }
    
    public function testShouldFindSimilarEntriesByPhraseAndLanguage()
    {
        // Given
        $phrase = '~abdumen';
        $language = 'en';
        
        $this->dataMapper->expects($this->once())
            ->method('findByPhraseAndLanguage')
            ->with($phrase, $language);
        
        // When
        $this->controller->findByPhraseAndLanguageAction($phrase, $language);
    }
}
