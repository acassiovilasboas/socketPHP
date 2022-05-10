<?php

namespace App\Rules;

class RuleCpf implements ValidateInterface
{
    private $cpf;

    function __construct(string $cpf)
    {
        $this->cpf = $cpf;
    }

    private function isNumeric(): bool
    {
        return is_numeric(filter_var($this->cpf, FILTER_VALIDATE_INT));
    }

    private function isValidAccount(): bool
    {
        return (strlen($this->cpf) == 11) ? true : false;
    }
    public function validate(): bool
    {
        return $this->isValidAccount() && $this->isNumeric() ? true : false;
    }
}
