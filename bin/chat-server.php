#!/usr/bin/env php
<?php

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocket\Chat;

require dirname(__DIR__) . '/vendor/autoload.php';

$server = IoServer::factory(
    new HttpServer(new WsServer(new Chat())),
    8080 // Port du serveur WebSocket
);

echo "Serveur WebSocket lancé sur ws://localhost:8080\n";

$server->run();
