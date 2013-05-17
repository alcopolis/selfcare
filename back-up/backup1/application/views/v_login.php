<!DOCTYPE html>
<html>
<head>
		<title>Web Selfcare</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>styles/layout.css" type="text/css" />
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.8.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/main.js"></script>
</head>

<body id="top">
<div id="header">
  <div class="wrapper">   
    <div id="branding">
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
	 	<li class="item64"><a href="#"><span>Login</span></a></li>
	</ul>
    
    <div class="clear"></div>
  </div>
</div>
<!-- ####################################################################################################### -->
<div id="content">
	<div class="wrapper">
		<div class="default-content">
			<div id="side" class="left">
				<div id="side-header">
					
				</div>
				<div id="side-body">
					<div id="login">
						<?php 
							$attributes = array('name' => 'login_form', 'id' => 'login_form');
	    					echo form_open('c_login/process_login', $attributes);
						?>
						
						<p class="label">Username</p>
						<input type="text" name="username" size="15"  value="<?php echo set_value('username');?>"/><br/>
						<p class="label">Password</p>
						<input type="password" name="password" size="15" value="<?php echo set_value('password');?>"/>
						<br /><br />
						<input type="submit" name="login" id="button" value="Login" />
                    <p class="label"><?php
						$message = $this->session->flashdata('message');
						echo $message == '' ? '' : '<strong>' . $message . '</strong>' 
					?></p>
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

</body>
</html>