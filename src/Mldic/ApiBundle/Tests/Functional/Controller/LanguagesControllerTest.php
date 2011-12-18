<?php
namespace Mldic\ApiBundle\Tests\Functional\Controller;

use Mldic\ApiBundle\Tests\Functional\WebTestCase;

class LanguagesControllerTest extends WebTestCase
{
    public function testShouldFindAllLanguages()
    {
        // When
        $this->client->request('GET', '/languages');
        
        // Then
        $response = $this->getResponseContent();
        $this->assertGreaterThan(0, count($response));
    }
    
    public function testShouldFindLanguageByCode()
    {
        // Given
        $languageCode = 'en';
        
        // When
        $this->client->request('GET', '/languages/'.$languageCode);
        
        // Then
        $response = $this->getResponseContent();
        $this->assertEquals($languageCode, $response['code']);
    }
    
    public function testShouldNotFindLanguageByCode()
    {
        // When
        $this->client->request('GET', '/languages/unknown');
        
        // Then
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
}
