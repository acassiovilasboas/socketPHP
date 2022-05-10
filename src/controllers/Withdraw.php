<?php

namespace App\Controller;

use App\Model\Withdraw as ModelWithdraw;
use App\Rules\ValidateTransection;

class Withdraw
{
    private string $message;
    private ModelWithdraw $model;
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

        $this->model = new ModelWithdraw(
            substr($this->message, 0, 20), //ip
            "withdraw", //transection
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
        $this->validateTransection->ruleValue($this->model->getValue());
        $this->result = $this->validateTransection->validate();
        return !$this->validateTransection->getError();
    }

    public function getResult()
    {
        return $this->result;
    }
}
