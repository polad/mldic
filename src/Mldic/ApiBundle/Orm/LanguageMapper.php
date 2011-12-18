<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

class LanguageMapper extends DataMapper
{
    public function __construct(DataAccessInterface $dataAccess,
                                LanguageBuilder $domainObjectBuilder,
                                LanguageQueryFactoryInterface $queryFactory)
    {
        parent::__construct($dataAccess,
                            $domainObjectBuilder,
                            $queryFactory);
    }
    
    public function findAll()
    {
        $query = $this->queryFactory->getFindAllQuery();
        return $this->processQuery($query);
    }
    
    public function findByCode($code)
    {
        $query = $this->queryFactory->getFindByCodeQuery($code);
        $result = $this->processQuery($query);
        return count($result) ? $result[0] : null;
    }
}
