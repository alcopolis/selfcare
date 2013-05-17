<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 * this is used for login controller also
	 * Maps to the following URL
	 * 		http://example.com/index.php/c_login
	 *	- or -  
	 * 		http://example.com/index.php/c_login/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/c_login/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	function __construct() {
        parent::__construct();  
		session_start();
		$this->load->helper(array('form','url'));
		$this->load->model('M_login', '', TRUE);
    }   	
	
	public function index()
	{
		if ($this->session->userdata('login') == TRUE)
		{
			redirect('welcome');
		}
		else
		{
			$this->load->view('v_login');
		}
	}
		
	public function process_login(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == TRUE)
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			if($this->M_login->check_existingpwd($username) > 0){
				//check apakah user sudah terdafatar di customer password tabel
				//echo $this->db->last_query();
				if($this->M_login->check_login($username,$password) == TRUE){
					$data = array('username' => $username, 'login' => TRUE);
					$this->session->set_userdata($data);
					redirect('welcome');
				}else{
					$this->session->set_flashdata('message', 'Incorrect Username or Password');
					$this->load->view('v_login');
				}				
				
			}else{
				//echo $this->db->last_query() . "<br />";
				if($this->M_login->check_exsistingcustomer($username,$password)== TRUE ){
					$customers = $this->M_login->get_customer($username)->row();
										
					//encrypted process
					$key = 'E1nk3y';
					$string = $password;
					$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), 
						$string, MCRYPT_MODE_CBC, md5(md5($key))));
					$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), 
						MCRYPT_MODE_CBC, md5(md5($key))), "\0");
					//END of encrypted process
					
					//set data for inserting in user password
					$userpwddata = array('CUSTOMERID' => $customers->customerid,
						'PASSWORD' => $encrypted,'CUSTOMERNAME' =>$customers->customername
					);	
					
					$this->M_login->add_new_user($userpwddata);
					
					$data['default']['customercode']= $customers->customercode;
					$data['default']['customername']= $customers->customername;
					$data['default']['password']= $password;
					$data['default']['custid'] =  $customers->customerid;
					$data['form_action'] = "update_pwd";
					$data['err_msg'] = "";
			
					$this->load->view('header',$data);
					$this->load->view('v_changepwd',$data);
					$this->load->view('footer');
					
				}else{
					//user name dan password salah
					$this->session->set_flashdata('message', 'Incorrect Username or Password');
					$this->load->view('v_login');					
				}
				
			}

		}else{
			$this->session->set_flashdata('message', 'Please Fill user name and password field');
			$this->load->view('v_login');
		}
		
	}
	
	public function update_pwd(){
		$curpass = $_POST['curr-pass'];
		$pwd1 = $_POST['new-pass'];
		$pwd2 = $_POST['confirm-pass'];
		$custid = $_POST['custid'];
		
		if ($pwd1!=$pwd2){
			$customers = $this->M_login->get_customer($username)->row();
			$data['err_msg'] = "Password unmatch!";
			$data['default']['customercode']= $customers->customercode;
			$data['default']['customername']= $customers->customername;
			$data['default']['password']= $password;
			$data['default']['custid'] =  $customers->customerid;
			$data['form_action'] = "update_pwd";
			
			$this->load->view('header',$data);
			$this->load->view('v_changepwd',$data);
			$this->load->view('footer');
		}else{
			$key = 'E1nk3y';
			$string = $pwd1;
			$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), 
				$string, MCRYPT_MODE_CBC, md5(md5($key))));
			$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, 
				md5(md5($key))), "\0");
			
			$userpwddata = array('PASSWORD' => $encrypted);
			$this->M_login->upadate_pwd($userpwddata,$custid);
			redirect('welcome');
		}
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect("c_login/index","refresh");
	}
}

/* End of file c_login.php */
/* Location: ./application/controllers/c_login.php */