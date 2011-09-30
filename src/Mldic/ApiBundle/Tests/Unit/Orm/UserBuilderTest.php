<?php
namespace Mldic\ApiBundle\Tests\Unit\Orm;

use Mldic\ApiBundle\Orm\UserBuilder;

class UserBuilderTest extends \PHPUnit_Framework_TestCase
{
    private $userBuilder;
    
    public function setUp()
    {
        $this->userBuilder = new UserBuilder();
    }
    
    public function testShouldBuildUserObject()
    {
        // Given
        $attributes = array('id' => 1,
                            'username' => 'testuser',
                            'first_name' => 'Test',
                            'last_name' => 'User');
        
        // When
        $user = $this->userBuilder->build($attributes);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Model\User', $user);
        $this->assertEquals($attributes['id'], $user->getId());
        $this->assertEquals($attributes['username'], $user->getUsername());
    }
    
    public function testShouldBuildEmptyUserObjectIfNoAttributesProvided()
    {
        // When
        $user = $this->userBuilder->build();
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Model\User', $user);
        $this->assertNull($user->getId());
        $this->assertNull($user->getUsername());
    }
}

