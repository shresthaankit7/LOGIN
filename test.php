<?php
	
$email = "test12@gmail.com";

if( filter_var($email,FILTER_VALIDATE_EMAIL))
	echo "ok";
