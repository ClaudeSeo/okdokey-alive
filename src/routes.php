<?php

require 'procfs.php';

$app->post('/v1/auth/login', function ($req, $res, $args) {
    $parsedBody = $req->getParsedBody();
    $addr = $req->getHeader('REMOTE_ADDR') || $req->getHeader('HTTP_X_FORWARDED_FOR');
    $agent = $req->getHeader('User-Agent');
    $this->logger->info("Authorization '/auth' " . json_encode($parsedBody) . " " . $addr . " " . json_encode($agent));
    if ($parsedBody['key'] == $this->security) {
        $_SESSION['authorization'] = time() * 1000;
        return json_encode(array('status' => 'success'));
    } else {
        return $res->withStatus(401)->write(json_encode(array('status' => 'error')));
    }
});

$app->delete('/v1/auth/logout', function ($req, $res, $args) {
    session_destroy();
    return json_encode(array('status' => 'success'));
});

$app->get('/v1/proc', function ($req, $res, $args) {
    $parsedBody = $req->getParsedBody();
    $addr = $req->getHeader('REMOTE_ADDR') || $req->getHeader('HTTP_X_FORWARDED_FOR');
    $agent = $req->getHeader('User-Agent');
    $this->logger->info("Authorization '/auth' " . json_encode($parsedBody) . " " . $addr . " " . json_encode($agent));
    if ($_SESSION['authorization'] && $_SESSION['authorization'] / 1000 > time() - 3600) {
        $proc = new procfs();
        $arr = array(
            'cpu' => $proc->getCpuProfile()['usage'],
            'uptime' => $proc->getUptime(),
            'load' => $proc->getLoadAve(),
            'disk' => $proc->getDiskSize(),
            'memory' => $proc->getMemoryProfile()['usage']
        );
        return json_encode($arr);
    }
    return $res->withStatus(403)->write('PERMISSION DENIED');
});