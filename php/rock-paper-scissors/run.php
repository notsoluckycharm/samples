<?php
/* Rock Paper Scissors */

$scoreBoard = [ 'player' => 0, 'computer' => 0 ];
 
echo "
===================
Rock Paper Scissors
===================

Please enter one of the following options to continue:
    - score
    - rock
    - paper
    - scissors

Type 'exit' to terminate.

";

while( ( $line = stream_get_line( STDIN, null, PHP_EOL ) ) !== false )
{
    $line = strtolower( $line );
    if( $line == 'exit' )
        exit;
    
    if( $line == 'score' )
    {
        echo "Player:" . $scoreBoard['player'] . PHP_EOL;
        echo "Computer:" . $scoreBoard['computer'] . PHP_EOL . PHP_EOL;
        continue;
    }
    try{
        $computersChoice = getChoice();
        echo "Computer Got $computersChoice" . PHP_EOL;
        $outcome = compare( $computersChoice, $line );
        if( !is_null( $outcome ) )
        {
            if( $outcome )
            {
                echo "Computer Wins!" . PHP_EOL;
                $scoreBoard['computer']++;
            } else {
                echo "Player Wins!" . PHP_EOL;
                $scoreBoard['player']++;
            }
        } else {
            echo "Tie!" . PHP_EOL;
        }
    } catch( Exception $e ) {
        echo $e->getMessage() . PHP_EOL;
    }
}

/** A simple function to return a randomized choice
 *
 * @return string the choice of rock, paper, or scissors
 */
function getChoice()
{
    $random = mt_rand(1, 100);
    if( $random < 33 )
        return 'rock';
    if( $random < 66 )
        return 'paper';
    return 'scissors';
}

/** A simple comparsion operator that returns true if choice2 beats choice1
 * False if choice1 beats choice2, and null if they are equivalent similar to
 * string comparison functions
 *
 * @param string $choice1 The first choice to compare to the second choice
 * @param string $choice2 The second choice to compare to the first choice
 * @return boolean If choice2 beats choice1;
 *
 */
function compare($choice1, $choice2)
{
    if( $choice1 == $choice2 )
        return null;
    else {
        switch($choice2){
            case 'rock':
                return $choice1 == 'paper';
            case 'paper':
                return $choice1 == 'scissors';
            case 'scissors':
                return $choice1 == 'rock';
        }
    }
    throw new Exception("Invalid Choice", 400);
}