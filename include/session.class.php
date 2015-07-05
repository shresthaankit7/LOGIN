<?php

class initiate_session
{
	public $session_name = 'secure_session';
	public $session_started = false;
	
	public $cookie_parameters;
	public $cookie_lifetime;
	public $cookie_domain;
	public $cookie_secure;
	public $cookie_httponly = TRUE;

	public function __construct(){
//		$this->check_cookies_enabled();  //Uncomment this
		$this->get_cookie_parameters();
	}

/*This function checks if cookies are enabled
/ in browser,if not, alerts to enable cookie
/ in browser.
*/	
	public function check_cookies_enabled(){	//check if browser has enabled cookie
		session_start();
		setcookie('test-cookie');	
		if( isset($_COOKIE['test-cookie']) ){
			header($_SERVER['PHP_SELF']);
		//	echo 'cookie enabled';
		}else{
			echo 'enable cookie to run<br>';
			exit();		
		}
		session_destroy();
	}		
	
	public function get_cookie_parameters(){
		 $this->cookie_parameters = session_get_cookie_params();
		//var_dump($this->cookie_parameters);
		 setcookie($this->cookie_parameters["lifetime"],
			   $this->cookie_parameters["domain"],
			   $this->cookie_parameters["secure"],
			   $this->cookie_parameters["httponly"]);
	
		 session_name("$this->session_name");
		 session_start();
		 session_regenerate_id(TRUE);	//what does this do ????
	}			
}



class stop_session
{
	public function __construct(){
		session_start();
	
		$_SESSION = array();
		$session_params = session_get_cookie_params();

		setcookie( session_name(),																		    '' ,																	 time()-42000,																	$session_params["path"],															      $session_params["domain"],														            $session_params["secure"],																$session_arams["httponly"]);
			
		session_unset(); //TEST			
		session_destroy();	

		header('Location : main_page.html');
	}
}
		



			
