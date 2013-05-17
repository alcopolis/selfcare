<?php
/**
 * Login_model Class
 *
 */
class Package_model extends CI_Model {
	/**
	 * Constructor
	 */
	function __construct()
    {
        parent::__construct();
		$this->baca = $this->load->database('altdb', TRUE);
    }
	
// for alacarte view pacakge

		function ala_get_service_id(){
			$this->baca->select('*');
			$this->baca->from('t_ms_service');
			$category = array("Movies-A","Sports-A");
			$this->baca->where_in('categoryid',$category);
			return $this->baca->get();	
		}
		
		function ala_get_channel_category(){
			$this->baca->select('categoryid');
		    $this->baca->group_by('categoryid');
			$category =array("Movies-A","Sports-A");
			$this->baca->where_in('categoryid',$category);
			$this->baca->from('t_ms_service');
		    return $this->baca->get();
		}
		
		function ala_get_ch_used($trpackid)
		{	
			$this->baca->select('serviceid');
			$this->baca->where('CUSTOMERPACKAGEID',$trpackid);
	//		$this->baca->where('serviceid',$svcid);
			$this->baca->from('t_customer_package_service');
	
			return $this->baca->get();
		}
			
		
//end of alacarte view package
	
	function get_package_name($pktid)
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
		$this->baca->where('t0.customerpackageid', $pktid);
		$this->baca->group_by('t0.customerpackageid');

		return $this->baca->get();	
	}
	
	
	function get_cust_package($custid)
	{  
		$this->baca->select('t_ms_pacakge.packagename as PACKAGE');
		$this->baca->select('t_ms_pacakge.description as DESCRIPTION');
		$this->baca->select('t_ms_pacakge.maxchanellist as MAXCHANEL');
		$this->baca->select('t_customer_package.pricem as PRICE');
		$this->baca->select('t_customer_package.firstbillingdate as BILLINGDATE');
		$this->baca->from('t_customer_package');
		$this->baca->join('t_ms_customer', 't_customer_package.customerid = t_ms_customer.customerid');
		$this->baca->join('t_ms_pacakge', 't_ms_pacakge.packageid = t_customer_package.packageid');
		$this->baca->where('t_ms_customer.customerid', $custid);
		return $this->baca->get();
	}

//Menampilkan data paket yang sudah dipilih oleh pelanggan
	function get_service_id()
	{
		$this->baca->select('*');
		$this->baca->from('t_ms_service');
		$this->baca->where('tipeid','IPTV');
		$category = array("National","International FTA","Movies-A","Sports-A");
		$this->baca->where_not_in('categoryid',$category);
		//$this->db->order_by('categoryid');
		
		$this->baca->order_by('servicename');
		return $this->baca->get();
	}
	
	function get_package($customerpackageid){
		$this->baca->select('*');
		$this->baca->from('t_customer_package');
		$this->baca->where('customerpackageid',$customerpackageid);
		return $this->baca->get();		
	}
	
	function get_channel_category()
	{
		$this->baca->select('categoryid');
	    $this->baca->group_by('categoryid');
	    $this->baca->where('tipeid','IPTV');
		$category =array("National","International FTA","Movies-A","Sports-A");
		$this->baca->where_not_in('categoryid',$category);
		$this->baca->from('t_ms_service');
	    return $this->baca->get();  
	}
	
	function get_ch_used($trpackid)
	{	
		$this->baca->select('t0.customerpackageid as pktid');
		$this->baca->select('t1.serviceid as serviceid');
		$this->baca->from('t_customer_package t0');
		$this->baca->join('t_customer_package_service t1','t0.customerpackageid = t1.customerpackageid','');
		$this->baca->join('t_ms_customer t3','t3.CUSTOMERID = t0.customerid','');
		$this->baca->where('t3.CUSTOMERCODE',$this->session->userdata('logged'));

		return $this->baca->get();
	}
	
/*	function get_ch_used_edit($trpackid)
	{	
		$this->db->select('serviceid');
		$this->db->where('CUSTOMERPACKAGEID',$trpackid);
//		$this->db->where('serviceid',$svcid);
		$this->db->from('t_customer_package_service');

		return $this->db->get();
	}
*/

	function get_chpremium($trpackid)
	{
		$this->baca->select('t_customer_package_service.serviceid as channel');
		$this->baca->where('t_customer_package_service.CUSTOMERPACKAGEID',$trpackid);
		$this->baca->where("t_ms_service.categoryid not in('National','International FTA','Movies-A','Sports-A')");
		$this->baca->join('t_ms_service', 't_ms_service.serviceid = t_customer_package_service.serviceid');
		$this->baca->from('t_customer_package_service');
		return $this->baca->get();
	}
	
	function count_param($trpackid,$svcid)
	{
		$this->baca->select('*');	
		$this->baca->from('t_customer_package_service');
		$this->baca->where('CUSTOMERPACKAGEID',$trpackid);
		$this->baca->where('serviceid',$svcid);
		$query = $this->baca->get();
		$rowcount = $query->num_rows();
		return $rowcount;
		
	}
	
	function add_chn_head($head_chn)
	{
		$this->db->insert('tr_transcod', $head_chn);	
	}
	function update_lastpackage($custdata)
	{
		$this->db->where('CUSTCODE', $this->session->userdata('logged'));
		//$this->db->update('t_ms_customer', $custdata);		
		$this->db->update('LOGIN_CUST', $custdata);
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
		$this->baca->select('max(transid) as terakhir');	
		$this->baca->from('tr_transcod');
		$this->baca->where('CUSTOMERCODE',$this->session->userdata('logged'));
		return $this->baca->get();
	}
}
// END Login_model Class

/* End of file login_model.php */ 
/* Location: ./system/application/model/login_model.php */