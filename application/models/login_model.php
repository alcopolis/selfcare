<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login_model extends CI_Model {
	/*
	 class untuk menampung fungsi yang berhubuggan dengan login
	*/	
	function __construct()
    {
        parent::__construct();
		$this->tulis = $this->load->database('default',TRUE);// koneksi ke database billing untuk update/insert
		//$this->baca = $this->load->database('altdb', TRUE);// koneksi ke database read/replikasi
		$this->baca = $this->load->database('default', TRUE);// koneksi ke database read/replikasi
    }
	
// fungsi login untuk memasukan usercode ke dalam session logged
	public function login($user_id, $a)
	{
		$CI =& get_instance();
		$cl = $this->get_cluster($user_id)->row();
		$cluster = $cl->CLUSTER;
		
		$CI->session->set_userdata('logged', $user_id);
		$CI->session->set_userdata('aktif', $a);		
		$CI->session->set_userdata('daerah', $cluster);		
	}
	
//function get cluster untuk mendapatkan cluster pelanggan
	public function get_cluster($custcode)
	{
		$this->baca->initialize();
		
		$this->baca->select('REGION as CLUSTER');
		$this->baca->where('CUSTOMERCODE',$custcode);
		$this->baca->from('t_ms_customer');	
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
	public function validate($username,$password)
	{
		$v1 = $this->validate1($username,$password);
		$v2 = $this->validate2($username,$password);
		$v3 = $this->validate3($username,$password);
		
		if($v1){
			$this->login($username,'0');
			return '1';
		} elseif($v2){
			$this->login($username,'1');
			return '2';
		}elseif($v3){
			$this->login($username,'0');
			return '3';
		}else{
			return '4';	
		}
	}
// end of validate function

// fungsi untuk melakukan cek apakah user sudah terdaftar di tabel login cust
	public function validate1($username,$password)
	{
		$this->baca->initialize();
		$qry = $this->baca->get_where('LOGIN_CUST', array('CUSTCODE' => $username));
		$cek = $qry->num_rows();
		
		if($cek <= 0){
			$this->baca->initialize();
			$qryd = $this->baca->get_where('t_ms_customer', array('customercode' => $username));
			$cekd = $qryd->num_rows();
			if($cekd!=0){
				$userdata = $this->get_login_data($username)->row();
				$this->tulis->initialize();
				$this->tulis->set('CUSTID'  , $userdata->custid);
				$this->tulis->set('CUSTCODE', $userdata->custcode);
				$this->tulis->set('CUSTNAME', $userdata->custname);
				$this->tulis->set('EMAIL'   , $userdata->EMAIL);
				$this->tulis->set('CUSTPWD' , $userdata->CUSTPWD);
				$this->tulis->set('LASTPACKAGEUPDATE',$userdata->LASTPACKAGEUPDATED);
				$this->tulis->set('PHONE' , $userdata->PHONE);
				$this->tulis->set('MOBILE',$userdata->MOBILE);
				$this->tulis->set('SALTKEY', $this->_create_salt());
				$this->tulis->set('REGDATE',date('Y-m-d'));
				$this->tulis->insert('LOGIN_CUST');
				return TRUE;
				$this->tulis->close();
			}else{
				return FALSE;	
			}
		}else{
			return FALSE;
		}
		
		$this->baca->close();
	}
// end of function validate1

//funtsi untuk cek apakah user tersebut sudah aktif
	public function validate2($username,$password)
	{
		$this->baca->initialize();
		
		$qrya = $this->baca->get_where('LOGIN_CUST', array('CUSTCODE' => $username,'ACCSTS'=>1));
		$ceka = $qrya->num_rows();
		if($ceka!=0){
			foreach($qrya->result() as $row):
				$client['custcode']	= $row->CUSTCODE;	
				$client['password'] = $row->CUSTPWD;
				$client['aktif']    = $row->ACCSTS;
			endforeach;
			$encpwd = sha1($password);
			if($encpwd == $client['password']){
				return true;
			}else{
				return false;
			}	
		}
		
		$this->baca->close();
	}
// end of validate 2
		
// funtsi untuk aktivasi
	public function validate3($username,$password)
	{
		$this->baca->initialize();
		
		$qryb = $this->baca->get_where('LOGIN_CUST', array('CUSTCODE' => $username,'ACCSTS'=>0));
		$cekb = $qryb->num_rows();
		if($cekb!=0){
			foreach($qryb->result() as $row):
				$client['custcode']	= $row->CUSTCODE;	
				$client['password'] = $row->CUSTPWD;
				$client['aktif']    = $row->ACCSTS;
				$client['salt']     = $row->SALTKEY;
			endforeach;
			$encpwd = sha1($password);
			if($encpwd == $client['password']){
				return true;
			}else{
				return false;
			}
		}
		
		$this->baca->close();
	}
// end of validate3 function

// function get login data digunakan untuk mengambil data customer yang akan di masukan kedalam login cust
	public function get_login_data($custcode)
	{
		$this->baca->initialize();
		
		$this->baca->select('CUSTOMERID `custid`');
		$this->baca->select('CUSTOMERCODE `custcode`');
		$this->baca->select('CUSTOMERNAME `custname`');
		$this->baca->select('EMAIL');
		$this->baca->select('SHA1(t_ms_customer.CUSTOMERCODE) `CUSTPWD`');
		$this->baca->select('LASTPACKAGEUPDATED');
		$this->baca->select('PHONE');
		$this->baca->select('MOBILE');
		$this->baca->where('CUSTOMERCODE',$custcode);
		$this->baca->from('t_ms_customer');	
		return $this->baca->get();
		
		$this->baca->close();
	}
// end of get login data function

// fungsi untuk update last login user
	public function last_login($custcode)
	{
		$this->tulis->initialize();
		$this->tulis->where('CUSTCODE', $custcode);
		$lastlogin = array('LASTLOGIN' => date('Y-m-d H:i:s', time()));
		$this->tulis->update('LOGIN_CUST', $lastlogin);
		$this->tulis->close();
	}
// end of last login update

//fungsi untuk menampilkan data pelanggan
	public function get_data_pelanggan($custcode)
	{
		$this->baca->select('t1.CUSTID CUSTOMERID');
		$this->baca->select('t1.CUSTCODE CUSTOMERCODE');
		$this->baca->select('t1.CUSTNAME CUSTOMERNAME');
		$this->baca->select('t0.CUSTOMERADDRESS CUSTOMERADDRESS');
		$this->baca->select('t0.IDENTIFICATIONTYPE');
		$this->baca->select('t0.IDENTIFICATIONNUMBER');
		$this->baca->select('t1.PHONE PHONE');
		$this->baca->select('t1.MOBILE MOBILE');
		$this->baca->select('t1.EMAIL EMAIL');
		$this->baca->select('t0.BILLINGADDRESS BILLINGADDRESS');
		$this->baca->select('t1.LASTPACKAGEUPDATE LASTPACKAGEUPDATED');
		$this->baca->from('t_ms_customer t0');
		$this->baca->join('LOGIN_CUST t1','t0.CUSTOMERCODE = t1.CUSTCODE');
		$this->baca->where ('t1.CUSTCODE',$custcode);
		
		return $this->baca->get();
	}
//end of get_data_pelanggan

// fungsi untuk validasi aktivasi password
	public function validate_pwd()
	{
		$this->baca->initialize();
		$curpwd = sha1($curpas);
		$query = $this->baca->get_where('LOGIN_CUST', array('CUSTCODE' => $username,'CUSTPWD' => $curpwd));
		$cek = $query->num_rows();
		$this->baca->close();	
		if($cek != 0){return true;}else{return false;}
	}
// end of validate pwd	

// fungsi untuk update data applikasi dan save password
	public function update_pwd($custcode,$array_data)
	{
		$this->tulis->initialize();
		$this->tulis->where('CUSTCODE', $custcode);
		$this->tulis->update('LOGIN_CUST', $array_data);
		$this->tulis->close();
	}
// end of activate password

// fungsi untuk mendapatakan verifikasi data dan update data user supaya aktif
	
	public function cek_activation($salt)
	{
		$query = $this->baca->get_where('LOGIN_CUST', array('SALTKEY' => $salt));
		$cek = $query->num_rows();			
		if($cek != 0){return true;}else{return false;}
	}
	
	public function get_activation($salt)
	{
		$this->baca->select('t1.CUSTID CUSTOMERID');
		$this->baca->select('t1.CUSTCODE CUSTOMERCODE');
		$this->baca->select('t1.CUSTNAME CUSTOMERNAME');
		$this->baca->select('t0.CUSTOMERADDRESS CUSTOMERADDRESS');
		$this->baca->select('t1.EMAIL EMAIL');
		$this->baca->select('t0.BILLINGADDRESS BILLINGADDRESS');
		$this->baca->select('t1.LASTPACKAGEUPDATE LASTPACKAGEUPDATED');
		$this->baca->from('t_ms_customer t0');
		$this->baca->join('LOGIN_CUST t1','t0.CUSTOMERCODE = t1.CUSTCODE');
		$this->baca->where ('t1.SALTKEY',$salt);
		
		return $this->baca->get();
	}
	
	public function update_activation($custcode,$salt_array)
	{
		$this->tulis->initialize();
		$this->tulis->where('CUSTCODE', $custcode);
		$this->tulis->update('LOGIN_CUST', $salt_array);
		$this->tulis->close();
	}
// end of verification and activation

// fungsi untuk memvalidasi id pelanggan yang akan 
	public function validate_reset($custcode,$email)
	{
		$this->baca->select('*');
		$this->baca->from('LOGIN_CUST');
		$this->baca->where('CUSTCODE',$custcode);
		$this->baca->where('EMAIL',$email);
		return $this->baca->get();
	}
// end of validate reset

// fungsi untuk update password setelah di reset
	public function reset_password($custcode,$reset_data)
	{
		$this->tulis->initialize();
		$this->tulis->where('CUSTCODE', $custcode);
		$this->tulis->update('LOGIN_CUST', $reset_data);
		$this->tulis->close();
	}
	
// end of function reset password
	
/**
 * Create Salt
 *
 * This function will create a salt hash to be used in 
 * authentication
 * 
 * @return  string      the salt
 */
	protected function _create_salt()
	{
		$this->load->helper('string');
		return sha1(random_string('alnum', 32));
	}
// end of create salt

}
/* End of file login_model.php */
/* Location: ./application/models/login_model.php */