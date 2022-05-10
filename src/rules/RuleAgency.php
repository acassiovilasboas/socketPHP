<?php

namespace App\Rules;

use Helpers;

class RuleAgency implements ValidateInterface
{
    private $agency;

    function __construct(string $agency)
    {
        $this->agency = $agency;
    }

    private function isNumeric(): bool
    {
        return is_numeric(filter_var($this->agency, FILTER_VALIDATE_INT));
    }

    private function isValidAccount(): bool
    {
        return (strlen($this->agency) == 4) ? true : false;
    }

    public function validate(): bool
    {
        return $this->isValidAccount() && $this->isNumeric() ? true : false;
    }
}
