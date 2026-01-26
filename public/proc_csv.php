<?php

# function definition: use the exact interface in your code.

function proc_csv ($filename, $delimiter, $quote, $columns_to_show) {
    /*
    # function body
    //need to open file
    $file_handle = fopen($filename,"r");
    if(!$file_handle){
        echo "cannot open csv file";
        return;
    }

    //get the columns to show
    $columns = null;
    if($columns_to_show !== "ALL"){
        $columns = explode(":",$columns_to_show);
        //for each column nums, convert to int, make 1 show 1st column
        for($i = 0; $i < count($columns); $i++){
            $columns[$i] = intval($columns[$i])-1;
        }
    }
    //explode(string $separator, string $string, int $limit = PHP_INT_MAX): array
    // Returns an array of strings, each of which is a substring of string formed by splitting it on boundaries formed by the string separator.
    echo "<table border=\"1\">\n"; //print table borders
    

    
    //Gets line from file pointer and parse for CSV fields
    while(($rows = fgetcsv($file_handle, 0, $delimiter, $quote))!== false){
        //start a row
        echo "<tr>\n";

        //for all
        if($columns_to_show == "ALL"){
            //add cells for each in the row
            for($j = 0; $j < count($rows); $j++){
                //cell = row at j column
                echo "<td>".$rows[$j]."</td>\n";
            }
        }
        //for specific columns
        else{
            for($k = 0; $k < count($columns); $k++){
                //add row for each column
                echo "<td>".$rows[$columns[$k]]."</td>\n";
                
            }
        }
        ///end row
        echo "</tr>\n";
    }
    echo "</table>\n";
    */
/////////////////////
/////////////////////
/////////////////////
    //forgot cant use getcsv so need to implement using regex
    //refering to https://catswhocode.com/development/php-regex/ for function definitions
    //store all text in file
    $file_handle = fopen($filename,"r");
    if(!$file_handle){
        echo "cannot open csv file";
        return;
    }

    //get the columns to show
    $columns = null;
    if($columns_to_show !== "ALL"){
        $columns = explode(":",$columns_to_show);
        //for each column nums, convert to int, make 1 show 1st column
        for($i = 0; $i < count($columns); $i++){
            $columns[$i] = intval($columns[$i])-1;
        }
    }
    //preg_quote from catswhocode.com
    $delimiter_reg = preg_quote($delimiter,"/");
    $quote_reg = preg_quote($quote,"/");

    //regex to find all entries
    //(?:"(?:[^"]|"")*"|[^,\r\n]*)(?=,|\r?\n|$)
    $csv_regex = "/(?:{$quote_reg}(?:[^{$quote_reg}]|{$quote_reg}{$quote_reg})*{$quote_reg}|[^{$delimiter_reg}\\r\\n]*)(?={$delimiter_reg}|\r?\n|$)/";
    
    echo "<table border=\"1\">\n";

    while(($line = fgets($file_handle))!==false){
        //take the line and split into fields
        $matches = [];
        $test = preg_match_all($csv_regex, $line, $matches);
        /*if($test === false){
            echo "regex fail";
            break;
        }
        if($test === 0){
            continue;
        }*/
        //make a cell list for all matches
        $cells = $matches[0];


        $rows = array();
        for($i = 0; $i < count($cells); $i++){
            $temp = $cells[$i];
            //appends temp string into rows
            $rows[] = $temp;
        }

        echo "<tr>\n";
        //for all
        if($columns_to_show == "ALL"){
            //add cells for each in the row
            for($j = 0; $j < count($rows); $j++){
                //cell = row at j column
                echo "<td>". htmlspecialchars($rows[$j]) ."</td>\n";
            }
        }
        //for specific columns
        else{
            for($k = 0; $k < count($columns); $k++){
                //k_column is column number we want from curr row
                //takes value if both is not negative and if witin row
                $k_column = $columns[$k];
                if ($k_column >= 0 && $k_column < count($rows)) {
                    $value = $rows[$k_column];
                } else {
                    $value = "";
                }
                echo "<td>" . htmlspecialchars($value) . "</td>\n";
            }
        }
        ///end row
        echo "</tr>\n";
    }
    echo "</table>\n";
    fclose($file_handle);

}



# example calls

#proc_csv("test.csv",",","\"", "1:3:4:7");

# proc_csv("test.csv",",","\"", "ALL");

# output would be formatted HTML code (table), that will be embedded where the above call is made in the PHP file.

?>