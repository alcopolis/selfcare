<!DOCTYPE html>
<html>
<head>
    <title>Web Selfcare</title>
    <link rel="stylesheet" href="<?=base_url()?>styles/layout.css" type="text/css" />
    <script type="text/javascript" src="<?=base_url()?>scripts/jquery-1.8.1.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>scripts/main.js"></script>
</head>

<body>
<div class="wrapper">
    <div id="header">
        <div id="bar">
			<div id="branding" class="left">
                <a href="http://www.cepat.net.id" title="CEPATNet"><img src="<?=base_url()?>images/cepat-net-logo.png"/></a>
            </div>
            
            <?php if($this->client_logon){?>
            	<div id="logout" class="top-menu right"><a href="<?=base_url();?>logout" title="Log out">Log Out</a></div>
            	<div id="selfcare" class="top-menu right"><a href="<?=base_url();?>welcome" title="Selfcare">Selfcare</a></div>
			<?php } ?>
                
            <div id="home" class="top-menu right"><a href="http://www.cepat.net.id" title="CEPATNet">Home</a></div>      
            <div class="clear"></div>
		</div>
		
		<?php /*?><div id="customer-nav">
            <div id="branding">
                <a href="<?=base_url();?>welcome" title="Home"><img src="<?=base_url()?>images/cepat-net-logo.png"/></a>
            </div>
            <?php 
                if($this->client_logon){
            ?>
            
            <div id="customer-profile">
                <div id="cust-name"><?php echo $default['customername'] ?> &or;</div>
                <div class="subnav">
                    <p><a href="<?=base_url();?>customer/change_pwd">Change Password</a></p>
                    <p><a href="<?=base_url();?>logout" class="logout">Log Out</a></p>
                </div>
                <div class="clear"></div>
            </div>
            
            <ul id="customer-menu">
                <li><a href="<?=base_url();?>welcome">Home</a></li>
                <li><a href="<?=base_url();?>customer">Profile</a></li>
                <li><a href="<?=base_url();?>package">Package</a></li>
                <li><a href="<?=base_url();?>billing">Billing Info</a></li>
            </ul>
            
            <?php 
                }
            ?>
            <div class="clear"></div>
        </div><?php */?>
    </div>
      
    <div id="content">
    	<?php if($this->client_logon){?>
            <ul id="user-menu">
                <li id="user"><a href="<?=base_url();?>customer" title="Lihat profil">Lihat <br />Profil</a></li>
                            <li id="package"><a href="<?=base_url();?>package" title="Modifikasi paket">Modifikasi <br />Paket</a></li>
                            <li id="billing"><a href="<?=base_url();?>billing" title="Lihat tagihan">Lihat <br />Tagihan</a></li>
            </ul> 	
        <?php }?>
    	