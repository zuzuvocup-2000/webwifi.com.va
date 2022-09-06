<?php 
namespace App\Libraries;

class Mailbie{

	private $email;

	public function __construct(){
		$this->email = \Config\Services::email();
	}
	public function send(array $param = []){
 		$this->email->setFrom($this->email->SMTPUser, CMS_NAME);
		$this->email->setTo($param['to']);
		$this->email->setSubject($param['subject']);
		$this->email->setMessage($param['messages']);
		if($this->email->send()){
			return true;
		}else{
			pre($this->email->printDebugger(['headers']));
		}

	}

}