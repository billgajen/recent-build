<?php
  $tdate = $_GET['date'];
  
  $host = "localhost";
  $user = "root";
  $pass = "";

  $databaseName = "syzygy";
  $tableName = "timesheet";

  $con = mysql_connect($host,$user,$pass);
  $dbs = mysql_select_db($databaseName, $con);

   session_start();
   if (isset($_SESSION['username'])) {

      $username =  ($_SESSION['username']);

      $result = mysql_query("SELECT * FROM $tableName WHERE username='$username' AND tdate='$tdate'");
      $rows = array();
      while($r = mysql_fetch_assoc($result)){

          $rows[] = array('timeSlots' => $r);
      }
      echo json_encode($rows);

   }else {
      echo 'false';
   }

?>
