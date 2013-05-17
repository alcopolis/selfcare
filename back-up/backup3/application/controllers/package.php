<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Package extends CI_Controller {

	/**
	 * Constructor
	 */
	function __construct() {
        parent::__construct();  
		$this->client_logon = $this->session->userdata('logged');
		$this->load->model('Package_model', '', TRUE);
		$this->load->model('Customer_model', '', TRUE);
    }   	
	
	/**
	 * Memeriksa user state, jika dalam keadaan login akan menampilkan halaman absen,
	 * jika tidak akan meredirect ke halaman login
	 */
	function index(){
		// Hapus data session yang digunakan pada proses update data absen
		
		//$this->session->unset_userdata('custcode');			
		if($this->client_logon){
			$this->view_package_all($this->session->userdata('logged'));
		}else{
			redirect('login');
		}
	}
	
	function view_package_all($custcode)
	{
		$this->load->library('table');
		
		$uri_segment = 3;
		$offset = $this->uri->segment($uri_segment);
		
		$customer = $this->Customer_model->get_cust_bycode($custcode)->row();
		$packages = $this->Customer_model->get_package_homeview($customer->CUSTOMERID)->result();
		
		$data['default']['customercode']= $customer->CUSTOMERCODE;
		$data['default']['customername']= $customer->CUSTOMERNAME;
		$data['default']['email']= $customer->EMAIL;
		
		$tmpl = array( 'table_open'    => '<table id="tbl-view" class="dynamic" border="0" cellpadding="0" cellspacing="10">',
						  'row_alt_start'  => '<tr class="zebra">',
							'row_alt_end'    => '</tr>'
						  );
		$this->table->set_template($tmpl);

		// Set heading untuk tabel
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('No', 'Nama Paket','Keterangan','Channel Aktif', 'Lihat');
			
		// Penomoran baris data
		$i = 0 + $offset;
		//screen untuk popup javascript
		foreach ($packages as $package)
			{
			// Penyusunan data baris per baris, perhatikan pembuatan link untuk updat dan delete
			// echo anchor_popup('friends/index/'.$uid.'/'.$suid,'add as friend',$attr);
				if($package->IDPAKET=='99983' || $package->IDPAKET=='99984' || $package->IDPAKET=='99999'){
					$this->table->add_row(++$i,$package->PACKAGE,
							$package->DESCRIPTION, 
							$package->MAXCHANEL,
							anchor('package/view_alacarte/'.$package->pktid,'Detil',array('class' => 'btn package')));
				}else{		
					$this->table->add_row(++$i,$package->PACKAGE,
							$package->DESCRIPTION, 
							$package->MAXCHANEL,
							anchor('package/view_packagedet/'.$package->pktid,'Detil',array('class' => 'btn package')));
				}
			}
			
			$data['table'] = $this->table->generate();		
		
		$this->load->view('header',$data);
		$this->load->view('v_package',$data);
		$this->load->view('footer');
	}
	
	function view_alacarte($trpackageid){
		
		$result = $this->Package_model->ala_get_service_id()->result();
		$chtabs = $this->Package_model->ala_get_channel_category()->result();
		$chusers = $this->Package_model->ala_get_ch_used($trpackageid)->result();
		$ch = 0;
		$cht="";
		$chdef="";
		$base_url = base_url();
		foreach($chtabs as $row)//get category id
		{
			switch ($row->categoryid) {
				case "Movies-A": $category = "entertainment";break;
				case "Sports-A": $category = "sport";break;
			}
			
				$cht .= "<div class='cat-box ". $category ."'>";
				$cht .= "<h3>". $row->categoryid ."</h3>";
				$cht .= "<ul>";
				
			foreach($result as $baris){//get channel category
				if ($row->categoryid == $baris->categoryid){
					$sel =0;
					foreach($chusers as $chuser){//get selected category					
						if($chuser->serviceid == $baris->serviceid){
							$cht .= "<li id='". $baris->serviceid ."' class='premium selected'>";	
							$cht .= $baris->servicename;
							$cht .= "</li>";
							$sel=1;
							break;
						}	
					}
					if ($sel == 0){
						$cht .= "<li id='". $baris->serviceid ."' class='premium'>";		
						$cht .= $baris->servicename;
						$cht .= "</li>";				
					}
				}
			}
			$cht .= "</ul></div>";		
		}
		//get package name
		$packagename = $this->Package_model->get_package_name($trpackageid)->result();
		foreach($packagename as $desc){
			$data['starter']=$desc->DESCRIPTION;
		}
		$data['chdefault'] = $cht;
		$this->load->view('v_alacarte',$data);
	}// end of fucntion alacarte
	
	function view_packagedet($trpackageid)
	{
		$result = $this->Package_model->get_service_id()->result();
		$chtabs = $this->Package_model->get_channel_category()->result();
		$chusers = $this->Package_model->get_ch_used($trpackageid)->result();
		$ch = 0;
		$cht="";
		$chdef="";
		$base_url = base_url();
		foreach($chtabs as $row)//get category id
		{
			switch ($row->categoryid) {
				case "Entertainment": $category = "entertainment";break;
				case "Movies": $category = "movie";break;
				case "Sports": $category = "sport";break;
				case "Science & Education": $category = "knowledge";break;
				case "Lifestyle": $category = "lifestyle";break;
				case "Toddlers & Kids": $category = "kids";break;
				case "Musics": $category = "entertainment";break;
				case "News": $category = "entertainment";break;
				case "Teen": $category = "kids";break;
			}
			
				$cht .= "<div class='cat-box ". $category ."'>";
				$cht .= "<h3>". $row->categoryid ."</h3>";
				$cht .= "<ul>";
			

			foreach($result as $baris){//get channel category
				if ($row->categoryid == $baris->categoryid){
					$sel =0;
					foreach($chusers as $chuser){//get selected category					
						if($chuser->serviceid == $baris->serviceid){
							$cht .= "<li id='". $baris->serviceid ."' class='premium selected'>";	
							$cht .= $baris->servicename;
							$cht .= "</li>";
							$sel=1;
							break;
						}	
					}
					if ($sel == 0){
						$cht .= "<li id='". $baris->serviceid ."' class='premium'>";		
						$cht .= $baris->servicename;
						$cht .= "</li>";				
					}
				}
			}
			
			$cht .= "</ul></div>";
			
		}
		//get package name
		$packagename = $this->Package_model->get_package_name($trpackageid)->result();
		foreach($packagename as $desc){
			$data['starter']=$desc->DESCRIPTION;
		}
		$valedit = $this->Customer_model->validate_change($this->session->userdata('logged'));
		//if ($valedit == TRUE){
		//	$data['editlink']='';	
		//}else{
			$data['editlink'] = $base_url."package/edit_paket/".$trpackageid;
		//}
		
		//$data['tabchanel']=$cht;
		$data['chdefault'] = $cht;//$chdef;
		$data['err_msg'] ='';
		$this->load->view('v_packagedet',$data);
	}
	
	function edit_paket($trpackageid)
	{
		$result = $this->Package_model->get_service_id()->result();
		$chtabs = $this->Package_model->get_channel_category()->result();
		$chusers = $this->Package_model->get_ch_used($trpackageid)->result();
		//$chusersed = $this->Package_model->get_ch_used_edit($trpackageid)->result();
		$chjs = $this->Package_model->get_chpremium($trpackageid)->result_array();
		$ch = 0;
		
		//$chdef="";
		$chdef="";$base_url = base_url();
//		<img class="selected" src="images/actived.png">
		foreach($chtabs as $row)
		{
			switch ($row->categoryid) {
				case "Entertainment": $category = "entertainment";break;
				case "Movies": $category = "movie";break;
				case "Sports": $category = "sport";break;
				case "Science & Education": $category = "knowledge";break;
				case "Lifestyle": $category = "lifestyle";break;
				case "Toddlers & Kids": $category = "kids";break;
				case "Musics": $category = "entertainment";break;
				case "News": $category = "entertainment";break;
				case "Teen": $category = "kids";break;
			}
			
				$chdef .= "<div class='cat-box ". $category ."'>";
				$chdef .= "<h3>". $row->categoryid ."</h3>";
				$chdef .= "<ul>";
				
			foreach($result as $baris){//get channel category
				if ($row->categoryid == $baris->categoryid){
					$sel =0;
					foreach($chusers as $chuser){//get selected category					
						if($chuser->serviceid == $baris->serviceid){
							if($trpackageid==$chuser->pktid){
								$chdef .= "<li id='". $baris->serviceid ."' class='premium selected'>";		
								$chdef .= $baris->servicename;
								$chdef .= "</li>";
								$sel=1;
								break;
							}else{
								$chdef .= "<li id='". $baris->serviceid ."' class='premium disabled'>";		
								$chdef .= $baris->servicename;
								$chdef .= "</li>";
								$sel=1;
								break;
							}
						}	
					}
					if ($sel == 0){
						$chdef .= "<li id='". $baris->serviceid ."' class='premium'>";		
						$chdef .= $baris->servicename;
						$chdef .= "</li>";				
					}
				}
			}
			
			$chdef .= "</ul></div>";
			$ch++;
		}
		
		//get package name
		$packagename = $this->Package_model->get_package_name($trpackageid)->result();
		foreach($packagename as $desc){
			$data['starter']=$desc->DESCRIPTION;
		}
		
		
		$data['chdefault'] = $chdef;
		
		$valedit = $this->Customer_model->validate_change($this->session->userdata('logged'));
//		if ($valedit== TRUE){
//			$data['savelink']='';	
//		}else{
			$data['savelink'] = $base_url."package/update_paket/".$trpackageid;
			$data['packagelink'] = $base_url."package/view_packagedet/".$trpackageid;
//		}
		
		foreach($chjs as $chj)
		{
			$chjss[] = $chj['channel'];
		}
		
		
		//----------json create
		//$arr_chdef=array("");
		$arr_chdef="{";
		$result = $this->Package_model->get_service_id()->result();
		
		foreach ($result as $baris){
			$arr_chs = $this->Package_model->count_param($trpackageid,$baris->serviceid);
			if ($arr_chs > 0){  			
				$arr_chdef .= "[".$baris->servicename.",2],";
			}else{
				$arr_chdef .= "[".$baris->servicename.",0],";
			}
		}
		//----------end json create
		
		$data['chjs'] = join('","',$chjss);
		$data['arr_js'] = $arr_chdef;

		$this->load->view('v_formedit',$data);
	}	

	
	function update_paket($trpackageid)
	{		
		$arch = $_POST['packdet'];
		$maxch = $_POST['chremain'];
		$editch = $_POST['editdata'];
		if ($maxch == 0 && $editch > 0) {
			$custdata = $this->Customer_model->get_cust_bycode($this->session->userdata('logged'))->row();
			$packdata = $this->Package_model->get_package($trpackageid)->row();
			
			$customercode = $custdata->CUSTOMERCODE;
			$customerid = $custdata->CUSTOMERID;
			
			$head_chn = array('CUSTOMERID' => $customerid,
					'CUSTOMERCODE' => $customercode,
					'customerpackageid' => $trpackageid,
					'packageid' => $packdata->packageid
					);
					
			$customerdata = array('LASTPACKAGEUPDATE' => date("Y-m-d"));
			$this->Package_model->add_chn_head($head_chn);
			$this->Package_model->update_lastpackage($customerdata);
			
			$lastinsert = $this->Package_model->get_lastinsert()->row();
			$trid = $lastinsert->terakhir;
			$chSubs = explode(",",$arch);		

			$chadd = array();
			$chrem = array();
			foreach ($chSubs as $key => $value) {
				list($chnl,$flag) = explode(" ",$value);
				$det_chn = array('transid' =>$trid,
							   'serviceid' => $chnl,
							   'flag' 	=> $flag); 
				$this->Package_model->add_chn_detail($det_chn);
				if($flag=="ADD"){array_push($chadd,$chnl);}
				if($flag=="REMOVE"){array_push($chrem,$chnl);}
			}
			for ($i=0; $i < count($chrem); $i++){
				$this->Package_model->update_cur_chn($chrem[$i],$chadd[$i],$trpackageid);
			}
			$this->change_result($trpackageid,'0');
		}else{
			$this->change_result($trpackageid,'1');
		}
	
	}
	
function change_result($trpackageid,$savestatus){
		if($savestatus=='0'){$data['err_msg'] = '<span id="succeed" style="color:#0066CC;">Perubahan channel sedang kami proses dan akan bisa anda nikmati dalam waktu 5 menit</span>';}
		else{$data['err_msg'] = '<span id="error" style="color:#F00;">Anda belum melakukan perubahan. Mohon lakukan modifikasi pada pilihan channel premium Anda</span>';}
		$result = $this->Package_model->get_service_id()->result();
		$chtabs = $this->Package_model->get_channel_category()->result();
		$chusers = $this->Package_model->get_ch_used($trpackageid)->result();
		$ch = 0;
		$cht="";
		$chdef="";
		$base_url = base_url();
		foreach($chtabs as $row)//get category id
		{
			switch ($row->categoryid) {
				case "Entertainment": $category = "entertainment";break;
				case "Movies": $category = "movie";break;
				case "Sports": $category = "sport";break;
				case "Science & Education": $category = "knowledge";break;
				case "Lifestyle": $category = "lifestyle";break;
				case "Toddlers & Kids": $category = "kids";break;
				case "Musics": $category = "entertainment";break;
				case "News": $category = "entertainment";break;
				case "Teen": $category = "kids";break;
			}
			
				$cht .= "<div class='cat-box ". $category ."'>";
				$cht .= "<h3>". $row->categoryid ."</h3>";
				$cht .= "<ul>";
			

			foreach($result as $baris){//get channel category
				if ($row->categoryid == $baris->categoryid){
					$sel =0;
					foreach($chusers as $chuser){//get selected category					
						if($chuser->serviceid == $baris->serviceid){
							$cht .= "<li id='". $baris->serviceid ."' class='premium selected'>";	
							$cht .= $baris->servicename;
							$cht .= "</li>";
							$sel=1;
							break;
						}	
					}
					if ($sel == 0){
						$cht .= "<li id='". $baris->serviceid ."' class='premium'>";		
						$cht .= $baris->servicename;
						$cht .= "</li>";				
					}
				}
			}
			
			$cht .= "</ul></div>";
			
		}
		//get package name
		$packagename = $this->Package_model->get_package_name($trpackageid)->result();
		foreach($packagename as $desc){
			$data['starter']=$desc->DESCRIPTION;
		}
		$valedit = $this->Customer_model->validate_change($this->session->userdata('logged'));
		//if ($valedit == TRUE){
		//	$data['editlink']='';	
		//}else{
			$data['editlink'] = $base_url."package/edit_paket/".$trpackageid;
		//}
		
		//$data['tabchanel']=$cht;
		$data['chdefault'] = $cht;//$chdef;
		$this->load->view('v_packagedet',$data);
	}


}
// END Absen Class

/* End of file absen.php */
/* Location: ./system/application/controllers/absen.php */