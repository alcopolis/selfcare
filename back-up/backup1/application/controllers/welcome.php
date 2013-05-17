<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 * this is used for login controller also
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
        parent::__construct();  
		$this->load->model('M_cust', '', TRUE);
    }
	 
	 
	public function index()
	{
		if ($this->session->userdata('login') == TRUE)
		{
			$this-> display_hompage($this->session->userdata('username'));
		}
		else
		{
			redirect('c_login');
		}
	}
	function display_hompage($custcode)
	{
		$this->load->library('table');
		
		$uri_segment = 3;
		$offset = $this->uri->segment($uri_segment);
		
		$customer = $this->M_cust->get_cust_bycode($custcode)->row();
		$packages = $this->M_cust->get_package_homeview($customer->CUSTOMERID)->result();
		
		$data['default']['customercode']= $customer->CUSTOMERCODE;
		$data['default']['customername']= $customer->CUSTOMERNAME;
		$data['default']['email']= $customer->EMAIL;
		
		$tmpl = array( 'table_open'    => '<table id="tbl-view" border="0" cellpadding="0" cellspacing="0">',
						  'row_alt_start'  => '<tr class="zebra">',
							'row_alt_end'    => '</tr>'
						  );
		$this->table->set_template($tmpl);

		// Set heading untuk tabel
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('No', 'Package Name','Dsecription','Max Chanel');
			
		// Penomoran baris data
		$i = 0 + $offset;
			
		foreach ($packages as $package)
			{
			// Penyusunan data baris per baris, perhatikan pembuatan link untuk updat dan delete
			$this->table->add_row(++$i, $package->PACKAGE, $package->DESCRIPTION, $package->MAXCHANEL);
			}
			$data['table'] = $this->table->generate();		
		
		$this->load->view('header',$data);
		$this->load->view('welcome_message',$data);
		$this->load->view('footer');
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */