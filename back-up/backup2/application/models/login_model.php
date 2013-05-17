<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
		$this->baca = $this->load->database('altdb', TRUE);
    }
 
	public function login($user_id){
		$CI =& get_instance();
		$CI->session->set_userdata('logged', $user_id);
	}
	 
	public function logout(){
		$CI =& get_instance();
		$CI->session->sess_destroy();
	}
	 
	public function validate($username,$password){
		
		$query = $this->baca->get_where('LOGIN_CUST', array('CUSTCODE' => $username));
		$cek = $query->num_rows();
		if($cek != 0){
			foreach($query->result() as $row):
			$client['id_client'] = $row->CUSTID;
			$client['username'] = $row->CUSTCODE;
			$client['password'] = $row->CUSTPWD;
			endforeach;
	 
			$encpwd = sha1($password);
	 
			if($encpwd == $client['password']){
				$this->login($client['username']);
				return true;
			}else{
				return false;
			}
		}else{
			$query = $this->db->get_where('LOGIN_CUST', array('CUSTEMAIL' => $username));
			$cek = $query->num_rows();
			if($cek != 0){
				foreach($query->result() as $row):
				$client['id_client'] = $row->CUSTID;
				$client['username'] = $row->CUSTCODE;
				$client['password'] = $row->CUSTPWD;
				endforeach;
		 
				$encpwd = sha1($password);
		 
				if($encpwd == $client['password']){
					$this->login($client['username']);
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}//end of function validate
	
	public function first_pwd($username,$password){
		$query = $this->db->get_where('LOGIN_CUST', array('CUSTCODE' => $username));
		$cek = $query->num_rows();
		if($cek != 0){
			foreach($query->result() as $row):
				$client['id_client'] = $row->CUSTID;
				$client['username'] = $row->CUSTCODE;
				$client['password'] = $row->CUSTPWD;
			endforeach;		
	
			$usercode = sha1($client['username']);	
			if($usercode == $client['password']){
				return true;
			}else{
				return false;
			}
		}else{
			$query = $this->baca->get_where('LOGIN_CUST', array('CUSTEMAIL' => $username));
			$cek = $query->num_rows();
			if($cek != 0){
				foreach($query->result() as $row):
					$client['id_client'] = $row->CUSTID;
					$client['username'] = $row->CUSTCODE;
					$client['password'] = $row->CUSTPWD;
				endforeach;
		 
				$usercode = sha1($client['username']);	
				if($usercode == $client['password']){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}// end of check first password change
	
	public function validate_pwd($username,$curpas,$newpas,$confpas){
		$curpwd = sha1($curpas);
		$query = $this->baca->get_where('LOGIN_CUST', array('CUSTCODE' => $username,'CUSTPWD' => $curpwd));
		$cek = $query->num_rows();
	
		if($cek != 0){return true;}else{return false;}
	}// end of validate_pwd
	
	public function save_password($custcode,$newpass){
		$this->db->where('CUSTCODE', $custcode);
		$this->db->update('LOGIN_CUST', $newpass);
	}//end of save_password
	
	public function last_login($custcode){
		$this->db->where('CUSTCODE', $custcode);
		$lastlogin = array('LASTLOGIN' => date('Y-m-d H:i:s', time()));
		$this->db->update('LOGIN_CUST', $lastlogin);
		
	}// end of last login update
	
	public function check_access($custcode){
		$this->baca->select('ACCSTS');//check login account status akses
		$this->baca->where('CUSTCODE', $custcode);
		return $this->baca->get();
	}
	
	public function check_mail($email){

		$this->baca->select('t1.CUSTID');
		$this->baca->select('t1.CUSTCODE');
		$this->baca->select('t1.CUSTNAME');
		$this->baca->select('t1.CUSTEMAIL');
		$this->baca->select('t0.EMAIL');
		$this->baca->from('t_ms_customer t0');
		$this->baca->join('LOGIN_CUST t1','t0.CUSTOMERCODE = t1.CUSTCODE');
		$this->baca->where('t1.CUSTEMAIL',$email);
//		-- LOGIN_CUST.CUSTCODE ='1000451'
		return $this->baca->get();
	}

}// end class

/* End of file cs_model.php */
/* Location: ./application/model/cs_model.php */