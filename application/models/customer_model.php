<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Login_model Class
 *
 */
class Customer_model extends CI_Model {
	/**
	 * Constructor
	 */
	function __construct()
    {
        parent::__construct();
		$this->tulis = $this->load->database('default',TRUE);// koneksi ke database billing untuk update/insert
		$this->baca = $this->load->database('default', TRUE);// koneksi ke database replikasi
	}
	
// fungsi untuk menampilkan data pelanggan pada saat view data pelanggan
	public function get_cust_bycode($custcode)
	{  
		$this->baca->initialize();
		
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
		$this->baca->close();
		
	}
// end of get cust_by_code

//fungsi untuk menampilkan data pelanggan
	public function get_password_data($custcode)
	{
		$this->baca->initialize();
		
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
		
		$this->baca->close();
	}
//end of get_data_pelanggan

// fungsi untuk update password dari data pelanggan setelah aktifasi
	public function update_pwd($custcode,$profil_array)
	{
		$this->tulis->initialize();
		$this->tulis->where('CUSTCODE', $custcode);
		$this->tulis->update('LOGIN_CUST', $profil_array);
		$this->tulis->close();
	}
// end of update profile

// fungsi untuk memeriksa apakah password sebelum diganti sesuai dengan database
	public function cek_curpas($custcode,$pwd)
	{
		$this->baca->initialize(); 
		
		$query = $this->baca->get_where('LOGIN_CUST', array('custcode' => $custcode,'custpwd'=>$pwd));
		$cek = $query->num_rows();			
		if($cek != 0){return true;}else{return false;}
		
		$this->baca->close();
	}
// end of check curpass

//fungsi untuk melakukan pengecekan terhadap
	public function validate_change($username)
	{	
		$this->baca->initialize();
		
		$bln = date('m');
		$thn = date('Y'); 
		$query = $this->baca->get_where('LOGIN_CUST', array('CUSTCODE' => $username,'MONTH(LASTPACKAGEUPDATE)'=>$bln,'YEAR(LASTPACKAGEUPDATE)'=>$thn));
		$cek = $query->num_rows();
		if($cek != 0){return true;}else{return false;}
		
		$this->baca->close();
	}
// end of validate change
	
	
}

/* End of file customer_model.php */ 
/* Location: ./system/application/model/customer_model.php */