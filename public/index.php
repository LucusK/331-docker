

<html>

<!-- HEAD section ............................................................................ -->
<head>
  <title> Lucus Kim's Experimental Web Site </title>


  <!-- javascript functions -->
  <script>
  function randText() {
      let randomBits = ["hello world", "random thoughts", "pinky and the brain"];
      document.getElementById("demo").innerHTML = randomBits[Math.floor(Math.random()*3)];
  }
  </script>

  <!-- style -->
 
  <!--
  <style>
    div.defaultFont {
        font-family: Helvetica, Arial, sans-serif;
    }
    
    div.secondaryFont {
        font-family: serif;
    }

    h3 {
        color: blue;
    }
    <link href="default.css" rel="stylesheet" type="text/css>
  </style> -->

  <LINK REL=StyleSheet HREF="simple.css" TYPE="text/css" MEDIA=screen>
  

</head>

<!-- BODY section ............................................................................. -->
<body>
<div class="defaultFont">

<!-- PHP testing area ................................ --> 
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

   require "./proc_csv.php";
   require "./proc_Markdown.php";
   require "./search.php";


   echo "<h1> Lucus's Experimental CSCE 331 Docker Web Site </h1>\n";

   echo "<font color=\"green\"> Haha update and redeploy </font><p/>\n";
   echo " Testing PHP <br>\n";
   echo " Hello world!<p/>\n";



   echo "<h3>Testing file loading:</h3>\n";
   //proc_csv("test.csv",",","\"","ALL");
   //echo "\n\n\n";
   proc_csv("../data/dat-doublequote-comma.csv",",","\"","1:3");
   proc_csv("../data/dat-doublequote-tab.csv","\t","\"","ALL");
   proc_csv("../data/dat2-doublequote-comma.csv",",","\"","ALL");
   proc_csv("../data/dat2-doublequote-tab.csv","\t","\"","ALL");
   proc_csv("../data/dat2-singlequote-tab.csv","\t","'","ALL");

   proc_markdown("../data/markdown.md");
   
   echo "before search<br>";
   search("Hello");
   echo "after search<br>";

   /*
   # FILE access 
   # $h = fopen("false.dat","r");

   $handle = fopen("data.dat","r") or die("Cannot open data.dat");

   echo "<table  border=\"1\">\n";

   while ($data = fgets($handle)) {
        echo "<tr>\n";
        $data_cols = preg_split('/,/',$data);
        for ($k=0; $k<count($data_cols); ++$k) {
            echo "  <td> ".$data_cols[$k]." </td>\n";
        }
        echo "</tr>\n";
   }

   fclose($handle);

   echo "</table>\n<p/>";
   

   echo "Debug: ";
   print_r($data_cols); 

   echo "<p/>";

   echo "rand : ".$data_cols[rand(0,1)]."\n";

   echo "<p/>";
   */

?>


<!-- Java script testing area ............................... -->

<div class="secondaryFont"> 

<h3>Java script test</h3>

<p id="demo"> Content to be changed: </p> 

<button type="button" onclick="randText()">Click Me!</button>

<button onClick="window.location.reload();">Reload Page</button>

<p>For more javascript examples, see <a href="jstest.php">jstest.php</a>.</p>

</div>

<!-- Fetch testing............................... -->
<div class="SecondaryFont">
<h3> Fetch html source code </h3>
<a href="fetch.php">fetch.php</a>
</div>

<!-- HTML form input handling .......................... -->

<h3>HTML Form input test</h3>
<p/>
<form action="action.php" method="post">
Search: <input type="text" name="name"> 
<input type="submit">
</form>
<p/>

<h3>HTML Form input test 2 </h3>

Search academic genealogy (external link: <a href="https://www.mathgenealogy.org">https://www.mathgenealogy.org</a>): <p/>
<form action="https://www.mathgenealogy.org/query-prep.php" method="post">
Firstname:
<input type="text" name="given_name" value="Yoonsuck">  <br/>
Lastname:
<input type="text" name="family_name" value="Choe"> 
<input type="submit">
</form>
<p/>
</div> <!-- end of big div -->

<?php echo "Container IP Address:".getenv('MY_IP')."\n"; ?>
</body>

</html>

