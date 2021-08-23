<?php
// Ex-4

function reverseElements($arr)
{
    $res = [];
    foreach ($arr as $val) {
        array_unshift($res, $val);
    }
    return $res;
}

# print_r(reverseElements([1, 2, 3, 4, 5, 6, 7, 8, 9]));
