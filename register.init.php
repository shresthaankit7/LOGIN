<?php

include 'include/database.class.php';

/*If any registration is invalid, 
/ set up error message in error string
/ to inform to the other page.error.php
*/


if( isset( $_GET['uname'],$_GET['uemail'],$_GET['upassword'] ) ){

	$uname = filter_input( INPUT_GET, 'uname', FILTER_SANITIZE_STRING);
//	$uemail = $_GET['uemail'];
	$uemail = filter_input( INPUT_GET,'uemail',FILTER_SANITIZE_EMAIL);
	
	$upassword = $_GET['upassword'];	
	check_email($uemail);
	check_user_exists($uname,$uemail);
	check_password($upassword);
	insert_user($uname,$uemail,$upassword);
}else{
	$mgs = "INFORMATION NOT PROPERLY SET";
	send_error($mgs);
}




function check_email($uemail){
	if(!filter_var($uemail,FILTER_VALIDATE_EMAIL)){
		$mgs = "INVALID EMAIL";
		send_error($mgs);
	}else{
		if( check_email_exists($uemail) ){
			$mgs = "EMAIL ALREADY REGISTERED";
			send_error($mgs);
			exit();
		}else{
			return;
		}			
	}
}

/* Check if user already exists
   count = 1 user exists, set error string
   else return true
   THIS execute only if new email is getting registered
   with new different user name
*/
function check_user_exists($uname,$uemail){
	$DB = new database_class();
	$sql = "SELECT COUNT(id) as count FROM User_table WHERE user_name = '$uname' LIMIT 1;";
	$retval = mysql_query($sql,$DB->db_conn);
	if( !$retval)
		die( "ERROR :".mysql_error());
	while( $row = mysql_fetch_array($retval,MYSQL_ASSOC))
		$count = $row['count'];

	if( $count == 1){
		$mgs = "USER ALREADY EXISTS";
		send_error($mgs);
//		exit();
	}else{
		return true;
	}
}

/* Check if password entered is ok
 
*/
function check_password($upassword){
	

}

function check_email_exists($uemail){
	$DB = new database_class();
	$sql = "SELECT COUNT(id) as count FROM User_table WHERE email_id = '$uemail' LIMIT 1;";
	$retval = mysql_query($sql,$DB->db_conn);
	if( !$retval )
		die("ERROR:mail ".mysql_error());
	while( $row = mysql_fetch_array($retval,MYSQL_ASSOC))
		$count = $row['count'];
		
	if( $count == 1){
		return TRUE;
	}else{
		return FALSE;
	}
}

function insert_user($uname,$uemail,$upassword){
	$salt = openssl_random_pseudo_bytes(32);
	$DB = new database_class();
	$sql = "INSERT INTO User_table(user_name,email_id,password,salt)values('$uname','$uemail','$upassword','$salt');";
	$retval = mysql_query($sql,$DB->db_conn);
	if( !$retval ){
		die("ERROR: ".mysql_error());
	}else{
		echo "ok inserted";	//deelete this line
		header("Location: registration_success.php");
	}
}


function send_error($mgs){
	header("Location: error.php?error_mgs= ".$mgs);
	exit();
}
