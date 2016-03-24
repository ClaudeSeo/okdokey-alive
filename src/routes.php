<?php

require 'procfs.php';

$app->get('/v1/proc', function ($req, $res, $args) {
    $parsedBody = $req->getParsedBody();
    $addr = $req->getHeader('REMOTE_ADDR') || $req->getHeader('HTTP_X_FORWARDED_FOR');
    $agent = $req->getHeader('User-Agent');
    $key = $req->getHeader('X-alive-key');
    if (!is_null($key) && strcmp($key[0], $this->security) != 0) {
        return $res->withStatus(403)->write('PERMISSION DENIED');
    }
    $this->logger->info("Procfile System '/proc' " . json_encode($parsedBody) . " " . $addr . " " . json_encode($agent));
    $proc = new procfs();
    $arr = array(
        'cpu' => $proc->getCpuProfile()['usage'],
        'uptime' => $proc->getUptime(),
        'load' => $proc->getLoadAve(),
        'disk' => $proc->getDiskSize(),
        'memory' => $proc->getMemoryProfile()['usage']
    );
    return json_encode($arr);

});