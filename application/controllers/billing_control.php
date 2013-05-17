<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Billing_control extends CI_Controller {

// fungsi construktor
	function __construct() {
        parent::__construct(); 
		$this->load->model('Billing_model', '', TRUE);
		$this->load->model('Customer_model', '', TRUE);
		
		$this->client_logon = $this->session->userdata('logged');
		$this->client_access = $this->session->userdata('aktif');
		$this->client_cluster = $this->session->userdata('daerah');
		if($this->client_logon==''){
			redirect('login');
		}
    }   	
	
// fungsi index dipanggil pada saat pertama kali controller dijalankan
	public function index(){			
		if($this->client_logon){
			if($this->client_access=='0'){	redirect('logout');	}
			$this->cepat_net_billing_info($this->session->userdata('logged'));
		}else{
			redirect('login');
		}

	}
	
// fungsi untuk menampilkan informasi billing dari pelanggan 
	public function cepat_net_billing_info($custcode)
	{
		$this->load->library('table');
		
		$uri_segment = 3;
		$offset = $this->uri->segment($uri_segment);
		
		$customer = $this->Customer_model->get_cust_bycode($custcode)->row();
	    		
		$data['default']['customercode']= $customer->CUSTOMERCODE;
		$data['default']['customername']= $customer->CUSTOMERNAME;
		$data['default']['email']= $customer->EMAIL;
		
		$bill_summs = $this->Billing_model->get_bill_summary($custcode)->result();
		
		$tmpl = array( 'table_open'    => '<table id="tbl-view" class="dynamic" border="0" cellpadding="0" cellspacing="10">',
						  'row_alt_start'  => '<tr class="zebra">',
							'row_alt_end'    => '</tr>'
						  );
						  
		$this->table->set_template($tmpl);

		// Set heading untuk tabel
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('No','Invoice No' ,'Tanggal Tagihan','Jumlah Tagihan','Lihat','Simpan');
			
		// Penomoran baris data
		$i = 0 + $offset;
		//screen untuk popup javascript
		foreach ($bill_summs as $bill)
			{
			$curbal = $this->Billing_model->get_billing_footer($bill->INVOICENO,$this->client_logon)->result();
			foreach($curbal as $cb)
			{
				$prevbal = $cb->PREVIOUSBALANCE;
				$lastpayment = $cb->LASTPAYMENT;
				$curinvpay =$cb->SUMTOTALINVOICE;
			// get billing adjustment if exist
				$bil_adj = $this->Billing_model->get_bill_adjust($custcode,$bill->INVOICENO)->result();
				$adjust =0;
				foreach($bil_adj as $bila){
					$adjust = $bila->AMOUNT;
				}
			// end of billing adjustment
				$curammount = $prevbal + $lastpayment + $curinvpay + $adjust;
			}
				
			$this->table->add_row(++$i,
					$bill->INVOICENO,
					$bill->TRANSACTIONDATE,
					number_format($curammount),
					//$bill->AMOUNT,
					anchor('billing_control/view_invoice/'.$bill->HISTORYID,"Detil",array('class' => 'btn billing')),
					anchor('billing_control/pdf_billing/'.$bill->HISTORYID,"PDF",array('class' => 'btn billing'))					
//					anchor('billing_control/display_detail_billing/'.$bill->HISTORYID,$bill->INVOICENO,array('class' => 'c_package'))
			);
		}
			
		$data['table'] = $this->table->generate();		

		$this->load->view('header',$data);
		$this->load->view('billing_view',$data);
		$this->load->view('footer');
	}
// end of function get billing cepat net info

// fungsi untuk menampilkan data invoice
	public function view_invoice($invoiceid)
	{
		$bilhs = $this->Billing_model->get_billing_h($invoiceid)->row();
		
		$data['invoiceid'] = $invoiceid;	
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
		$data['email']= $bilhs->EMAIL;
		$data['npwp']= "";//$bilhs->npwp;
		$data['fax']= "";//$bilhs->fax;
		$cdate = new DateTime($bilhs->BLNTHN);

		$bln = $cdate->format('m');
		$thn = $cdate->format('Y');
				
		$data['bildet'] = $this->Billing_model->get_billing_d($invoiceid)->result();//get billing summary

		$adms = $this->Billing_model->get_adm($bilhs->CUSTOMERCODE,$bln,$thn)->result();

		foreach ($adms as $adm){
			if($adm->PRODUCTNAME=='Biaya Administrasi'){
				$data['administrasi']=	$adm->ATRBTVAL;
			}
			if($adm->PRODUCTNAME=='PPN'){
				$data['ppn']=$adm->ATRBTVAL;
			}
		}
		
		$bilfoots=$this->Billing_model->get_billing_footer($bilhs->INVOICENO,$this->client_logon)->result();
		//echo $this->db->last_query();
		foreach($bilfoots as $bf){
			$previnvno =$bf->LASTINVOICENO;
			$prevbal = $bf->PREVIOUSBALANCE;
			$lastpaydate = $bf->LASTPAYDATE;
			$lastpayment = $bf->LASTPAYMENT;
			$curinvno = $bf->INVOICENO;
			$curinvpay =$bf->SUMTOTALINVOICE;
			$vamandiri =$bf->VAMANDIRI;
			$vabca = $bf->VABCA;
		}
		
		$data['previnvno']=$previnvno;
		if($prevbal<0){
			$data['prevbal'] = "<font color='red'>(" . number_format($prevbal * -1) . ")</font>";
		}else{
			$data['prevbal']=number_format($prevbal);	
		}
		$data['lastpaydate']=$lastpaydate;
		if($lastpayment<0){
			$data['lastpayment']="<font color='red'>(" . number_format($lastpayment * -1) . ")</font>";
		}else{
			$data['lastpayment']=number_format($lastpayment);
		}
		$data['curinvno']=$curinvno;
		if($curinvpay<0){
			$data['curinvpay']="<font color='red'>(" . number_format($curinvpay * -1). ")</font>";
		}else{
			$data['curinvpay']=number_format($curinvpay);	
		}			
		$data['vamandiri']=$vamandiri;
		$data['vabca']=$vabca;
		$curbal = $prevbal + $lastpayment;
		if($curbal<0){
			$data['curbalance'] = "<font color='red'>(" . number_format($curbal * -1) .")</font>";
		}else{
			$data['curbalance'] = number_format($curbal);
		}
		
		
		// get billing adjustment if exist
		$bil_adj = $this->Billing_model->get_bill_adjust($this->client_logon,$bilhs->INVOICENO)->result();
		//$adjust=0;
		foreach($bil_adj as $bila){
			$data['adjustment']=$bila->AMOUNT;
			$adjust = $bila->AMOUNT;
		}
		
		if($adjust<0){
			$data['adjustment']  = "<font color='red'>(" . number_format($adjust*-1) .")</font>";
		}else{
			$data['adjustment']  = number_format($adjust);
		}
		// end of billing adjustment
		$ttlbyr = number_format($prevbal + $lastpayment + $curinvpay);
		if($ttlbyr<0){
			$data['totalbayar']  = "<font color='red'>(" . number_format(($prevbal + $lastpayment + $curinvpay + $adjust)*-1) .")</font>";
		}else{
			$data['totalbayar']  = number_format($prevbal + $lastpayment + $curinvpay + $adjust);
		}
		
		$data['tbilang'] = $this->Terbilang(round($prevbal + $lastpayment + $curinvpay + $adjust));
		$data['etbilang'] = $this->number_to_words(round($prevbal + $lastpayment + $curinvpay + $adjust));
		
		$this->load->view('invoice_view',$data);
	}
// end of view_invoice

// function view pdf

	public function pdf_billing($invoiceid)
	{
		$bilhs = $this->Billing_model->get_billing_h($invoiceid)->row();
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
		$data['email']= $bilhs->EMAIL;
		$data['npwp']= "";//$bilhs->npwp;
		$data['fax']= "";//$bilhs->fax;
		$date = new DateTime($bilhs->BLNTHN);
		
		$bln = $date->format('m');
		$thn = $date->format('Y');
		$periode = $date->format('m-Y');
		
		$data['bildet'] = $this->Billing_model->get_billing_d($invoiceid)->result();//get billing summary

		$adms = $this->Billing_model->get_adm($bilhs->CUSTOMERCODE,$bln,$thn)->result();
		foreach ($adms as $adm){
			if($adm->PRODUCTNAME=='Biaya Administrasi'){$data['administrasi']=	$adm->ATRBTVAL;}
			if($adm->PRODUCTNAME=='PPN'){$data['ppn']=$adm->ATRBTVAL;}
		}
		
		$bilfoots=$this->Billing_model->get_billing_footer($bilhs->INVOICENO,$this->client_logon)->result();
		//echo $this->db->last_query();
		foreach($bilfoots as $bf){
			$previnvno =$bf->LASTINVOICENO;
			$prevbal = $bf->PREVIOUSBALANCE;
			$lastpaydate = $bf->LASTPAYDATE;
			$lastpayment = $bf->LASTPAYMENT;
			$curinvno = $bf->INVOICENO;
			$curinvpay =$bf->SUMTOTALINVOICE;
			$vamandiri =$bf->VAMANDIRI;
			$vabca = $bf->VABCA;
		}
		
		$data['previnvno']=$previnvno;
		if($prevbal<0){
			$data['prevbal'] = "<font color='red'>(" . number_format($prevbal * -1) . ")</font>";
		}else{
			$data['prevbal']=number_format($prevbal);	
		}
		$data['lastpaydate']=$lastpaydate;
		if($lastpayment<0){
			$data['lastpayment']="<font color='red'>(" . number_format($lastpayment * -1) . ")</font>";
		}else{
			$data['lastpayment']=number_format($lastpayment);
		}
		$data['curinvno']=$curinvno;
		if($curinvpay<0){
			$data['curinvpay']="<font color='red'>(" . number_format($curinvpay * -1). ")</font>";
		}else{
			$data['curinvpay']=number_format($curinvpay);	
		}			
		$data['vamandiri']=$vamandiri;
		$data['vabca']=$vabca;
		$curbal = $prevbal + $lastpayment;
		if($curbal<0){
			$data['curbalance'] = "<font color='red'>(" . number_format($curbal * -1) .")</font>";
		}else{
			$data['curbalance'] = number_format($curbal);
		}
		// get billing adjustment if exist
		$bil_adj = $this->Billing_model->get_bill_adjust($this->client_logon,$bilhs->INVOICENO)->result();
		//$adjust=0;
		foreach($bil_adj as $bila){
			$data['adjustment']=$bila->AMOUNT;
			$adjust = $bila->AMOUNT;
		}
		
		if($adjust<0){
			$data['adjustment']  = "<font color='red'>(" . number_format($adjust*-1) .")</font>";
		}else{
			$data['adjustment']  = number_format($adjust);
		}
		// end of billing adjustment
		
		$ttlbyr = number_format($prevbal + $lastpayment + $curinvpay);
		if($ttlbyr<0){
			$data['totalbayar']  = "<font color='red'>(" . number_format(($prevbal + $lastpayment + $curinvpay + $adjust)*-1) .")</font>";
		}else{
			$data['totalbayar']  = number_format($prevbal + $lastpayment + $curinvpay + $adjust);
		}
		
		$data['tbilang'] = $this->Terbilang(round($prevbal + $lastpayment + $curinvpay + $adjust));
		$data['etbilang'] = $this->number_to_words(round($prevbal + $lastpayment + $curinvpay + $adjust));
		
		
		$this->load->library('mpdf54/mpdf');		 
		$mpdf = new mPDF('utf-8','A4');
		$html = $this->load->view('inv_pdf_view',$data,TRUE);
		$mpdf->WriteHTML($html);
		$filename = $bilhs->CUSTOMERCODE .'-' . $periode;
		$mpdf->Output($filename,D);
	}
// end of pdf view
	
	
// fungsi terbilang 
	private function Terbilang($x)
	{
		$abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		if ($x<0){
			return "Minus " . $this->Terbilang($x * -1);  
		}
		if ($x < 12)
		return " " . $abil[$x];
		elseif ($x < 20)
		return $this->Terbilang($x - 10) . "belas";
		elseif ($x < 100)
		return $this->Terbilang($x / 10) . " puluh" . $this->Terbilang($x % 10);
		elseif ($x < 200)
		return " seratus" . $this->Terbilang($x - 100);
		elseif ($x < 1000)
		return $this->Terbilang($x / 100) . " ratus" . $this->Terbilang($x % 100);
		elseif ($x < 2000)
		return " seribu" . $this->Terbilang($x - 1000);
		elseif ($x < 1000000)
		return $this->Terbilang($x / 1000) . " ribu" . $this->Terbilang($x % 1000);
		elseif ($x < 1000000000)
		return $this->Terbilang($x / 1000000) . " juta" . $this->Terbilang($x % 1000000);
	}
//end fungsi terbilang
	
// fungsi terbilang dalam bahasa inggris	
	private function number_to_words($number){
	$hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'minus ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion'
    );
   
    if (!is_numeric($number)) {
        return false;
    }
   
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            '$this->number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . $this->number_to_words(abs($number));
    }
   
    $string = $fraction = null;
   
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
   
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . $this->number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = $this->number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= $this->number_to_words($remainder);
            }
            break;
    }
   
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
   
    return $string;
	}
// end of function convert number

// Email billing bermasalah
	public function billing_email($invoiceid, $msg='')
	{
		
			$bilhs = $this->Billing_model->get_billing_h($invoiceid)->row();
				
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
			$data['email']= $bilhs->EMAIL;
			$data['invid'] = $invoiceid;
			$data['msg'] = $msg;
			
			$this->load->view('header');
			$this->load->view('billing_email',$data);
			$this->load->view('footer');
	}
	
	function send_billingmail(){
		// code untuk mengirimkan email billing
			$this->load->library('email');
			$this->load->helper('email');
			$this->load->library('form_validation');
		
			$this->form_validation->set_rules('custmsg', 'Message', 'required|min_length[10]');
			
			
			if($this->form_validation->run()==FALSE){
				if(form_error('custmsg')){
					$msg ='Mohon masukkan pesan Anda';
					$invid = $this->input->post('invid');
					
					$this->billing_email($invid, $msg);
				}
			}else{
				$emailbody ='';
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
				$this->email->from($this->input->post('custemail'), $this->input->post('custname'));
				$this->email->to('cs@cepat.net.id');
				$this->email->cc('cs-leader@cepat.net.id');
				$this->email->bcc('billing@cepat.net.id');
				$this->email->subject('Invoice: ' . $this->input->post('invoice'));
				
				$emailbody = '<table style="width:80%; font-family:Arial, Helvetica, sans-serif; font-size:12px;"><tr><td style="width:10%;text-align:right;">ID Pelanggan :</td>';
				$emailbody = $emailbody . '<td style="font-weight:bold; font-size:12px;">' . $this->input->post('custcode') . '</td></tr>';
				$emailbody = $emailbody . '<tr><td style="width:10%;text-align:right;">Nama :</td>';
				$emailbody = $emailbody . '<td style="font-weight:bold; font-size:12px;">' . $this->input->post('custname') . '</td></tr>';
				$emailbody = $emailbody . '<tr><td style="width:10%;text-align:right;">Invoice No :</td>';
				$emailbody = $emailbody . '<td style="font-weight:bold; font-size:12px;">' . $this->input->post('invoice') . '</td></tr>';
				$emailbody = $emailbody . '<tr><td style="width:10%;text-align:right;vertical-align:top;">Pesan :</td>';
				$emailbody = $emailbody . '<td style="font-weight:bold; font-size:12px;">' . $this->input->post('custmsg') . '</td></tr></table>';
				$this->email->message($emailbody);
				
				$this->email->send();
				$this->index();
			}			
		// end of send mail
	}
// end of function


}
/* End of file billing_control.php */
/* Location: ./application/controllers/billing_billing.php */