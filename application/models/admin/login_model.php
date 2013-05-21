<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->tulis = $this->load->database('default',TRUE);// koneksi ke database billing untuk update/insert
		//$this->baca = $this->load->database('altdb', TRUE);// koneksi ke database read/replikasi
		$this->baca = $this->load->database('default', TRUE);// koneksi ke database read/replikasi
	}
	
	// fungsi login untuk memasukan usercode ke dalam session logged
	public function login($user_email, $a)
	{
		$CI =& get_instance();
		$usr = $this->get_user_data($user_email)->row();
	
		$CI->session->set_userdata('logged', $user_email);
		$CI->session->set_userdata('aktif', $a);
	}
	
	//function get cluster untuk mendapatkan cluster pelanggan
	public function get_user_data($user_email)
	{
		$this->baca->initialize();
	
		$this->baca->select('*');
		$this->baca->where('EMAIL',$user_email);
		$this->baca->from('login_admin');
		return $this->baca->get();
	
		$this->baca->close();
	}
	// end of get cluster
	
	// fungsi logout untuk menghapus usercode di session
	public function logout()
	{
		$CI =& get_instance();
		$CI->session->sess_destroy();
		$CI->session->unset_userdata(array('logged'=>'','aktif'=>''));
	}
	
	// fungsi untuk melakukan validasi login
	public function validate($email,$password)
	{
		$this->baca->initialize();
		$qry = $this->baca->get_where('LOGIN_ADMIN', array('email' => $email));
		$cek = $qry->num_rows();
		
		if($cek <= 0){			
			return FALSE;
		}else{
			$this->login($username,'1');
		}
		
		$this->baca->close();
	}
	// end of validate function
}