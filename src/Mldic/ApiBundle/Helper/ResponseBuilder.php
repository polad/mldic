<?php
namespace Mldic\ApiBundle\Helper;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\Response;

class ResponseBuilder
{
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $conttrollerResult = $event->getControllerResult();
        $response = new Response(json_encode($conttrollerResult));
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');
        $event->setResponse($response);
    }
}
