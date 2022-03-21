<?php
namespace Ratchet\Server;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * A simple Ratchet application that will reply to all messages with the message it received
 */
class EchoServer implements MessageComponentInterface {
    public function onOpen(ConnectionInterface $conn) {
        echo "onOpen";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "onMessage";
        $from->send($msg);
    }

    public function onClose(ConnectionInterface $conn) {
        echo "onClose";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "onError";
        $conn->close();
    }
}
