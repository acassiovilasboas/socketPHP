<?php

namespace App\Rules;

use App\Model\Account;
use App\Model\Transection;
use ValidateInterface;

class ValidateTransection
{
    private string $message;
    private bool $error = false;
    private string $ip = CONF_SERVER_HOST . ":" . CONF_SERVER_PORT;
    private $codeResponse = 400;
    private $code = [
        400 => ["ERROR400" => "Solicitação incorreta"],
        404 => ["ERROR404" => "Não encontrado"],
        411 => ["ERROR411" => "Comprimento obrigatório"],
        500 => ["ERROR500" => "Erro interno do servidor"],
        503 => ["ERROR503" => "Serviço indisponível"],
        200 => ["RESP200" => "Ok"]
    ];

    // checksum
    public function checkSum()
    {
        if ((new CheckSum($this->message))->validate()) {
            $this->codeResponse = 400;
        }
    }

    // ruleAccount
    public function ruleAccount(string $account)
    {
        $isValid = new RuleAccount($account);
        if (!$isValid->validate()) {
            $this->codeResponse = 404;
            $this->error = true;
        }
    }

    // ruleAgency
    public function ruleAgency(string $agency)
    {
        $isValid = new RuleAgency($agency);
        if (!$isValid->validate()) {
            $this->codeResponse = 411;
            $this->error = true;
        }
    }

    // RuleCPF
    public function ruleCpf(string $cpf)
    {
        $isValid = new RuleCpf($cpf);
        if (!$isValid->validate()) {
            $this->codeResponse = 500;
            $this->error = true;
        }
    }

    // RuleValue
    public function ruleValue(string $value)
    {
        $isValid = new RuleValue($value);
        if (!$isValid->validate()) {
            $this->codeResponse = 503;
            $this->error = true;
        }
    }

    // RuleOperation
    public function ruleOperation()
    {
        if (new RuleTransection($this->message)) {
            $this->codeResponse = 503;
            $this->error = true;
        }
    }

    // ruleAgencyOfBank
    public function ruleAgencyOfBank(string $agency)
    {
        $isValid = new RuleAgencyOfBank($agency);
        if (!$isValid->validate()) {
            $this->codeResponse = 404;
            $this->error = true;
        }
    }

    // ruleAccountOfBank
    public function ruleAccountOfBank(string $account)
    {
        $isValid = new RuleAccountOfBank($account);
        if (!$isValid->validate()) {
            $this->codeResponse = 411;
            $this->error = true;
        }
    }

    public function validate()
    {
        if (!$this->error) {
            $this->codeResponse = 200;
        }
        $message = $this->makeMessageResponse($this->ip, implode(array_keys($this->code[$this->codeResponse])), implode(array_values($this->code[$this->codeResponse])));

        return (string) $message;
    }

    public function getError()
    {
        return $this->error;
    }

    private function makeMessageResponse($ip, $responseCode, $response)
    {
        return "{$this->addEspace($ip, 20)}{$this->addEspace($responseCode, 15)}{$this->addEspace($response, 50)}";
    }

    private function addEspace(string $string, int $length): string
    {
        $string = trim($string);
        $message = "";
        $length = $length - strlen($string);
        for ($i = 0; $i < $length; $i++) {
            $message .= " ";
        }
        return $message . $string;
    }
}
