<?php

if (!function_exists("monetaire")) {
    function monetaire($value)
    {
        if ($value == 0) {
            return '-';
        }
        return number_format($value, 2, '.', ' ');
    }
}

