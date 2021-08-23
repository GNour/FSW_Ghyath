<?php

// Ex-3

$arr = [3, 4, 5, 1, 3, 5, 32, 6342, 513, 61, 5];

// First method
$min = $arr[0];
$max = $arr[0];

foreach ($arr as $val) {
    if ($min > $val) {
        $min = $val;
    }
    if ($max < $val) {
        $max = $val;
    }
}

# echo $min . " " . $max;

// Second Method

/*
sort($arr);
$min = $arr[0];
$max = $arr[count($arr) - 1]; */
