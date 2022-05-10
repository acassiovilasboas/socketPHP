<?php

namespace App\Middleware;
require __DIR__ . '/vendor/autoload.php';

use Ratchet\ConnectionInterface as Conn;
use Ratchet\Wamp\WampServerInterface as Wamp;

/**
 * When a user publishes to a topic all clients who have subscribed
 * to that topic will receive the message/event from the publisher
 */
class BasicPubSub implements Wamp {
    public function onPublish(Conn $conn, $topic, $event, array $exclude, array $eligible) {
        $topic->broadcast(['message' => $event]);
        print_r([$conn, $topic, $event]);
    }

    public function onCall(Conn $conn, $id, $topic, array $params) {
        print_r($conn, $id, $topic, $params);
        // $conn->callError($id, $topic, 'RPC not supported on this demo');
    }

    // No need to anything, since WampServer adds and removes subscribers to Topics automatically
    public function onSubscribe(Conn $conn, $topic) {
    }
    public function onUnSubscribe(Conn $conn, $topic) {

    }

    public function onOpen(Conn $conn) {
    }
    public function onClose(Conn $conn) {
    }
    public function onError(Conn $conn, \Exception $e) {
    }
}