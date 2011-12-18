<?php
namespace Mldic\ApiBundle\Tests\Unit\Orm;

use Mldic\ApiBundle\Orm\UserMapper;

class UserMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldFindUserById()
    {
        // Given
        $dataAccess = $this->getMock('Mldic\ApiBundle\Orm\DataAccessInterface');
        $domainObjectBuilder = $this->getMock('Mldic\ApiBundle\Orm\UserBuilder');
        $queryFactory = $this->getMock('Mldic\ApiBundle\Orm\UserQueryFactoryInterface');
        $userMapper = new UserMapper($dataAccess, $domainObjectBuilder, $queryFactory);
        $userId = 1;
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        $queryFactory->expects($this->once())
            ->method('getFindByIdQuery')
            ->will($this->returnValue($query));
        
        $dataAccess->expects($this->once())
            ->method('execute')
            ->with($query)
            ->will($this->returnValue(array(array('id' => $userId))));
        
        // When
        $userMapper->findById($userId);
    }
}
