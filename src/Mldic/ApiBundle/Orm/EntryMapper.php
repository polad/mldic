<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

class EntryMapper extends DataMapper
{
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
        $query = $this->queryFactory->getFindByPhraseQuery($phrase);
        return $this->processQuery($query);
    }
    
    public function findByPhraseAndLanguage($phrase, $language)
    {
        $query = $this->queryFactory->getFindByPhraseAndLanguageQuery($phrase, $language);
        $result = $this->processQuery($query);
        return count($result) ? $result[0] : null;
    }
}
