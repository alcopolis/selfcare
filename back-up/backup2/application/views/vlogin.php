<!DOCTYPE html>
<html>
<head>
<title>Web Selfcare</title>
	<link rel="stylesheet" href="<?=base_url()?>styles/layout.css" type="text/css" />
	<script type="text/javascript" src="<?=base_url()?>scripts/jquery-1.8.1.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>scripts/main.js"></script>
	<script type="text/javascript">
		$(function(){
			var sideH = $('#side').height();
			var contentBodyH = $('#content-wrap').innerHeight();
			
			console.log(sideH + ' : ' + contentBodyH);
			
			if(sideH < contentBodyH){
				$('#side').css('height', contentBodyH);
			};
		});
	</script>
</head>
<body id="top">
<div id="header" style="background:#163F75; padding:0;">
  <div class="wrapper">   
    <?php /*?><div id="branding">
	 	<a href="#">
	 		<img src="<?php echo base_url();?>images/cepat-net-logo.png" title="CepatNet" width="150"/>
	 	</a>
	</div>
	<ul class="menu">
	 	<li id="current" class="active item1"><a href="http://localhost/mqm-jo/"><span>Home</span></a></li>
	 	<li class="item53"><a href="../broadband-internet"><span>Broadband Internet</span></a></li>
	 	<li class="item54"><a href="/mqm-jo/tv-cable"><span>TV Cable</span></a></li>
	 	<li class="item55"><a href="/mqm-jo/telephone"><span>Telephone</span></a></li>
	 	<li class="item56"><a href="http://localhost/cepatnet/portal/retail/corporate-home.php"><span>Corporate</span></a></li>
	</ul><?php */?>
    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="970" height="337" id="header" align="middle">
		<param name="movie" value="<?=base_url()?>images/header.swf" />
		<param name="quality" value="high" />
		<param name="bgcolor" value="#b00300" />
		<param name="play" value="true" />
		<param name="loop" value="true" />
		<param name="wmode" value="window" />
		<param name="scale" value="showall" />
		<param name="menu" value="true" />
		<param name="devicefont" value="false" />
		<param name="salign" value="" />
		<param name="allowScriptAccess" value="sameDomain" />
		<!--[if !IE]>-->
		<object type="application/x-shockwave-flash" data="<?=base_url()?>images/header.swf" width="970" height="337">
			<param name="movie" value="header.swf" />
			<param name="quality" value="high" />
			<param name="bgcolor" value="#b00300" />
			<param name="play" value="true" />
			<param name="loop" value="true" />
			<param name="wmode" value="window" />
			<param name="scale" value="showall" />
			<param name="menu" value="true" />
			<param name="devicefont" value="false" />
			<param name="salign" value="" />
			<param name="allowScriptAccess" value="sameDomain" />
		<!--<![endif]-->
			<a href="http://www.adobe.com/go/getflash">
				<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
			</a>
		<!--[if !IE]>-->
		</object>
		<!--<![endif]-->
	</object>
  </div>
</div>
<!-- ####################################################################################################### -->
<div id="content">
	<div class="wrapper">
		<div class="default-content">
			<div id="side" class="left">
				<div id="side-header">
					<a href="<?=base_url()?>customer/forgetpwd"><div id="customer-name">Forgot Your Password?</div></a>
				</div>
				<div id="side-body">
					<div id="login">
					<?php 
						$form = array('name' => 'login_form', 'id' => 'login_form');
						echo form_open('welcome/login',$form);						
						$username = array('name'=>'username','id'=> 'username', 'maxlength'=> '100','size'=> '20',
								'value'=>set_value('username'));
						$password = array('name'=>'password','size'=>'20','value'=>set_value('password'));
						$login = array('name'=>'login','id'=>'button','value'=>'Login');
						
					?>
					
                    <p class="label">Username</p><?=form_input($username)?>
                    <p class="label">Password</p><?=form_password($password)?><br /><br />
                    <?=form_submit($login)?>
                    <p class="label"><?=isset($pesan) ? $pesan : ''?></p>
                    <?=form_close()?>
					</div>
				</div>
			</div>
			<div id="content-wrap" class="left">
				<div id="content-body" style="margin:0; width:auto;">
					<img style="margin:0; padding:0; width:102%;" src="<?php echo base_url();?>images/cod-welcome.png">
				</div>	
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>

<!-- ####################################################################################################### -->
<?php /*
<div id="footer">
	<div class="wrapper">
		<div class="footer-menu">
            <h4>I Want To</h4>
            <ul class="vm">
            	<li><a href="map.php">View Coverage Map</a></li>
                <li><a href="http://192.168.10.10:8080/MoraCod/setupLoginCustomer.action" target="_blank">View My Packages / Change Packages</a></li>
                <!--<li><a href="http://192.168.10.10:8080/MoraCod/GetMyPackageForTransaction.action" target="_blank">View My Packages / Change Packages</a></li>
                <li><a href="http://192.168.10.10:8080/MoraCod/SetupListProfileCustomer.action" target="_blank">View My Profile</a></li>-->
            </ul>
        </div>
        
        <div class="footer-menu">
            <h4>Shop</h4>
            <ul class="vm">
            	<li><a href="product-inet.php">Internet Packages</a></li>
                <li><a href="product-tv.php">TV Packages</a></li>
                <li><a href="http://homelinks.cepat.net.id">OTT Mobile</a></li>
                <!-- <li><a href="#">Wi-Eye Services</a></li> -->
            </ul>
        </div>
        
        <div class="footer-menu">
            <h4>Help &amp; Support</h4>
            <ul class="vm">
            	<li><a href="support-payment.php">Payment</a></li>
                <!--<li><a href="#">Troubleshoot &amp; Resolve</a></li>-->
                <li><a href="support-id.php">Support</a></li>
                <li><a href="support-faqs.php">FAQs</a></li>
            </ul>
        </div>
        
        <div class="footer-menu">
            <h4>Contact</h4>
            <p>
            	Grha 9, 4th Floor<br />
                Jl. Panataran No. 9, Proklamasi<br />
                Jakarta Pusat 10320, Indonesia<br />
            </p>
            <p id="phone">+6221 31998600</p>
            <p id="fax">+6221 3927931</p>
            <p>&copy; 2012 CepatNet. All rights reserved</p>
        </div>
        
        <div class="clear"></div>
	</div>
</div>
*/ ?>

<div id="footer" style="text-align:center; color:#FFF; background:#2E1010; padding:10px;">
	<p>&copy; 2012 CEPATnet. All rights reserved.<br />
	Grha 9 Building. Jl. Panataran No 9, Proklamasi, Jakarta 10320 Phone: +62-21-31998600 Fax: +62-21-3160897</p>
</div>

</body>
</html>
