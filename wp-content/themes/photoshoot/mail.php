<?php
if($_POST){
	
	//your email address 
	$email_to = $_POST['receiveEmail'];
	//email subject
	$emailSubject = "PhotoShoot contact form";
	
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	
	$text = "NAME: $name<br>
	         EMAIL: $email<br> 
	         MESSAGE: $message";
	$headers = "MIME-Version: 1.0" . "\r\n"; 
	$headers .= "Content-type:text/html; charset=utf-8" . "\r\n"; 
	$headers .= "From: <$email>" . "\r\n";
	mail($email_to, $emailSubject, $text, $headers);
	$data['success'] = true;
	echo json_encode($data);
}
?>