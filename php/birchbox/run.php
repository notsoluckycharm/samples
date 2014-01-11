<?php

$array = [ 14,1,18,23,12,8,16,24,22 ]; // Potential Max Loss in this array should be 15.

$max = $lowest = array_shift( $array );
$maxLoss = 0;
foreach( $array as $key => $value ){
    if( $value >= $max ) {
        $max = $lowest = $value;
    } else {
        $lowest = min( $lowest, $value );
    }
    $potentialLoss = $max - $lowest;
    if( $potentialLoss > $maxLoss )
        $maxLoss = $potentialLoss;
}

echo $maxLoss;

