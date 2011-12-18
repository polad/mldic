<?php
namespace Mldic\ApiBundle\Tests\Functional\Controller;

use Mldic\ApiBundle\Tests\Functional\WebTestCase;

class EntriesControllerTest extends WebTestCase
{
    public function testShouldFindEntriesByPhrase()
    {
        // Given
        $searchPhrase = 'abdomen';
        
        // When
        $this->client->request('GET', '/entries/'.$searchPhrase);
        
        // Then
        $response = $this->getResponseContent();
        $this->assertEquals($searchPhrase, $response[0]['phrase']);
    }
    
    public function testShouldNotFindEntriesByPhrase()
    {
        // Given
        $searchPhrase = 'unknown';
        
        // When
        $this->client->request('GET', '/entries/'.$searchPhrase);
        
        // Then
        $this->assertEmpty($this->getResponseContent());
    }
    
    public function testShouldFindEntryByPhraseAndLanguage()
    {
        // Given
        $searchPhrase = 'abdomen';
        $language = 'en';
        
        // When
        $this->client->request('GET', '/entries/'.$searchPhrase.'/'.$language);
        
        // Then
        $response = $this->getResponseContent();
        $this->assertEquals($searchPhrase, $response['phrase']);
        $this->assertEquals($language, $response['language']['code']);
    }
    
    public function testShouldNotFindEntryByPhraseAndLanguage()
    {
        // Given
        $searchPhrase = 'unknown';
        $language = 'un';
        
        // When
        $this->client->request('GET', '/entries/'.$searchPhrase.'/'.$language);
        
        // Then
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
}
