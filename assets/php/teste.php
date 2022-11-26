<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception; 
 
// Include library files 
require_once('Exception.php');
require_once('SMTP.php'); 
require_once('PHPMailer.php'); 

require_once("connection.php");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

if($_POST){
	$temperatura = floatval($_POST['temperatura']);
	$id = $_POST['user'];

	$sql_select_email = "SELECT pessoa.email_recuperacao AS `email` FROM pessoa WHERE pessoa.id = ". $id;
	$result = mysqli_query($conn, $sql_select_email);

	if(mysqli_num_rows($result) != 1){
		$response["status"] = "erro";
		$response["sql"] = $sql_select_email;
	} else {
		$row = mysqli_fetch_assoc($result);
		
		if($temperatura > 30.00){
			$mail = new PHPMailer;
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'mail.smtp2go.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'gabriel.ramos@yooper.com.br';                 // SMTP username
			$mail->Password = 'AJzqoeeMhGVKPNxE';                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;    
			
			$from = "grsantos2215@gmail.com";
			$to = $row["email"];
			$message = "teste $temperatura";
	
			$mail->setFrom($from);
			$mail->addAddress($to);     // Add a recipient
			$mail->isHTML(true);
			$mail->Subject = "Temperatura acima do normal";
			$mail->Body    = $message;
			
			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
			    echo 'Message has been sent';
			}
		} else if($temperatura < 15.00){
			$mail = new PHPMailer;
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'mail.smtp2go.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'gabriel.ramos@yooper.com.br';                 // SMTP username
			$mail->Password = 'AJzqoeeMhGVKPNxE';                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 8465;    
			
			$from = "grsantos2215@gmail.com";
			$to = $row["email"];
			$message = "teste $temperatura";
	
			$mail->setFrom($from);
			$mail->addAddress($to);     // Add a recipient
			$mail->isHTML(true);
			$mail->Subject = "Temperatura abaixo do normal";
			$mail->Body    = $message;
			
			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
			    echo 'Message has been sent';
			}
		}
	}
}
