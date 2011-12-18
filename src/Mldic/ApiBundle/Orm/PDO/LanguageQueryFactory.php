<?php
/**
 * @package orm
 * @subpackage pdo
 */
namespace Mldic\ApiBundle\Orm\PDO;

use Mldic\ApiBundle\Orm\LanguageQueryFactoryInterface;

class LanguageQueryFactory implements LanguageQueryFactoryInterface
{
    public function getFindByIdQuery($id)
    {
        return new Query('SELECT * FROM languages WHERE id=:id',
                         array('id' => $id));
    }
    
    public function getFindAllQuery()
    {
        return new Query('SELECT * FROM languages');
    }
    
    public function getFindByCodeQuery($code)
    {
        return new Query('SELECT * FROM languages WHERE code=:code',
                         array('code' => $code));
    }
}
