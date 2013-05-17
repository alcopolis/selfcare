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
					<div id="customer-name"><?php echo $default['customername'] ?></div>
					<div id="customer-id">Acc. Number : <?php echo $default['customercode'] ?></div>
                    <?php /*?><div id="customer-email"><?php echo $default['email'] ?></div><?php */?>
				</div>
				<div id="side-body">
					<ul id="cust-menu">
				        <li><a href="welcome">Home</a></li>
				        <li><a href="c_cust">Profile</a>
					      <!--<ul>
				            <li><a href="c_cust">Lihat Profil</a></li>
				            <li><a href="#">Ubah Profil</a></li>
				            <li><a href="#">Ganti Password</a></li>            
				          </ul>-->
				        </li>
				        <li><a href="c_package">Package</a>
				          <!--<ul>
				            <li><a href="c_package">Paket Anda</a></li>
				            <li><a href="#">Tambah/Modifikasi</a></li>
				          </ul>-->
				        </li>
				        <li><a href="c_billing">Billing Info</a></li>
				    </ul>
                    <a href="c_login/logout" class="logout">Log Out</a>
				</div>
			</div>
<!-- ####################################################################################################### -->