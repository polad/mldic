<?php
namespace Mldic\ApiBundle\Tests\Functional\Orm;

use Mldic\ApiBundle\Tests\Functional\TestCase;
use Mldic\ApiBundle\Orm\PDO\DataAccess;
use Mldic\ApiBundle\Orm\LanguageBuilder;
use Mldic\ApiBundle\Orm\PDO\LanguageQueryFactory;
use Mldic\ApiBundle\Orm\LanguageMapper;
use Mldic\ApiBundle\Orm\UserBuilder;
use Mldic\ApiBundle\Orm\PDO\UserQueryFactory;
use Mldic\ApiBundle\Orm\UserMapper;
use Mldic\ApiBundle\Orm\EntryBuilder;
use Mldic\ApiBundle\Orm\PDO\EntryQueryFactory;
use Mldic\ApiBundle\Orm\EntryMapper;

class EntryMapperTest extends TestCase
{
    private $entryMapper;
    
    public function setUp()
    {
        parent::setUp();

        $dbConnection = $this->getDatabaseConnection();
        $dataAccess = new DataAccess($dbConnection);
        
        $languageMapper = new LanguageMapper($dataAccess,
                                             new LanguageBuilder(),
                                             new LanguageQueryFactory());
        
        $userMapper = new UserMapper($dataAccess,
                                     new UserBuilder(),
                                     new UserQueryFactory());
        
        $domainObjectBuilder = new EntryBuilder($languageMapper, $userMapper);
        $this->entryMapper = new EntryMapper($dataAccess,
                                             $domainObjectBuilder,
                                             new EntryQueryFactory());
    }
    
    public function testShouldFindEntryById()
    {
        // Given
        $entryId = 20;
        
        // When
        $result = $this->entryMapper->findById($entryId);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Entry', $result);
        $this->assertEquals($entryId, $result->getId());
    }
    
    public function testShouldNotFindEntryById()
    {
        // Given
        $entryId = 999999;
        
        // When
        $result = $this->entryMapper->findById($entryId);
        
        // Then
        $this->assertNull($result);
    }
    
    public function testShouldFindEntriesByPhrase()
    {
        // Given
        $phrase = 'abdomen';
        
        // When
        $result = $this->entryMapper->findByPhrase($phrase);
        
        // Then
        $this->assertGreaterThan(0, count($result));
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Entry', $result[0]);
        $this->assertEquals($phrase, $result[0]->getPhrase());
    }
    
    public function testShouldNotFindEntriesByPhrase()
    {
        // Given
        $phrase = 'unknown';
        
        // When
        $result = $this->entryMapper->findByPhrase($phrase);
        
        // Then
        $this->assertEmpty($result);
    }
    
    public function testShouldFindEntryByPhraseAndLanguage()
    {
        // Given
        $phrase = 'abdomen';
        $language = 'en';
        
        // When
        $result = $this->entryMapper->findByPhraseAndLanguage($phrase, $language);
        
        // Then
        $this->assertEquals(1, count($result));
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Entry', $result[0]);
        $this->assertEquals($phrase, $result[0]->getPhrase());
        $this->assertEquals($language, $result[0]->getLanguage()->getCode());
    }
    
    public function testShouldNotFindEntryByPhraseAndLanguage()
    {
        // Given
        $phrase = 'unknown';
        $language = 'unknown';
        
        // When
        $result = $this->entryMapper->findByPhraseAndLanguage($phrase, $language);
        
        // Then
        $this->assertEmpty($result);
    }
    
    public function testShouldFindEntriesByPartialPhraseUsingWildcards()
    {
        // Given
        $phrase = 'abd%en';
        
        // When
        $result = $this->entryMapper->findByPhrase($phrase);
        
        // Then
        $this->assertGreaterThan(0, count($result));
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Entry', $result[0]);
        $resultPhrases = array_map(function($item) { return $item->getPhrase(); }, $result);
        $this->assertEquals(count($result), count(preg_grep('/^abd.*en$/', $resultPhrases)));
    }
    
    public function testShouldFindSimilarEntriesByPhrase()
    {
        // Given
        $phrase = '~abdumen';
        $normalizedPhrase = ltrim($phrase, '~');
        
        // When
        $result = $this->entryMapper->findByPhrase($phrase);
        
        // Then
        $this->assertGreaterThan(0, count($result));
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Entry', $result[0]);
        foreach ($result as $item) {
            $this->assertLessThanOrEqual(3, levenshtein($normalizedPhrase, $result[0]->getPhrase()));
        }
    }
    
    public function testShouldFindEntriesByPhraseUsingWildcardsAndLanguage()
    {
        // Given
        $phrase = 'abd%en';
        $language = 'en';
        
        // When
        $result = $this->entryMapper->findByPhraseAndLanguage($phrase, $language);
        
        // Then
        $this->assertGreaterThan(0, count($result));
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Entry', $result[0]);
        $resultPhrases = array_map(function($item) { return $item->getPhrase(); },
                                   $result);
        $this->assertEquals(count($result), count(preg_grep('/^abd.*en$/', $resultPhrases)));
    }
    
    public function testShouldFindSimilarEntriesByPhraseAndLanguage()
    {
        // Given
        $phrase = '~abdumen';
        $normalizedPhrase = ltrim($phrase, '~');
        $language = 'en';
        
        // When
        $result = $this->entryMapper->findByPhraseAndLanguage($phrase, $language);
        
        // Then
        $this->assertGreaterThan(0, count($result));
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Entry', $result[0]);
        foreach ($result as $item) {
            $this->assertLessThanOrEqual(3, levenshtein($normalizedPhrase, $item->getPhrase()));
            $this->assertEquals($language, $item->getLanguage()->getCode());
        }
    }
}
