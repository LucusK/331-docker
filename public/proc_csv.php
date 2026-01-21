<?php

# function definition: use the exact interface in your code.

function proc_csv ($filename, $delimiter, $quote, $columns_to_show) {

... # function body

}

...

# example calls

proc_csv("test.csv",",","\"", "1:3:4:7");

proc_csv("test.csv",",","\"", "ALL");

# output would be formatted HTML code (table), that will be embedded where the above call is made in the PHP file.

?>