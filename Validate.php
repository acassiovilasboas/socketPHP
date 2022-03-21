<?php

class Validate {
    private $str;
    private $count;
    private $replace;

    function __construct(string $str, int $count = 0, string $replace = "")
    {
        $this->str = $str;
        $this->$count = $count;
        $this->replace = $replace;
    }

    public function validate(){
        echo $this->str;
    }
}

$teste = new Validate("Acassio");
$teste->validate();