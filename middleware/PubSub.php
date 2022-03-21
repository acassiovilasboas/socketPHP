<?php
namespace Middleware;

use Exception;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Rules\Validate;
use ValidateInterface;

/**
 * A simple Ratchet application that will reply to all messages with the message it received
 */
class PubSub implements MessageComponentInterface {
    private $conn = [];
    private Validate $validate;
    public function onOpen(ConnectionInterface $conn) {
        echo "nova conexao " . PHP_EOL;
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $this->validate = new Validate($msg);
        $from->send($this->validate->validate());
        // echo $this->validate->validate();
        // echo $msg;

        // enviar para outros membros exceto o usuario que enviou.
        // foreach($this->conn as $client) {
        //     if($client != $from) {
        //         $client->send($msg);
        //     }
        // }
    }

    public function onClose(ConnectionInterface $conn) {
        // echo "onClose" . PHP_EOL;
    }

    public function onError(ConnectionInterface $conn, \Exception $e = null) {
        echo "onError" . PHP_EOL;
        $conn->close();
    }
}
