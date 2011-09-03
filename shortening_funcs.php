<?php

$alphabet = array('q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 
                  'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M', 
                  '2', '3', '4', '5', '6', '7', '8', '9');

/*
 * Encode an id (integer) into a url code
 */
function encode($id, $alphabet) {
  $code = "";
  $base = count($alphabet);
  while ($id != 0) {
    $char = $alphabet[$id % $base];
    $code = $char . $code;
    $id = (int)($id/$base);
  }
  return $code;
}

/*
 * Decode a url code into ann id (integer)
 */
function decode($code, $alphabet) {
  $id = 0;
  $len = strlen($code);
  $base = count($alphabet);
  for ($i = 0; $i < $len; $i++) {
    $id += pow($base, $i)*array_search($code{$len-1-$i}, $alphabet);
  }
  return $id;
}

?>