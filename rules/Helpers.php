<?php

class Helpers {
    protected function isNumeric($data): bool {
        return is_numeric(filter_var($data, FILTER_SANITIZE_NUMBER_INT));
    }
}