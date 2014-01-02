<?php
  
  $host = "localhost";
  $user = "root";
  $pass = "";

  $databaseName = "syzygy";
  $tableName = "timesheet";

  $con = mysql_connect($host,$user,$pass);
  $dbs = mysql_select_db($databaseName, $con);

   session_start();
   if (isset($_SESSION['username'])) {

      $username = $_SESSION['username'];
      $tdate = $_GET['date'];

      for ($i = 0; $i <= 5; $i++) {
        $dateCollection[] = date('Y/m/d', strtotime($tdate.'+'.$i.' day'));
      }

      $rows = array();

      foreach($dateCollection as $date) {
        $result = mysql_query("SELECT * FROM $tableName WHERE username='$username' AND tdate='$date'");
        while($r = mysql_fetch_assoc($result)){
            $rows[] = array('timeSlots' => $r);
        }
      }
      echo json_encode($rows);

   }else {
      echo 'false';
   }

?>
