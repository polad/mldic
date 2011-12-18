<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

class UserMapper extends DataMapper
{
    public function __construct(DataAccessInterface $dataAccess,
                                UserBuilder $domainObjectBuilder,
                                UserQueryFactoryInterface $queryFactory)
    {
        parent::__construct($dataAccess,
                            $domainObjectBuilder,
                            $queryFactory);
    }
}
