<?php

namespace App\Rules;

class RuleTransection implements ValidateInterface
{
    private $transection;
    private $transectionSelected;
    private $transections = [
        "open_account" => ["cadastrar_conta", "open_account", "Cadastrar_Conta", "cadastrar-conta", "Cadastrar-Conta", "Cadastrar-conta", "cadastrar-Conta"],
        "withdraw" => ["sacar", "saque", "Sacar", "Saque", "withdraw", "to_withdraw", "to-withdraw"],
        "deposit" => ["depositar", "deposito", "Depositar", "Deposito", "Deposit", "deposit"],
        "transfer" => ["transferir", "Transferir", "transfer", "Transfer"],
        "loan" => ["emprestimo", "Emprestimo", "loan", "Loan"]
    ];

    function __construct(string $message)
    {
        $this->transection = trim(substr($message, 20, 35));
    }

    public function validate(): bool
    {
        foreach ($this->transections as $transection => $names) {
            if (in_array($this->transection, $names)) {
                $this->transectionSelected = $transection;
                return true;
            }
        }
        return false;
    }

    public function getTransectionSelected(): string
    {
        return $this->transectionSelected;
    }
}
