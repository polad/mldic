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
    
    public function testShouldFindUniqueEntryByPhraseAndLanguage()
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
    
    public function testShouldNotFindUniqueEntryByPhraseAndLanguage()
    {
        // Given
        $searchPhrase = 'unknown';
        $language = 'un';
        
        // When
        $this->client->request('GET', '/entries/'.$searchPhrase.'/'.$language);
        
        // Then
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
    
    public function testShouldFindEntriesByPartialPhrase()
    {
        // Given
        $searchPhrase = 'abd*en';
        
        // When
        $this->client->request('GET', '/entries/'.$searchPhrase);
        
        // Then
        $response = $this->getResponseContent();
        $resultPhrases = array_map(function($item) { return $item['phrase']; }, $response);
        $this->assertEquals(count($response), count(preg_grep('/^abd.*en$/', $resultPhrases)));
    }
    
    public function testShouldFindEntriesByPartialPhraseAndLanguage()
    {
        // Given
        $searchPhrase = 'abd*en';
        $language = 'en';
        
        // When
        $this->client->request('GET', '/entries/'.$searchPhrase.'/'.$language);
        
        // Then
        $response = $this->getResponseContent();
        $resultPhrases = array_map(function($item) { return $item['phrase']; }, $response);
        $this->assertEquals(count($response), count(preg_grep('/^abd.*en$/', $resultPhrases)));
    }
    
    public function testShouldNotFindEntriesByPartialPhraseAndLanguage()
    {
        // Given
        $searchPhrase = 'unk*wn';
        $language = 'un';
        
        // When
        $this->client->request('GET', '/entries/'.$searchPhrase.'/'.$language);
        
        // Then
        $this->assertEmpty($this->getResponseContent());
    }
    
    public function testShouldFindSimilarEntriesByPhrase()
    {
        // Given
        $searchPhrase = '~abdumen';
        $normalizedPhrase = str_replace('~', '', $searchPhrase);
        
        // When
        $this->client->request('GET', '/entries/'.$searchPhrase);
        
        // Then
        $response = $this->getResponseContent();
        foreach ($response as $item) {
            $this->assertLessThanOrEqual(3, levenshtein($normalizedPhrase, $item['phrase']));
        }
    }
    
    public function testShouldFindSimilarEntriesByPhraseAndLanguage()
    {
        // Given
        $searchPhrase = '~abdumen';
        $normalizedPhrase = str_replace('~', '', $searchPhrase);
        $language = 'en';
        
        // When
        $this->client->request('GET', '/entries/'.$searchPhrase.'/'.$language);
        
        // Then
        $response = $this->getResponseContent();
        foreach ($response as $item) {
            $this->assertLessThanOrEqual(3, levenshtein($normalizedPhrase, $item['phrase']));
        }
    }
    
    public function testShouldNotFindSimilarEntriesByPhraseAndLanguage()
    {
        // Given
        $searchPhrase = '~unknown';
        $normalizedPhrase = str_replace('~', '', $searchPhrase);
        $language = 'un';
        
        // When
        $this->client->request('GET', '/entries/'.$searchPhrase.'/'.$language);
        
        // Then
        $this->assertEmpty($this->getResponseContent());
    }
}
