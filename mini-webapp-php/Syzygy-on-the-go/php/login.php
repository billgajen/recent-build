<?php
	session_start();
	$username = $_POST['username'];
	$password = $_POST['password'];
	$mysqli=mysqli_connect('localhost','root','','syzygy');
	$query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
	$result = mysqli_query($mysqli,$query)or die(mysqli_error());
	$num_row = mysqli_num_rows($result);
	$row=mysqli_fetch_array($result);
 
	if( $num_row >=1 ) {
		echo 'true';
		//echo json_encode($row);
		$_SESSION['username']=$row['username'];
	}
	else{
		echo 'false';
	}
?>