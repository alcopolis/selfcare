<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Admin_Controller {
	// fungsi construktor
	function __construct() {
		parent::__construct();
		$this->data['page_title'] = 'Administrator Login';
		
		$this->load->model('admin/login_model');
		$this->client_logon = $this->session->userdata('logged');
		$this->client_access = $this->session->userdata('aktif');
	}
	
	// fungsi pertama kali admin controller dipanggil
	public function index()
	{
		if($this->client_logon){
			if($this->client_access=='0'){
				redirect('logout');
			}
			$this->home_page($this->session->userdata('logged'));
		}else{
			//redirect('login');
			$this->login();
		}
	}
	

	public function login(){
		$this->load->view('admin/parts/header', $this->data);
		$this->load->view('admin/login', $this->data);
		$this->load->view('admin/parts/footer', $this->data);
	}
	
	// end fungsi index
}