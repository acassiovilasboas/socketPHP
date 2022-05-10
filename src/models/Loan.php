<?php

namespace App\Model;

use DateTime;
use Exception;

class Loan extends Model
{
    private $ip;
    private $transection;
    private $agency;
    private $account;
    private $agencyDestiny;
    private $accountDestiny;
    private $value;
    private $created_at;
    private $path = "loan";

    public function __construct(
        string $ip,
        string $transection,
        string $agency,
        string $account,
        string $agencyDestiny,
        string $accountDestiny,
        string $value
    ) {
        $this->ip = trim($ip);
        $this->transection = trim($transection);
        $this->agency = trim($agency);
        $this->account = trim($account);
        $this->agencyDestiny = trim($agencyDestiny);
        $this->accountDestiny = trim($accountDestiny);
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

    public function getAgencyDestiny()
    {
        return $this->agencyDestiny;
    }

    public function getAccountDestiny()
    {
        return $this->accountDestiny;
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
