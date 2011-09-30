<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

class EntryMapper extends DataMapper
{
    public function __construct(DataAccessInterface $dataAccess,
                                EntryBuilder $domainObjectBuilder,
                                QueryFactoryInterface $queryFactory)
    {
        parent::__construct($dataAccess,
                            $domainObjectBuilder,
                            $queryFactory);
    }
}
