<?php
namespace Mldic\ApiBundle\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testShouldReturnApiEntryPoints()
    {
        // Given
        $expectedResponse = array('entries' => array('link' => array('href' => '/entries')),
                                  'languages' => array('link' => array('href' => '/languages')),
                                  'users' => array('link' => array('href' => '/users')));
        
        $client = static::createClient();
        
        // When
        $crawler = $client->request('GET', '/');
        
        // Then
        //$this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
        $this->assertEquals($expectedResponse, json_decode($client->getResponse()->getContent(), true));
    }
}
