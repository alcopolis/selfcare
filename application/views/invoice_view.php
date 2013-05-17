<!DOCTYPE html>
<html>
<head>
	<title>Billing Invoice</title>  
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/base.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/simple.css" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.8.1.min.js"></script>   
    <script type="text/javascript" src="<?=base_url()?>scripts/jquery.masonry.min.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>scripts/main.js"></script>
   	
    <style type="text/css">
		body{background:none; margin:0; padding-top:40px; }
	</style>
    
    <script type="text/javascript">
		$(function(){
			var h = $(document).height() + 80;
			parent.resizeIFrame(h);
			console.log(h);
		});
	</script>
</head>
<body>
<div id="status-bar">
    <p style="width:75%; margin:0 auto;">
    	<a href="<?php echo base_url(); ?>/billing_control/billing_email/<?php echo $invoiceid;?>" target="_parent" style="background:url(../../images/icons/email.png) no-repeat 0 2px ; padding:1% 1% 1% 30px; color:#666; font-size:12px; font-weight:bold; text-decoration:none;">Anda mempunyai pertanyaan mengenai tagihan ini ?</a>
    </p>
</div>
        
                 
<div id="invoice"> 
  <div id="invoice-header"> <img alt="Mainlogo_large" class="logo screen" src="<?php echo base_url();?>images/logo.png" /> 
    <!-- hCard microformat --> 
    <div id="company-address"> 
      	<h3>PT. MORA QUATRO MULTIMEDIA</h3> 
		<i>Powered By PT Mora Telematika Indonesia</i>
        <p>
            Grha9, 2nd Floor Jl. Penataran No. 9 Proklamasi<br/> 
            Jakarta Pusat, Indonesia 10320<br />
            Tel. 021 31998600 Fax. 021 3927931 
        </p>  
    </div> 
    <!-- company-address vcard --> 
  </div> 
  <!-- #invoice-header --> 
  <div id="invoice-info"> 
    <h1 class="left" style="margin:0;">INVOICE</h1>
    <table class="right" style="width:200px; text-align:center;" cellspacing="0" border="1" bordercolor="#000000" bordercolorlight="#000000" bordercolordark="#000000">
    	<tr><td>Kode Pelanggan</td></tr>
        <tr><td><?php echo $kdcust;?></td></tr>
    </table>
    
    <br class="clearfloat" />
    
    <table style="width:100%; text-align:center; margin:10px 0;" cellspacing="0" border="1" bordercolor="#000000" bordercolorlight="#000000" bordercolordark="#000000" >
    	<tr class="first">
        	<th>No</th>
            <th>Tanggal Cetak Tagihan/<br /> Statement Date</th>
            <th>Tanggal Jatuh Tempo/<br /> Due Date</th>
            <th>No. Kontrak/ <br />Contract No</th>
            <th>Total Tagihan Bulan Ini/ <br />Total Amount</th>
            <th>NPWP</th>
        </tr>
        <tr>
        	<td><?php echo $invoice . "(".$invno.")"; ?></td>
            <td><?php echo $trdate; ?></td>
            <td><?php echo $jthtmp; ?></td>
            <td><?php echo $ctrtno; ?></td>
            <td><?php echo "Rp. ". $totalbayar;//echo "Rp. ".$ttltagihan; ?></td>
            <td></td>
        </tr>
    </table>
     
    <div class="vcard left" id="client-details"> 
        <p>
        	Kepada<br />
            <span class="bold"><?php echo $nmcust; ?></span>
        </p> 
        <p>
           <?php echo $billaddr; ?><br /><br />
            Attention:<br />
            Phone: <?php 
			if($phone != ''){ echo $phone. " "; } else {echo $mobile;} ?> 
			Fax:<?php echo $fax; ?><br />
			Email : <?php echo $email; ?>
        </p> 
    </div> 
    <!-- #client-details vcard -->
      
    <table class="right" style="width:250px; text-align:center;" cellspacing="0" border="1" bordercolor="#000000" bordercolorlight="#000000" bordercolordark="#000000">
    	<tr><td>Customer Service:</td></tr>
        <tr><td>Tel. 021 31998600, Fax. 021 3927931</td></tr>
    </table>
    
    <br class="clearfloat" /> 
  </div> 
  <!-- #invoice-info --> 
  
  <table width="1101" id="invoice-amount"> 
    <thead> 
      <tr id="header_row"> 
        <th class="item_c first">Keterangan/<br />Description</th> 
        <th class="item_c">Periode/<br />Period</th> 
        <th class="item_c">Pemakaian/<br />Usage</th> 
        <th class="item_c">Harga/Unit/<br />Price/Unit <br />(Rupiah)</th> 
        <th class="item_c">Total <br />(Rupiah)</th> 
      </tr> 
    </thead> 
    <?php 
	$subtotal = 0;$disc = 0 ;
	foreach ($bildet as $row){ ?>
    <tbody>
      <tr class="item odd"> 
        <td class="item_l"><?=$row->DESCRIPTION?></td> 
        <td class="item_c"><?=$row->PERIODE?></td> 
        <td class="item_c"><?=$row->QUANTITY?></td> 
        <td class="item_c"><?=number_format($row->PRICE)?></td> 
        <td class="item_r"><?=number_format($row->TOTAL_PRICE)?></td> 
      </tr> 
    </tbody>
   <?php
	if ($row->TOTAL_PRICE>0){$subtotal = $subtotal + $row->TOTAL_PRICE;}
	if ($row->TOTAL_PRICE<0){$disc = $disc + $row->TOTAL_PRICE;}
   } ?>
   <tfoot> 
      <tr id="discount_tr"> 
        <td colspan="2">&nbsp;</td> 
        <td colspan="2" class="item_r bold">Sub Total</td> 
        <td class="item_r"><b><u><?php echo number_format($totax = $subtotal + $disc);?></u></b></td> 
      </tr> 
<!--  <tr id="net_total_tr"> 
        <td colspan="2">&nbsp;</td> 
        <td colspan="2" class="item_r bold">Discount</td> 
        <td class="item_r"><?php //echo number_format($disc);?></td> 
      </tr> 
-->
      <tr id="vat_tr"> 
        <td colspan="2">&nbsp;</td> 
        <td colspan="2" class="item_r bold">Subject to Tax</td> 
        <td class="item_r"><?php echo number_format($totax); ?></td> 
      </tr>
      <tr id="vat_tr"> 
        <td colspan="2">&nbsp;</td> 
        <td colspan="2" class="item_r bold">VAT 10%</td> 
        <td class="item_r"><?php 
			if($ppn!=0){
				echo number_format($ppn);
			}else{
				$vat = (0.10 * $totax);
				echo number_format($vat);
			}
		?></td> 
      </tr>
      <tr id="vat_tr"> 
        <td colspan="2">&nbsp;</td> 
        <td colspan="2" class="item_r bold">Biaya Administrasi</td> 
        <td class="item_r"><?php 
			if($administrasi!=0){
				echo number_format($administrasi);
			}else{
				$administrasi=5000;
				echo number_format($administrasi);
			}
		?></td> 
      </tr>
  
      <tr id="total_tr"> 
        <td colspan="2">&nbsp;</td> 
        <td colspan="2" class="total">Tagihan Bulan Ini</td> 
        <td class="total"><?php echo $ttltagihan;//number_format($ttl=$totax + $vat);?></td> 
      </tr>
    </tfoot> 
  </table>
  
  <table width="100%" style="margin-top:20px; border:1px solid #000;" cellspacing="0" cellpadding="2">
   	<tr><td colspan="2" align="center" style="border-bottom:1px solid #000;" class="bold">Ringkasan Tagihan (Termasuk PPN dalam Rupiah)</td></tr>
        <tr>
        	<td align="left">Total tagihan sebelumnya/Previous Balance
        	  <?=$previnvno?> 
       	    (A)</td>
            <td align="right"><?=$prevbal?></td>
        </tr>
        <tr>
        	<td align="left">Pembayaran terakhir/Last Payment <?=$lastpaydate?> (B)</td>
            <td align="right"><?=$lastpayment?></td>
        </tr>
        <tr>
        	<td align="left">Total tagihan sebelum /  Previous Balance Before
       	    <?=$trdate?> (A+B)</td>
            <td align="right"><?=$curbalance?></td>
        </tr>
        <tr>
        	<td align="left">Tagihan bulan ini Invoice No./Current Charges<?=$curinvno?></td>
            <td align="right"><?=$curinvpay?></td>
        </tr>
        <?php if($adjustment!=0){?>
       	<tr>
        	<td align="left">Koreksi Sampai <?=$trdate?></td>
            <td align="right"><?=$adjustment?></td>
        </tr>
        <?php } ?>
        <tr>
        	<td align="left"><b>Total tagihan bulan ini/Total Amount</b></td>
            <td align="right"><b><?=$totalbayar?></b></td>
        </tr>
        
  </table>
    <table width="100%" style="border:1px solid #000;">
	     <tr id="terbilang_tr"> 
    	    <td colspan="5">Terbilang/ Ammount In Words:<br /> # <?php echo $tbilang." rupiah / ". $etbilang . " rupiahs";  ?> #</td> 
      	</tr> 
    </table>
    
    <div id="payment-details"> 
    <p class="bold">Transfer Pembayaran:</p> 
    <div>Nomor Virtual Account <span class="bold">BCA</span> anda adalah / Your BCA Virtual Account is <span class="bold">00343<?=$vabca?></span></div> 
    <div>Nomor Virtual Account <span class="bold">Mandiri</span> anda adalah / Your MANDIRI Virtual Account is <span class="bold"><?=$vamandiri?></span> dengan sebelum nya memasukan kode perusahaan/with institution code which is input before: <span class="bold">99000</span></div>
    <div>Masukkan nomor Virtual Account anda pada nomor rekening yang dituju ketika akan melakukan aktivitas transfer via Bank BCA atau Bank Mandiri</div>
    
  </div> 
  <!-- payment-details --> 
  
  <div id="comments" style="width:100%;">
  	<p class="bold" style="text-align:center;"><em>Terima kasih telah menggunakan Jasa Layanan dari CEPATnet</em></p>
    <ol>
        <li>Pembayaran bulanan dapat dilakukan melalui transfer Bank BCA &amp; Bank Mandiri.</li>
        <li>Mohon cantumkan No ID Pelanggan saat melakukan pembayaran via Bank Mandiri atau bukti setoran difax ke nomor 021-3927931</li>
        <li>Kekurangan, keterlambatan dan ketidakjelasan data pembayaran dapat mengakibatkan terblokirnya layanan anda.</li>
        <li>Tidak sampainya tagihan ini tidak menghilangkan kewajiban pelanggan untuk membayar tagihan.</li>
        <li>Tagihan hanya kan dikirimkan melalui e-mail &amp; SMS sesuai data terlampir dari pelanggan.</li>
        <li>Apabila ada hal-hal yang kurang jelas, silahkan menghubungi Customer Service kami di no telp 021-31998600.</li>
        <li>Mohon abaikan tagihan ini apabila Bapak/Ibu sudah melakukan pembayaran sebelumnya.</li>
    </ol>
  </div> 
  <!-- comments --> 
</div> 
</body>
</html>