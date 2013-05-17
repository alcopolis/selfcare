<?php
/**
 * Login_model Class
 *
 */
class M_login extends CI_Model {
	/**
	 * Constructor
	 */
	function __construct()
    {
        parent::__construct();
    }
	
	// Inisialisasi nama tabel user
	var $table = 't_preview_customer';
	
	/**
	 * Cek tabel user, apakah ada user dengan username dan password tertentu
	 */
	function check_login($username, $password)
	{
		$key = 'E1nk3y';
		$string = md5($password);
		//$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
		//$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
		
		$this->db->select('COUNT(*) AS `numrows`');
		$this->db->from('`CUSTOMER_PASSWORD` , `t_preview_customer` '); 
		$this->db->where('`t_preview_customer`.`customerid`=`CUSTOMER_PASSWORD`.`CUSTOMERID`'); 
		$this->db->where('`t_preview_customer`.`customercode`',$username);
		//$this->db->where('`CUSTOMER_PASSWORD`.`PASSWORD`',md5($encrypted));
		$this->db->where('`CUSTOMER_PASSWORD`.`PASSWORD`',$string);
		$hasil = $this->db->count_all_results();
		
		if ($hasil > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
// check user yang login apakah sudah terdaftar sebagai pelanggan
	function check_exsistingcustomer($custcode,$custdob){
			
		$query = $this->db->get_where($this->table, array("customercode" => $custcode,
					"DATE_FORMAT(dob,'%d%m%Y')" => $custdob), 1, 0);		
		if ($query->num_rows() > 0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
// chek apakah user sudah terdaftar di customer password	
	function check_existingpwd($custcode){
		
		$this->db->select('COUNT(*) AS `numrows`');
		$this->db->from('`CUSTOMER_PASSWORD` , `t_preview_customer` '); 
		$this->db->where('`t_preview_customer`.`customerid`=`CUSTOMER_PASSWORD`.`CUSTOMERID`'); 
		$this->db->where('`t_preview_customer`.`customercode`',$custcode);
		return $this->db->count_all_results();
		
	}
	
	function get_customer($custcode){
		
		$this->db->select('*');
		$this->db->from('t_preview_customer '); 
		$this->db->where('customercode',$custcode);
		return $this->db->get();
	}
	
	function add_new_user($userpwddata){
		$this->db->insert('CUSTOMER_PASSWORD', $userpwddata);
	}
	
	function upadate_pwd($userpwd,$custid){
		$this->db->where('CUSTOMERID', $custid);
		$this->db->update('CUSTOMER_PASSWORD', $userpwd);
	}

}
// END Login_model Class

/* End of file login_model.php */ 
/* Location: ./system/application/model/login_model.php */