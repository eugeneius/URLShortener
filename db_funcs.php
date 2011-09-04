<?php

/*
 * Connect to the db
 */
function connect($url, $name, $user, $pass) {
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
 * Create the table
 */
function createTable() {
  mysql_query("CREATE TABLE dictionary(id INT NOT NULL AUTO_INCREMENT, url VARCHAR(255), redirects INT, PRIMARY KEY(id), KEY(url, id))");
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
    mysql_query("INSERT INTO dictionary(url,redirects) VALUES('".$url."',0) ") or die(mysql_error());

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
  mysql_query("UPDATE dictionary SET redirects=redirects+1 WHERE id='".$id."'") or die(mysql_error());
  $return = mysql_query("SELECT url FROM dictionary WHERE id='".$id."'") or die(mysql_error());
  $return = mysql_fetch_array($return);
  return $return['url'];
}

/*
 * Print the table 
 */
function printTable() {
  $return = mysql_query("SELECT * FROM dictionary") or die(mysql_error());
  $fieldCount = mysql_num_fields($return);

  echo "<h1>dictionary</h1>\n";
  echo "<table border='1'>\n  <tr>\n";
  for ($i=0; $i < $fieldCount; $i++) {
    $field = mysql_fetch_field($return);
    echo "    <td>{$field->name}</td>\n";
  }
  echo "  </tr>\n";
  
  while ($row = mysql_fetch_row($return)) {
    echo "  <tr>\n";
    foreach($row as $cell)
      echo "    <td>$cell</td>\n";
    echo "  </tr>\n";
  }
  echo "</table>";
}

/*
 * Press in case of emergency
 */
function clearTable() {
  mysql_query("TRUNCATE TABLE dictionary") or die(mysql_error());
}

/*
 * Even bigger red button
 */
function dropTable() {
  mysql_query("DROP TABLE dictionary") or die(mysql_error());
}

?>