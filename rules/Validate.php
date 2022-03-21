<?php

namespace Rules;

use ValidateInterface;

class Validate
{
    private ValidateInterface $validate;
    private string $message;
    private $codeResponse = 400;
    private $code = [
        400 => "Solicitação incorreta",
        404 => "Não encontrado",
        411 => "Comprimento obrigatorio",
        500 => "Erro interno do servidor",
        503 => "Serviço indisponível",
        200 => "Ok"
    ];

    public function __construct(string $message)
    {
        if (strlen($message) < 50) {
            $this->codeResponse = 411;
            return;
        }
        $this->message = $message;
        $this->workString();
    }

    private function workString()
    {
        $ip = substr($this->message, 0, 20);

        $operation = substr($this->message, 20, 15);
        if ((new RuleOperation($operation))->validate() != 200) {
            $this->codeResponse = 501;
            return;
        }

        $codeAgency = substr($this->message, 35, 4);
        $codeAccount = substr($this->message, 39, 6);
        if ((new RuleAccount($codeAgency, $codeAccount))->validate() != 200) {
            $this->codeResponse = 400;
            return;
        }

        $cpf = substr($this->message, 45, 11);
        if ((new RuleCpf($cpf))->validate() != 200) {
            $this->codeResponse = 400;
            return;
        }

        $checksum = substr($this->message, 56);
        if ((new CheckSum($this->message))->validate($checksum) != 200) {
            $this->codeResponse = 400;
            return;
        }

        $data = [
            "ip" => $ip,
            "operation" => $operation,
            "agency" => $codeAgency,
            "account" => $codeAccount,
            "cpf" => $cpf,
            "checksum" => $checksum
        ];
        $this->save($data);

        // echo "ip: " . $ip . PHP_EOL;
        // echo "operation: " . $operation . PHP_EOL;
        // echo "codeAgency: " . $codeAgency . PHP_EOL;
        // echo "codeAccount: " . $codeAccount . PHP_EOL;
        // echo "cpf: " . $cpf . PHP_EOL;
        // echo "checksum: " . $checksum . PHP_EOL;
        // echo "ip: " . $ip . PHP_EOL;
        $this->codeResponse = 200;
    }

    public function returnCode()
    {
        // $this->stringLength();
    }

    private function save(array $data)
    {
        $json = json_encode($data);
        file_put_contents($data["cpf"] . ".json", $json);
    }

    public function validate()
    {
        return json_encode(["codigo" => $this->codeResponse,"message" => $this->code[$this->codeResponse]]);
    }
}
