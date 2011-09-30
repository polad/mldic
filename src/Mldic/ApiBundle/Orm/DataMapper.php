<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

class DataMapper
{
    private $dataAccess;
    private $domainObjectBuilder;
    private $queryFactory;
    
    public function __construct(DataAccessInterface $dataAccess,
                                DomainObjectBuilderInterface $domainObjectBuilder,
                                QueryFactoryInterface $queryFactory)
    {
        $this->dataAccess = $dataAccess;
        $this->domainObjectBuilder = $domainObjectBuilder;
        $this->queryFactory = $queryFactory;
    }
    
    public function all(array $conditions = null)
    {
        if (empty($conditions)) {
            $query = $this->queryFactory->findAll();
        } else {
            $query = $this->queryFactory->findWithConditions($conditions);
        }
        return $this->processQuery($query);
    }
    
    public function get($id)
    {
        $query = $this->queryFactory->findById($id);
        $result = $this->processQuery($query);
        return count($result) ? $result[0] : null;
    }
    
    private function processQuery(QueryInterface $query)
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
