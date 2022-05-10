<?php
namespace App\Rules;

class Helpers {
    public static function isNumeric($data): bool {
        return is_numeric(filter_var($data, FILTER_VALIDATE_INT));
    }

    public static function isValidQuantityOfCaracters(string $data, int $quantiyOfCaracters): bool
    {
        return (strlen($data) == $quantiyOfCaracters) ? true : false;
    }
}