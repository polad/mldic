<?php
namespace Mldic\ApiBundle\Tests\Unit\Orm\PDO;

use Mldic\ApiBundle\Orm\PDO\LanguageQueryFactory;

class LanguageQueryFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $queryFactory;
    
    public function setUp()
    {
        $this->queryFactory = new LanguageQueryFactory();
    }
    
    public function testShouldReturnFindByIdQuery()
    {
        // Given
        $sql = 'SELECT * FROM languages WHERE id=:id';
        $parameters = array('id' => 1);
        
        // When
        $query = $this->queryFactory->getFindByIdQuery($parameters['id']);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Orm\PDO\Query', $query);
        $this->assertEquals($sql, $query->getSql());
        $this->assertEquals($parameters, $query->getParameters());
    }
    
    public function testShouldReturnFindAllQuery()
    {
        // Given
        $sql = 'SELECT * FROM languages';
        
        // When
        $query = $this->queryFactory->getFindAllQuery();
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Orm\PDO\Query', $query);
        $this->assertEquals($sql, $query->getSql());
        $this->assertEmpty($query->getParameters());
    }
    
    public function testShouldReturnFindByCodeQuery()
    {
        // Given
        $sql = 'SELECT * FROM languages WHERE code=:code';
        $parameters = array('code' => 'en');
        
        // When
        $query = $this->queryFactory->getFindByCodeQuery($parameters['code']);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Orm\PDO\Query', $query);
        $this->assertEquals($sql, $query->getSql());
        $this->assertEquals($parameters, $query->getParameters());
    }
}
