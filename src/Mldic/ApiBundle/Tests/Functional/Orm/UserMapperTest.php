<?php
namespace Mldic\ApiBundle\Tests\Functional\Orm;

use Mldic\ApiBundle\Tests\Functional\TestCase;
use Mldic\ApiBundle\Orm\PDO\DataAccess;
use Mldic\ApiBundle\Orm\UserBuilder;
use Mldic\ApiBundle\Orm\PDO\UserQueryFactory;
use Mldic\ApiBundle\Orm\UserMapper;

class UserMapperTest extends TestCase
{
    private $userMapper;
    
    public function setUp()
    {
        parent::setUp();
        $dbConnection = $this->getDatabaseConnection();
        $this->userMapper = new UserMapper(new DataAccess($dbConnection),
                                           new UserBuilder(),
                                           new UserQueryFactory());
    }
    
    public function testShouldFindUserById()
    {
        // Given
        $userId = 1;
        
        // When
        $result = $this->userMapper->findById($userId);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Model\User', $result);
        $this->assertEquals($userId, $result->getId());
    }
    
    public function testShouldNotFindUserById()
    {
        // Given
        $userId = 999999;
        
        // When
        $result = $this->userMapper->findById($userId);
        
        // Then
        $this->assertNull($result);
    }
}
