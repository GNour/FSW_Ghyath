<?php

// Ex-9

function removeSpecified($arr, $val)
{
    $res = [];
    foreach ($arr as $idx => $value) {
        if ($value === $val) {
            // We can mutate the orginal array using the below 2 lines
            // $arr[$idx] = $arr[count($arr) - 1];
            // $arr[count($arr) - 1] = null;
        } else {
            $res[] = $value;
        }
    }
    return $res;
}

print_r(removeSpecified([3, 4, 5, 6], 6));
