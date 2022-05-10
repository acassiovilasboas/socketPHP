<?php

namespace App\Model;

use DateTime;
use Exception;

class Deposit extends Model
{
    private $ip;
    private $transection;
    private $agency;
    private $account;
    private $value;
    private $created_at;
    private $path = "deposit";

    public function __construct(
        string $ip,
        string $transection,
        string $agency,
        string $account,
        string $value
    ) {
        $this->ip = trim($ip);
        $this->transection = trim($transection);
        $this->agency = trim($agency);
        $this->account = trim($account);
        $this->value = trim($value);
        $this->created_at = Date("Y-m-d H:i:s");
    }

    public function save()
    {
        $array =  get_object_vars($this);
        $array = array_slice($array, 0, -1);
        $this->create($array, $this->path);
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getTransection()
    {
        return $this->transection;
    }

    public function getAgency()
    {
        return $this->agency;
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getPath()
    {
        return $this->path;
    }
}
