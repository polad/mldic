<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

class EntryMapper extends DataMapper
{
    const SEARCH_TYPE_EXACT = 'EXACT_SEARCH';
    const SEARCH_TYPE_PARTIAL = 'PARTIAL_SEARCH';
    const SEARCH_TYPE_SIMILAR = 'SIMILAR_SEARCH';
    
    public function __construct(DataAccessInterface $dataAccess,
                                EntryBuilder $domainObjectBuilder,
                                EntryQueryFactoryInterface $queryFactory)
    {
        parent::__construct($dataAccess,
                            $domainObjectBuilder,
                            $queryFactory);
    }
    
    public function findByPhrase($phrase)
    {
        $searchType = $this->determineSearchType($phrase);
        $phrase = $this->normalizeString($phrase);
        switch ($searchType) {
        case self::SEARCH_TYPE_PARTIAL:
            $query = $this->queryFactory->getFindByPhraseUsingWildcardsQuery($phrase);
            break;
        case self::SEARCH_TYPE_SIMILAR:
            $query = $this->queryFactory->getFindSimilarByPhraseQuery($phrase);
            break;
        default:
            $query = $this->queryFactory->getFindByPhraseQuery($phrase);
        }
        return $this->processQuery($query);
    }
    
    public function findByPhraseAndLanguage($phrase, $language)
    {
        $searchType = $this->determineSearchType($phrase);
        $phrase = $this->normalizeString($phrase);
        switch ($searchType) {
        case self::SEARCH_TYPE_PARTIAL:
            $query = $this->queryFactory->getFindByPhraseUsingWildcardsAndLanguageQuery($phrase, $language);
            break;
        case self::SEARCH_TYPE_SIMILAR:
            $query = $this->queryFactory->getFindSimilarByPhraseAndLanguageQuery($phrase, $language);
            break;
        default:
            $query = $this->queryFactory->getFindByPhraseAndLanguageQuery($phrase, $language);
        }
        return $this->processQuery($query);
    }
    
    private function determineSearchType($value)
    {
        if (strpos($value, '~') === 0) {
            $type = self::SEARCH_TYPE_SIMILAR;
        } elseif (strpos($value, '%') !== false) {
            $type = self::SEARCH_TYPE_PARTIAL;
        } else {
            $type = self::SEARCH_TYPE_EXACT; 
        }
        return $type;
    }
    
    private function normalizeString($value)
    {
        return ltrim($value, '~');
    }
}
