<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_cust extends CI_Controller {

	/**
	 * Constructor
	 */
	function __construct() {
        parent::__construct();  
		session_start();
		$this->load->helper(array('form','url'));
		$this->load->model('M_cust', '', TRUE);
    }   	
	
	/**
	 * Memeriksa user state, jika dalam keadaan login akan menampilkan halaman absen,
	 * jika tidak akan meredirect ke halaman login
	 */
	function index()
	{
		// Hapus data session yang digunakan pada proses update data absen
		
		//$this->session->unset_userdata('custcode');			
		if ($this->session->userdata('login') == TRUE)
		{
			$this->view_cust_info($this->session->userdata('username'));
		}
		else
		{
			redirect('c_login');
		}
	}
	
	function view_cust_info($custcode)
	{
		$customer = $this->M_cust->get_cust_bycode($custcode)->row();
		
		// buat session untuk menyimpan data primary key (id_absen)
		//$this->session->set_userdata('custcode', $customer->cst_code);
		
		// Data untuk mengisi field2 form
		$data['default']['customercode']= $customer->CUSTOMERCODE;
		$data['default']['customername']= $customer->CUSTOMERNAME;
		$data['default']['address']= $customer->CUSTOMERADDRESS;
		//$data['default']['city']= $customer->'';
		$data['default']['idtype']= $customer->IDENTIFICATIONTYPE;
		$data['default']['idno']= $customer->IDENTIFICATIONNUMBER;
		$data['default']['phone']= $customer->PHONE;
		$data['default']['mobile']= $customer->MOBILE;
		$data['default']['email']= $customer->EMAIL;
		$data['default']['billing']= $customer->BILLINGADDRESS;
		$data['default']['lastupdate']= $customer->LASTPACKAGEUPDATED;

		$this->load->view('header',$data);
		$this->load->view('v_customer', $data);
		$this->load->view('footer');		

	}
}
// END Absen Class

/* End of file absen.php */
/* Location: ./system/application/controllers/absen.php */