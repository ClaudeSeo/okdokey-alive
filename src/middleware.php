<?php

// response set header
$app->add(function ($request, $response, callable $next) {
    $newResponse = $response->withHeader('Content-Type', 'application/json;charset=utf-8');
    return $next($request, $newResponse);
});