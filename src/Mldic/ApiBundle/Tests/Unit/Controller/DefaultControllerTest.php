<?php
namespace Mldic\ApiBundle\Tests\Unit\Controller;

use Mldic\ApiBundle\Controller\DefaultController;

class DefaultControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldReturnAPIEntryPoints()
    {
        // Given
        $controller = new DefaultController();
        $entryPoints = array('entries' => array('link' => array('href' => '/entries')),
                             'languages' => array('link' => array('href' => '/languages')),
                             'users' => array('link' => array('href' => '/users')));
        
        // When
        $result = $controller->indexAction();
        
        // Then
        $this->assertEquals($entryPoints, $result);
    }
}
