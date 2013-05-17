<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Admin_Controller {
	
	// fungsi construktor
	function __construct() {
		parent::__construct();
	}
	
	public function index(){
		echo 'admin user page';
	}
}