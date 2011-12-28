<?php
namespace Mldic\ApiBundle\Tests\Unit\Orm;

use Mldic\ApiBundle\Orm\EntryMapper;

class EntryMapperTest extends \PHPUnit_Framework_TestCase
{
    private $dataAccess;
    private $domainObjectBuilder;
    private $queryFactory;
    private $entryMapper;
    
    public function setUp()
    {
        $this->dataAccess = $this->getMock('Mldic\ApiBundle\Orm\DataAccessInterface');
        $this->domainObjectBuilder = $this->getMockBuilder('Mldic\ApiBundle\Orm\EntryBuilder')
            ->disableOriginalConstructor()
            ->getMock();
        $this->queryFactory = $this->getMock('Mldic\ApiBundle\Orm\EntryQueryFactoryInterface');
        $this->entryMapper = new EntryMapper($this->dataAccess,
                                             $this->domainObjectBuilder,
                                             $this->queryFactory);
    }
    
    public function testShouldFindEntriesByPhrase()
    {
        // Given
        $phrase = 'abdomen';
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        
        $this->queryFactory->expects($this->once())
            ->method('getFindByPhraseQuery')
            ->with($phrase)
            ->will($this->returnValue($query));
        
        $dataSet = array(array('id' => 1, 'phrase' => 'abdomen'),
                         array('id' => 2, 'phrase' => 'abdomen'));
        
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($dataSet));
        
        $this->domainObjectBuilder->expects($this->exactly(count($dataSet)))
            ->method('build');
        
        // When
        $entries = $this->entryMapper->findByPhrase($phrase);
    }
    
    public function testShouldNotFindEntriesByPhrase()
    {
        // Given
        $phrase = 'unknown';
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        
        $this->queryFactory->expects($this->once())
            ->method('getFindByPhraseQuery')
            ->with($phrase)
            ->will($this->returnValue($query));
        
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(array()));
        
        $this->domainObjectBuilder->expects($this->never())
            ->method('build');
        
        // When
        $entries = $this->entryMapper->findByPhrase($phrase);
    }
    
    public function testShouldFindUniqueEntryByPhraseAndLanguage()
    {
        // Given
        $phrase = 'abdomen';
        $language = 'en';
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        
        $this->queryFactory->expects($this->once())
            ->method('getFindByPhraseAndLanguageQuery')
            ->with($phrase, $language)
            ->will($this->returnValue($query));
        
        $dataSet = array(array('id' => 1, 'phrase' => 'abdomen'));
        
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($dataSet));
        
        $this->domainObjectBuilder->expects($this->exactly(count($dataSet)))
            ->method('build');
        
        // When
        $entries = $this->entryMapper->findByPhraseAndLanguage($phrase, $language);
    }
    
    public function testShouldNotFindUniqueEntryByPhraseAndLanguage()
    {
        // Given
        $phrase = 'abdomen';
        $language = 'en';
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        
        $this->queryFactory->expects($this->once())
            ->method('getFindByPhraseAndLanguageQuery')
            ->with($phrase, $language)
            ->will($this->returnValue($query));
        
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(array()));
        
        $this->domainObjectBuilder->expects($this->never())
            ->method('build');
        
        // When
        $entries = $this->entryMapper->findByPhraseAndLanguage($phrase, $language);
    }
    
    public function testShouldFindEntriesByPartialPhraseUsingWildcards()
    {
        // Given
        $phrase = 'abd%en';
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        
        $this->queryFactory->expects($this->once())
            ->method('getFindByPhraseUsingWildcardsQuery')
            ->with($phrase)
            ->will($this->returnValue($query));
        
        $dataSet = array(array('id' => 1, 'phrase' => 'abdomen'),
                         array('id' => 92, 'phrase' => 'abdominaalinen'));
        
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($dataSet));
        
        $this->domainObjectBuilder->expects($this->exactly(count($dataSet)))
            ->method('build');
        
        // When
        $entries = $this->entryMapper->findByPhrase($phrase);
    }
    
    public function testShouldFindSimilarEntriesByPhrase()
    {
        // Given
        $phrase = '~abdumen';
        $normalizedPhrase = ltrim($phrase, '~');
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        
        $this->queryFactory->expects($this->once())
            ->method('getFindSimilarByPhraseQuery')
            ->with($normalizedPhrase)
            ->will($this->returnValue($query));
        
        $dataSet = array(array('id' => 1, 'phrase' => 'abdomen'),
                         array('id' => 81632, 'phrase' => 'abducens'),
                         array('id' => 6644, 'phrase' => 'acumen'));
        
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($dataSet));
        
        $this->domainObjectBuilder->expects($this->exactly(count($dataSet)))
            ->method('build');
        
        // When
        $entries = $this->entryMapper->findByPhrase($phrase);
    }
    
    public function testShouldFindEntriesByPhraseUsingWildcardsAndLanguage()
    {
        // Given
        $phrase = 'abd%en';
        $language = 'en';
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        
        $this->queryFactory->expects($this->once())
            ->method('getFindByPhraseUsingWildcardsAndLanguageQuery')
            ->with($phrase, $language)
            ->will($this->returnValue($query));
        
        $dataSet = array(array('id' => 20, 'phrase' => 'abdomen'),
                         array('id' => 126197, 'phrase' => 'Abscess of spleen'));
        
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($dataSet));
        
        $this->domainObjectBuilder->expects($this->exactly(count($dataSet)))
            ->method('build');
        
        // When
        $entries = $this->entryMapper->findByPhraseAndLanguage($phrase, $language);
    }
    
    public function testShouldFindSimilarEntriesByPhraseAndLanguage()
    {
        // Given
        $phrase = '~abdumen';
        $normalizedPhrase = ltrim($phrase, '~');
        $language = 'en';
        
        $query = $this->getMock('Mldic\ApiBundle\Orm\QueryInterface');
        
        $this->queryFactory->expects($this->once())
            ->method('getFindSimilarByPhraseAndLanguageQuery')
            ->with($normalizedPhrase, $language)
            ->will($this->returnValue($query));
        
        $dataSet = array(array('id' => 20, 'phrase' => 'abdomen'),
                         array('id' => 6644, 'phrase' => 'acumen'),
                         array('id' => 70766, 'phrase' => 'albumen'));
        
        $this->dataAccess->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($dataSet));
        
        $this->domainObjectBuilder->expects($this->exactly(count($dataSet)))
            ->method('build');
        
        // When
        $entries = $this->entryMapper->findByPhraseAndLanguage($phrase, $language);
    }
}
