<?php
/**
 * @package model
 */
namespace Mldic\ApiBundle\Model;

interface ConvertibleToArray
{
    /**
     * @return array
     */
    public function toArray();
}
