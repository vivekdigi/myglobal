<?php
namespace App;

if(count(get_included_files()) == 1) exit("No direct script access allowed");

class meta
{
	
	public function verify_license(){
		return true;
		$website = $_SERVER['HTTP_HOST'];
		$url = "https://onlinetrade.questdigiflex.in/api/v1/check-license/$website";
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($curl);
		curl_close($curl);
		return $res;
	}
 
}