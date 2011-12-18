<?php
/**
 * @package orm
 * @subpackage pdo
 */
namespace Mldic\ApiBundle\Orm\PDO;

use Mldic\ApiBundle\Orm\UserQueryFactoryInterface;

class UserQueryFactory implements UserQueryFactoryInterface
{
    public function getFindByIdQuery($id)
    {
        return new Query('SELECT * FROM users WHERE id=:id',
                         array('id' => $id));
    }
}
