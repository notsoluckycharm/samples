<?php
/** Welcome to my code test, please see the attached documentation "problem.txt"
 *
 * This attempts to solve for a list of patterns and a list of paths, finding the
 * most optimized pattern that matches the path. Optimized is defined in the
 * supplied and included documentation.
 *
 * Loop
 *  Loop
 *
 * Would work, but instead I built a tree traversal mechanism that consumes the requested
 * path as it traverses for what I think the optimal solution is to this problem. If this
 * were mission critical, perhaps PHP wouldn't be the best language to do it in.
 *
 * Enjoy.
 *
 */
require 'Trie.php';

stream_set_blocking( STDIN, 0 );
$patterns = stream_get_line( STDIN, null, PHP_EOL );
if( $patterns ) // Valid setup
{
    $tree = new Trie();
    while( $line =stream_get_line( STDIN, null, PHP_EOL ) )
    {
        // Skipping zero, which should actually contain the number of paths...
        if( $patterns > 0 ) // build the Trie
        {
            $tree->setBranch( $line );
        } else if( $patterns < 0 ) { // process the most optimal paths
            echo $tree->bestPath( $line ) . PHP_EOL;
        }
        $patterns--;
    }
} else { // Input wasn't granted through STDIN, as the problem stated
    echo "Please use the following sytnax: ./your_program.ext < input_file > output_file";
}