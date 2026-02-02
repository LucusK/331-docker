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
    $unorder = false;

    $orderedlist = false;
    $orderedlist2 = false; #nested
    $order = false;

    foreach($string_array as $curr_string){
        
        #check for blank line to end paragraph or any lists
        if(trim($curr_string) === ""){
            #check if already in paragraph
            if($paragraph){
                echo "</p>\n";
                $paragraph = false;
            }
            if($unorderedlist2){
                echo "</ul>\n";
                $unorderedlist2 = false;
            }
            if($unorderedlist){
                echo "</ul>\n";
                $unorderedlist = false;
            }
            if($unorder){
                    echo "</li>\n";
                    $unorder = false;
                }
            if($orderedlist2){
                echo "</ul>\n";
                $orderedlist2 = false;
            }
            if($orderedlist){
                echo "</ol>\n";
                $orderedlist = false;
            }
            continue;
        }


        #check headings, remember . is concatentation
        #substr: string, starting, ending
        if(substr(ltrim($curr_string),0,2)=== "# "){
            if($paragraph){
                echo "</p>\n";
                $paragraph = false;
            }
            if($unorderedlist2){
                echo "</ul>\n";
                $unorderedlist2 = false;
            }
            if($unorderedlist){
                echo "</ul>\n";
                $unorderedlist = false;
            }
            if($unorder){
                    echo "</li>\n";
                    $unorder = false;
                }
            if($orderedlist2){
                echo "</ul>\n";
                $orderedlist2 = false;
            }
            if($orderedlist){
                echo "</ol>\n";
                $orderedlist = false;
            }
            echo "<h1>" . helperStyling(substr(ltrim($curr_string), 2)) . "</h1>\n";
            continue;
        }
        if(substr(ltrim($curr_string),0,3)=== "## "){
            if($paragraph){
                echo "</p>\n";
                $paragraph = false;
            }
            if($unorderedlist2){
                echo "</ul>\n";
                $unorderedlist2 = false;
            }
            if($unorderedlist){
                echo "</ul>\n";
                $unorderedlist = false;
            }
            if($unorder){
                    echo "</li>\n";
                    $unorder = false;
                }
            if($orderedlist2){
                echo "</ul>\n";
                $orderedlist2 = false;
            }
            if($orderedlist){
                echo "</ol>\n";
                $orderedlist = false;
            }
            echo "<h2>" . helperStyling(substr(ltrim($curr_string), 3)) . "</h2>\n";
            continue;
        }
        if(substr(ltrim($curr_string),0,4)=== "### "){
            if($paragraph){
                echo "</p>\n";
                $paragraph = false;
            }
            if($unorderedlist2){
                echo "</ul>\n";
                $unorderedlist2 = false;
            }
            if($unorderedlist){
                echo "</ul>\n";
                $unorderedlist = false;
            }
            if($orderedlist2){
                echo "</ul>\n";
                $orderedlist2 = false;
            }
            if($orderedlist){
                echo "</ol>\n";
                $orderedlist = false;
            }
            echo "<h3>" . helperStyling(substr(ltrim($curr_string), 4)) . "</h3>\n";
            continue;
        }



        #unordered list  regex checks for non-charactrs then a * followed by the capture group for rest of line
        if (preg_match('/^(\s*)\*\s+(.*)$/', $curr_string, $match)) { #list mode
            #gotta close other modes
            if($orderedlist2){
                echo "</ul>\n";
                $orderedlist2 = false;
            }
            if($orderedlist){
                echo "</ol>\n";
                $orderedlist = false;
            }
            if($paragraph){
                echo "</p>\n";
                $paragraph = false;
            }

            if(!$unorderedlist){ #start top of unordered list
                echo "<ul>\n";
                $unorderedlist = true;
            }
            #see if nested, if first match is more 1 space
            if(strlen($match[1]) >= 2) {
                #start nested list
                
                if(!$unorderedlist2){
                    echo "\n<ul>\n";
                    $unorderedlist2 = true;
                }
                echo "<li>" . helperStyling($match[2]) . "</li>\n";
            }
            else{ #not nested
                if($unorderedlist2){ #end nest
                    echo "</ul>\n";
                    $unorderedlist2 = false;
                }
                if($unorder){
                    echo "</li>\n";
                    $unorder = false;
                }
                echo "<li>" . helperStyling($match[2]) . "</li>\n";
                $unorder = true;
            }           
            continue;
        }

        #ordered list, similar logic to unordered
        #regex check if starts with 1.
        if(preg_match('/^\s*1\.\s+(.*)$/', $curr_string, $match)) {
            if (!$orderedlist){
                echo "<ol>\n";
                $orderedlist = true;
            }
            if($orderedlist2){
                echo "</ul>\n";
                $orderedlist2 = false;
            }
            echo "<li>" . helperStyling($match[1]) . "</li>\n";
            continue;
        }
        #nested ordered, regex check if starts with -
        if(preg_match('/^\s*-\s+(.*)$/', $curr_string, $match)) {
            if(!$orderedlist2){
                echo "<ul>\n";
                $orderedlist2 = true;
            }
            echo "<li>" . helperStyling($match[1]) . "</li>\n";
            continue;
        }

        #normal text, close all

        if($unorderedlist2){
            echo "</ul>\n";
            $unorderedlist2 = false;
        }
        if($unorder){
            echo "</li>\n";
                $unorder = false;
        }
        if($unorderedlist){
            echo "</ul>\n";
            $unorderedlist = false;
        }
        if($orderedlist2){
            echo "</ul>\n";
            $orderedlist2 = false;
        }
        if($orderedlist){
            echo "</ol>\n";
            $orderedlist = false;
        }


        #make ending a new paragraph
        if(!$paragraph){
            echo "<p>";
            $paragraph = true;
        }
        echo helperStyling($curr_string) . " ";
    }
    if ($paragraph) echo "</p>\n";
    if ($unorderedlist2) echo "</ul>\n";
    if ($unorder) echo "</li>\n";
    if ($unorderedlist) echo "</ul>\n";

    if ($orderedlist2) echo "</ul>\n";
    if ($orderedlist) echo "</ol>\n";
}

function helperStyling($in){
    # $1, $2 means the text regex captured
    #**bold**  looks like ? only matches first match rather than whole thing
    $in = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $in);
    #_TALIC_
    $in = preg_replace('/_(.+?)_/', '<i>$1</i>', $in);
    #<ins>UNDERLINED</ins> doesnt need to be changed idt

    #need image first bc link alrdy matches image
    #images ![alt text](url), similar regex but with a !, and just match anything in [] and ()
    $in = preg_replace('/!\[([^\]]*)\]\(([^)]+)\)/', '<img src="$2" alt="$1">', $in);


    #links  [name](url). regex matches [any char or more]( anything except ), or more)
    $in = preg_replace('/\[(.*?)\]\(([^)]+)\)/', '<a href="$2">$1</a>', $in);

    

    return $in;
}

# example call

# proc_markdown("test.md");

# the "test.md" file will contain plain ASCII text, in GitHub markdown syntax.

?>