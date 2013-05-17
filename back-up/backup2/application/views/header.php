<!DOCTYPE html>
<html>
<head>
		<title>Web Selfcare</title>
        <link rel="stylesheet" href="<?=base_url()?>styles/layout.css" type="text/css" />
		<script type="text/javascript" src="<?=base_url()?>scripts/jquery-1.8.1.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>scripts/main.js"></script>
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
					<div id="customer-name"><?php echo $default['customername'] ?></div>
					<div id="customer-id">Acc. Number : <?php echo $default['customercode'] ?></div>
                    <?php /*?><div id="customer-email"><?php echo $default['email'] ?></div><?php */?>
				</div>
				<div id="side-body">
					<ul id="cust-menu">
				        <li><a href="<?=base_url();?>welcome">Home</a></li>
				        <li><a href="<?=base_url();?>customer">Profile</a>
					      <!--<ul>
				            <li><a href="c_cust">Lihat Profil</a></li>
				            <li><a href="#">Ubah Profil</a></li>
				            <li><a href="#">Ganti Password</a></li>            
				          </ul>-->
				        </li>
				        <li><a href="<?=base_url();?>package">Package</a></li>
				        <li><a href="<?=base_url();?>billing">Billing Info</a></li>
				    </ul>
                    <a href="logout" class="logout">Log Out</a>
				</div>
			</div>
<!-- ####################################################################################################### -->