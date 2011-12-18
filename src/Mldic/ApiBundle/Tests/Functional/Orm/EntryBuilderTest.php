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

class EntryBuilderTest extends TestCase
{
    private $entryBuilder;
    
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
        
        $this->entryBuilder = new EntryBuilder($languageMapper, $userMapper);
    }
    
    public function testShouldBuildEntryObject()
    {
        // Given
        $attributes = array('id' => 1,
                            'phrase' => 'abdomen',
                            'language_id' => 1,
                            'created_by' => 1,
                            'created_date' => null,
                            'modified_by' => 1,
                            'modified_date' => null);
        
        // When
        $result = $this->entryBuilder->build($attributes);
        
        // Then
        $this->assertInstanceOf('Mldic\ApiBundle\Model\Entry', $result);
        $this->assertEquals($attributes['id'], $result->getId());
        $this->assertEquals($attributes['phrase'], $result->getPhrase());

    }
}
