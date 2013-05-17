<!DOCTYPE html>
<html>
<head>
<style type="text/css">
body {margin: 0;padding: 0;line-height: 1.6em;font:80%/1.5 Helvetica, Arial, Verdana, sans-serif;background: #fff;}
ul, ul li, p, ol {margin:0;padding:0;}
</style>
	<title>Billing Invoice</title>
</head>
<body>
<div style="margin-top:0.3cm; border-bottom:1px solid #000;padding-bottom:10px; overflow:hidden">
<table width="100%"><tr>
  	<td align="left"><img alt="Mainlogo_large" class="logo screen" src="<?php echo base_url();?>images/logo.png" /></td>
    <!-- hCard microformat --> 
    <td align="right">
      	<h3>PT. MORA QUATRO MULTIMEDIA</h3> 
		<i>Powered By PT Mora Telematika Indonesia</i>
        <p>
            Grha9, 2nd Floor Jl. Penataran No. 9 Proklamasi<br/> 
            Jakarta Pusat, Indonesia 10320<br />
            Tel. 021 31998600 Fax. 021 3927931 
        </p>
    </td>
    <!-- company-address vcard --> 
</tr></table>
</div>
  <!-- #invoice-header --> 
<table width="100%"><tr>
	<td align="left" valign="top"><h1 class="left" style="margin:0;">INVOICE</h1></td>
    <td align="right">
    <table style="width:200px; text-align:center;border-collapse: collapse;" cellspacing="0" border="1">
    	<tr>
    	  <td>Kode Pelanggan/<em>Customer ID</em></td></tr>
        <tr><td><?php echo $kdcust;?></td></tr>
    </table>
    </td>
</tr></table>    
<table style="width:100%; text-align:center; margin:10px 0; border-collapse: collapse;" 
    cellspacing="0" border="1" >
    	<tr bgcolor="#CCC" >
        	<th>Invoice No</th>
            <th>Tgl Cetak Tagihan/<br />Statement Date</th>
            <th>Tgl Jatuh Tempo/<br />Due Date</th>
            <th>No.Kontrak/<br />Contract No</th>
            <th>Total Tagihan/<br />Total Amount</th>
            <th>NPWP</th>
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
<table style="width:100%;">
  <tr>
    <td>
        <p>
        	Kepada<br />
            <span class="bold"><strong><?php echo $nmcust; ?></strong></span>
        </p>
        <!-- #client-details vcard -->
        <p>
			<?php echo $billaddr; ?><br /><br />
            Attention:<br />
            Phone: <?php 
            if($phone != ''){ echo $phone. " "; } else {echo $mobile;} ?> 
            Fax:<?php echo $fax; ?><br />
            Email : <?php echo $email; ?>
        </p> 

    </td>
    <td align="right" style="vertical-align:text-top;">
    <table style="width:250px; text-align:center;border-collapse: collapse;" cellspacing="0" border="1" bordercolor="#000000" bordercolorlight="#000000" bordercolordark="#000000">
    	<tr><td><strong>Customer Service:</strong></td></tr>
        <tr><td>Tel. 021 31998600, Fax. 021 3927931</td></tr>
    </table>
    </td>
  </tr>
    </table>

  
  <!-- #invoice-info -->
  <table width="100%"> 
    <thead> 
      <tr style="background-color:#CCC;"> 
        <th style="border-bottom:2px double;border-top:1px solid;">Keterangan/<br /><em>Description</em></th>
        <th style="border-bottom:2px double;border-top:1px solid;">Periode/<br />
        <em>Period</em></th> 
        <th style="border-bottom:2px double;border-top:1px solid;">Pemakaian/<br />
        <em>Usage</em></th> 
        <th style="border-bottom:2px double;border-top:1px solid;">Harga/Unit/<br />
        <em>Price/Unit</em></th> 
        <th style="border-bottom:2px double;border-top:1px solid;">Total<br />(Rupiah)</th> 
      </tr> 
    </thead> 
    <?php 
	$subtotal = 0;$disc = 0 ;
	foreach ($bildet as $row){ ?>
    <tbody>
      <tr> 
        <td><?=$row->DESCRIPTION?></td> 
        <td align="center"><?=$row->PERIODE?></td> 
        <td align="center"><?=$row->QUANTITY?></td> 
        <td align="right"><?=number_format($row->PRICE)?></td> 
        <td align="right"><?=number_format($row->TOTAL_PRICE)?></td> 
      </tr> 
    </tbody>
   <?php
	if ($row->TOTAL_PRICE>0){$subtotal = $subtotal + $row->TOTAL_PRICE;}
	if ($row->TOTAL_PRICE<0){$disc = $disc + $row->TOTAL_PRICE;}
   } ?>
   <tfoot> 
      <tr> 
        <td colspan="2" rowspan="5" style="border-top:1px solid;">&nbsp;</td> 
        <td colspan="2" style="border-top:1px solid;border-bottom:1px solid;"><strong>Sub Total</strong></td> 
        <td align="right" style="border-top:1px solid;border-bottom:1px solid;"><strong><?php echo number_format($totax = $subtotal + $disc);?></strong></td> 
      </tr> 
      <tr> 
        <td colspan="2"><strong>Subject to Tax</strong></td> 
        <td align="right"><?php echo number_format($totax); ?></td> 
      </tr>
      <tr> 
        
        <td colspan="2"><strong>VAT 10%</strong></td> 
        <td align="right"><?php echo number_format($ppn);//number_format($vat= (0.10 * $totax));?></td> 
      </tr>
      <tr> 
        <td colspan="2"><strong>Biaya Administrasi</strong></td> 
        <td align="right"><?php echo number_format($administrasi);?></td> 
      </tr>
  
      <tr> 
        <td colspan="2" class="total" style="border-top:1px solid;border-top:1px solid;"><strong>Tagihan Bulan Ini</strong></td> 
        <td align="right" style="border-top:1px solid;border-top:1px solid;"><strong><?php echo $ttltagihan;//number_format($ttl=$totax + $vat);?></strong></td> 
      </tr>
    </tfoot> 
  </table>
  
  <table width="100%" style="margin-top:20px; border:1px solid #000;" cellspacing="0" cellpadding="2">
   	<tr>
    <td colspan="2" align="center" style="border-bottom:1px solid #000;" class="bold"><strong>Ringkasan Tagihan (Termasuk PPN dalam Rupiah)</strong></td></tr>
        <tr>
        	<td align="left">Total tagihan sebelumnya/<em>Previous Balance</em>
<?=$previnvno?> (A)</td>
            <td align="right"><?=$prevbal?></td>
        </tr>
        <tr>
        	<td align="left">Pembayaran terakhir/<em>Last Payment</em>
<?=$lastpaydate?> (B)</td>
            <td align="right"><?=$lastpayment?></td>
        </tr>
        <tr>
        	<td align="left">Total tagihan sebelum /<em> Previous Balance Before</em>
<?=$trdate?> (A+B)</td>
            <td align="right"><?=$curbalance?></td>
        </tr>
        <tr>
        	<td align="left">Tagihan bulan ini Invoice No./<em>Current Charges </em><?=$curinvno?></td>
            <td align="right"><?=$curinvpay?></td>
        </tr>
        <tr>
        	<td align="left"><b>Total tagihan bulan ini/<em>Total Amount</em></b></td>
            <td align="right"><b><?=$totalbayar?></b></td>
        </tr>
        
</table>
    <table width="100%" style="border:1px solid #000;">
	     <tr id="terbilang_tr"> 
    	    <td colspan="5">Terbilang/ <em>Ammount In Words</em>:<br /> 
   	       # <?php echo $tbilang." rupiah /<em>". $etbilang . " rupiahs </em>";  ?> #</td> 
      	</tr> 
    </table>
<br style="clear:both;" />
<div>    
    <p><strong>Transfer Pembayaran:</strong></p> 
    <div>Nomor Virtual Account <span class="bold">BCA</span> anda adalah / Your <strong>BCA</strong> Virtual Account is <strong>00343
    <?=$vabca?>
    </strong></span></div> 
    <div>Nomor Virtual Account <span class="bold">Mandiri</span> anda adalah / Your <strong>MANDIRI</strong> Virtual Account is<strong>
    <?=$vamandiri?>
    </strong></span> dengan sebelum nya memasukan kode perusahaan/with institution code which is input before: <span class="bold"><strong>99000</strong></span></div>
    <div>Masukkan nomor Virtual Account anda pada nomor rekening yang dituju ketika akan melakukan aktivitas transfer via Bank <strong>BCA</strong> atau Bank Mandiri</div>
</div>    
  <!-- payment-details -->
<br style="clear:both;" /> 
<div>
  <p style="text-align:center;"><em><strong>Terima kasih telah menggunakan Jasa Layanan dari CEPATnet</strong></em></p>
    <table width="100%" style="border-collapse: collapse;" border="1" cellpadding="10"><tr><td>
    <ol type="a">
        <li>Pembayaran bulanan dapat dilakukan melalui transfer Bank <strong>BCA</strong> &amp; Bank Mandiri.</li>
        <li>Mohon cantumkan No ID Pelanggan saat melakukan pembayaran via Bank<strong> Mandiri </strong>atau bukti setoran difax ke nomor 021-3927931</li>
        <li>Kekurangan, keterlambatan dan ketidakjelasan data pembayaran dapat mengakibatkan terblokirnya layanan anda.</li>
        <li>Tidak sampainya tagihan ini tidak menghilangkan kewajiban pelanggan untuk membayar tagihan.</li>
        <li>Tagihan hanya kan dikirimkan melalui e-mail &amp; SMS sesuai data terlampir dari pelanggan.</li>
        <li>Apabila ada hal-hal yang kurang jelas, silahkan menghubungi Customer Service kami di no telp 021-31998600.</li>
        <li>Mohon abaikan tagihan ini apabila Bapak/Ibu sudah melakukan pembayaran sebelumnya.</li>
    </ol>
    </td></tr></table>
</div>
  <!-- comments --> 
</body>
</html>