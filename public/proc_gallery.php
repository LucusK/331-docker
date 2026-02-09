<?php
# function definition: use the exact interface in your code.

function proc_gallery($image_list_filename, $mode, $sort_mode) {

    #read file
    $file_array = file($image_list_filename);
    $image_array = [];

    #use regex to find the filename and description text string
    for($i = 0; $i < count($file_array); $i ++){
        $row = trim($file_array[$i]);
        #regex matches not " then any char thats not " then separated by comma then that again
        if(preg_match('/^"([^"]*)","([^"]*)"/'),$row,$matches){
            #matches has two entries: filename, description
            $filename = $matches[0];
            $description = $matches[1];
            #uses php.net to find filesize and filemtime. idk whether i should use access time or modification time
            $size = filesize($filename);
            $modtime = filemtime($filename);
            #php.net about arrays shows associative key-value structure
            $image_list[] = [
                "filename" => $filename,
                "description" => $description,
                "size" => $size,
                "modtime" => $modtime
            ];

        }
    }
    # $sort_mode == "orig"  : original ordering in the CSV file
   # $sort_mode == "date_newest"  : newest images first
   # $sort_mode == "date_oldest"  : oldest images first
   # $sort_mode == "size_largest" : largest file size first
   # $sort_mode == "size_smallest": smallest file size first
   # $sort_mode == "rand"  : random ordering
    #sorting files using php.net usort and lambda functions
    #usort: neg if a before b. <=> spaceship operator means (a < b)? -1 : 1
    if($sort_mode == "date_newest"){
        usort($image_list, function($a,$b){
            return ($b["modtime"] <=> $a["modtime"]);
        })
    }
    if($sort_mode == "date_oldest"){
        usort($image_list, function($a,$b){
            return ($a["modtime"] <=> $b["modtime"]);
        })
    }
    if($sort_mode == "size_largest"){
        usort($image_list, function($a,$b){
            return ($b["size"] <=> $a["size"]);
        })
    }
    if($sort_mode == "size_newest"){
        usort($image_list, function($a,$b){
            return ($a["size"] <=> $b["size"]);
        })
    }
    if($sort_mode == "rand"){
        shuffle($image_list);
    }
    # $mode == "list"	   : list of large images view
   # $mode == "matrix"	   : image matrix view (3 columns)
   # $mode == "details"	   : file details view (text)
    #modes
    
}

# example calls

#proc_gallery("my_favorites.csv", "matrix", "date_newest")

#proc_gallery("my_projects.csv", "list", "size_largest")

# my_favorites.csv etc. will be a properly formatted CSV file that has the two following columns:
#     "filename.jpg","description text string" 
?>