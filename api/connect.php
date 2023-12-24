<?php
	$connect = mysqli_connect('localhost','root','mintu12345','banking') or die("Connection failed");
	if($connect){
	} else {
		echo "not connected";
	}
?>