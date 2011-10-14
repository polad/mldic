<?php
namespace Mldic\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return array('entries' => array('link' => array('href' => '/entries')),
                     'languages' => array('link' => array('href' => '/languages')),
                     'users' => array('link' => array('href' => '/users')));
    }
}
