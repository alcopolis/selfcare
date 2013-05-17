<?php

class watch_control extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Billing_model', '', TRUE);
		$this->load->model('Customer_model', '', TRUE);
	
		$this->client_logon = $this->session->userdata('logged');
		$this->client_access = $this->session->userdata('aktif');
		$this->client_cluster = $this->session->userdata('daerah');
		if($this->client_logon==''){
			redirect('login');
		}
	}
	
	public function index(){
		if($this->client_logon){
			if($this->client_access=='0'){	redirect('logout');	}
			//$this->cepat_net_billing_info($this->session->userdata('logged'));
			$this->init_tv_stream();
		}else{
			redirect('login');
		}
	}
	
	public function init_tv_stream(){
		$this->load->view('header');
		$this->load->view('watch_view');
		$this->load->view('footer');
	}
}
