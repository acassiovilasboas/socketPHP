<?php

namespace App\Rules;

use Helpers;

class RuleAccountOfBank implements ValidateInterface
{
    private $accountOfBank;

    function __construct(string $accountOfBank)
    {
        $this->accountOfBank = $accountOfBank;
    }

    private function isNumeric(): bool
    {
        return is_numeric(filter_var($this->accountOfBank, FILTER_VALIDATE_INT));
    }

    private function isValidAccount(): bool
    {
        return (strlen($this->accountOfBank) == 6) ? true : false;
    }

    private function isValidNumber(): bool
    {
        return $this->accountOfBank == CONF_NUMBER_OF_ACCOUNT ? true : false;
    }

    public function validate(): bool
    {
        return $this->isValidAccount() && $this->isNumeric() && $this->isValidNumber() ? true : false;
    }
}
