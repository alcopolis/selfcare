<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Admin_Controller {
	// fungsi construktor
	function __construct() {
		parent::__construct();
	}
	
	public function index(){
		var_dump($this->data['base_dir']);
		echo 'Login Page';
		
		$this->load->view('admin/parts/header');
		$this->load->view('admin/login');
		$this->load->view('admin/parts/footer');
	}
}