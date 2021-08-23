<?php

// Ex-5

$even = [];
$odd = [];

$arr = [1, 2, 3, 4, 5, 6, 7, 8, 9];

foreach ($arr as $val) {
    if ($val % 2 == 0) {
        array_push($even, $val);
    } else {
        array_push($odd, $val);
    }
}

# print_r($even);
# print_r($odd);
