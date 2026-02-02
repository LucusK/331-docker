<?php
# function definition
#search all web pages within your local web directory
#provide list of links to the pages that contain the search word (or phrase)
#You have to be careful when the page contains php-generated text. You must search for keywords in the final generated HTML, not the PHP file source. 
#Important:  You must sanitize the user input, to avoid any security issues.
function search($string)  {
    #first sanitize, only care about letters & numbers
    $query = trim($string); #trim found in php.net, removes whitespace
    $query = preg_replace('/[^a-zA-Z0-9 ]/','',$query);
    echo "query: " . $query . "<br>\n";

    #find the local web directory
    #php.net uses $_SERVER which has 'DOCUMENT_ROOT'
                    #    The document root directory under which the current script is executing, as defined in the server's configuration file.
    $web_root_dir = $_SERVER['DOCUMENT_ROOT'];
    $matches = array();

    #scans the website’s document root to find all HTML and PHP files
    #glob found on php.net, Find pathnames matching a pattern, Returns an array containing the matched files/directories,
    $php_files = glob($web_root_dir . "/*.php");
    $html_files = glob($web_root_dir . "/*.html");

    $all_files = array_merge($php_files, $html_files);

    foreach($all_files as $curr_file){
        $base = basename($curr_file);
        if ($base === "index.php" || $base === "search.php") {
            continue;
        }
        #converts its file path into a URL on localhost:5555
        $link_url = "http://localhost:5555" . substr($curr_file, strlen($web_root_dir));
        $test_url = "http://webserver" . substr($curr_file, strlen($web_root_dir));
        echo "trying: $test_url<br>";

        #loads the page through the web server so that any PHP code is executed and the final HTML output is retrieved
        #turn into html using file_get_contents
        # php.net says this reads entire file into string. it also would generate the page in the website first before sending it over
        $file_string = @file_get_contents($test_url); 
        if($file_string === false){
            echo "FETCH FAILED<br>\n";
            continue;
        } #we basically store all contents in a string
        #search on this generated HTML to check whether the search keyword appears
        if (stripos($file_string, $query) !== false) { #originally had str_contains, but that doesnt work on this php version
            $matches[] = $link_url; #found this is same as array_push, in definition on php.net
        }
        
    }
    #outputs an ordered list of hyperlinks to all pages that contain the search
    echo "matches: " . count($matches) . "<br>\n";
    echo "<ol>";
    foreach ($matches as $match) {
        echo "<li><a href=\"$match\">$match</a></li>";
    }
    echo "</ol>";
    

}

# example calls

#search("search keyword")

# this will result in a list of hyperlinks that point to your 
# web pages that contain the search keyword.
#
# 1. http://your.site.com/blog.php
# 2. http://your.site.com/resources.php
# ...
#

#* No need to support search including special characters. Just alphanumeric and blank space is enough. 


?>