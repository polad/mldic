<?php
namespace Mldic\ApiBundle\Tests\Unit\Orm\PDO;

use Mldic\ApiBundle\Orm\PDO\UserQueryFactory;

class UserQueryFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldReturnFindByIdQuery()
    {
        // Given
        $queryFactory = new UserQueryFactory();
        $sql = "SELECT * FROM users WHERE id=:id";
        $parameters = array('id' => 1);
        
        // When
        $query = $queryFactory->getFindByIdQuery($parameters['id']);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Orm\PDO\Query', $query);
        $this->assertEquals($sql, $query->getSql());
        $this->assertEquals($parameters, $query->getParameters());
    }
}
