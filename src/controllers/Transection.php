<?php

namespace App\Controller;

use App\Model\Transection as ModelTransection;
use App\Rules\RuleOperation;

class Transection
{
    private string $message;
    // private string $ip;
    // private string $account;
    // private string $agency;
    // private string $operation;
    // private string $cpf;

    private ModelTransection $transection;

    // public function __construct(string $message)
    // {
    //     $this->message = $message;
    //     // return ($this->create()) ? true : false;
    // }

    // private function create()
    // {
    //     $this->transaction = new ModelTransection(
    //         $this->transaction->operation = trim(substr($this->message, 20, 35)),
    //         $this->transaction->ip = trim(substr($this->message, 0, 20)),
    //     );
    //     $this->operation = trim(substr($this->message, 20, 35));
    //     $ruleOperation = new RuleOperation($this->operation);
    //     if ($ruleOperation->validate()) {
    //         $this->operation = $ruleOperation->getOperationSelected();
    //         $dataAccount = trim(substr($this->message, 35, 85));
    //         $this->ip = trim(substr($this->message, 0, 20));
    //         $this->account = trim(substr($dataAccount, -17, -11));
    //         $this->agency = trim(substr($dataAccount, -21, -17));
    //         $this->cpf = trim(substr($dataAccount, -11));

    //         $transaction = new ModelTransection($this->ip, $this->account, $this->agency, $this->operation, $this->cpf);
    //         if ($transaction) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }
}
