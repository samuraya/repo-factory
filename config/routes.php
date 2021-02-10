<?php
declare(strict_types=1);
use function FastRoute\simpleDispatcher;
use FastRoute\RouteCollector;

use App\Controllers\MessageStore;

use App\Controllers\MessageCreate;

return simpleDispatcher(function (RouteCollector $r) {
    
    $r->post('/store', MessageStore::class);    
    $r->get('/', MessageCreate::class);
    
});