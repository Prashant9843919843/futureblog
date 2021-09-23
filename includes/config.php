<?php 
ob_start();
session_start();

//database details
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','futureblog');

$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



date_default_timezone_set('UTC');

//load classes as needed
function __autoload($class) {
   
   $class = strtolower($class);

    //if call from within assets adjust the path
   $classpath = 'classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
    }   
    
    //if call from within admin adjust the path
   $classpath = '../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
    }
    
    //if call from within admin adjust the path
   $classpath = '../../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
    }       
     
}

$user = new User($db); 
include("functions.php"); 

//comment

?>