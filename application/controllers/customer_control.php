<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_control extends CI_Controller {

//constructor 	
	function __construct() {
        parent::__construct();  
		$this->load->model('Customer_model', '', TRUE);
		$this->client_logon = $this->session->userdata('logged');
		$this->client_access = $this->session->userdata('aktif');
		$this->client_cluster = $this->session->userdata('daerah');

		if($this->client_logon==''){
			redirect('login');
		}
    }
// end of constructor

// fungsi index pertama kali pada saat controller di panggil
	public function index()
	{
		if($this->client_logon){
			if($this->client_access=='0'){	redirect('logout');	}
			$this->view_cust_info($this->client_logon);
		}else{
			redirect('login');
		}
	}
// end of index

// fungsi untuk menampilkan data customer 
	public function view_cust_info($custcode)
	{
		
		$customer = $this->Customer_model->get_cust_bycode($custcode)->row();
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
		$data['err_msg'] = '';

		$this->load->view('header');
		$this->load->view('customer_view', $data);
		$this->load->view('footer');
		
	}
// end of function view_cust_info($custcode)
	
// fungsi untuk menampilkan perubahan password
	public function change_profile()
	{
			$customers = $this->Customer_model->get_password_data($this->client_logon)->row();	
			$data['default']['email'] = $customers->EMAIL;
			$data['default']['hp'] = $customers->MOBILE;
			$data['default']['customercode']=$customers->CUSTOMERCODE;
			$data['err_msg'] ='';
			$data['firstpwd']=FALSE;
			
			$this->load->view('header');
			$this->load->view('pwd_view', $data);
			$this->load->view('footer');
	}
// end of function change pwd	

// fungsi update profil digunakan untuk update data profile
	public function update_profile()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('curr-pass', 'Current Password', 'required');
		$this->form_validation->set_rules('new-pass', 'New Password', 'required|min_length[6]|max_length[20]');
		$this->form_validation->set_rules('confirm-pass', 'Confirm Password', 'required|matches[new-pass]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('hp','Mobile Number', 'trim|required|xss_clean|integer');

		if($this->form_validation->run()==FALSE){
			if(form_error('curr-pass')){
				$data['err_msg']=form_error('curr-pass');
			}elseif(form_error('new-pass')){
				$data['err_msg']=form_error('new-pass');
			}elseif(form_error('confirm-pass')){
				$data['err_msg']=form_error('confirm-pass');
			}elseif(form_error('email')){
				$data['err_msg']=form_error('email');
			}elseif(form_error('hp')){
				$data['err_msg']=form_error('hp');
			}
			
			$customers = $this->Customer_model->get_password_data($this->client_logon)->row();
		
			$data['default']['email'] = $customers->EMAIL;
			$data['default']['hp'] = $customers->MOBILE;
			$data['default']['customercode']= $this->client_logon;
						
			$this->load->view('header');
			$this->load->view('pwd_view', $data);
			$this->load->view('footer');
		}else{
			
			$cekcurpas = $this->Customer_model->cek_curpas($this->client_logon,sha1($_POST['curr-pass']));
			if($cekcurpas){
				$update_array = array(
    	           'CUSTPWD' => sha1($_POST['new-pass']),
        	       'EMAIL' => $_POST['email'],
            	   'MOBILE' => $_POST['hp']
	            );
				$this->Customer_model->update_pwd($this->client_logon,$update_array);
				redirect('index');
				
			}else{
				$customers = $this->Customer_model->get_password_data($this->client_logon)->row();
		
				$data['default']['email'] = $customers->EMAIL;
				$data['default']['hp'] = $customers->MOBILE;
				$data['default']['customercode']= $this->client_logon;
				$data['err_msg']='Invalid Current Password';
							
				$this->load->view('header');
				$this->load->view('pwd_view', $data);
				$this->load->view('footer');
			}
			
		}
	}
// end of update profile


}
/* End of file customer_control.php */
/* Location: ./application/controllers/customer_control.php */