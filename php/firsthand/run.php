<?

// Our expected input file
$file = './dictionary.txt';

// output destinations
$uniques = fopen( "./uniques.txt", "w" );
$fullwords = fopen( "./fullwords.txt", "w" );

// Sanity check
if( !$uniques || !$fullwords ){
    echo "Destination files unwritable";
    fclose( $uniques );
    fclose( $fullwords );
    exit(1);
}

// Where we will store the results
$map = [];

// Sanity checking, file exists and is readable
if ( file_exists($file) && $handle = fopen($file, "r") ) {
    
    // Read each line in the input
    while (($buffer = fgets($handle, 4096)) !== false) {
        
        // Trim newlines and non alpha-numeric - leave periods intact, hyphons
        // included hyphons/periods, don't know why. Seemed like correct english
        $clean =  preg_replace('@[^0-9a-z\.\-]+@i', '', $buffer);
        
        // Avoid processing lines less than 4 characters in length
        $strlen = strlen($clean);

        if( $strlen > 4 ){

            // write it to the fullwords file
            // NOTE: excercise says "in the same order" so I won't be touching it
            // NOTE: Or be ensuring it is unique. 100% original input
            fwrite( $fullwords, $buffer );

            // process each 4 character piece within the string
            for( $i = 0; $i <= $strlen - 4; $i++ ){
                // Abusing PHP's lack of strict typing. It'll assume it's an integer, even if null
                $map[ substr( $clean, $i, 4 ) ]++;
            }

        }
    }

    // error reading file
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }

    // Alphabetize me, captain
    ksort( $map );

    // echo results where the value only occured once
    foreach( $map as $key => $value ){
        if( $value === 1 ){
            fwrite( $uniques, "$key\n" );
        }
    }
    
    // cleanup 
    fclose( $uniques );
    fclose( $fullwords );

} else {
    exit( "Missing input file, or unable to read input file." );
}
?>
