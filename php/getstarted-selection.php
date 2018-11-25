<?php

    error_reporting(~E_ALL & ~E_NOTICE);

    include '../dbconnection.php';

    //Set autocommit to false
    mysqli_autocommit($con,false);

    $user_id = $_REQUEST['user_id'];

    $sqlstr = "SELECT *
                 FROM yadayada.debt_user_input
                WHERE user_id = '$user_id'";

    $result = $con->query($sqlstr);

    echo mysqli_num_rows($result);
    //echo $sqlstr;

    $con->close();

?>
