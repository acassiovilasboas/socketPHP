<?php

namespace App\Controller;

use App\Rules\CheckSum;
use App\Rules\RuleTransection;
use App\Controller\Deposit;

class Controller
{
    private string $message;
    private CheckSum $checkSum;
    private string $result;

    public function __construct(string $message)
    {
        $this->message = $message;
        $this->checkSum = new CheckSum($this->message);
        $this->init();
    }

    private function init()
    {
        if (!$this->checkSum->validate()) {
            $this->result = "checksum não validado";
        }

        $ruleTransection = new RuleTransection($this->message);
        if (!$ruleTransection->validate()) {
            $this->result = "operacao nao validada";
        }
        $transection = $ruleTransection->getTransectionSelected();

        $this->create($transection);
    }

    private function create($transection)
    {
        switch ($transection) {
            case 'deposit':
                $deposit = new Deposit($this->message);
                $this->result = $deposit->getResult();
                break;
            case 'withdraw':
                $withdraw = new Withdraw($this->message);
                $this->result = $withdraw->getResult();
                break;
            case 'transfer':
                $transfer = new Transfer($this->message);
                $this->result = $transfer->getResult();
                break;
            case 'loan':
                $loan = new Loan($this->message);
                $this->result = $loan->getResult();
                break;
                break;
            case 'open_account':
                $account = new Account($this->message);
                $this->result = $account->getResult();
                break;
        }
    }

    public function getResult()
    {
        return $this->result;
    }
}
