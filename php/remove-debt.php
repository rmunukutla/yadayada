<?php

    error_reporting(~E_ALL & ~E_NOTICE);

    include '../dbconnection.php';

    //Set autocommit to false
    mysqli_autocommit($con,false);

    $user_id = $_REQUEST['user_id'];
    $debt_identifier = $_REQUEST['debt_identifier'];
    $sqlstr = "DELETE
                 FROM yadayada.debt_user_input
                WHERE user_id = '$user_id'
                  AND debt_identifier = '$debt_identifier'";

    if($con->query($sqlstr) == TRUE){
      //echo "insert successful";
    }
    else {
      //echo "insert failed: " . $con->error;
    }

    mysqli_commit($con);
    $con->close();

?>
