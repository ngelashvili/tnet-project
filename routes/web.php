<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
//    return view('welcome');


    function solve($string) {
        $string = strrev($string);
        $result = '';
        for ($i=0; $i<strlen($string); $i++) {
            if($string[$i] == '(' || $string[$i] == ')') continue;
            $result .= intval($string[$i]) ? str_repeat($result, intval($string[$i]) - 1) : $string[$i];
        }

        return strrev($result);
    }

//    echo solve('3(ab)');

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
    $arr = [-6,-3,-2,-1,0,1,3,4,5,7,8,9,10,11,14,15,17,18,19,20, 25];
    echo rangeExtraction($arr);


});

Route::get('login', [ 'as' => 'login', function (Request $request) {
    echo 'Please use auth/login to get token';
}]);

