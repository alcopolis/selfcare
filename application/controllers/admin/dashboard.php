<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Admin_Controller {
	// fungsi construktor
	function __construct() {
		parent::__construct();
	}

	public function index(){
		//var_dump($this->data['base_dir']);
		echo 'Dashboard';
	}
}