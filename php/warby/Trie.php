<?php
/** A Trie data structure tailored to the problem set I am solving for Warby.
 * Traditionally, a Trie is a binary tree with nodes populated character by character to allow quick wildcard
 * returns by returning the entire child tree to the caller. For instance the word "rain*" could return rainbow
 * r -> a -> i -> n -> *
 *                  -> b -> o -> w
 *
 * Except instead of consuming it character by character, this class will consume things word by word to
 * traverse paths while consuming the requested path for optimal performance.
 *
 * a -> b -> *
 *        -> c -> d
 *
 * Please Enjoy. Use this for anything other than cheating ;]
 *
 * @author Brad Gunn <hevean@gmail.com>
 */
class Trie {

    /**
     * @var array This is where we will store our tree!
     */
    protected $tree = [];

    /** The public facing function that takes in the path as a string and transforms it into
     * the way we need it to be consumed by the interal functions.
     *
     * @param string $path the flat path representation we want to add to our binary tree representation
     * @param string $delim what character are we going to explode on to add this path to our tree?
     * @return boolean if we were successful or not, which is always yes.
     */
    public function setBranch($path, $delim = ',')
    {
        return $this->_setBranch($this->tree, explode($delim, $path));
    }

    /** This function leverages pass by reference array pointers to traverse the existing in memory tree without
     * copying for performance. It also allows the function to quickly apply the paths by traversing the tree
     * as it is populating the tree from the $path argument
     *
     * @param array PassByR to the tree we will traverse and add this path to.
     * @param array a preformulated array to our specifications
     */
    protected function _setBranch(&$array_ptr, $path)
    {
        // shift the next element off the stack
        while ($arr_key = array_shift($path)) {
            // If it doesn't exist in the tree, create it.
            if (!array_key_exists($arr_key, $array_ptr))
               $array_ptr[$arr_key] = ['meta' => [ 'end' => false ] ];
            //traverse to the node requested/created in anticipation of the next element
            $array_ptr = &$array_ptr[$arr_key];
        }
        // If we got here, whatever node was last is an endpoint in our system and should be marked as such
        $array_ptr['meta']['end'] = true;
        return true;
    }

    /** For each path encountered in the input, print the *best-matching
     * pattern*. The best-matching pattern is the one which matches the path
     * using the fewest wildcards.
     *
     * If there is a tie (that is, if two or more patterns with the same number
     * of wildcards match a path), prefer the pattern whose leftmost wildcard
     * appears in a field further to the right. If multiple patterns' leftmost
     * wildcards appear in the same field position, apply this rule recursively
     * to the remainder of the pattern.
     *
     * For example: given the patterns `*,*,c` and `*,b,*`, and the path
     * `/a/b/c/`, the best-matching pattern would be `*,b,*`.
     *
     * If no pattern matches the path, print `NO MATCH`.
     */
    public function bestPath($path, $delim = '/')
    {
        // This function uses a memory pointer to an array, like preg_match, so we need to instantiate one
        $paths = [];
        $this->_getPaths($this->tree, explode($delim, trim( $path, $delim )), $paths);

        // If it did not populate the paths array, there were no matching paths available
        if( !$paths )
            return "NO MATCH";

        // There is likely room for some trickery here, but I'm just going to go and do the comparison

        // Pop one off as the best
        $best = array_shift($paths);
        foreach( $paths as $path )
        {
            // If the wildcard count is less than the current best, it is the new best match
            if( $path['w'] < $best['w'] )
                $best = $path;
            // If the wildcards are identical, but the position of the last wildcard is higher ( rightmost )
            // it is the new best
            if( $path['w'] == $best['w'] && $path['p'] > $best['p'] )
                $best = $path;
        }
        // return the cleaned product
        return trim( $best['t'], ',' );
    }

    /** This function should return all applicable paths that are contained
     * within the array pointer by traversing it. Further it reports the wild
     * cards used and the last wildcard position, as this was the requirement.
     *
     * @param array $array_ptr PassByR pointer to the array to traverse
     * @param array $path This array is consumed as traversal happens
     * @param array $matches PassByR place to stick the matches because of the
     *              inability to directly return the result because of the
     *              the decision tree.
     * @param string $trail this parameter keeps track of where we've gone thus
     *              far while traversing and is the primary return
     * @param int $wildcards This is the count of wildcards used thus far
     * @param int $lastWildcardPosition This is the position of the last
     *              wildcard used, the index is "rightmost" or from the left
     * @param int $depth Want to break this? Go deep. I didn't do anything with
     *              this parameter, but it would theoretically be your break
     */
    protected function _getPaths(&$array_ptr, $path, &$matches, $trail = '',
                        $wildcards = 0, $lastWildcardPosition = 0, $depth = 1 )
    {
        /* Take the node we're searching for off the stack,
         * if there is no stack and we've reached an endpoint, return the path we found
         */
        $arr_key = array_shift( $path );
        if( $arr_key )
        {
            // Check for the requested key or a wildcard in the current tree branch
            foreach( [$arr_key, '*'] as $index => $validChoice )
            {
                // if found traverse the tree to the next node that we found
                if( isset( $array_ptr[$validChoice] ) )
                {
                    $tryThisPath = $this->_getPaths(
                        $array_ptr[$validChoice],   // Traverse to the next node
                        $path,                      // Pass in the path we're looking for
                        $matches,                   // Pass in the array pointer where we are storing results
                        "$trail/$validChoice",      // Build the return path we're looking for
                        $wildcards + $index,        // If index is one, it's a wildcard and we incremement
                                                    // if index is one, we have a new wildcard position
                        $index ? $depth : $lastWildcardPosition,
                        $depth + 1                  // increment the depth
                    );
                    // If we have results, save it to our array pointer
                    if( $tryThisPath )
                       $matches[] = $tryThisPath;
                }
            }
            // If we do not have results, return false
            if( !$matches )
                return false;
        } else if( $array_ptr['meta']['end'] ) {
            return [ 'w' => $wildcards, 'p' => $lastWildcardPosition, 't' => $trail ];
        }
        // Theoretically, you should only get here for an empty path, default false
        return false;
    }

    /** A simple getter for our protected tree variable
     *
     * @return array the protected tree variable of this object
     */
    public function getTree()
    {
        return $this->tree;
    }
}