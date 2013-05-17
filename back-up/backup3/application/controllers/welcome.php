<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Login_model');
		$this->load->model('Customer_model');
		$this->client_logon = $this->session->userdata('logged');
	}
	 
	public function index(){
		if($this->client_logon){
			$this->display_hompage($this->session->userdata('logged'));
		}else{
			redirect('login');
		}
	}//end of index
	 
	public function login(){
		if($_POST){
			$user = $this->Login_model->validate($_POST['username'], $_POST['password']);
			if($user == TRUE){
				$chkpwd = $this->Login_model->first_pwd($_POST['username'], $_POST['password']);
				if ($chkpwd == true){
					$this->must_change_pwd($this->session->userdata('logged'));
				}else{ 
					$this->Login_model->last_login($this->session->userdata('logged'));
					redirect('index');
				}
			}else{
				$data['pesan'] = 'Invalid username or password';
				$this->load->view('header');
				$this->load->view('vlogin', $data);
				$this->load->view('footer');
			}
		}else{
			$this->load->view('header');
			$this->load->view('vlogin');
			$this->load->view('footer');
		}
	}// end of login
	 
	public function logout(){
		$this->Login_model->logout();
		redirect('login');
	}//end of log out
	
	public function display_hompage($custcode){
		$customer = $this->Customer_model->get_cust_bycode($custcode)->row();
		$packages = $this->Customer_model->get_package_homeview($customer->CUSTOMERID)->result();
		
		$data['default']['customercode']= $customer->CUSTOMERCODE;
		$data['default']['customername']= $customer->CUSTOMERNAME;
		$data['default']['email']= $customer->EMAIL;
		
		$this->load->view('header',$data);
		$this->load->view('vhome', $data);
		$this->load->view('footer');
	}//end of display_homepage
	
	public function must_change_pwd($custcode){
		$customer = $this->Customer_model->get_cust_bycode($custcode)->row();
		$packages = $this->Customer_model->get_package_homeview($customer->CUSTOMERID)->result();
		
		$data['default']['customercode']= $customer->CUSTOMERCODE;
		$data['default']['customername']= $customer->CUSTOMERNAME;
		$data['default']['email']= $customer->EMAIL;
		$data['err_msg'] ='';
		
		$this->load->view('header',$data);
		$this->load->view('vcustomerpwd', $data);
		$this->load->view('footer');
	}// end of must_change_pwd
	
	public function change_pwd(){
		if($_POST){
			
			if($_POST['curr-pass']==''){
				$data['err_msg'] = 'Please fill current password';
			}elseif($_POST['new-pass']!=$_POST['confirm-pass']){
				$data['err_msg'] = 'Confirm password not match';
			}else{
			
				$pwd = $this->Login_model->validate_pwd($this->session->userdata('logged'),
								$_POST['curr-pass'],
								$_POST['new-pass'],
								$_POST['confirm-pass']);
								
				if($pwd==TRUE){
					$userpwddata = array('CUSTPWD' => sha1($_POST['new-pass']));
					$this->Login_model->save_password($this->session->userdata('logged'),$userpwddata);
					redirect('index');
				}else{
					$data['err_msg'] = 'Invalid password';
				}
			}
			
			$customer = $this->Customer_model->get_cust_bycode($this->session->userdata('logged'))->row();
			$packages = $this->Customer_model->get_package_homeview($customer->CUSTOMERID)->result();
		
			$data['default']['customercode']= $customer->CUSTOMERCODE;
			$data['default']['customername']= $customer->CUSTOMERNAME;
			$data['default']['email']= $customer->EMAIL;
			$this->load->view('header',$data);
			$this->load->view('vcustomerpwd', $data);
			$this->load->view('footer');
		}
	}// end of change_pwd
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */