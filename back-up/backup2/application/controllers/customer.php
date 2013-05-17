<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

	/**
	 * Constructor
	 */
	function __construct() {
        parent::__construct();  
		$this->load->model('Customer_model', '', TRUE);
		$this->load->model('Login_model', '', TRUE);
		$this->client_logon = $this->session->userdata('logged');
    }   	
	
	/**
	 * Memeriksa user state, jika dalam keadaan login akan menampilkan halaman absen,
	 * jika tidak akan meredirect ke halaman login
	 */
	function index(){
		// Hapus data session yang digunakan pada proses update data absen
		
		//$this->session->unset_userdata('custcode');			
		if($this->client_logon){
			$this->view_cust_info($this->session->userdata('logged'));
		}else{
			redirect('login');
		}
	}
	
	function view_cust_info($custcode){
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

		$this->load->view('header',$data);
		$this->load->view('vcustomer', $data);
		$this->load->view('footer');		

	}//end of view_cust_info
	

public function change_pwd(){
		$customer = $this->Customer_model->get_cust_bycode($this->session->userdata('logged'))->row();
		$packages = $this->Customer_model->get_package_homeview($customer->CUSTOMERID)->result();
		
		$data['default']['customercode']= $customer->CUSTOMERCODE;
		$data['default']['customername']= $customer->CUSTOMERNAME;
		$data['default']['email']= $customer->EMAIL;
		$data['err_msg'] ='';
		
		$this->load->view('header',$data);
		$this->load->view('vcustomerpwd', $data);
		$this->load->view('footer');
	}// end of change_pwd
	
	
	function forgetpwd(){
		$data['msg']='';
		$this->load->view('vforgetpwd',$data);
	}
		
	function resetpwd(){
		if($_POST){
			$pwd = $this->Login_model->check_mail($_POST['email'])->result();			
			$i=0;
			foreach ($pwd as $row)
			{
				$custcode = $row->CUSTCODE;
				$i++;
			}
			if($i>0){
				$respwd = $this->randomPassword();
				
				$userpwddata = array('CUSTPWD' => sha1($respwd));
				//$this->Login_model->save_password($custcode,$userpwddata);
				$this->sendmail_pwd($_POST['email'],$respwd);
				
				$data['msg']='new password has been sent to ' . $_POST['email'];
				$this->load->view('vforgetpwd',$data);				
			}else{
				$data['msg']='e-mail not registered';
				$this->load->view('vforgetpwd',$data);			
			}
		}else{
			$data['msg']='email not registered';
			$this->load->view('vforgetpwd',$data);		
		}
	}
	
	function randomPassword() {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
    	return implode($pass); //turn the array into a string
	}
	
	function sendmail_pwd($email,$pwd){
		$this->load->library('email');

		$this->email->from('admin@cust.cepat.net.id', 'Administrator');
		$this->email->to($email);
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');
		
		$this->email->subject('Password Reset');
		$body = 'Dear Valued Customer,<br />';
		
		$body .= 'Thank you for joining Cepat.net, We have receive your request to reset password
				  for http://selfcare.cepat.net.id login.<br />';
		$body .= 'Your details are as follows:<br />';
		$body .= 'Logon email : '. $email .'<br />';
		$body .= 'Password : '. $pwd . '<br />';
		$body .= 'Please change the password after you login, then your old password will be replaced by the new one.<br />';
		$body .= 'This email was generated by system, please do not reply to sender!<br />';
		$body .= 'Regards,';
		$body .= 'The Code Project Team';
		$body .= 'This message was created by The Code Project';

		$this->email->message($body);
		
		$this->email->send();
		
		echo $this->email->print_debugger();
	}
	
}
// END customer

/* End of file customer.php */
/* Location: ./application/controllers/customer.php */