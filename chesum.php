<?php
$message = "ADASFAFGDFGDFADASFAFGDFGDFADASFAF GDFGDFADA FAFGDFGDFADA SFAFGDFGDFADASFAFGDFGDFADASFAFGDFGDFADASFAF GDFGDFAD ASFAFGDFG DFADASFAFGDFGDF";
$byte = unpack("C*", utf8_encode($message));

$xor = 0;
foreach ($byte as $char) {
    // print_r($char . PHP_EOL);
    $xor ^= $char;
}
print_r($xor . PHP_EOL);

// Encoding.UTF8.GetBytes

