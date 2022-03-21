<?php

namespace Rules;

use Helpers;

class RuleCpf {
    private $codeCpf;
    private static $rule = '//';

    function __construct(string $codeCpf)
    {
        $this->codeCpf = $codeCpf;
    }

    private function isNumeric($data): bool {
        return is_numeric(filter_var($data, FILTER_SANITIZE_NUMBER_INT));
    }

    public function validate(): int {
        if(!$this->isNumeric($this->codeCpf)) return 400;
        return 200;
    }

}