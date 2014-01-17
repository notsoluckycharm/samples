<?php
/* Choice of 2 problems from a list, I chose fibonacci and the palidrome substring checker.
 */
function fibonacci($position){
    if( $position < 2 )
        return $position;
    return fibonacci($position-1) + fibonacci($position-2);
}
$tests = [ 5, 7, 11 ];
foreach( $tests as $test )
    echo "Fibonacci Position {$test}:" . fibonacci($test) . "\n";

// Greplin Challenge 1
/** A palindrome is defined as having the same spelling forwards and backwards, e.x. kayak
 *
 *  It basically loops over the string and compares a left and right offset until the letters do not match
 *  either confirming or breaking the pattern.
 *
 */
function palindrome($string){
    $length = strlen($string);
    if($length <= 1)
        return true;
    if( $string[0] == $string[$length-1] )
        return palindrome( substr($string,1,$length-2) );
    return false;
}
//sample.
$tests = [
    'FourscoreandsevenyearsagoourfaathersbroughtforthonthiscontainentanewnationconceivedinzLibertyanddedicatedtothepropositionthatallmenarecreatedequalNowweareengagedinagreahtcivilwartestingwhetherthatnaptionoranynartionsoconceivedandsodedicatedcanlongendureWeareqmetonagreatbattlefiemldoftzhatwarWehavecometodedicpateaportionofthatfieldasafinalrestingplaceforthosewhoheregavetheirlivesthatthatnationmightliveItisaltogetherfangandproperthatweshoulddothisButinalargersensewecannotdedicatewecannotconsecratewecannothallowthisgroundThebravelmenlivinganddeadwhostruggledherehaveconsecrateditfaraboveourpoorponwertoaddordetractTgheworldadswfilllittlenotlenorlongrememberwhatwesayherebutitcanneverforgetwhattheydidhereItisforusthelivingrathertobededicatedheretotheulnfinishedworkwhichtheywhofoughtherehavethusfarsonoblyadvancedItisratherforustobeherededicatedtothegreattdafskremainingbeforeusthatfromthesehonoreddeadwetakeincreaseddevotiontothatcauseforwhichtheygavethelastpfullmeasureofdevotionthatweherehighlyresolvethatthesedeadshallnothavediedinvainthatthisnationunsderGodshallhaveanewbirthoffreedomandthatgovernmentofthepeoplebythepeopleforthepeopleshallnotperishfromtheearth',
    "Ilikeracecarsthatgofast"
];

/** Here we unfortunately brute force every combination and every length of letters possible.
 *  Not sure if there is a more optimized solution.
 */

foreach( $tests as $test ) {
    $start = 0;
    $stringlength = 0;
    $length = strlen($test);
    $test = strtolower( $test );
    while( $start++ < $length ){
        $end = $length;
        while($end-- > 1){
            $substring = substr($test,$start-1,$end+1);
            if( palindrome($substring) )
                $stringlength = max( $stringlength, strlen($substring) );
        }
    }
    echo "Longest Palindrome: $stringlength \n";
}