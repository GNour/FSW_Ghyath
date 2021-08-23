<?php
// Ex-1

function loopFactorial($num)
{
    $res = 1;
    for ($i = 1; $i <= $num; $i++) {
        $res = $res * $i;
    }
    return $res;
}

# echo loopFactorial(5);
