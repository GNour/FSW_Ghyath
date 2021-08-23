<?php

// Ex-10

function setUnion($arr1, $arr2)
{
    $res = $arr1;
    foreach ($res as $val1) {
        $found = false;
        foreach ($arr2 as $val2) {
            if ($val1 == $val2) {
                $found = true;
            }
        }

        if (!$found) {
            $res[] = $val1;
        }
    }

    return $res;
}

print_r(setUnion([3, 4, 5, 6], [2, 3, 4, 5, 6]));
