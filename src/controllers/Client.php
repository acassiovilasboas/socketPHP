<?php

namespace App\Controller;

class Client {
    private $data;
    private $json;

    public function __construct($data)
    {
        $term = $data["data"]["cpf"];
        $this->json = $this->getAccount($term);
    }

    private function getAccount($term)
    {
        $path = "/home/acassio/Documentos/Faculdade/sistemasDistribuidos/websocketNavegador/accounts.json";
        $term = preg_replace("/[^0-9]/","", $term);
        $accounts = [];

        if (file_exists($path)) {
            $file = file_get_contents($path);
            $data = json_decode($file, true);

            foreach ($data as $register => $value) {
                if ($value["cpf"] == $term) {
                    $accounts[0]["accounts"][] = $value;
                }
            }
        }
        $accounts = array_values($accounts);
        return json_encode($accounts, true);
    }

    public function getJson()
    {
        return $this->json;
    }
    
}