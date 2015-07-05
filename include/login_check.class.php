<?php

include 'database.class.php';

class login_check extends database_class
{
	public $session_user_id;
	public $session_user_name;
	public $session_login_string;
	
	public $is_session_set = false;

	public $user_browser;

	public $login_status = "logged_out";

	public function __construct(){
		parent::__construct();
		$this->check_session();
		$this->check_loged_in($this->db_conn);	
	}
	
	public function check_session(){	
		if( isset($_SESSION['user_id'],$_SESSION['user_name'],$_SESSION['login_string'])){
			$this->session_user_id = $_SESSION['user_id'];
			$this->session_user_name = $_SESSION['user_name'];	
			$this->session_login_string = $_SESSION['login_string'];
		
			$this->is_session_set = true;
			
			$this->user_browser = $_SERVER['HTTP_USER_AGENT'];		//current browser information	
			
		}else{
			echo "ERROR: NOT LOGGED IN: session";
			exit();
		}	
	}

	public function check_loged_in($db_conn){

		$sql = "SELECT password FROM User_table where id = '{$_SESSION['user_id']}' LIMIT 1;";
		$retval = mysql_query($sql,$db_conn);
		if( !$retval ){
			die("ERROR: ".mysql_error());
			exit();
		}
		while( $row = mysql_fetch_array($retval,MYSQL_ASSOC))
			$db_password = $row['password']; 		//db_password is the password fetched from the database
	
		if(  $_SESSION['login_string'] == hash('sha512',$db_password.$this->user_browser)){
//			echo "logged in";
			$this->login_status="logged_in";
		}else{
			echo "error logging in";
		}
	}		
}
