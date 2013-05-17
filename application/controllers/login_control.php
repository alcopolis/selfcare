<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_control extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
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
// fungsi constructor
	function __construct(){
		parent::__construct();
		$this->load->model('Login_model');
		$this->client_logon = $this->session->userdata('logged');
		$this->client_access = $this->session->userdata('aktif');
		$this->client_cluster = $this->session->userdata('daerah');
		//$this->index();
	}
// end of constructor
	 	 
// fungsi pertama kali welcome controller dipanggil
	public function index()
	{
		if($this->client_logon){
			if($this->client_access=='0'){
				redirect('logout');
			}
			$this->home_page($this->session->userdata('logged'));
		}else{
			redirect('login');
		}
	}
// end fungsi index

// fungsi homepage digunakan untuk menampikan data pertama kali pada saat pelanggan login
	public function home_page($custcode)
	{	
		//$data['home']='';
		$this->load->view('header');
		$this->load->view('home_view');
		$this->load->view('footer');
	}
//end of homepage function

// fungsi login untuk melakukan pengecekan login 
	public function login()
	{	
		if($_POST){			
			if($_POST['username']==''){
				$data['pesan'] = 'Harap isi id pelanggan anda!';
			}elseif($_POST['password']==''){
				$data['pesan'] = 'Harap Isi password anda!';
			}else{
				$userlogin = $this->Login_model->validate($_POST['username'], $_POST['password']);
				if(($userlogin == '1') || ($userlogin == '3')){
					// user tersebut pertama kali login dan belum melakukan aktivasi user dan password
					$this->must_change_pwd($_POST['username']);
					$data['pesan'] = '';
				}elseif($userlogin=='2'){
					$this->Login_model->last_login($_POST['username']);
					$data['pesan'] = '';
					redirect('index');
				}elseif($userlogin=='4'){
					$data['pesan'] = 'ID Pelanggan atau password salah, atau belum terdaftar!';
				}else{
					$data['pesan'] = 'ID Pelanggan atau password salah, atau belum terdaftar!';
				}	
			}
			if($data['pesan']!=''){
				$this->load->view('header');
				$this->load->view('login_view',$data);	
				$this->load->view('footer');
			}
		}else{
			if($this->client_logon){
				$this->home_page($this->session->userdata('logged'));
			}else{
				$this->load->view('header');
				$this->load->view('login_view');	
				$this->load->view('footer');
			}
		}
	}
//end fungsi login

// fungsi untuk memaksa user untuk merubah password untuk pertama kali
	public function must_change_pwd($custcode)
	{
		$customers = $this->Login_model->get_data_pelanggan($custcode)->row();
		
		$data['default']['email'] = $customers->EMAIL;
		$data['default']['hp'] = $customers->MOBILE;
		$data['default']['customercode']= $custcode;
		$data['err_msg'] ='';
		
		$this->load->view('header');
		$this->load->view('firstpwd_view', $data);
		$this->load->view('footer');
	}	
// end of must_change_password

// fungsi untuk aktivasi password pertama kali
	public function activate_pwd()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('curr-pass', 'Password', 'required');
		$this->form_validation->set_rules('new-pass', 'New Password', 'required|min_length[6]|max_length[20]');
		$this->form_validation->set_rules('confirm-pass', 'Confirm Password', 'required|matches[new-pass]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('hp','Mobile Number', 'trim|required|xss_clean|integer');

		if($this->form_validation->run()==FALSE){
			if(form_error('curr-pass')){
				$data['err_msg']='Current password !';
			}elseif(form_error('new-pass')){
				$data['err_msg']='New password must be 6 digit max 20 digit!';
			}elseif(form_error('confirm-pass')){
				$data['err_msg']='Confirm password not match';
			}elseif(form_error('email')){
				$data['err_msg']='Invalid email format!';
			}elseif(form_error('hp')){
				$data['err_msg']='Invalid mobile no format!';
			}
			
			$customers = $this->Login_model->get_data_pelanggan($this->client_logon)->row();
		
			$data['default']['email'] = $customers->EMAIL;
			$data['default']['hp'] = $customers->MOBILE;
			$data['default']['customercode']= $this->client_logon;
						
			$this->load->view('header');
			$this->load->view('firstpwd_view', $data);
			$this->load->view('footer');
		}else{
			$passkey = $this->_create_salt();
			$update_array = array(
               'CUSTPWD' => sha1($_POST['new-pass']),
               'EMAIL' => $_POST['email'],
               'MOBILE' => $_POST['hp'],
			   'SALTKEY' => $passkey
            );
			
			$this->Login_model->update_pwd($this->client_logon,$update_array);
			
			$this->homepage($this->client_logon,$_POST['email'],$passkey,$_POST['new-pass']);
		}
	}
// end of function activate_pwd

//function untuk menampilkan home page ketika user berhasil login
	public function homepage($custcode,$mailto,$saltkey,$newpass)
	{	
		
		$customers = $this->Login_model->get_data_pelanggan($custcode)->row();
		$emailbody ='';
	// code untuk mengirimkan email aktivasi kepada pelanggan 
		$this->load->library('email');
		$config['protocol']  = 'smtp';
		$config['smtp_host'] = 'mail.cepat.net.id';
		$config['smtp_port'] = 25;
		$config['smtp_user'] = 'rachmat.web@cepat.net.id';//'qorianku@gmail.com';
		$config['smtp_pass'] = 'moratel';//'1234567890';
		$config['priority']  = 2;
		$config['mailtype']  = 'html';
		$config['charset']   = 'utf-8';
		$config['wordwrap']  = TRUE;
		$this->email->initialize($config);
		$this->email->from('admin-selfcare@cepat.net.id', 'Admin Selfcare');
		$this->email->to($mailto);
		//$this->email->cc('deka@somemail.com');
		$this->email->bcc('rachmat.web@cepat.net.id');
		$this->email->subject('Email Verifikasi');
		$emailbody = $emailbody . "<div style='font-family:Arial, sans-serif; color:#004993'><p>Pelanggan yang terhormat <span style='font-weight:bold; font-style:italic;'>" . $customers->CUSTOMERNAME . "</span>,</p>"; 
		$emailbody = $emailbody . "<p>Selamat datang di layanan Webselfcare CEPATnet. <br />"; 
		$emailbody = $emailbody . "Berikut ini adalah ID Pelanggan dan password baru anda</p>";
		$emailbody = $emailbody . "<p>ID Pelanggan Anda 	: " .$custcode . "</p>";
		$emailbody = $emailbody . "<p>Password baru Anda	: " .$newpass . "</p>";
		$emailbody = $emailbody . "<p>Untuk aktifasi akun selfcare anda, silahkan klik link berikut ini,<p>";
		$emailbody = $emailbody . "<p>" . base_url() . "login_control/verify/" .$saltkey . "</p>"; 
		$emailbody = $emailbody . "<p>Terima kasih atas kepercayaan anda dalam menggunakan jasa dan layanan CEPATnet.</p>"; 
		$emailbody = $emailbody . "<p>Terimakasih,<br /> CEPATnet <br /></p></div>"; 
		$emailbody = $emailbody . "<p style='font-size:11px; color:#000;'>Email ini merupakan email otomatis, harap jangan membalas ke alamat email pengirim!</p>";
		
		$this->email->message($emailbody);
		$this->email->send();
	// end of send mail
		$data['default']['custmail'] = $mailto;		
		$data['default']['customercode']=$custcode;
	//	$data['default']['debuger'] = $this->email->print_debugger();
		$data['default']['status']=FALSE;
		
		$this->load->view('header');
		$this->load->view('success_view', $data);
		$this->load->view('footer');
	}
// end of homepage function

// fungsi untuk aktivasi verifikasi setelah perubahan password
	public function verify($saltkey)
	{
		$cekver = $this->Login_model->cek_activation($saltkey);
		
		if($cekver){
			$verifikasi = $this->Login_model->get_activation($saltkey)->row();
			$newsalt = $this->_create_salt();
			$salt_array = array(
//               'SALTKEY' => $newsalt,
			   'SALTKEY' => $saltkey,
			   'ACCSTS' => 1
            );
			$this->Login_model->update_activation($verifikasi->CUSTOMERCODE,$salt_array);
			//redirect('login');
			$this->logout();
		}
	}
// end of function verify
// fungsi untuk logout
	public function logout()
	{
		$this->Login_model->logout();
		redirect('login');
	}
//end of log out

// beberapa fungsi untuk melakukan forget password
	public function forgetpwd()
	{
		$data['msg']='';
		$this->load->view('header');
		$this->load->view('forget_view',$data);
		$this->load->view('footer');
	}
		
	public function resetpwd()
	{
		if($_POST){
			$pwd = $this->Login_model->validate_reset($_POST['loginid'],$_POST['email'])->result();			
			$i=0;
			foreach ($pwd as $row)
			{
				$custcode = $row->CUSTCODE;
				$custemail= $row->EMAIL;
				$i++;
			}
			if($i>0){
				$respwd = $this->randomPassword();
				
				$userpwddata = array('CUSTPWD' => sha1($respwd),
						'SALTKEY' => $saltkey,
						'ACCSTS' => 0);
				$this->Login_model->reset_password($custcode,$userpwddata);
				
				$this->sendmail_pwd($custemail,$respwd,$custcode);
				
				$data['msg']='Terimakasih, silahkan memeriksa password baru yang telah anda terima melalui email ' . $_POST['email'];
		
				$this->load->view('header');
				$this->load->view('forget_view',$data);
				$this->load->view('footer');
				
			}else{
				$data['msg']='Email dan id pelanggan anda tidak sesuai!';
				$this->load->view('header');
				$this->load->view('forget_view',$data);
				$this->load->view('footer');	
			}
		}else{
			$data['msg']='email tidak terdaftar dengan ID pelanggan' . $_POST['loginid'];
			$this->load->view('header');
			$this->load->view('forget_view',$data);
			$this->load->view('footer');	
		}
	}
	
	public function randomPassword() {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
    	return implode($pass); //turn the array into a string
	}
	
	public function sendmail_pwd($email,$pwd,$custcode)
	{
		$this->load->library('email');

		$this->load->library('email');
		$config['protocol']  = 'smtp';
		$config['smtp_host'] = 'mail.cepat.net.id';
		$config['smtp_port'] = 25;
		$config['smtp_user'] = 'rachmat.web@cepat.net.id';//'qorianku@gmail.com';
		$config['smtp_pass'] = 'moratel';//'1234567890';
		$config['priority']  = 2;
		$config['mailtype']  = 'html';
		$config['charset']   = 'utf-8';
		$config['wordwrap']  = TRUE;
		
		$this->email->initialize($config);
		$this->email->from('admin-selfcare@cepat.net.id', 'Admin Selfcare');
		$this->email->to($email);
		$this->email->subject('Password Reset');
		$this->email->bcc('rachmat.web@cepat.net.id');
		
		$body = '<div style="font-family:Arial, sans-serif; color:#004993"><p>Pelanggan yang terhormat,</p>';
		$body .= '<p>Anda telah melakukan reset password untuk login ke http://selfcare.cepat.net.id <br />';
//		$body .= 'Jika anda merasa tidak melakukan reset password, harap abaikan email ini. </p>';		
		$body .= '<p>Berikut data login dan password anda:<br />';
		$body .= 'ID Pelanggan : '. $custcode .'<br />';
		$body .= 'Password     : '. $pwd . '</p>';
		$body .= '<p style="font-weight:bold; color:#F00;">Harap segera mengganti password anda</p>';
		$body .= '<p>Terimakasih,<br /><br />';
		$body .= 'Admin Selfcare<br />';
		$body .= '<a href="http://www.cepat.net.id">CEPATnet</a></p>';
		$body .= '<p style="font-size:11px; color:#000;">Email ini merupakan email otomatis, harap jangan membalas ke alamat email pengirim!</p>';

		$this->email->message($body);
		
		$this->email->send();
		
//		echo $this->email->print_debugger();
	}
// end of forget pwd

/**
 * Create Salt
 *
 * This function will create a salt hash to be used in 
 * authentication
 * 
 * @return  string      the salt
 */
	protected function _create_salt()
	{
		$this->load->helper('string');
		return sha1(random_string('alnum', 32));
	}
// end of create salt


}
/* End of file login_control.php */
/* Location: ./application/controllers/login_control.php */