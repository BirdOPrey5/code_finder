<html>
<head>
<title>Bad Code Finder by BOP5 v 1.1</title>
</head>
<body>
<strong>Bad Code Tester</strong><br>
<br>
<form action="<?php echo basename(__FILE__); ?>">
  <input type="text" size="40" autofocus="autofocus" name="findthis">
  <input type="submit" value="Submit">
</form>
<br>
<br>
<hr>
<br>
<br>
</body>




<?php
//Choose max PHP memory limit that works....
//ini_set('memory_limit','1024M');
ini_set('memory_limit','512M');
//ini_set('memory_limit','256M');
//ini_set('memory_limit','128M');

set_time_limit(0); 

//Bad Code Finder by Joe / BOP5, Code snippets from Stack Overflow and php.net.


class IgnorantRecursiveDirectoryIterator extends RecursiveDirectoryIterator { 
    function getChildren() { 
        try { 
            return new IgnorantRecursiveDirectoryIterator($this->getPathname()); 
        } catch(UnexpectedValueException $e) { 
            echo "<span style='color:red;'>Can't read directory (No Permission?): " . $this->getPathname() . "</span><br>";
            return new RecursiveArrayIterator(array()); 
        } 
    } 
} 




if (!$_REQUEST['findthis'])
{
  die ("<br>No search.");
}


$string = $_REQUEST['findthis'];
$nocode = 1;


$dir = new IgnorantRecursiveDirectoryIterator(getcwd());
$Iterator = new RecursiveIteratorIterator($dir);
foreach ($Iterator as $file) 
    { 
      if (endswith($file, '.php'))
      {
      $content = file_get_contents($file->getPathname());
      if (strpos($content, $string) !== false) {
        echo "Bad Code: " . $file->getPathname() . "<br>";
        $nocode = 0;
     }
   }
    unset($content);
}


/**********
$dir = getcwd();
foreach (glob("$dir/*.php") as $file) {
    $content = file_get_contents("$file");
    if (strpos($content, $string) !== false) {
        echo "Bad Code: " . $file . "<br>";
        $nocode = 0;
    }
}
**********/


if ($nocode == 1)
echo "No bad code found.";




//Functions

function endswith($string, $test) {
    $strlen = strlen($string);
    $testlen = strlen($test);
    if ($testlen > $strlen) return false;
    return substr_compare($string, $test, $strlen - $testlen, $testlen) === 0;
}