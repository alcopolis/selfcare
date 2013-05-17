<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_billing extends CI_Controller {

	/**
	 * Constructor
	 */
	function __construct() {
        parent::__construct();  
		session_start();
		$this->load->library('pdf');
		$this->pdf->fontpath = 'font/'; // Specify font folder
		$this->load->helper(array('form','url'));
		$this->load->model('M_billing', '', TRUE);
		$this->load->model('M_cust', '', TRUE);
    }   	
	
	/**
	 * Memeriksa user state, jika dalam keadaan login akan menampilkan halaman absen,
	 * jika tidak akan meredirect ke halaman login
	 */
	function index()
	{
		// Hapus data session yang digunakan pada proses update data absen
		
		//$this->session->unset_userdata('username');			
		if ($this->session->userdata('login') == TRUE)
		{
			$this->cepat_net_billing_info($this->session->userdata('username'));
		}
		else
		{
			redirect('c_login');
		}
	}
	
	function cepat_net_billing_info($custcode)
	{
		$this->load->library('table');
		
		$uri_segment = 3;
		$offset = $this->uri->segment($uri_segment);
		
		$customer = $this->M_cust->get_cust_bycode($custcode)->row();
	    		
		$data['default']['customercode']= $customer->CUSTOMERCODE;
		$data['default']['customername']= $customer->CUSTOMERNAME;
		$data['default']['email']= $customer->EMAIL;
		
		$bill_summs = $this->M_billing->get_bill_summary($custcode)->result();
		//echo $this->db->last_query();
		$tmpl = array( 'table_open'    => '<table id="tbl-view" border="0" cellpadding="0" cellspacing="0">',
						  'row_alt_start'  => '<tr class="zebra">',
							'row_alt_end'    => '</tr>'
						  );
						  
		$this->table->set_template($tmpl);

		// Set heading untuk tabel
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('No', 'Billing Date','Ending Ballance','Display');
			
		// Penomoran baris data
		$i = 0 + $offset;
		//screen untuk popup javascript
		foreach ($bill_summs as $bill)
			{
			$this->table->add_row(++$i,
					$bill->TRANSACTIONDATE,
					$bill->AMOUNT,
					anchor('c_billing/display_detail_billing/'.$bill->HISTORYID,"DISPLAY",array('class' => 'c_billing'))
//					anchor('c_billing/display_detail_billing/'.$bill->HISTORYID,$bill->INVOICENO,array('class' => 'c_package'))
			);
		}
			
			$data['table'] = $this->table->generate();		

		$this->load->view('header',$data);
		$this->load->view('v_billing',$data);
		$this->load->view('footer');
	}

	function display_detail_billing($historyid){
		$bilhs = $this->M_billing->get_billing_h($historyid)->row();
		//echo $this->db->last_query();
		$data['kdcust']= $bilhs->CUSTOMERCODE;//kode pelanggan
		$data['nmcust']= $bilhs->CUSTOMERNAME;//nama pelanggan
		$data['ctrtno']= $bilhs->CONTRACTNO;// Nomor kontrak
		$data['invoice']= $bilhs->INVOICENO;// no invoice
		$data['invno']= $bilhs->INVno;// no invoice bracket
		$data['trdate']= $bilhs->TRANSACTIONDATE;//tanggal cetak
		$data['jthtmp']= $bilhs->RECEIPTDATE; // jatuh tempo
		$data['ttltagihan']= $bilhs->AMOUNT;//total tagihan
		$data['billaddr']= $bilhs->BILLINGADDRESS;// alamat penagihan
		$data['phone']= $bilhs->PHONE;
		$data['mobile']= $bilhs->MOBILE;
		$data['email']= $bilhs->email;
		$data['npwp']= "";//$bilhs->npwp;
		$data['fax']= "";//$bilhs->fax;
		
		$date = new DateTime($bilhs->TRANSACTIONDATE);
		$bln = $date->format('m');
		$thn = $date->format('Y');
		$data['bildet'] = $this->M_billing->get_billing_d($historyid)->result();//get billing summary
		$data['biladm'] = $this->M_billing->get_adm($bilhs->CUSTOMERCODE,$bln,$thn)->result();//get billing administration PPN and registration
		//$data['bilfoot']= $this->M_billing->get_adm($bilhs->CUSTOMERCODE,$bln,$thn)->result();//get billing administration
		//$this->M_billing->get_adm($bilhs->CUSTOMERCODE,$bln,$thn)->result();
		//echo $this->db->last_query();
		$this->load->view('v_billingdet',$data);	
	}

}
// END Absen Class

/* End of file absen.php */
/* Location: ./system/application/controllers/absen.php */