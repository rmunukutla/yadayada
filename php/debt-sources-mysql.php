<?php

  include '../dbconnection.php';

  //Credit card
  function insert_credit_card($user_id,
                              $credit_card_nickname,
                              $credit_card_apr,
                              $credit_card_balance,
                              $credit_card_minimum_payment) {

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
                                   VALUES(NULL),
                                   '$credit_card_nickname',
                                   'Credit Card',
                                   VALUES(NULL),
                                   VALUES(NULL),
                                   'APR',
                                   '$credit_card_apr',
                                   '$credit_card_balance',
                                   VALUES(NULL),
                                   '$credit_card_minimum_payment',
                                   create_timestamp,
                                   create_timestamp)";

        //Issue INSERT to database table
        if($con->query($sql_insert) == TRUE){
          echo "insert successful";
        }
        else {
          echo "insert failed: " . $con->error;
        }

      //  $con->close();
      }

      //Student loan

      function insert_student_loan($user_id,
                                   $student_loan_nickname,
                                   $student_loan_remaining_balance,
                                   $student_loan_interest_rate,
                                   $student_loan_remain_term) {

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
                                      VALUES(NULL),
                                      '$student_loan_nickname',
                                      'Student Loan',
                                      VALUES(NULL),
                                      VALUES(NULL),
                                      'APR',
                                      '$student_loan_interest_rate',
                                      '$student_loan_remaining_balance',
                                      '$student_loan_remain_term',
                                      VALUES(NULL),
                                      create_timestamp,
                                      create_timestamp)";

           //Issue INSERT to database table
           if($con->query($sql_insert) == TRUE){
             echo "insert successful";
           }
           else {
             echo "insert failed: " . $con->error;
           }

          // $con->close();

         }

         //Payday loan

         function insert_payday_loan($user_id,
                                     $payday_loan_nickname,
                                     $payday_loan_remaining_balance,
                                     $payday_loan_interest_rate,
                                     $payday_loan_remain_term) {

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
                                         VALUES(NULL),
                                         '$payday_loan_nickname',
                                         'Payday Loan',
                                         VALUES(NULL),
                                         VALUES(NULL),
                                         'APR',
                                         '$payday_loan_interest_rate',
                                         '$payday_loan_remaining_balance',
                                         '$payday_loan_remain_term',
                                         VALUES(NULL),
                                         create_timestamp,
                                         create_timestamp)";

              //Issue INSERT to database table
              if($con->query($sql_insert) == TRUE){
                echo "insert successful";
              }
              else {
                echo "insert failed: " . $con->error;
              }

            //  $con->close();

            }

            //Loan
            function insert_loan($user_id,
                                 $loan_nickname,
                                 $loan_remaining_balance,
                                 $loan_interest_rate,
                                 $loan_remain_term) {

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
                                            VALUES(NULL),
                                            '$loan_nickname',
                                            'Loan',
                                            VALUES(NULL),
                                            VALUES(NULL),
                                            'APR',
                                            '$loan_interest_rate',
                                            '$loan_remaining_balance',
                                            '$loan_remain_term',
                                            VALUES(NULL),
                                            create_timestamp,
                                            create_timestamp)";

                 //Issue INSERT to database table
                 if($con->query($sql_insert) == TRUE){
                   echo "insert successful";
                 }
                 else {
                   echo "insert failed: " . $con->error;
                 }

                // $con->close();

               }

               //Legal Obligation
              function insert_legal_obligation($user_id,
                                               $legal_obligation_nickname,
                                               $legal_obligation_loan_amount,
                                               $legal_obligation_interest_rate,
                                               $legal_obligation_remain_term) {

                    //Insert into  database table
                    $sql_insert = "INSERT INTO yadayada.
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
                                               VALUES(NULL),
                                               '$legal_obligation_nickname',
                                               'Legal Obligation',
                                               '$legal_obligation_loan_amount',
                                               VALUES(NULL),
                                               'APR',
                                               '$legal_obligation_interest_rate',
                                               VALUES(NULL),
                                               '$legal_obligation_remain_term',
                                               VALUES(NULL),
                                               create_timestamp,
                                               create_timestamp)";

                    //Issue INSERT to database table
                    if($con->query($sql_insert) == TRUE){
                      echo "insert successful";
                    }
                    else {
                      echo "insert failed: " . $con->error;
                    }

                  }

                  //  $con->close();

?>
