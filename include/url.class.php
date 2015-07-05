<?php

class URL_class
{
	public $url;
	public function __construct(){
		$this->url = $_SERVER['PHP_SELF'];
		$this->sanitize_url($this->url);
	}
	
	public function sanitize_url($url){
		if(' ' == $url){
			echo $url;
		}
		
		$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@#$\|*\'()\\x80-\\xff]|i','',$url);
		$strip = array('%0d','%0a','%0D','%0A');
		$url = (string) $url;
	
		$count = 1;
		
		while($count){
			$url = str_replace($strip, '' ,$url,$count);
		}
		
		$url = str_replace(';\\',':\\',$url);
		
		$url = htmlentities($url);
			
		$url = str_replace('&amp;', '&#039;', $url);

		if($url[0] !== '/'){
		//	return '';
			echo '';
		}else{
			echo "url";
		}
	}		
}
	

//$a = new URL_class();

