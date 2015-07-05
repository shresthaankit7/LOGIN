<?php

	include 'include/session.class.php';
	include 'include/login_check.class.php';
	$session = new initiate_session();
	$lg_check = new login_check();
	if( $lg_check->login_status == "logged_in"){
		echo "PROTECTED CONTENTS";
	}else{
		echo "SIGN IN TO VIEW PROTECTED CONTENTS";
	}
