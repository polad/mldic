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
        $sql = 'SELECT * FROM entries WHERE phrase=:phrase';
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
               'WHERE phrase=:phrase AND l.code=:language';
        $parameters = array('phrase' => 'abdomen', 'language' => 'en');
        
        // When
        $query = $this->queryFactory->getFindByPhraseAndLanguageQuery($parameters['phrase'],
                                                                      $parameters['language']);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Orm\PDO\Query', $query);
        $this->assertEquals($sql, $query->getSql());
        $this->assertEquals($parameters, $query->getParameters());
    }
}
