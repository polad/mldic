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
    
    public function testShouldReturnFindAllQuery()
    {
        // Given
        $sql = 'SELECT * FROM entries';
        
        // When
        $query = $this->queryFactory->findAll();
        
        // Then
        $this->assertEquals($sql, $query->getSQL());
        $this->assertEmpty($query->getParameters());
    }
    
    public function testShouldReturnFindByIdQuery()
    {
        // Given
        $sql = 'SELECT * FROM entries WHERE id=:id';
        $parameters = array('id' => 1);
        
        // When
        $query = $this->queryFactory->findById($parameters['id']);
        
        // Then
        $this->assertEquals($sql, $query->getSql());
        $this->assertEquals($parameters, $query->getParameters());
    }
    
    public function testShouldReturnFindWithConditionsQuery()
    {
        // Given
        $sql = 'SELECT * FROM entries ' .
               'INNER JOIN language ON language.id=entries.language_id ' .
               'WHERE phrase=:phrase AND language.code=:language_code';
        $parameters = array('phrase' => 'abdomen',
                            'language_code' => 'en');
        
        $conditions = array(array('phrase', 'abdomen'),
                            array('language' => array('code', 'en')));
        
        // When
        $query = $this->queryFactory->findWithConditions($conditions);
        
        // Then
        $this->assertEquals($sql, $query->getSql());
        $this->assertEquals($parameters, $query->getParameters());
    }
}
