<?php
  //Development
  $servername="127.0.0.1";
  $username="root";
  $password="root";
  $dbname="yadayada";

  /*
  //Production
  $servername="";
  $username="root";
  $password="root";
  $dbname="yadayada";
  */

  // Establish connection to MySQL
  $con = mysqli_connect($servername,$username,$password,$dbname);

  //Check connection status
  if(!$con) {
    die("connection failed". $con->connection_error);
  }

?>
