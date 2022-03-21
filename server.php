<?php

require './vendor/autoload.php';

use Middleware\PubSub;

require './middleware/PubSub.php';

$app = new Ratchet\App('localhost', 9980);
$app->route('/echo', new PubSub, ['*']);
$app->run();
