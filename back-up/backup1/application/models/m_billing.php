<?php
/**
 * Billing model Class
 *
 */
class M_billing extends CI_Model {
	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
    }
	
	/**
	 * Cek tabel user, apakah ada user dengan username dan password tertentu
	 */
	function get_bill_summary($custcode){		
		$this->db->select("t1.ATRBTID AS HISTORYID");
		$this->db->select("t0.ATRBAID AS CUSTOMERID");
		$this->db->select("t0.ATRBAP03 AS CUSTOMERCODE");
		$this->db->select("t3.ATRBTTYNM AS BILLINGTYPE");
		$this->db->select("t1.ATRBTNOG AS INVOICENO");
		$this->db->select("date_format(t1.ATRBTDT,'%d-%b-%Y') AS TRANSACTIONDATE",FALSE);
		$this->db->select("date_format(t1.ATRBTDTD,'%d-%b-%Y') AS RECEIPTDATE", FALSE);
		$this->db->select("format((sum(t2.ATRBTVAL) * if(find_in_set(2,t3.ATRBTTYFLAG),1,-(1))),0) AS AMOUNT", FALSE);
		$this->db->select("concat('l1+u1') AS BALANCE");
				
		$this->db->from("ta10_moratelv2_ap.ENTBA t0");
		$this->db->join("ta10_moratelv2_ap.ENTBT t1", "t1.ATRBAIDP = t0.ATRBAID", "left");
		$this->db->join("ta10_moratelv2_ap.ENTBT t2","t2.ATRBTIDP = t1.ATRBTID","left");
		$this->db->join("ta10_moratelv2_ap.ENTBTTY t3","t3.ATRBTTYID = t1.ATRBTTYID","left");
		
		$this->db->where("ifnull(t1.ATRBTIDP,0)",0);
		$wherein = 't3.ATRBTCID in (3,4,6)';
		$this->db->where($wherein);
		$this->db->where("t3.ATRBTTYNM", "Subscriber Invoice");
		$wheredate = "date_format(t1.ATRBTDT,'%Y-%m-%d') > (curdate() - interval 6 month)";
		$this->db->where($wheredate);
		$this->db->where("t0.ATRBAP03",  $custcode);
		
		$this->db->group_by("t0.ATRBAID"); 
		$this->db->group_by("t1.ATRBTID");
		return $this->db->get();
	}
	
	function get_billing_h($bilhistid){
		$this->db->select("t1.ATRBTID as HISTORYID");
		$this->db->select("t0.ATRBAID as CUSTOMERID");
		$this->db->select("t0.ATRBAP03 as CUSTOMERCODE");
		$this->db->select("t3.ATRBTTYNM as BILLINGTYPE");
		$this->db->select("t1.ATRBTNOG as INVOICENO");
		$this->db->select("t0.ATRBACD AS CONTRACTNO");
		$this->db->select("t0.ATRBAP10 AS INVno"); 
		$this->db->select("date_format(t1.ATRBTDT,'%d-%b-%Y') as TRANSACTIONDATE",FALSE);
		$this->db->select("date_format(t1.ATRBTDTD,'%d-%b-%Y') as RECEIPTDATE", FALSE);
		$this->db->select("format((sum(t2.ATRBTVAL) * if(find_in_set(2,t3.ATRBTTYFLAG),1,-(1))),0) as AMOUNT", FALSE);
		$this->db->select("t4.CUSTOMERNAME");
		$this->db->select("t4.BILLINGADDRESS");
		$this->db->select("t4.PHONE");
		$this->db->select("t4.MOBILE");
		//$this->db->select("'' as  FAX");
		//$this->db->select("'' as CUSTEMAIL");
		//$this->db->select("'' as DEFAULTPWD");
		$this->db->select("t4.email");
		//$this->db->select("'' as NPWP");
				
		$this->db->from("ta10_moratelv2_ap.ENTBA as t0");
		$this->db->join("ta10_moratelv2_ap.ENTBT as t1", "t1.ATRBAIDP = t0.ATRBAID", "left");
		$this->db->join("ta10_moratelv2_ap.ENTBT as t2","t2.ATRBTIDP = t1.ATRBTID","left");
		$this->db->join("ta10_moratelv2_ap.ENTBTTY as t3","t3.ATRBTTYID = t1.ATRBTTYID","left");
		$this->db->join("t_ms_customer as t4","t4.CUSTOMERID = t0.ATRBAID","left");
		
		$this->db->where("ifnull(t1.ATRBTIDP,0)",0);
		$wherein = 't3.ATRBTCID in (3,4,6)';
		$this->db->where($wherein);
		$this->db->where("t3.ATRBTTYNM", "Subscriber Invoice");
		$wheredate = "date_format(t1.ATRBTDT,'%Y-%m-%d') > (curdate() - interval 6 month)";
		$this->db->where($wheredate);
		$this->db->where("t1.ATRBTID",  $bilhistid);
		
		$this->db->group_by("t0.ATRBAID"); 
		$this->db->group_by("t1.ATRBTID");
		return $this->db->get();
	}
	
	
	function get_adm($custcode,$bln,$thn){	
	 	$this->db->select("t0.ATRBAID");
		$this->db->select("t4.ATRBENM as CustName");
		$this->db->select("t0.ATRBAP03 as CustCode");
		$this->db->select("t7.ATRLVNM as CustStat");
		$this->db->select("t8.*");
		$this->db->from("ta10_moratelv2_ap.ENTBA t0");
		$this->db->join("ta10_moratelv2_ap.ENTBAP t1","t1.ATRBAPID = t0.ATRBAPID","LEFT");
		//$this->db->join("ta10_moratelv2_ap.ENTBA t2","t2.ATRBAID = t0.ATRBAIDP","LEFT"); 
		$this->db->join("ta10_moratelv2_ap.ENTBE t4","t4.ATRBEID = t0.ATRBEID","LEFT"); 
		$this->db->join("ta10_moratelv2_ap.ENTBAC t6","t6.ATRBACID = t0.ATRBACID","LEFT");
		$this->db->join("ta10_moratelv2_ap.ENTLV t7","t7.ATRLVCD=t0.ATRBAST","LEFT");
		$this->db->join("self_care.t_tmp_billing_det t8","t0.ATRBAID = t8.ATRBAIDP","INNER");
		$this->db->where("t6.ATRBACNM","Customer");
		$this->db->where("t7.ATRLVTYID",8); 
		$this->db->where("t0.ATRBAP03",$custcode);
		$this->db->where("MONTH(t8.ATRBTDT)",$bln);
		$this->db->where("YEAR(t8.ATRBTDT)",$thn);		
		$pname = array('PPN','Biaya Administrasi');
		$this->db->where_in('t8.PRODUCTNAME',$pname);
		$this->db->order_by("t8.PRODUCTNAME","ASC");
		return $this->db->get();
	}	

	
	function get_billing_d($historyid){
		$this->db->select("t0.ATRBTID AS ATRBTID");
		$this->db->select("t3.ATRBTNOG AS INVOICENO");
		$this->db->select("t0.ATRBAIDP AS ATRBAIDP");
		$this->db->select("t0.ATRBTIDP AS ATRBTIDP");
		$this->db->select("date_format(t3.ATRBTDTD,'%d-%b-%Y') AS DUEDATE",FALSE);
		$this->db->select("date_format(t3.ATRBTDT,'%d-%b-%Y') AS INVOICE_PERIODE",FALSE);
		$this->db->select("t1.ATRBIID AS TRBCD");
		$qrys1 ="if((t3.ATRBTDTP > '2012-06-25'),concat(substring_index(substr(t0.ATRBTDSC,9,200),'(',1),if((length(substring_index(substr(t0.ATRBTDSC,9,200),'(',1)) > 1),concat(' '),''),t1.ATRBINM),t1.ATRBINM) AS DESCRIPTION";
		$this->db->select($qrys1,FALSE);
		$this->db->select("format(t0.ATRBTQTY,2) AS QUANTITY",FALSE);
		$this->db->select("cast(t0.ATRBTVALU as unsigned) AS PRICE",false);
		$this->db->select("t0.ATRBTVAL AS TOTAL_PRICE");
		$qrys1 ="concat(date_format(if(t0.ATRBTVSA,t0.ATRBTVSA,t3.ATRBTDT),'%d %b %y'),' - ',date_format(if(t0.ATRBTVSO,t0.ATRBTVSO,((t3.ATRBTDT + interval 1 month) - interval 1 day)),'%d %b %y')) AS PERIODE";
		$this->db->select($qrys1,FALSE);
		$this->db->from("ta10_moratelv2_ap.ENTBT t0");
		$this->db->join("ta10_moratelv2_ap.ENTBI t1","t1.ATRBIID = t0.ATRBIID","LEFT"); 
		$this->db->join("ta10_moratelv2_ap.ENTUNIT t2","t2.ATRUNITID = t0.ATRUNITID","LEFT");
		$this->db->join("ta10_moratelv2_ap.ENTBT t3","t3.ATRBTID = t0.ATRBTIDP","LEFT"); 
		$names = array(1,2,3,4,10);
		$this->db->where_in('t0.ATRTRFTYID', $names);
		$this->db->where("t0.ATRBIID !=",643); 
		$this->db->where("t0.ATRBTIDP",$historyid);
		$this->db->order_by("t1.ATRBICID","ASC");
		return $this->db->get();
	}

}
// END Billing model Class

/* End of file Billing model.php */ 
/* Location: ./system/application/model/Billing model.php */