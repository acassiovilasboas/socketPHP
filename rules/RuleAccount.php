<?php

namespace Rules;

use Helpers;

class RuleAccount {
    private $codeAgency;
    private $codeAccount;
    private static $rule = '//';

    function __construct(string $codeAgency, string $codeAccount)
    {
        $this->codeAccount = $codeAccount;
        $this->codeAgency = $codeAgency;
    }

    private function isNumeric($data): bool {
        return is_numeric(filter_var($data, FILTER_SANITIZE_NUMBER_INT));
    }

    public function validate(): int {
        if(!$this->isNumeric($this->codeAgency . $this->codeAccount)) return 400;
        return 200;
    }




}