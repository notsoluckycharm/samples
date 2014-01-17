<?php
/* Simple N+N efficiency probability picker.
 * It loops over the array, shifts the quantity to reflect a randomized
 * number comparison
 */
$test = [ 'red'=>5, 'blue'=>10, 'green'=>15 ];
function probability(&$arr){
    $count = 0;
    foreach($arr as $index => $value){
        $arr[$index] += $count;
        $count += $value;
    }
    var_dump($arr);
    $random = mt_rand(0, $count);
    echo $random;
    foreach($arr as $key => $value){
        if( $value >= $random )
            return $key;
    }
    return false;
}

$probability = probability($test);
echo "{$probability}\n";
