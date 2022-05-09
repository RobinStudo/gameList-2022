<?php
function average(array $array, int $precision = 1): float
{
    $avg = array_sum($array) / count($array);
    return round($avg, $precision);
}

function getDefaultGamePoster(): string
{
    return 'https://www.onlylondon.properties/application/modules/themes/views/default/assets/images/image-placeholder.png';
}