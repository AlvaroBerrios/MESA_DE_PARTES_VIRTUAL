<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_PHPMailer {
	public function My_PHPMailer()
	{
		/*require_once('PHPMailer/class.phpmailer.php');*/
		
		require_once dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';
		require_once dirname(__FILE__) . '/PHPMailer/class.smtp.php';
		
		
	}
}
?>