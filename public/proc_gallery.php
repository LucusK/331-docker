<?php
# function definition: use the exact interface in your code.

function proc_gallery($image_list_filename, $mode, $sort_mode) {
    $csv_fs_path = __DIR__ . "/data/" . $image_list_filename;
    $img_url_base = "/data/";
    $img_fs_base  = __DIR__ . "/data/";

    #read file
    $file_array = file($csv_fs_path);
    if ($file_array === false) {
        echo "CSV not found: " . htmlspecialchars($csv_fs_path);
    return;
}
    $image_list = [];

    #use regex to find the filename and description text string
    for($i = 0; $i < count($file_array); $i ++){
        $row = trim($file_array[$i]);
        #regex matches not " then any char thats not " then separated by comma then that again
        if(preg_match('/^"([^"]*)","([^"]*)"$/',$row,$matches)){
            #matches has two entries: filename, description
            $filename = $matches[1];
            $description = $matches[2];
            $file_path = $img_fs_base . $filename; #disk
            $src = $img_url_base . $filename; #web source
            #uses php.net to find filesize and filemtime. idk whether i should use access time or modification time

            #php.net about arrays shows associative key-value structure
            $image_list[] = [
                "filename" => $filename,
                "description" => $description,
                "size" => filesize($file_path),
                "modtime" => filemtime($file_path),
                "src" => $src
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
        });
    }
    if($sort_mode == "date_oldest"){
        usort($image_list, function($a,$b){
            return ($a["modtime"] <=> $b["modtime"]);
        });
    }
    if($sort_mode == "size_largest"){
        usort($image_list, function($a,$b){
            return ($b["size"] <=> $a["size"]);
        });
    }
    if($sort_mode == "size_smallest"){
        usort($image_list, function($a,$b){
            return ($a["size"] <=> $b["size"]);
        });
    }
    if($sort_mode == "rand"){
        shuffle($image_list);
    }
    # $mode == "list"	   : list of large images view
   # $mode == "matrix"	   : image matrix view (3 columns)
   # $mode == "details"	   : file details view (text)
    #modes
    
    #list
    if($mode == "list"){
        for($i = 0; $i<count($image_list); $i ++){
            #use div wrapper to divide images so can write descriptions
            echo "<div style='margin-bottom:10px;'>";
            echo "<img src='{$image_list[$i]['src']}' width='400'><br>";
            echo "<p>{$image_list[$i]['description']}</p>";
            echo "</div>";
        }
    }
    #matrix, 3 columns
    if($mode == "matrix"){
        #use table to format images
        echo "<table>";
        for($i = 0; $i < count($image_list); $i++){
            #for each new row use <tr>
            if ($i % 3 == 0) {
                echo "<tr>";
            }
            echo "<td style='padding:10px; text-align:center'>";
            echo "<img src='{$image_list[$i]['src']}' width='200'><br>";
            echo "{$image_list[$i]['description']}";
            echo "</td>";
            if ($i % 3 == 2) {
                echo "</tr>";
            }
        }
        echo "</table>";
    }
    #details using table again
    if ($mode == "details") {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr>
                <th>Filename</th>
                <th>Description</th>
                <th>Size (bytes)</th>
                <th>Last Modified</th>
              </tr>";

        for ($i = 0; $i < count($image_list); $i++) {
            echo "<tr>";
            echo "<td>{$image_list[$i]['src']}</td>";
            echo "<td>{$image_list[$i]['description']}</td>";
            echo "<td>{$image_list[$i]['size']}</td>";
            echo "<td>" . date("Y-m-d H:i:s", $image_list[$i]['modtime']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
}

# example calls

#proc_gallery("my_favorites.csv", "matrix", "date_newest")

#proc_gallery("my_projects.csv", "list", "size_largest")

# my_favorites.csv etc. will be a properly formatted CSV file that has the two following columns:
#     "filename.jpg","description text string" 
?>