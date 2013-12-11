<?php
/** This was to be done without the internet as a resource with pen and paper, so I established
 * That a prime number was only divisible by itself and 1. I broke every number into basic
 * lowest common denominators to answer the question quickly. This is the digitized outcome.
 *
 * "Write a program that prints out the first 100 prime numbers."
 *
 * @author Brad Gunn <hevean@gmail.com>
 */
$count = 0;
foreach( range( 2, 100 ) as $index )
{
    $isPrime = true;
    // Every non-prime should be divisible by one or more of the following numbers
    foreach( [2,3,5,7] as $divisible )
    {
        // but of course, the numbers themselves are primes. Tricky tricky.
        if( $index != $divisible && $index % $divisible == 0 )
        {
            $isPrime = false;
            break;
        }
    }
    echo $isPrime ? "$index" . PHP_EOL : ''; 
}