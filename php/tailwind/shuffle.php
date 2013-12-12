<?php
/** This was to be done without the internet as a resource with pen and paper, so I established
 * that swapping card positions in place consumed no additional memory and achieves the goal
 * of shuffling the array
 *
 * "Write a program that shuffles a deck of cards. (do not use a language or library's built in
 * function; I want to see *your* implementation of a shuffle algorithm)"
 *
 * @author Brad Gunn <hevean@gmail.com>
 */
$deck = [];
foreach( ['heart','spade','club','diamond'] as $suite )
    foreach( range(1,13) as $card )
        $deck[] = "$suite-$card";

foreach( $deck as $index => $card )
{
    foreach( range(0,51) as $index )
    {
        $random = mt_rand(0,51);
        $variable = $deck[$index];
        $deck[$index] = $deck[$random];
        $deck[$random] = $variable;
    }
}