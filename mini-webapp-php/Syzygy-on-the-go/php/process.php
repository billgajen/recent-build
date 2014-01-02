<?php

    // $mysqli = mysqli_connect('localhost','root','root','syzygy');
    // $username=$_POST['username'];
    // $fname = mysql_query("SELECT fname FROM user WHERE username='$username'";);

    // echo $fname;
  
  $username = $_GET['username'];
  $password = $_GET['password']; 
  
  $host = "localhost";
  $user = "root";
  $pass = "";

  $databaseName = "syzygy";
  $tableName = "user";

  $con = mysql_connect($host,$user,$pass);
  $dbs = mysql_select_db($databaseName, $con);


  $result = mysql_query("SELECT * FROM $tableName WHERE username='$username' AND password='$password'");
  $array = mysql_fetch_row($result);  

  echo json_encode($array);

?>
