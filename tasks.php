<?php


// ამოცანა 1
// JS: https://www.codewars.com/kata/reviews/57cec2caf0fe9cd5df000072/groups/5e6a4b3e5a397500018e77c1

// ამოცანა 2
// JS: https://www.codewars.com/kata/reviews/5975bf816aec339cc000006c/groups/65491498546e47000115da80

// ამოცანა 3
// PHP: https://www.codewars.com/kata/reviews/57e880b6d24a8b58ca000016/groups/596fa4bcb82f99d952000cbb

// ამოცანა 4
function solve($string) {
    $string = strrev($string);
    $result = '';
    for ($i=0; $i<strlen($string); $i++) {
        if($string[$i] == '(' || $string[$i] == ')') continue;
        $result .= intval($string[$i]) ? str_repeat($result, intval($string[$i]) - 1) : $string[$i];
    }

    return strrev($result);
}
    //echo solve('3(ab)');


// ამოცანა 5
function rangeExtraction($array){
    $result = [];
    $temp = [];

    foreach ($array as $i) {
        if (!empty($temp) && $temp[count($temp) - 1] + 1 == $i) {
            $temp[] = $i;
        } else {
            if (count($temp) >= 3) {
                $result[] = $temp[0] . '-' . end($temp);
            } else {
                if($temp)
                    $result[] = implode(',', $temp);
            }
            $temp = [$i];
        }
    }

    if (count($temp) >= 3) {
        $result[] = $temp[0] . '-' . end($temp);
    } else {
        $result[] = implode(',', $temp);
    }

    return implode(',', $result);
}
    //$arr = [-6,-3,-2,-1,0,1,3,4,5,7,8,9,10,11,14,15,17,18,19,20, 25];
    //echo rangeExtraction($arr);

// ამოცანა 6
// PHP: https://www.codewars.com/kata/reviews/59c6404b8d0bd6f95e000b7a/groups/63fda9f1d47038000115f886
