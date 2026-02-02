<?php


# function definition: use the exact interface in your code.

function proc_markdown ($filename) {
    # function body
    
    # php.net says this reads entire file into string
    $file_string = @file_get_contents($filename); 

    # create array split by newlines
    $string_array = explode("\n",$file_string);

    #track states
    $paragraph = false;
    $unorderedlist = false;
    $unorderedlist2 = false; #nested
    $orderedlist = false;
    $orderedlist2 = false; #nested

    foreach($string_array as $curr_string){
        #check headings, remember . is concatentation 
        if(substr($curr_string,0,2)=== "# "){
            echo "<h1>" . helperStyling(substr($curr_string, 2)) . "</h1>\n";
            continue
        }
        if(substr($curr_string,0,3)=== "## "){
            echo "<h2>" . helperStyling(substr($curr_string, 3)) . "</h2>\n";
            continue
        }
        if(substr($curr_string,0,4)=== "### "){
            echo "<h3>" . helperStyling(substr($curr_string, 4)) . "</h3>\n";
            continue
        }
    }
}

function helperStyling($in){
    # $1, $2 means the text regex captured
    #**bold**  looks like ? only matches first match rather than whole thing
    $in = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $in);
    #_TALIC_
    $in = preg_replace('/_(.+?)_/', '<i>$1</i>', $in);
    #<ins>UNDERLINED</ins> doesnt need to be changed idt

    #links  [name](url). regex matches [any char or more]( anything except ), or more)
    $in = preg_replace('/\[(.*?)\]\(([^)]+)\)/', '<a href="$2">$1</a>', $in);

    #images ![alt text](url), similar regex but with a !, and just match anything in [] and ()
    $in = preg_replace('/!\[([^\]]*)\]\(([^)]+)\)/', '<img src="$2" alt="$1">', $in);
}

# example call

# proc_markdown("test.md");

# the "test.md" file will contain plain ASCII text, in GitHub markdown syntax.

?>