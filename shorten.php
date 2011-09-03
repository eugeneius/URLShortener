<?php 

require('db_funcs.php');
require('shortening_funcs.php');

/* Base url - end with a forward slash */
$BASEURL = "";

/* Database vars */
$DBURL  = "";
$DBNAME = "";
$DBUSER = "";
$DBPASS = "";

//Do we encode?
if (isset($_GET["e"])) {
  connect($DBURL, $DBNAME, $DBUSER, $DBPASS);
  $id = insertURL($_GET["e"]);
  echo "$BASEURL" . encode($id, $alphabet);
  disconnect();
}
//Or decode?
else if (isset($_GET["d"])) {
  connect($DBURL, $DBNAME, $DBUSER, $DBPASS);
  $id = decode($_GET["d"], $alphabet);
  $forwardingAddress = retrieveURL($id);
  if (!isset($forwardingAddress))
    $forwardingAddress = "http://www.google.com";
  disconnect();
}
//Else redirect somewhere
else {
  $forwardingAddress = "http://www.google.com";
}

//Forward if no encoding
if (isset($forwardingAddress)) {
  header("HTTP/1.1 301 Moved Permanently");
  header("Location: $forwardingAddress");
}

?>