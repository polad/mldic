<?php
namespace Mldic\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LanguagesController extends Controller
{
    public function findAllAction()
    {
        return $this->get('datamapper.language')->findAll();
    }
    
    public function findByCodeAction($code)
    {
        $language = $this->get('datamapper.language')->findByCode($code);
        if (empty($language)) {
            throw new NotFoundHttpException('Language not found!');
        }
        return $language;
    }
}
