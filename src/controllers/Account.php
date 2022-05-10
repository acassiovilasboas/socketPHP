<?php

namespace App\Controller;

use App\Model\Account as ModelAccount;
use App\Rules\ValidateTransection;

class Account
{
    private string $message;
    private ModelAccount $account;
    private ValidateTransection $validateTransection;
    private string $result;

    public function __construct(string $message)
    {
        $this->message = substr($message, 0, 85);
        $this->validateTransection = new ValidateTransection();
        $this->prepar();
    }

    private function prepar()
    {
        $this->account = new ModelAccount(
            substr($this->message, 0, 20),
            "open_account",
            substr($this->message, -21, -17),
            substr($this->message, -17, -11),
            substr($this->message, -11)
        );

        if($this->validate())
        {
            $this->account->save();
        }
    }

    public function validate()
    {
        $this->validateTransection->ruleCpf($this->account->getCpf());
        $this->validateTransection->ruleAccount($this->account->getAccount());
        $this->validateTransection->ruleValue($this->account->getAgency());
        $this->result = $this->validateTransection->validate();
        return !$this->validateTransection->getError();
    }

    public function getResult()
    {
        return $this->result;
    }
}
