<?php
function average(array $array, int $precision = 1): float
{
    $avg = array_sum($array) / count($array);
    return round($avg, $precision);
}