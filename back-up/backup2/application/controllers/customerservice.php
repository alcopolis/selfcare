<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customerservice extends CI_Controller {

	/**
	 * Constructor
	 */
	function __construct() {
        parent::__construct();  
		$this->client_logon = $this->session->userdata('logged');
    }   	
	
	/**
	 * Memeriksa user state, jika dalam keadaan login akan menampilkan halaman absen,
	 * jika tidak akan meredirect ke halaman login
	 */
	function index(){
		// Hapus data session yang digunakan pada proses update data absen
		
		//$this->session->unset_userdata('custcode');			
		if($this->client_logon){
			$this->homepage($this->session->userdata('logged'));
		}else{
			redirect('login');
		}
	}
	
	function homepage($cscode){
		
	}
	
}
// END Customerservice

/* End of file absen.php */
/* Location: ./system/application/controllers/customerservice.php */