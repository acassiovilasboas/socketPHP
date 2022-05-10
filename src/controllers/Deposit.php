<?php

namespace App\Controller;

use App\Model\Deposit as ModelDeposit;
use App\Rules\ValidateTransection;

class Deposit
{
    private string $message;
    private ModelDeposit $model;
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
        $message = trim(substr($this->message, 35, 85)); //ip

        $this->model = new ModelDeposit(
            substr($this->message, 0, 20), //ip
            "deposit", //transection
            substr($message, 0, 4), //agency
            substr($message, 4, 6), //account
            substr($message, 10) //value
        );

        if($this->validate())
        {
            $this->model->save();
        }
    }

    public function validate()
    {
        $this->validateTransection->ruleAccount($this->model->getAccount());
        $this->validateTransection->ruleAgency($this->model->getAgency());
        print_r($this->validateTransection->ruleAgency($this->model->getAgency()));
        $this->validateTransection->ruleValue($this->model->getValue());
        $this->result = $this->validateTransection->validate();
        return !$this->validateTransection->getError();
    }

    public function getResult()
    {
        return $this->result;
    }
}
