<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__  . '/init.php';

use App\Middleware\PubSub;

// require './middleware/PubSub.php';

$app = new Ratchet\App(CONF_SERVER_HOST, CONF_SERVER_PORT);
$app->route('/echo', new PubSub, ['*']);
$app->run();
