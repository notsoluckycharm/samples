<?php
/** Welcome to my code test, please see the attached documentation "README.md"
 *
 * Enjoy.
 *
 */

$validChoices = [ 'rock', 'paper', 'scissors' ];
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
    
    $computerChoice = getChoice();
    
    if( $line == $computerChoice )
    {
        echo "Tie!";
    } else {
        switch($line)
        {
            case 'rock':
                $outcome = $computerChoice == 'paper';
                break;
            case 'paper':
                $outcome = $computerChoice == 'scissors';
                break;
            case 'scissors':
                $outcome = $computerChoice == 'rock';
                break;
            default:
                echo 'Invalid Choice!' . PHP_EOL;
                continue;
        }

        if( isset( $outcome ) )
        {
            if( $outcome )
            {
                echo "Computer Wins!" . PHP_EOL;
                $scoreBoard['computer']++;
            } else {
                echo "Player Wins!" . PHP_EOL;
                $scoreBoard['player']++;
            }
        }
    }
}

function getChoice()
{
    $random = mt_rand(1, 100);
    if( $random < 33 )
        return 'rock';
    if( $random < 66 )
        return 'paper';
    return 'scissors';
}