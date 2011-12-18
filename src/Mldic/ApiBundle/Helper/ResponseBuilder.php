<?php
namespace Mldic\ApiBundle\Helper;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\Response;
use Mldic\ApiBundle\Model\ConvertibleToArray;

class ResponseBuilder
{
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $controllerResult = $event->getControllerResult();
        $controllerResult = $this->convertToArray($controllerResult);
        $response = new Response(json_encode($controllerResult));
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');
        $event->setResponse($response);
    }
    
    private function convertToArray($item)
    {
        if ($item instanceof ConvertibleToArray) {
            $item = $item->toArray();
        } elseif (is_array($item)) {
            $item = array_map(array($this, 'convertToArray'), $item);
        }
        return $item;
    }
}
