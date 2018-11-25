<?php

error_reporting(~E_ALL & ~E_NOTICE);

include '../dbconnection.php';

//Set autocommit to false
mysqli_autocommit($con,false);

//initialize variables
$user_id = $_REQUEST['user_id'];
$debt_identifier = $_REQUEST['debt_identifier'];
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

//Ensure ALL values are Complete

//all the input field names are now in $fields and corresponding values are in $values
//loop through all the input vairables and every time 'nick name' begins, capture all details of the loan and issue SQL
for ($i=0; $i < count($fields); $i++) {

  //Reset variables sent to database
  $sql_str = "";
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

    update_credit_card($user_id, $debt_identifier, $nickname, $interest_rate, $remaining_balance, $credit_card_minimum_payment);
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

    update_student_loan($user_id, $debt_identifier, $nickname, $remaining_balance, $interest_rate, $remaining_term);
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

    update_payday_loan($user_id, $debt_identifier, $nickname, $remaining_balance, $interest_rate, $remaining_term);
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

    update_loan($user_id, $debt_identifier, $nickname, $remaining_balance, $interest_rate, $remaining_term);
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

    update_legal_obligation($user_id, $debt_identifier, $nickname, $remaining_balance, $remaining_term);
  }

}

function myException($exception) {
  echo $exception->getMessage();
}

set_exception_handler('myException');

//Credit card
function update_credit_card($user_id,
                            $debt_identifier,
                            $credit_card_nickname,
                            $credit_card_apr,
                            $credit_card_balance,
                            $credit_card_minimum_payment) {

    global $con;

    //Insert into  database table
      $sql_update = "UPDATE yadayada.debt_user_input
                        SET nick_name = '$credit_card_nickname',
                            debt_identifier = '$credit_card_nickname',
                            interest_rate = $credit_card_apr,
                            remaining_balance = $credit_card_balance,
                            minimum_payment = $credit_card_minimum_payment,
                            update_timestamp = now()
                      WHERE user_id = '$user_id'
                        AND debt_identifier = '$debt_identifier'";

      //Issue UPDATE to database table
      if($con->query($sql_update) == TRUE){
        //echo "update successful";
      }
      else {
        //echo "update failed: " . $con->error;
      }

    }

    //Student loan
    function update_student_loan($user_id,
                                 $debt_identifier,
                                 $student_loan_nickname,
                                 $student_loan_remaining_balance,
                                 $student_loan_interest_rate,
                                 $student_loan_remain_term) {

       global $con;

       //Insert into  database table
         $sql_update = "UPDATE yadayada.debt_user_input
                           SET debt_identifier = '$student_loan_nickname',
                               nick_name = '$student_loan_nickname',
                               interest_rate = '$student_loan_interest_rate',
                               remaining_balance = '$student_loan_remaining_balance',
                               remaining_term = '$student_loan_remain_term',
                               update_timestamp = now()
                         WHERE user_id = '$user_id'
                           AND debt_identifier = '$debt_identifier'";

         //Issue UPDATE to database table
         if($con->query($sql_update) == TRUE){
           //echo "update successful";
         }
         else {
           //echo "update failed: " . $con->error;
         }

       }

       //Payday loan

       function update_payday_loan($user_id,
                                   $debt_identifier,
                                   $payday_loan_nickname,
                                   $payday_loan_remaining_balance,
                                   $payday_loan_interest_rate,
                                   $payday_loan_remain_term) {

          global $con;

          //Insert into  database table
            $sql_update = "UPDATE yadayada.debt_user_input
                              SET debt_identifier = '$payday_loan_nickname',
                                  nick_name = '$payday_loan_nickname',
                                  interest_rate = '$payday_loan_interest_rate',
                                  remaining_balance = '$payday_loan_remaining_balance',
                                  remaining_term = '$payday_loan_remain_term',
                                  update_timestamp = now()
                            WHERE user_id = '$user_id'
                              AND debt_identifier = '$debt_identifier'";

            //Issue UPDATE to database table
            if($con->query($sql_update) == TRUE){
              //echo "update successful";
            }
            else {
              //echo "update failed: " . $con->error;
            }

          }

          //Loan
          function update_loan($user_id,
                               $debt_identifier,
                               $loan_nickname,
                               $loan_remaining_balance,
                               $loan_interest_rate,
                               $loan_remain_term) {

              global $con;

               //Insert into  database table
               $sql_update = "UPDATE yadayada.debt_user_input
                                 SET debt_identifier = '$loan_nickname',
                                     nick_name = '$loan_nickname',
                                     interest_rate = '$loan_interest_rate',
                                     remaining_balance = '$loan_remaining_balance',
                                     remaining_term = '$loan_remain_term',
                                     update_timestamp = now()
                               WHERE user_id = '$user_id'
                                AND debt_identifier = '$debt_identifier'";

               //Issue UPDATE to database table
               if($con->query($sql_update) == TRUE){
                 //echo "update successful";
               }
               else {
                 //echo "update failed: " . $con->error;
               }

             }

             //Legal Obligation
            function update_legal_obligation($user_id,
                                             $debt_identifier,
                                             $legal_obligation_nickname,
                                             $legal_obligation_loan_amount,
                                             $legal_obligation_remain_term) {

                  global $con;

                  //Insert into  database table
                  $sql_update = "UPDATE yadayada.debt_user_input
                                    SET debt_identifier = '$legal_obligation_nickname',
                                        nick_name = '$legal_obligation_nickname',
                                        remaining_balance = '$legal_obligation_loan_amount',
                                        remaining_term = '$legal_obligation_remain_term',
                                        update_timestamp = now()
                                  WHERE user_id = '$user_id'
                                    AND debt_identifier = '$debt_identifier'";

                  //Issue UPDATE to database table
                  if($con->query($sql_update) == TRUE){
                    //echo "update successful";
                  }
                  else {
                    //echo "update failed: " . $con->error;
                  }

                }

  mysqli_commit($con);
  $con->close();

?>
