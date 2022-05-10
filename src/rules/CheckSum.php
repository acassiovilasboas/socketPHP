<?php

namespace App\Rules;

class CheckSum implements ValidateInterface
{
    private $message;
    private $sum;

    function __construct($message)
    {
        $this->xor = (int) substr($message, (85 - strlen($message)));
        $this->message = substr($message, 0, 85);
    }

    private function checkSum()
    {
        $byte = unpack("C*", utf8_encode($this->message));
        $xor = 0;
        foreach ($byte as $char) {
            $xor ^= $char;
        }
        $this->checksum = $xor;
    }

    public function validate(): bool
    {
        $this->checkSum();
        if($this->xor == $this->checksum) {
            echo "- checksum: OK" . PHP_EOL;
        } else {
            echo "- checksum: ERROR" . PHP_EOL;
        }
        return $this->xor === $this->checksum ? true : false;
    }
}
