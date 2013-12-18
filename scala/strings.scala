/** The below code snippets were asked during interview questions.
 *
 *
 */

/* Find the fibonachi number at the desired position in the sequence */
def fib( a:Int ) : Int = {
    if( a < 2 ) {
        return a
    }
    fib(a - 1) + fib(a - 2)
}
println( fib(10) ) // 55


/** Find the number of occurances of a substring within another string, occurances do not need to be
 * in immediate sequence. for example the pattern ab will match with (a)(b)xcy(a)z(b) for an answer of 3
 *
 */
def strPos( a:List[Char], b:List[Char] ) : Int = {
    var count = 0;
    if( b.length > 0 ) {
        var pos = 0
        for( character <- a ) {
            pos += 1;
            if( character == b(0) ) {
                count += strPos( a.slice( pos, a.length ), b.slice( 1, b.length ) );
            }
        }
    } else {
        count += 1
    }
    count;
}

println( strPos( "ababab".toList, "ab".toList ) ) // 6
println( strPos( "abababab".toList, "ab".toList ) ) // 10