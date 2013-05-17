<!DOCTYPE html>
<html>
<head>
	<title>Billing Invoice</title>  
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/base.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/simple.css" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.8.1.min.js"></script>    
    <script type="text/javascript" src="<?php echo base_url(); ?>scripts/main.js"></script>
	
</head>
<body> 
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
        	<td>Nomor</td>
            <td>Tanggal Cetak Tagihan</td>
            <td>Tanggal Jatuh Tempo</td>
            <td>No. Kontrak</td>
            <td>Total Tagihan Bulan Ini</td>
            <td>NPWP</td>
        </tr>
        <tr>
        	<td><?php echo $invoice . "(". $invno .")"; ?></td>
            <td><?php echo $trdate; ?></td>
            <td><?php echo $jthtmp; ?></td>
            <td><?php echo $ctrtno; ?></td>
            <td><?php echo "Rp. ".$ttltagihan; ?></td>
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
  
  <table id="invoice-amount"> 
    <thead> 
      <tr id="header_row"> 
        <th class="item_c first">Keterangan</th> 
        <th class="item_c">Periode</th> 
        <th class="item_c">Pemakaian</th> 
        <th class="item_c">Harga/Unit (Rupiah)</th> 
        <th class="item_c">Total (Rupiah)</th> 
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
        <td class="item_r"><?php echo number_format($subtotal);?></td> 
      </tr> 
<!--      <tr id="net_total_tr"> 
        <td colspan="2">&nbsp;</td> 
        <td colspan="2" class="item_r bold">Discount</td> 
        <td class="item_r"><?php //echo number_format($disc);?></td> 
      </tr> 
-->
      <tr id="vat_tr"> 
        <td colspan="2">&nbsp;</td> 
        <td colspan="2" class="item_r bold">Subject to Tax</td> 
        <td class="item_r"><?php echo number_format($totax = $subtotal + $disc); ?></td> 
      </tr>
      <tr id="vat_tr"> 
        <td colspan="2">&nbsp;</td> 
        <td colspan="2" class="item_r bold">VAT 10%</td> 
        <td class="item_r"><?php echo number_format($vat= (0.10 * $totax));?></td> 
      </tr>
      <tr id="vat_tr"> 
        <td colspan="2">&nbsp;</td> 
        <td colspan="2" class="item_r bold">Biaya Administrasi</td> 
        <td class="item_r">5,000</td> 
      </tr>
  
      <tr id="total_tr"> 
        <td colspan="2">&nbsp;</td> 
        <td colspan="2" class="total">Tagihan Bulan Ini</td> 
        <td class="total"><?php echo number_format($ttl=$totax + $vat);?></td> 
      </tr>
      <tr id="terbilang_tr"> 
        <td colspan="5">Terbilang: #dua ratus delapan puluh ribu rupiah#</td> 
      </tr> 
    </tfoot> 
  </table>
  <!-- invoice-amount --> 
  
  <div id="invoice-promo"> 
    <p class="bold">
        DAPATKAN FREE BIAYA BULANAN SELAMA 1 ATAU 2 BULAN<br /> 
        * Bila pembayaran selama 6 bulan dimuka (Free 1 bulan di bulan ke 7)<br />
        * Bila pembayaran selama 12 bulan dimuka (Free 2 bulan di bulan ke 13 dan 14)
    </p>
  </div> 
  <!-- invoice-promo --> 
  
  <div id="payment-details"> 
    <p class="bold">Transfer Pembayaran:</p> 
    <div>Nomor Virtual Account <span class="bold">BCA</span> anda adalah <span class="bold">9015124752</span></div> 
    <div>Nomor Virtual Account <span class="bold">Mandiri</span> anda adalah <span class="bold">101004796</span></div>
    <div>Masukkan nomor Virtual Account anda pada nomor rekening yang dituju ketika akan melakukan aktivitas transfer via Bank BCA atau Bank Mandiri</div>
    
    <table style="width:350px; margin-top:20px; border:1px solid #000;" cellspacing="0" cellpadding="2">
    	<tr><td colspan="2" align="center" style="border-bottom:1px solid #000;" class="bold">Ringkasan Tagihan (Termasuk PPN dalam Rupiah)</td></tr>
        <tr>
        	<td align="left">Total tagihan sebelumnya 1112.0001475 (A)</td>
            <td align="right">280,000</td>
        </tr>
        <tr>
        	<td align="left">Pembayaran terakhir 26-Dec-2011 (B)</td>
            <td align="right"><span class="red">(280,000)</span></td>
        </tr>
        <tr>
        	<td align="left">Total tagihan sebelum 20-Jan-2012 (A+B)</td>
            <td align="right">0</td>
        </tr>
        <tr>
        	<td align="left">Tagihan bulan ini Invoice No. 1201.0001466</td>
            <td align="right">280,000</td>
        </tr>
        <tr>
        	<td align="left">Total tagihan bulan ini</td>
            <td align="right">280,000</td>
        </tr>
    </table>
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