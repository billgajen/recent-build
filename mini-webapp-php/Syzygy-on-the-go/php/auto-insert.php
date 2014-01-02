<?php

	$host = "localhost";
	$user = "root";
	$pass = "";

	$databaseName = "syzygy";
	$tableName = "timesheet";

	$con = mysql_connect($host,$user,$pass);
	$dbs = mysql_select_db($databaseName, $con);

	session_start();
	$username = ($_SESSION['username']);
	$date=$_POST['date'];
	$jcode=$_POST['jobcode'];
	$hours=$_POST['hours'];

	$query=mysql_query("UPDATE $tableName SET addedHours='$hours' WHERE username='$username' AND tdate='$date' AND jobcode='$jcode'");
	if(mysql_affected_rows() == 1){
	echo "Time added to $jcode";
	}
	else{ 
		echo "<p class=\"error\">Are you dizzy blood?</p>";
	}

?>
 
 