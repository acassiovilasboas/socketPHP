<?php

namespace App\Model;

use DateTime;
use Exception;

class Transection extends Model
{
    private $ip;
    private $transection;
    private $agency;
    private $account;
    private $agencyDestiny;
    private $accountDestiny;
    private $value;
    private $cpf;
    private $checksum;
    private $createdAt;
    private $path = "transection";

    // public function __construct(
    //     string $ip,
    //     string $transection,
    //     string $message,
    //     string $checksum,
    // ) {
    //     $this->ip = trim($ip);
    //     $this->account = trim($account);
    //     $this->agency = trim($agency);
    //     $this->transection = trim($transection);
    //     $this->cpf = trim($cpf);
    //     $this->value = trim($value);
    //     $this->createdAt = Date("Y-m-d H:i:s");

    //     return ($this->prepar()) ? true : false;
    // }

    // private function prepar()
    // {
    //     $data = [
    //         "ip" => $this->ip,
    //         "account" => $this->account,
    //         "agency" => $this->agency,
    //         "transection" => $this->transection,
    //         "cpf" => $this->cpf,
    //         "value" => $this->value,
    //         "created_at" => $this->createdAt
    //     ];
    //     return ($this->create($data, $this->path) ? true : false);
    // }
}
