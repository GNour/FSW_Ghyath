<?php

// Ex-7

$arr = array("Zero" => 0, "One" => 1, "Two" => 2, "Three" => 10, "Four" => 9);
$maxIdx = "";
$maxVal = 0;
foreach ($arr as $idx => $val) {
    if ($maxVal < $val) {
        $maxVal = $val;
        $maxIdx = $idx;
    }
}

echo $maxIdx . "\n";
