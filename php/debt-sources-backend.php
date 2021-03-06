<?php

error_reporting(~E_ALL & ~E_NOTICE);

include '../dbconnection.php';

//Set autocommit to false
mysqli_autocommit($con,false);

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
    $values[]=str_replace("_",".",$tokens[1]);
  }
  else if ($i == 0){
    echo "All fields are mandatory. Please do not leave any field blank.";
    throw new Exception('All fields are mandatory. Please do not leave any field blank.');
  }
}

//echo print_r($values);
//Ensure ALL values are Complete

//all the input field names are now in $fields and corresponding values are in $values
//loop through all the input vairables and every time 'nick name' begins, capture all details of the loan and issue SQL
for ($i=0; $i < count($fields); $i++) {

  //Reset variables sent to database
  $sql_str = "";
  $user_id = $_REQUEST['user_id'];
  $nickname = "";
  $remaining_balance = 0.0;
  $interest_rate = 0.0;
  $remaining_term = "";
  $loan_type = "";
  $credit_card_minimum_payment = 0.0;

  if (strpos($fields[$i], "Credit-Card-Nickname") !== false) {

    $loan_type = "credit card";

    if (empty($values[$i]) or empty($values[$i+1]) or empty($values[$i+2]) or empty($values[$i+3])) {
      //$response_array['status'] = 'error';
      //$response_array['exception'] = 'All fields are mandatory. Please do not leave any field blank.';
      echo "All fields are mandatory. Please do not leave any field blank.";
      throw new Exception('All fields are mandatory. Please do not leave any field blank.');
    }

    $nickname = $values[$i++];
    $remaining_balance = $values[$i++];
    $credit_card_minimum_payment = $values[$i++];
    $interest_rate = $values[$i];

    insert_credit_card($user_id, $nickname, $interest_rate, $remaining_balance, $credit_card_minimum_payment);
  }

  elseif (strpos($fields[$i], "Student-Loan-Nickname") !== false) {
    $loan_type = "student loan";

    if (empty($values[$i]) or empty($values[$i+1]) or empty($values[$i+2]) or empty($values[$i+3])) {
      //$response_array['status'] = 'error';
      //$response_array['exception'] = 'All fields are mandatory. Please do not leave any field blank.';
      echo "All fields are mandatory. Please do not leave any field blank.";
      throw new Exception('All fields are mandatory. Please do not leave any field blank.');
    }

    $nickname = $values[$i++];
    $remaining_balance = $values[$i++];
    $interest_rate = $values[$i++];
    $remaining_term[0] = strtok($values[$i]," ");

    insert_student_loan($user_id, $nickname, $remaining_balance, $interest_rate, $remaining_term);
  }

  elseif (strpos($fields[$i], "Payday-Loan-Nickname") !== false) {
    $loan_type = "payday loan";

    if (empty($values[$i]) or empty($values[$i+1]) or empty($values[$i+2]) or empty($values[$i+3])) {
      //$response_array['status'] = 'error';
      //$response_array['exception'] = 'All fields are mandatory. Please do not leave any field blank.';
      echo "All fields are mandatory. Please do not leave any field blank.";
      throw new Exception('All fields are mandatory. Please do not leave any field blank.');
    }

    $nickname = $values[$i++];
    $remaining_balance = $values[$i++];
    $interest_rate = $values[$i++];
    $remaining_term[0] = strtok($values[$i]," ");

    insert_payday_loan($user_id, $nickname,$remaining_balance,$interest_rate, $remaining_term);
  }

  elseif (strpos($fields[$i], "Loan-Nickname") !== false) {
    $loan_type = "loan";

    if (empty($values[$i]) or empty($values[$i+1]) or empty($values[$i+2]) or empty($values[$i+3])) {
      //$response_array['status'] = 'error';
      //$response_array['exception'] = 'All fields are mandatory. Please do not leave any field blank.';
      echo "All fields are mandatory. Please do not leave any field blank.";
      throw new Exception('All fields are mandatory. Please do not leave any field blank.');
    }
    $nickname = $values[$i++];
    $remaining_balance = $values[$i++];
    $interest_rate = $values[$i++];
    $remaining_term[0] = strtok($values[$i]," ");

    insert_loan($user_id, $nickname,$remaining_balance,$interest_rate, $remaining_term);
  }

  elseif (strpos($fields[$i], "Legal-Obligation-Nickname") !== false) {
    $loan_type = "legal obligation";

    if (empty($values[$i]) or empty($values[$i+1]) or empty($values[$i+2])) {
      //$response_array['status'] = 'error';
      //$response_array['exception'] = 'All fields are mandatory. Please do not leave any field blank.';
      echo "All fields are mandatory. Please do not leave any field blank.";
      throw new Exception('All fields are mandatory. Please do not leave any field blank.');
    }

    $nickname = $values[$i++];
    $remaining_balance = $values[$i++];
    $remaining_term[0] = strtok($values[$i]," ");

    insert_legal_obligation($user_id, $nickname,$remaining_balance,$remaining_term);
  }

}

function myException($exception) {
  echo $exception->getMessage();
}

set_exception_handler('myException');

//Credit card
function insert_credit_card($user_id,
                            $credit_card_nickname,
                            $credit_card_apr,
                            $credit_card_balance,
                            $credit_card_minimum_payment) {

    global $con;

    //Insert into  database table
      $sql_insert = "INSERT INTO yadayada.debt_user_input
                                (user_id,
                                 debt_identifier,
                                 nick_name,
                                 debt_type,
                                 original_balance,
                                 original_term,
                                 interest_type,
                                 interest_rate,
                                 remaining_balance,
                                 remaining_term,
                                 minimum_payment,
                                 create_timestamp,
                                 update_timestamp)
                         VALUES ('$user_id',
                                 '$credit_card_nickname',
                                 '$credit_card_nickname',
                                 'Credit Card',
                                 NULL,
                                 NULL,
                                 'APR',
                                 $credit_card_apr,
                                 $credit_card_balance,
                                 NULL,
                                 $credit_card_minimum_payment,
                                 now(),
                                 now())";

                                 //echo $sql_insert;

      //Issue INSERT to database table
      if($con->query($sql_insert) == TRUE){
        //echo "insert successful";
      }
      else {
        //echo "insert failed: " . $con->error;
      }

    }

    //Student loan
    function insert_student_loan($user_id,
                                 $student_loan_nickname,
                                 $student_loan_remaining_balance,
                                 $student_loan_interest_rate,
                                 $student_loan_remain_term) {

       global $con;

       //Insert into  database table
         $sql_insert = "INSERT INTO yadayada.debt_user_input
                                   (user_id,
                                    debt_identifier,
                                    nick_name,
                                    debt_type,
                                    original_balance,
                                    original_term,
                                    interest_type,
                                    interest_rate,
                                    remaining_balance,
                                    remaining_term,
                                    minimum_payment,
                                    create_timestamp,
                                    update_timestamp)
                            VALUES ('$user_id',
                                    '$student_loan_nickname',
                                    '$student_loan_nickname',
                                    'Student Loan',
                                    NULL,
                                    NULL,
                                    'APR',
                                    '$student_loan_interest_rate',
                                    '$student_loan_remaining_balance',
                                    '$student_loan_remain_term',
                                    NULL,
                                    now(),
                                    now())";

         //Issue INSERT to database table
         if($con->query($sql_insert) == TRUE){
           //echo "insert successful";
         }
         else {
           //echo "insert failed: " . $con->error . " sql: " . $sql_insert;
         }

       }

       //Payday loan

       function insert_payday_loan($user_id,
                                   $payday_loan_nickname,
                                   $payday_loan_remaining_balance,
                                   $payday_loan_interest_rate,
                                   $payday_loan_remain_term) {

          global $con;

          //Insert into  database table
            $sql_insert = "INSERT INTO yadayada.debt_user_input
                                      (user_id,
                                       debt_identifier,
                                       nick_name,
                                       debt_type,
                                       original_balance,
                                       original_term,
                                       interest_type,
                                       interest_rate,
                                       remaining_balance,
                                       remaining_term,
                                       minimum_payment,
                                       create_timestamp,
                                       update_timestamp)
                               VALUES ('$user_id',
                                       '$payday_loan_nickname',
                                       '$payday_loan_nickname',
                                       'Payday Loan',
                                       NULL,
                                       NULL,
                                       'APR',
                                       '$payday_loan_interest_rate',
                                       '$payday_loan_remaining_balance',
                                       '$payday_loan_remain_term',
                                       NULL,
                                       now(),
                                       now())";

            //Issue INSERT to database table
            if($con->query($sql_insert) == TRUE){
              //echo "insert successful";
            }
            else {
              echo "insert failed: " . $con->error . " sql: " . $sql_insert;            }

          }

          //Loan
          function insert_loan($user_id,
                               $loan_nickname,
                               $loan_remaining_balance,
                               $loan_interest_rate,
                               $loan_remain_term) {

              global $con;

               //Insert into  database table
               $sql_insert = "INSERT INTO yadayada.debt_user_input
                                         (user_id,
                                          debt_identifier,
                                          nick_name,
                                          debt_type,
                                          original_balance,
                                          original_term,
                                          interest_type,
                                          interest_rate,
                                          remaining_balance,
                                          remaining_term,
                                          minimum_payment,
                                          create_timestamp,
                                          update_timestamp)
                                  VALUES ('$user_id',
                                          '$loan_nickname',
                                          '$loan_nickname',
                                          'Loan',
                                          NULL,
                                          NULL,
                                          'APR',
                                          '$loan_interest_rate',
                                          '$loan_remaining_balance',
                                          '$loan_remain_term',
                                          NULL,
                                          now(),
                                          now())";

               //Issue INSERT to database table
               if($con->query($sql_insert) == TRUE){
                 //echo "insert successful";
               }
               else {
                 //echo "insert failed: " . $con->error;
               }

             }

             //Legal Obligation
            function insert_legal_obligation($user_id,
                                             $legal_obligation_nickname,
                                             $legal_obligation_loan_amount,
                                             $legal_obligation_remain_term) {

                  global $con;

                  //Insert into  database table
                  $sql_insert = "INSERT INTO yadayada.debt_user_input
                                            (user_id,
                                             debt_identifier,
                                             nick_name,
                                             debt_type,
                                             original_balance,
                                             original_term,
                                             interest_type,
                                             interest_rate,
                                             remaining_balance,
                                             remaining_term,
                                             minimum_payment,
                                             create_timestamp,
                                             update_timestamp)
                                     VALUES ('$user_id',
                                             '$legal_obligation_nickname',
                                             '$legal_obligation_nickname',
                                             'Legal Obligation',
                                             NULL,
                                             NULL,
                                             'APR',
                                             NULL,
                                             '$legal_obligation_loan_amount',
                                             '$legal_obligation_remain_term',
                                             NULL,
                                             now(),
                                             now())";

                  //Issue INSERT to database table
                  if($con->query($sql_insert) == TRUE){
                    //echo "insert successful";
                  }
                  else {
                    //echo "insert failed: " . $con->error;
                  }

                }

  mysqli_commit($con);
  $con->close();

?>
