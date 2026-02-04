<?php

if (!function_exists('format_date')) {
    function format_date($date)
    {
        return \Carbon\Carbon::parse($date)->format('d-m-Y');
    }
}

if (!function_exists('greet_user')) {
    function greet_user($name)
    {
        return "Hello, " . $name . "!";
    }
}

