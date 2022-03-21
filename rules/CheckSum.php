<?php

namespace Rules;

class CheckSum
{
    private $message;
    private $sum;

    function __construct($message)
    {
        $this->message = $message;
        $this->sum = $this->checkSum();
    }

    private function checkSum()
    {
        $sum = 0;
        for ($i = 0; $i < strlen($this->message); $i++)
            $sum += ord($this->message[$i]) * $i;

        return $sum;
    }

    public function validate(int $checksum): int
    {
        if ($checksum != $this->sum) {
            echo "check servidor: " . $this->sum . PHP_EOL;
            echo "check client: " . $checksum . PHP_EOL;
            return 200;
        }
        return 200;
    }
}
