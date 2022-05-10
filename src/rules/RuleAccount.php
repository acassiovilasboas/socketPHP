<?php

namespace App\Rules;

use Helpers;

class RuleAccount implements ValidateInterface
{
    private $codeAccount;

    function __construct(string $codeAccount)
    {
        $this->codeAccount = $codeAccount;
    }

    private function isNumeric(): bool
    {
        return is_numeric(filter_var($this->codeAccount, FILTER_VALIDATE_INT));
    }

    private function isValidAccount(): bool
    {
        return (strlen($this->codeAccount) == 6) ? true : false;
    }

    public function validate(): bool
    {
        return $this->isValidAccount() && $this->isNumeric() ? true : false;
    }
}
