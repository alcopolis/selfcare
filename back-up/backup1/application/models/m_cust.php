<?php
/**
 * Login_model Class
 *
 */
class M_cust extends CI_Model {
	/**
	 * Constructor
	 */
	function __construct()
    {
        parent::__construct();
    }
	
	// Inisialisasi nama tabel user
	var $table = 't_ms_customer';
	
	/**
	 * Cek tabel user, apakah ada user dengan username dan password tertentu
	 */
	function get_datacode($custcode)
	{
		$this->db->select('CUSTOMERID as custid');
		$this->db->select('CUSTOMERCODE as custcode');
		$this->db->where('customercode', $custcode);
		return $this->db->get($this->table);
	}
	
	function get_cust_bycode($custcode)
	{  
		$this->db->select('*');
		$this->db->where('customercode', $custcode);
		return $this->db->get($this->table);
	}
	
	function get_package_homeview($custid)
	{
		$this->db->select('t_customer_package.customerpackageid as pktid');
		$this->db->select('t_ms_package.packagename as PACKAGE');
		$this->db->select('t_ms_package.description as DESCRIPTION');
		$this->db->select('t_ms_package.maximalchannellist as MAXCHANEL');
		$this->db->select('t_customer_package.pricem as PRICE');
		$this->db->select('t_customer_package.firstbillingdate as BILLINGDATE');
		$this->db->from('t_customer_package');
		$this->db->join('t_ms_customer', 't_customer_package.customerid = t_ms_customer .customerid');
		$this->db->join('t_ms_package', 't_ms_package.packageid = t_customer_package.packageid');
		$this->db->where('t_ms_customer.customerid', $custid);
		return $this->db->get();	
	}
	function upadate_pwd($userpwd,$custid){
		$this->db->where('CUSTOMERID', $custid);
		$this->db->update('CUSTOMER_PASSWORD', $userpwd);
	}

}
// END Login_model Class

/* End of file login_model.php */ 
/* Location: ./system/application/model/login_model.php */