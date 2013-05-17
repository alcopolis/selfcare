<?php
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
		$this->baca = $this->load->database('altdb', TRUE);
    }
	
	// Inisialisasi nama tabel user
	var $table = 't_ms_customer';
	
	/**
	 * Cek tabel user, apakah ada user dengan username dan password tertentu
	 */
	
	function get_cust_bycode($custcode)
	{  
		$this->baca->select('*');
		$this->baca->where('customercode', $custcode);
		return $this->baca->get($this->table);
	}
	
	function get_package_homeview($custid)
	{
	
		$this->baca->select('t0.customerpackageid as pktid');
		$this->baca->select('t2.packagename as PACKAGE');
		$this->baca->select('t2.PACKAGEID as IDPAKET');// untuk pemilihan alacarte atau bukan
		$this->baca->select('t2.description as DESCRIPTION'); 
		$this->baca->select('COUNT(t3.serviceid) as MAXCHANEL');
		$this->baca->select('t0.pricem as PRICE'); 
		$this->baca->select('t0.firstbillingdate as BILLINGDATE');
		$this->baca->from('t_customer_package t0'); 
		$this->baca->join('t_ms_customer t1' , 't0.customerid = t1.customerid');
		$this->baca->join('t_ms_package t2','t2.packageid = t0.packageid'); 
		$this->baca->join('t_customer_package_service t3','t3.customerpackageid = t0.customerpackageid');
		$this->baca->where('t1.customerid', $custid);
		$this->baca->group_by('t0.customerpackageid');

/*	
		$this->baca->select('t_customer_package.customerpackageid as pktid');
		$this->baca->select('t_ms_package.packagename as PACKAGE');
		$this->baca->select('t_ms_package.description as DESCRIPTION');
		$this->baca->select('t_ms_package.maximalchannellist as MAXCHANEL');
		$this->baca->select('t_customer_package.pricem as PRICE');
		$this->baca->select('t_customer_package.firstbillingdate as BILLINGDATE');
		$this->baca->from('t_customer_package');
		$this->baca->join('t_ms_customer', 't_customer_package.customerid = t_ms_customer .customerid');
		$this->baca->join('t_ms_package', 't_ms_package.packageid = t_customer_package.packageid');
		$this->baca->where('t_ms_customer.customerid', $custid);
*/
		return $this->baca->get();	
	}
	
//	function upadate_pwd($userpwd,$custid){
//		$this->db->where('CUSTOMERID', $custid);
//		$this->db->update('CUSTOMER_PASSWORD', $userpwd);
//	}
	
	function validate_change($username){
		
		$bln = date('m');
		$thn = date('Y'); 
		$query = $this->baca->get_where('LOGIN_CUST', array('CUSTCODE' => $username,'MONTH(LASTPACKAGEUPDATE)'=>$bln,'YEAR(LASTPACKAGEUPDATE)'=>$thn));
		$cek = $query->num_rows();
		if($cek != 0){return true;}else{return false;}
	}

}
// END Login_model Class

/* End of file login_model.php */ 
/* Location: ./system/application/model/login_model.php */