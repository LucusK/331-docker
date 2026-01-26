<?php

# function definition: use the exact interface in your code.

function proc_csv ($filename, $delimiter, $quote, $columns_to_show) {

    # function body
    //need to open file
    $file_handle = fopen($filename,"r");
    if(!$file_handle){
        echo "cannot open csv file";
        return;
    }

    if($columns_to_show != "ALL"){
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

    fclose($file_handle);

    

}



# example calls

#proc_csv("test.csv",",","\"", "1:3:4:7");

# proc_csv("test.csv",",","\"", "ALL");

# output would be formatted HTML code (table), that will be embedded where the above call is made in the PHP file.

?>