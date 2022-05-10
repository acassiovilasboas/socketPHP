<?php

require './vendor/autoload.php';

use Middleware\BasicPubSub;

require './middleware/BasicPubSub.php';

$app = new Ratchet\App('localhost', 8840);
$app->route('/wamp', new BasicPubSub, ['*']);
$webSock = new React\Socket\Server('0.0.0.0:8080', $loop); // Binding to 0.0.0.0 means remotes can connect
$webServer = new Ratchet\Server\IoServer(
    new Ratchet\Http\HttpServer(
        new Ratchet\WebSocket\WsServer(
            new Ratchet\Wamp\WampServer(
                $pusher
            )
        )
    ),
    $webSock
);

$app->run();
