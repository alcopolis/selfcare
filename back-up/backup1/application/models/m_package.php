<?php
/**
 * Login_model Class
 *
 */
class M_package extends CI_Model {
	/**
	 * Constructor
	 */
	function __construct()
    {
        parent::__construct();
    }
	
	// Inisialisasi nama tabel user
	/**
	 * Cek tabel user, apakah ada user dengan username dan password tertentu
	 */
	function get_cust_package($custid)
	{  
		$this->db->select('t_ms_pacakge.packagename as PACKAGE');
		$this->db->select('t_ms_pacakge.description as DESCRIPTION');
		$this->db->select('t_ms_pacakge.maxchanellist as MAXCHANEL');
		$this->db->select('t_customer_package.pricem as PRICE');
		$this->db->select('t_customer_package.firstbillingdate as BILLINGDATE');
		$this->db->from('t_customer_package');
		$this->db->join('t_ms_customer', 't_customer_package.customerid = t_ms_customer.customerid');
		$this->db->join('t_ms_pacakge', 't_ms_pacakge.packageid = t_customer_package.packageid');
		$this->db->where('t_ms_customer.customerid', $custid);
		return $this->db->get();
	}

//Menampilkan data paket yang sudah dipilih oleh pelanggan
	function get_service_id()
	{
		$this->db->select('*');
		$this->db->from('t_ms_service');
		$this->db->where('tipeid','IPTV');
		$category = array("National","International FTA","Movies-A","Sports-A");
		$this->db->where_not_in('categoryid',$category);
		//$this->db->order_by('categoryid');
		
		$this->db->order_by('servicename');
		return $this->db->get();
	}
	
	function get_package($customerpackageid){
		$this->db->select('*');
		$this->db->from('t_customer_package');
		$this->db->where('customerpackageid',$customerpackageid);
		return $this->db->get();		
	}
	
	function get_channel_category()
	{
		$this->db->select('categoryid');
	    $this->db->group_by('categoryid');
	    $this->db->where('tipeid','IPTV');
		$category =array("National","International FTA","Movies-A","Sports-A");
		$this->db->where_not_in('categoryid',$category);
		$this->db->from('t_ms_service');
	    return $this->db->get();  
	}
	
	function get_ch_used($trpackid)
	{
		$this->db->select('serviceid');
		$this->db->where('CUSTOMERPACKAGEID',$trpackid);
//		$this->db->where('serviceid',$svcid);
		$this->db->from('t_customer_package_service');
		return $this->db->get();
	}

	function get_chpremium($trpackid)
	{
		$this->db->select('t_customer_package_service.serviceid as channel');
		$this->db->where('t_customer_package_service.CUSTOMERPACKAGEID',$trpackid);
		$this->db->where("t_ms_service.categoryid not in('National','International FTA','Movies-A','Sports-A')");
		$this->db->join('t_ms_service', 't_ms_service.serviceid = t_customer_package_service.serviceid');
		$this->db->from('t_customer_package_service');
		return $this->db->get();
	}
	
	function count_param($trpackid,$svcid)
	{
		$this->db->select('*');	
		$this->db->from('t_customer_package_service');
		$this->db->where('CUSTOMERPACKAGEID',$trpackid);
		$this->db->where('serviceid',$svcid);
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		return $rowcount;
		
	}
	
	function add_chn_head($head_chn)
	{
		$this->db->insert('tr_transcod', $head_chn);	
	}
	
	function update_lastpackage($custdata)
	{
		$this->db->where('CUSTOMERCODE', $this->session->userdata('username'));
		$this->db->update('t_ms_customer', $custdata);
	}
	function add_chn_detail($det_chn)
	{
		$this->db->insert('tr_transcod_t', $det_chn);	
	}
	
	function update_cur_chn($chrem,$chadd,$trpackageid)
	{
		$data = array('serviceid' => $chadd);
		$this->db->where('customerpackageid', $trpackageid);
		$this->db->where('serviceid', $chrem);
		$this->db->update('t_customer_package_service',$data);	
	}
	
	function get_lastinsert()
	{
		$this->db->select('max(transid) as terakhir');	
		$this->db->from('tr_transcod');
		$this->db->where('CUSTOMERCODE',$this->session->userdata('username'));
		return $this->db->get();
	}
}
// END Login_model Class

/* End of file login_model.php */ 
/* Location: ./system/application/model/login_model.php */