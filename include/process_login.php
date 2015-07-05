<?php
	
include 'session.class.php';
include 'login.php';

$start = new initiate_session();
if( isset($_GET['uemail'],$_GET['upassword'])){	
	$lg = new login($_GET['uemail'],$_GET['upassword']);
// successfull login	
	header('Location: ok_page_after_login.php');		//user protected page
	exit();
}else{
// login failed
	header('Location: erro_page.html');		//error page, error count = 1;
}
	


