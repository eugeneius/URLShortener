<?php

/*
 * Connect to the db
 */
function connect($url, $name, $user, $pass) {
  //Connect to the DB
  mysql_connect($url, $user, $pass) or die(mysql_error());
  mysql_select_db($name) or die(mysql_error());
}

/*
 * Close DB connection
 */
function disconnect() {
  mysql_close();
}

/*
 * Create the tables
 */
function createTables() {
  //Create the table
  mysql_query("CREATE TABLE dictionary(id INT NOT NULL AUTO_INCREMENT, url VARCHAR(256), PRIMARY KEY(id), KEY(url, id))");
}

/*
 * Try to add a url to the db, returning the id for the url
 */
function insertURL($url) {
  //Check if the url exists
  $alreadyExists = mysql_query("SELECT id FROM dictionary WHERE url='".$url."'") or die(mysql_error());
  $row = mysql_fetch_array($alreadyExists);
  $id = $row['id'];

  //If it doesn't, add it
  if (!isset($id)) {
    //Add to the dictionary
    mysql_query("INSERT INTO dictionary(url) VALUES('".$url."') ") or die(mysql_error());

    //Get the new id
    $return = mysql_query("SELECT id FROM dictionary ORDER BY id DESC LIMIT 1");
    $return = mysql_fetch_array($return);
    $id = $return['id'];
  }

  //Return the id for encoding
  return $id;
}

/*
 * Retrieve the url using the id
 */
function retrieveURL($id) {
  $return = mysql_query("SELECT url FROM dictionary WHERE id='".$id."'") or die(mysql_error());
  $return = mysql_fetch_array($return);
  return $return['url'];
}

/*
 * Press in case of emergency
 */
function clearTables() {
  mysql_query("TRUNCATE TABLE dictionary") or die(mysql_error());
}

?>