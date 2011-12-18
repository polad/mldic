<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

abstract class DataMapper
{
    private $dataAccess;
    private $domainObjectBuilder;
    protected $queryFactory;
    
    public function __construct(DataAccessInterface $dataAccess,
                                DomainObjectBuilderInterface $domainObjectBuilder,
                                QueryFactoryInterface $queryFactory)
    {
        $this->dataAccess = $dataAccess;
        $this->domainObjectBuilder = $domainObjectBuilder;
        $this->queryFactory = $queryFactory;
    }
    
    public function findById($id)
    {
        $query = $this->queryFactory->getFindByIdQuery($id);
        $result = $this->processQuery($query);
        return count($result) ? $result[0] : null;
    }
    
    protected function processQuery(QueryInterface $query)
    {
        $result = array();
        $dataSet = $this->dataAccess->execute($query);
        foreach ($dataSet as $item) {
            $result[] = $this->build($item);
        }
        return $result;
    }
    
    public function build(array $attributes = array())
    {
        return $this->domainObjectBuilder->build($attributes);
    }
}
