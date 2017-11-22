<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Logout</title>
    <link rel='stylesheet' type='text/css' href='../stylesPWS/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='../stylesPWS/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='../stylesPWS/smartphone.css' />
  </head>
  <style>
	div {
		text-align: center;
		padding: 50px 50px 50px 50px;
	}
  </style>
  <body>
	<?php
	session_start (); 
	$email=$_SESSION['mail'];
	echo '<div> Bye ' . $email .' :)';
	session_destroy(); 
	?>
	<br>
	<a href="../html/layout.html">Home</a>
	</div>
  </body>
 </html>