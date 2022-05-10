<?php

namespace App\Rules;

class RuleValue implements ValidateInterface
{
    private $value;

    function __construct(string $value)
    {
        $this->value = $value;
    }

    private function isNumeric(): bool
    {
        return is_numeric(filter_var($this->value, FILTER_VALIDATE_INT));
    }

    public function validate(): bool
    {
        return $this->isNumeric() ? true : false;
    }
}
