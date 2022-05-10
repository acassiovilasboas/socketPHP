<?php

namespace App\Rules;

use Helpers;

class RuleAgencyOfBank implements ValidateInterface
{
    private $agencyOfBank;

    function __construct(string $agencyOfBank)
    {
        $this->agencyOfBank = $agencyOfBank;
    }

    private function isValidAgency(): bool
    {
        return (strlen($this->agencyOfBank) == 4) ? true : false;
    }

    private function isValidNumber(): bool
    {
        return $this->agencyOfBank == CONF_NUMBER_OF_AGENCY ? true : false;
    }

    public function validate(): bool
    {
        return $this->isValidAgency() && $this->isValidNumber() ? true : false;
    }
}
