<?php

namespace Rules;

class RuleOperation
{
    private $nameOperation;
    private $operations = "cadastrar_conta";

    function __construct(string $nameOperation)
    {
        $this->nameOperation = $nameOperation;
    }

    private function isOperationValid(): bool {
        return $this->nameOperation == $this->operations ? true : false;
    }

    public function validate(): int {
        if (!$this->isOperationValid()) return 404;
        return 200;
    }
}