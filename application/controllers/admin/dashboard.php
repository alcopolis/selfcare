<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {
	// fungsi construktor
	function __construct() {
		parent::__construct();
		$this->data['page_title'] = 'Dashboard';
	}

	public function index(){
		$this->load->view('admin/parts/header', $this->data);
		//$this->load->view('admin/login', $this->data);
		$this->load->view('admin/parts/footer', $this->data);
	}
}