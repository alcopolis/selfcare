<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {
	
	// fungsi construktor
	function __construct(){
		parent::__construct();
		
		//Load CI built-in modules
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		
		//Load necessary models
		$this->load->model('admin/login_model');
		
		//General Settings
		$this->data['meta_title'] = 'Innovate';	
		
		//Login Check
		$exception_uris = array('admin/login/login', 'admin/login/logout');
		
		if (in_array(uri_string(), $exception_uris) == FALSE){
			if($this->login_model->loggedin() == FALSE){
				redirect('admin');
			}
		}
	}
	
}