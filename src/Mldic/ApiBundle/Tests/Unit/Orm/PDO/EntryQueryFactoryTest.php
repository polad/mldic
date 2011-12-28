<?php
namespace Mldic\ApiBundle\Tests\Unit\Orm\PDO;

use Mldic\ApiBundle\Orm\PDO\EntryQueryFactory;

class EntryQueryFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $queryFactory;
    
    public function setUp()
    {
        $this->queryFactory = new EntryQueryFactory();
    }
    
    public function testShouldReturnFindByIdQuery()
    {
        // Given
        $sql = 'SELECT * FROM entries WHERE id=:id';
        $parameters = array('id' => 1);
        
        // When
        $query = $this->queryFactory->getFindByIdQuery($parameters['id']);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Orm\PDO\Query', $query);
        $this->assertEquals($sql, $query->getSql());
        $this->assertEquals($parameters, $query->getParameters());
    }
    
    public function testShouldReturnFindByPhraseQuery()
    {
        // Given
        $sql = 'SELECT * FROM entries WHERE phrase=:phrase ORDER BY phrase';
        $parameters = array('phrase' => 'abdomen');
        
        // When
        $query = $this->queryFactory->getFindByPhraseQuery($parameters['phrase']);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Orm\PDO\Query', $query);
        $this->assertEquals($sql, $query->getSql());
        $this->assertEquals($parameters, $query->getParameters());
    }
    
    public function testShouldReturnFindByPhraseAndLanguageQuery()
    {
        // Given
        $sql = 'SELECT e.* FROM entries AS e ' .
               'INNER JOIN languages AS l ON l.id = e.language_id ' .
               'WHERE phrase=:phrase AND l.code=:language ' .
               'ORDER BY phrase';
        $parameters = array('phrase' => 'abdomen', 'language' => 'en');
        
        // When
        $query = $this->queryFactory->getFindByPhraseAndLanguageQuery($parameters['phrase'],
                                                                      $parameters['language']);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Orm\PDO\Query', $query);
        $this->assertEquals($sql, $query->getSql());
        $this->assertEquals($parameters, $query->getParameters());
    }
    
    public function testShouldReturnFindByPhraseUsingWildcardsQuery()
    {
        // Given
        $sql = 'SELECT * FROM entries ' .
               'WHERE phrase LIKE :phrase ' .
               'ORDER BY phrase';
        $parameters = array('phrase' => 'abd%en');
        
        // When
        $query = $this->queryFactory->getFindByPhraseUsingWildcardsQuery($parameters['phrase']);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Orm\PDO\Query', $query);
        $this->assertEquals($sql, $query->getSql());
        $this->assertEquals($parameters, $query->getParameters());
    }
    
    public function testShouldReturnFindSimilarByPhraseQuery()
    {
        // Given
        $sql = 'SELECT * FROM entries ' .
               'WHERE LEVENSHTEIN(phrase, :phrase)<=3 ' .
               'ORDER BY LEVENSHTEIN(phrase, :phrase)';
        $parameters = array('phrase' => 'abdumen');
        
        // When
        $query = $this->queryFactory->getFindSimilarByPhraseQuery($parameters['phrase']);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Orm\PDO\Query', $query);
        $this->assertEquals($sql, $query->getSql());
        $this->assertEquals($parameters, $query->getParameters());
    }
    
    public function testShouldReturnFindByPhraseUsingWildcardsAndLanguageQuery()
    {
        // Given
        $sql = 'SELECT e.* FROM entries AS e ' .
               'INNER JOIN languages AS l ON l.id = e.language_id ' .
               'WHERE phrase LIKE :phrase AND l.code=:language ' .
               'ORDER BY phrase';
        $parameters = array('phrase' => 'abd%en', 'language' => 'en');
        
        // When
        $query = $this->queryFactory->getFindByPhraseUsingWildcardsAndLanguageQuery($parameters['phrase'],
                                                                                    $parameters['language']);
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Orm\PDO\Query', $query);
        $this->assertEquals($sql, $query->getSql());
        $this->assertEquals($parameters, $query->getParameters());
    }
    
    public function testShouldReturnFindSimilarByPhraseAndLanguageQuery()
    {
        // Given
        $sql = 'SELECT e.* FROM entries AS e ' .
               'INNER JOIN languages AS l ON l.id = e.language_id ' .
               'WHERE LEVENSHTEIN(phrase, :phrase)<=3 AND l.code=:language ' .
               'ORDER BY LEVENSHTEIN(phrase, :phrase)';
        $parameters = array('phrase' => 'abdumen', 'language' => 'en');
        
        // When
        $query = $this->queryFactory->getFindSimilarByPhraseAndLanguageQuery($parameters['phrase'],
                                                                                    $parameters['language']);
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Orm\PDO\Query', $query);
        $this->assertEquals($sql, $query->getSql());
        $this->assertEquals($parameters, $query->getParameters());
    }
}
