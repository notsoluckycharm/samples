<?php
/** A Trie data structure tailored to the problem set I am solving for Warby
 * Except instead of consuming it character by character, we will consume things
 * word by word to traverse paths while ocnsuming the requested path
 *
 * Please Enjoy. Use this for anything other then cheating ;]
 *
 * @author Brad Gunn <hevean@gmail.com>
 */
class Trie {

    /**
     * @var array This is where we will store our tree!
     */
    protected $tree = [];

    /** The public facing function that takes in the path and transforms it into
     * the way we need it to be. Instead of commas this could be any deliminated
     * String
     *
     * @param string the path we want to add from the Warby Parker code test
     * @return boolean if we were successful or not, which is always yes.
     */
    public function setBranch($path)
    {
        $keys = explode(',', $path);
        return $this->_setBranch($this->tree, $keys);
    }

    /** This function leverages array pointers to traverse the existing tree
     * quickly and apply the paths to where they need to go. Populating the tree
     * Should be as quick per item as retrieval. Hopefully. This is PHP.
     *
     * @param array PassByR to the tree we will traverse and add this path to.
     * @param array a preformulated array to our specifications
     *
     */
    protected function _setBranch(&$array_ptr, $path)
    {
        while ($arr_key = array_shift($path)) {
            if (!array_key_exists($arr_key, $array_ptr)) {
               $array_ptr[$arr_key] = ['meta' => [ 'end' => false ] ];
            }
            $array_ptr = &$array_ptr[$arr_key];
        }
        $array_ptr['meta']['end'] = true;
        return true;
    }

    /*For each path encountered in the input, print the *best-matching
    pattern*. The best-matching pattern is the one which matches the path
    using the fewest wildcards.

    If there is a tie (that is, if two or more patterns with the same number
    of wildcards match a path), prefer the pattern whose leftmost wildcard
    appears in a field further to the right. If multiple patterns' leftmost
    wildcards appear in the same field position, apply this rule recursively
    to the remainder of the pattern.

    For example: given the patterns `*,*,c` and `*,b,*`, and the path
    `/a/b/c/`, the best-matching pattern would be `*,b,*`.

    If no pattern matches the path, print `NO MATCH`. */
    public function bestPath($path)
    {
        $path = explode('/', trim( $path, '/' ));
        $paths = [];
        $this->_getPaths($this->tree, $path, $paths);
        if( !$paths )
            return "NO MATCH";
        // There is likely room for some trickery here, but I'm just going to go
        // and do the comparison
        $best = array_shift($paths);
        foreach( $paths as $path )
        {
            if( $path['w'] < $best['w'] )
                $best = $path;
            if( $path['w'] == $best['w'] && $path['p'] > $best['p'] )
                $best = $path;
        }
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
     *
     */
    protected function _getPaths(&$array_ptr, $path, &$matches, $trail = '',
                        $wildcards = 0, $lastWildcardPosition = 0, $depth = 1 )
    {
        $arr_key = array_shift( $path );
        if( $arr_key )
        {
            foreach( [$arr_key, '*'] as $index => $validChoice )
            {
                if( isset( $array_ptr[$validChoice] ) )
                {
                    $tryThisPath = $this->_getPaths(
                        $array_ptr[$validChoice],
                        $path,
                        $matches,
                        "$trail,$validChoice",
                        $wildcards + $index,
                        $index ? $depth : $lastWildcardPosition,
                        $depth + 1 );
                    if( $tryThisPath )
                       $matches[] = $tryThisPath;
                }
            }
            if( !$matches )
                return false;
        } else if( $array_ptr['meta']['end'] ) {
            return [ 'w' => $wildcards, 'p' => $lastWildcardPosition, 't' => $trail ];
        }
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