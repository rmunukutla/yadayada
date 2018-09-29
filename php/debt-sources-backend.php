<?php

//initialize variables
$input_str = "";
$inputs = array();
$tokens = array();
$fields = array();
$values = array();
$output = "";
$i = 0;

//dataString to $_POST comes as one big string with each input separted by ';' and field and value separated by ':'
foreach ($_POST as $key => $value) {
  $inputs = explode(";", $key);
}

for ($i=0; $i < count($inputs); $i++) {
  $tokens = explode(":", $inputs[$i]);
  if(!empty($tokens[1])) {
    $fields[]=$tokens[0];
    $values[]=$tokens[1];
  }
}

//all the input field names are now in $fields and corresponding values are in $values
for ($i=0; $i < count($fields); $i++) {

  if (strpos($fields[$i], "Creadit-Card-Nickname") !== false) {

  }

  elseif (strpos($fields[$i], "Student-Loan-Nickname") !== false) {


  }


  elseif (strpos($fields[$i], "Payday-Loan-Nickname") !== false) {


  }

  elseif (strpos($fields[$i], "Loan-Nickname") !== false) {


  }

  elseif (strpos($fields[$i], "Legal-Obligation-Nickname") !== false) {


  }


}
echo "Complete";

?>
