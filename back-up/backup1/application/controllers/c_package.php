<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_package extends CI_Controller {

	/**
	 * Constructor
	 */
	function __construct() {
        parent::__construct();  
		session_start();
		$this->load->helper(array('form','url'));
		$this->load->model('M_package', '', TRUE);
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
			$this->view_package_all($this->session->userdata('username'));
		}
		else
		{
			redirect('c_login');
		}
	}
	
	function view_package_all($custcode)
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
		$this->table->set_heading('No', 'Package Name','Description','Max Chanel');
			
		// Penomoran baris data
		$i = 0 + $offset;
		//screen untuk popup javascript
		foreach ($packages as $package)
			{
			// Penyusunan data baris per baris, perhatikan pembuatan link untuk updat dan delete
			// echo anchor_popup('friends/index/'.$uid.'/'.$suid,'add as friend',$attr);
			if ($package->MAXCHANEL!=0){
			$this->table->add_row(++$i,
			//anchor_popup('c_package/view_packagedet/'.$package->pktid,$package->PACKAGE,array('class' =>'c_package')),
			
			anchor('c_package/view_packagedet/'.$package->pktid,$package->PACKAGE,array('class' => 'c_package')),
			//anchor('c_package/edit_paket/'.$package->pktid,$package->PACKAGE,array('class' => 'c_package')),
			 
			//anchor('c_package/ch_detail/'.$package->pktid,$package->PACKAGE,array('class' =>'ch_detail')), 
					$package->DESCRIPTION, 
					$package->MAXCHANEL);
			}else{
			$this->table->add_row(++$i,$package->PACKAGE, 
					$package->DESCRIPTION, 
					$package->MAXCHANEL);				
				}
			
			}
			$data['table'] = $this->table->generate();		
		
		$this->load->view('header',$data);
		$this->load->view('v_package',$data);
		$this->load->view('footer');
	}
	
	function view_packagedet($trpackageid)
	{
		$result = $this->M_package->get_service_id()->result();
		$chtabs = $this->M_package->get_channel_category()->result();
		$chusers = $this->M_package->get_ch_used($trpackageid)->result();
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
			
				$cht .= "<div class='cat-box ". $category ." masonry-brick'>";
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
		$data['editlink'] = $base_url."index.php/c_package/edit_paket/".$trpackageid;
		//$data['tabchanel']=$cht;
		$data['chdefault'] = $cht;//$chdef;
		$this->load->view('v_packagedet',$data);
	}
	
	function edit_paket($trpackageid)
	{
		$result = $this->M_package->get_service_id()->result();
		$chtabs = $this->M_package->get_channel_category()->result();
		$chusers = $this->M_package->get_ch_used($trpackageid)->result();
		$chjs = $this->M_package->get_chpremium($trpackageid)->result_array();
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
			
				$chdef .= "<div class='cat-box ". $category ." masonry-brick'>";
				$chdef .= "<h3>". $row->categoryid ."</h3>";
				$chdef .= "<ul>";
				
			foreach($result as $baris){//get channel category
				if ($row->categoryid == $baris->categoryid){
					$sel =0;
					foreach($chusers as $chuser){//get selected category					
						if($chuser->serviceid == $baris->serviceid){
							$chdef .= "<li id='". $baris->serviceid ."' class='premium selected'>";		
							$chdef .= $baris->servicename;
							$chdef .= "</li>";
							$sel=1;
							break;
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
		
		$data['chdefault'] = $chdef;
		$data['savelink'] = $base_url."index.php/c_package/update_paket/".$trpackageid;
		
		foreach($chjs as $chj)
		{
			$chjss[] = $chj['channel'];
		}
		
		
		//----------json create
		//$arr_chdef=array("");
		$arr_chdef="{";
		$result = $this->M_package->get_service_id()->result();
		foreach ($result as $baris){
			$arr_chs = $this->M_package->count_param($trpackageid,$baris->serviceid);
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
		if ($maxch == 0 && $editch !=0) {
			$custdata = $this->M_cust->get_cust_bycode($this->session->userdata('username'))->row();
			$packdata = $this->M_package->get_package($trpackageid)->row();
			
			$customercode = $custdata->CUSTOMERCODE;
			$customerid = $custdata->CUSTOMERID;
			
			$head_chn = array('CUSTOMERID' => $customerid,
					'CUSTOMERCODE' => $customercode,
					'customerpackageid' => $trpackageid,
					'packageid' => $packdata->packageid
					);
					
			$customerdata = array('LASTPACKAGEUPDATED' => date("Y-m-d"));
			$this->M_package->add_chn_head($head_chn);
			$this->M_package->update_lastpackage($customerdata);
			
			$lastinsert = $this->M_package->get_lastinsert()->row();
			$trid = $lastinsert->terakhir;
			$chSubs = explode(",",$arch);		

			$chadd = array();
			$chrem = array();
			foreach ($chSubs as $key => $value) {
				list($chnl,$flag) = explode(" ",$value);
				$det_chn = array('transid' =>$trid,
							   'serviceid' => $chnl,
							   'flag' 	=> $flag); 
				$this->M_package->add_chn_detail($det_chn);
				if($flag=="ADD"){array_push($chadd,$chnl);}
				if($flag=="REMOVE"){array_push($chrem,$chnl);}
			}
			for ($i=0; $i < count($chrem); $i++){
				$this->M_package->update_cur_chn($chrem[$i],$chadd[$i],$trpackageid);
			}
			$data['error_msg'] = 'Edit Paket Berhasil';
			$this->view_packagedet($trpackageid);
		}else{
			$data['error_msg'] = 'Total Sisa Paket harus 0';
			$this->edit_paket($trpackageid);
		}
		
	}
}
// END Absen Class

/* End of file absen.php */
/* Location: ./system/application/controllers/absen.php */