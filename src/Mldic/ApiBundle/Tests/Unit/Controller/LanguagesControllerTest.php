<?php
namespace Mldic\ApiBundle\Tests\Unit\Controller;

use Mldic\ApiBundle\Controller\LanguagesController;
use Symfony\Component\DependencyInjection\Container;

class LanguagesControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller;
    private $dataMapper;
    
    public function setUp()
    {
        $this->dataMapper = $this->getMockBuilder('Mldic\ApiBundle\Orm\LanguageMapper')
            ->disableOriginalConstructor()->getMock();
        
        $container = new Container();
        $container->set('datamapper.language', $this->dataMapper);
        
        $this->controller = new LanguagesController();
        $this->controller->setContainer($container);
    }
    
    public function testShouldFindAllLanguages()
    {
        // Given
        $this->dataMapper->expects($this->once())
            ->method('findAll');
        
        // When
        $this->controller->findAllAction();
    }
    
    public function testShouldFindLanguageByCode()
    {
        // Given
        $languageCode = 'en';
        
        $language = $this->getMockBuilder('Mldic\ApiBundle\Model\Language')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->dataMapper->expects($this->once())
            ->method('findByCode')
            ->with($languageCode)
            ->will($this->returnValue($language));
        
        // When
        $result = $this->controller->findByCodeAction($languageCode);
        
        // Then
        $this->assertSame($language, $result);
    }
    
    public function testShouldNotFindLanguageByCode()
    {
        // Given
        $languageCode = 'unknown';
        
        $this->dataMapper->expects($this->once())
            ->method('findByCode')
            ->with($languageCode)
            ->will($this->returnValue(null));
        
        $this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
        
        // When
        $this->controller->findByCodeAction($languageCode);
    }
}
