<?php

namespace App\Middleware;

use Account;
use App\Controller\Controller;
use Exception;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use App\Rules\Validate;
use ValidateInterface;
use Ratchet\ConnectionInterface as Conn;

/**
 * A simple Ratchet application that will reply to all messages with the message it received
 */
class PubSub implements MessageComponentInterface
{
    private $conn = [];
    private $clients;
    private Controller $controller;

    public function onOpen(ConnectionInterface $conn)
    {
        $this->conn[] = $conn;
        echo PHP_EOL . "nova conexao " . PHP_EOL;
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // $this->validate = new Validate($msg);
        // $from->send($this->validate->validate());
        // echo $this->validate->validate();
        // echo "|" . $msg . "|" . PHP_EOL;
        
        $controller = new Controller($msg);
        $result = $controller->getResult();
        // print_r($controller->result);
        $from->send($result);

        // $from->send($msg);

        // foreach ($this->conn as $client) {
        //     if ($client == $from) {
        //         $result = $this->controller = new Controller($msg);
        //         $client->send($result);
        //     }
        // }
        // if($msg == "new-connection") {
        //     return;
        // }
        // $result = $this->controller->getResult();


        // enviar para outros membros exceto o usuario que enviou.
        // foreach($this->conn as $client) {
        //     if($client != $from) {
        //         $client->send($msg);
        //     }
        // }
    }

    public function onCall(Conn $conn, $id, $topic, array $params)
    {
        print_r($conn, $id, $topic, $params);
        // $conn->callError($id, $topic, 'RPC not supported on this demo');
    }

    public function onClose(ConnectionInterface $conn)
    {
        // echo "onClose" . PHP_EOL;
    }

    public function onError(ConnectionInterface $conn, \Exception $e = null)
    {
        echo $e->getMessage() . " - Conexão encerrada!" . PHP_EOL;
        $conn->close();
    }
}
