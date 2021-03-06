<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Billing extends CI_Controller {

	/**
	 * Constructor
	 */
	function __construct() {
        parent::__construct(); 
		$this->client_logon = $this->session->userdata('logged');
		$this->load->model('Billing_model', '', TRUE);
		$this->load->model('Customer_model', '', TRUE);
    }   	
	
	/**
	 * Memeriksa user state, jika dalam keadaan login akan menampilkan halaman absen,
	 * jika tidak akan meredirect ke halaman login
	 */
	function index(){			
		if($this->client_logon){
			$this->cepat_net_billing_info($this->session->userdata('logged'));
		}else{
			redirect('login');
		}
	}
	
	function cepat_net_billing_info($custcode)
	{
		$this->load->library('table');
		
		$uri_segment = 3;
		$offset = $this->uri->segment($uri_segment);
		
		$customer = $this->Customer_model->get_cust_bycode($custcode)->row();
	    		
		$data['default']['customercode']= $customer->CUSTOMERCODE;
		$data['default']['customername']= $customer->CUSTOMERNAME;
		$data['default']['email']= $customer->EMAIL;
		
		$bill_summs = $this->Billing_model->get_bill_summary($custcode)->result();
//		echo $this->db->last_query();
		$tmpl = array( 'table_open'    => '<table id="tbl-view" border="0" cellpadding="0" cellspacing="0">',
						  'row_alt_start'  => '<tr class="zebra">',
							'row_alt_end'    => '</tr>'
						  );
						  
		$this->table->set_template($tmpl);

		// Set heading untuk tabel
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('No', 'Billing Date','Ending Ballance','Display');
			
		// Penomoran baris data
		$i = 0 + $offset;
		//screen untuk popup javascript
		foreach ($bill_summs as $bill)
			{
			$this->table->add_row(++$i,
					$bill->TRANSACTIONDATE,
					$bill->AMOUNT,
					anchor('billing/pdf_billing/'.$bill->HISTORYID,"VIEW",array('class' => 'billing'))
					//anchor('billing/pdf_billing/'.$bill->HISTORYID,"PDF")
//					anchor('billing/display_detail_billing/'.$bill->HISTORYID,$bill->INVOICENO,array('class' => 'c_package'))
			);
		}
			
			$data['table'] = $this->table->generate();		

		$this->load->view('header',$data);
		$this->load->view('v_billing',$data);
		$this->load->view('footer');
	}
	
	function Terbilang($x)
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
	
	
	function number_to_words($number){
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
	}// end of function convert number
	
	
private function _gen_pdf($html,$paper='A4'){
	$this->load->library('mpdf54/mpdf');
	$mpdf = new mPDF('utf-8',$paper);
	$mpdf->WriteHTML($html);
	$mpdf->Output();
}

public function doprint($pdf=false){
	$this->load->library('parser');
	$data = $this->data->gendata();
	$output = $this->parser->parse('form',$data,true);
	if($pdf=='print')
		$this->_gen_pdf($output);
	else
		$this->output->set_output($output);
		
}
	
	function pdf_billing($historyid){
		//$this->load->helper(array('dompdf', 'file'));
		
		//load data for billing information
		$bilhs = $this->Billing_model->get_billing_h($historyid)->row();
//		echo $this->db->last_query();
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
		$data['email']= $bilhs->email;
		$data['npwp']= "";//$bilhs->npwp;
		$data['fax']= "";//$bilhs->fax;
		
		$date = new DateTime($bilhs->TRANSACTIONDATE);
		$bln = $date->format('m');
		$thn = $date->format('Y');
		$data['bildet'] = $this->Billing_model->get_billing_d($historyid)->result();//get billing summary

		$adms = $this->Billing_model->get_adm($bilhs->CUSTOMERCODE,$bln,$thn)->result();
		foreach ($adms as $adm){
			if($adm->PRODUCTNAME=='Biaya Administrasi'){$data['administrasi']=	$adm->ATRBTVAL;}
			if($adm->PRODUCTNAME=='PPN'){$data['ppn']=$adm->ATRBTVAL;}
		}
		$bilfoots=$this->Billing_model->get_billing_footer($bilhs->INVOICENO)->result();
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
		$ttlbyr = number_format($prevbal + $lastpayment + $curinvpay);
		if($ttlbyr<0){
			$data['totalbayar']  = "<font color='red'>(" . number_format(($prevbal + $lastpayment + $curinvpay)*-1) .")</font>";
		}else{
			$data['totalbayar']  = number_format($prevbal + $lastpayment + $curinvpay);
		}
		
		$data['tbilang'] = $this->Terbilang(round($prevbal + $lastpayment + $curinvpay));
		$data['etbilang'] = $this->number_to_words(round($prevbal + $lastpayment + $curinvpay));	
		
		 // page info here, db calls, etc.     
		$this->load->library('mpdf54/mpdf');		 
		$mpdf = new mPDF('utf-8','A4');
		$html = $this->load->view('vpdfbilling',$data,TRUE);
		$mpdf->WriteHTML($html);
		$filename = $bilhs->CUSTOMERCODE;
		$mpdf->Output($filename,I);
	}



}
// END billing

/* End of file absen.php */
/* Location: ./system/application/controllers/billing.php */