<?php

namespace App\Controller;

use App\Model\Transfer as ModelTransfer;
use App\Rules\ValidateTransection;

class Transfer
{
    private string $message;
    private ModelTransfer $model;
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

        $this->model = new ModelTransfer(
            substr($this->message, 0, 20), //ip
            "transfer", //transection
            substr($message, 0, 4), //agencyOrigin
            substr($message, 4, 6), //accountOrigin
            substr($message, 10, 4), //agencyDestiny
            substr($message, 14, 6), //accountDestiny
            substr($message, 20) //value
        );

        if($this->validate())
        {
            $this->model->save();
        }
    }

    public function validate()
    {
        $this->validateTransection->ruleAccount($this->model->getAccountOrigin());
        $this->validateTransection->ruleAgency($this->model->getAgencyOrigin());
        $this->validateTransection->ruleAccount($this->model->getAccountDestiny());
        $this->validateTransection->ruleAgency($this->model->getAgencyDestiny());
        $this->validateTransection->ruleValue($this->model->getValue());
        $this->result = $this->validateTransection->validate();
        return !$this->validateTransection->getError();
    }

    public function getResult()
    {
        return $this->result;
    }
}
