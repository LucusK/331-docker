<?php
# function definition
#search all web pages within your local web directory
#provide list of links to the pages that contain the search word (or phrase)
#You have to be careful when the page contains php-generated text. You must search for keywords in the final generated HTML, not the PHP file source. 
#Important:  You must sanitize the user input, to avoid any security issues.
function search($string)  {
    #first sanitize, only care about letters & numbers
    $query = trim($string); #trim found in php.net, removes whitespace
    $query = preg_replace('/[^a-zA-Z0-9]/','',$query);

    #find the local web directory
    #php.net uses $_SERVER which has 'DOCUMENT_ROOT'
                    #    The document root directory under which the current script is executing, as defined in the server's configuration file.
    $web_root_dir = $_SERVER['DOCUMENT_ROOT'];
    $matches = array();

    #scans the website’s document root to find all HTML and PHP files
    #glob found on php.net, Find pathnames matching a pattern, Returns an array containing the matched files/directories,
    $php_files = glob($web_root_dir . "/*.php");
    $html_files = glob($web_root_dir . "/*.html");

    #converts its file path into a URL on localhost:5555

    #loads the page through the web server so that any PHP code is executed and the final HTML output is retrieved

    #search on this generated HTML to check whether the search keyword appears

    #outputs an ordered list of hyperlinks to all pages that contain the search



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