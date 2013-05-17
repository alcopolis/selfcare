<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
	// fungsi construktor
	function __construct() {
		parent::__construct();
		
		$this->data['base_dir'] = config_item('base_dir');
	}
}
