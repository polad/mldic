<?php
require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';
require_once __DIR__.'/../app/AppCache.php';

use Symfony\Component\HttpFoundation\Request;

defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ?: 'prod'));

if (APPLICATION_ENV == 'prod') {
    $kernel = new AppKernel(APPLICATION_ENV, false);
    $kernel->loadClassCache();
    $kernel = new AppCache($kernel);
} else {
    $kernel = new AppKernel(APPLICATION_ENV, true);
    $kernel->loadClassCache();
}
$kernel->handle(Request::createFromGlobals())->send();
