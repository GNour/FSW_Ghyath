<?php
function binaryToDecimal($bin)
{
    $res = 0;
    for ($i = 0; $bin != 0; $i++) {
        $temp = $bin % 10;
        $res += $temp * pow(2, $i);
        $bin = intval($bin / 10);
    }
    return $res;
}

# echo binaryToDecimal(101010001);
