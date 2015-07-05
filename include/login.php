<?php

include 'database.class.php';
	
class login extends database_class
{
	public $uemail;
	private $upassword;	
	private $uname;
	private $usalt;
	private $uid;

	public function __construct($email,$password){
	//	echo "login class constructor called";
		parent::__construct();	
		$this->check_user_exists($email,$password,$this->db_conn);
	}	
	
	public function check_user_exists($email,$password,$db_conn){
		$sql = "SELECT COUNT(email_id) as no_of_users FROM User_table WHERE email_id ='{$email}' LIMIT 1;";
		$retval = mysql_query($sql,$db_conn);
		
		if( !$retval ){
			die("ERROR:(retval) ".mysql_error());
		}else{
		//	echo "query done";
		}
			
		while($row = mysql_fetch_array($retval,MYSQL_ASSOC)){
				if( $row['no_of_users'] == 1 ){
			//		echo "user exists";	
					$this->uemail = $email;
					$this->check_password($password,$db_conn);
				}else{
					echo "ERROR: IN USERNAME";
					exit();
				}
		}
	}	
	
	
	public function check_password($password,$db_conn){

/*Check brute force attack, new table for it and login attemps first
/ IF more attempts are done, send email/ or any handler to stop 
*/
		$sql = "SELECT id,user_name,password,salt FROM User_table WHERE email_id = '{$this->uemail}';";
		$retval = mysql_query($sql,$db_conn);
			if( !$retval )
			die("ERROR: ".mysql_error());
		while( $row = mysql_fetch_array($retval,MYSQL_ASSOC)){
			$db_pass = $row['password']; 	//$db_pass  password from database
			$db_salt = $row['salt'];	
			$db_uname = $row['user_name'];
			$db_uid = $row['id'];
		}
/*check if user's password and input password matches*/
		if( crypt($password,$db_salt) == crypt($db_pass,$db_salt) ){
//			echo "login ok";
			$this->set_uname($db_uname);	
			$this->set_password($db_pass);
			$this->set_salt($db_salt);
			$this->set_uid($db_uid);
			$this->set_session_names();
		}else{
			echo "ERROR: IN PASSWORD";
			exit();
		}
	}

	public function set_uid($uid){
		$this->uid = $uid;
	}

	public function set_uname($name){
		$this->uname = $name;
	}
	public function set_password($pw){
		$this->upassword = $pw;
	}
		
	public function set_salt($salt){
		$this->usalt = $salt;
	}

/* $_SESSION VARIABLES SET 
   $_SEESION['user_id']
   $_SEESION['user_name']
   $_SEESION['login_string']
*/

/* user_id is not done any thing till now
/  look up to handle this user_id
/  test are commented
*/
	public function set_session_names(){
	
/* TEST CODE UNCOMMENT 
/ IF ERROR OCCURS
/ UPTO SECTION 1 
*/	
//		session_start();

/* SECTION 1 
  DELETE UP TO SECTION 1 ABOVE
*/




		$user_browser = $_SERVER['HTTP_USER_AGENT'];
//		$this->uid = crypt($this->uid,$this->usalt);
//		$this->uid = preg_replace("/[^0-9]+/", "",$this->uid);		
		$_SESSION['user_id'] = $this->uid;
		
		$this->uname = preg_replace("/[^a-zA-Z0-9_\-]+/","",$this->uname);
		$_SESSION['user_name'] = $this->uname;
		
		$_SESSION['login_string'] = hash('sha512',$this->upassword.$user_browser);
		
//		echo "login successfull";
//		echo $_SESSION['login_string'];		

		return true;
		
	}

}



/* THIS IS THE INPUT OF USER AND 
/ PASSWORD BY GET METHOD
/ MUST USE OTHER WAY TO MAKE SECURE
*/


/*    UC THIS SECTION
if( isset($_GET['uemail']) && isset($_GET['upassword'])){
	$lg = new login($_GET['uemail'],$_GET['upassword']);
}else{
	echo "ERROR: ";
	exit();
}
*/
