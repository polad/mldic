<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

class LanguageMapper extends DataMapper
{
    public function __construct(DataAccessInterface $dataAccess,
                                LanguageBuilder $domainObjectBuilder,
                                QueryFactoryInterface $queryFactory)
    {
        parent::__construct($dataAccess,
                            $domainObjectBuilder,
                            $queryFactory);
    }
}
