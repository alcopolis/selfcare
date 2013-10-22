<!DOCTYPE html>
<html>
<head>
    <title>Web Selfcare</title>
    <link rel="stylesheet" href="<?=base_url()?>styles/layout.css" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>   
    
    <script type="text/javascript" src="<?=base_url()?>scripts/jquery-1.8.1.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>scripts/main.js"></script>
    <script type="text/javascript" src="<?=base_url()?>jwplayer/jwplayer.js" ></script>
	
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-39788034-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
</head>

<body>
<div class="wrapper">
    <div id="header">
        <div id="bar">
			<div id="branding" class="left">
                <a href="<?=base_url();?>login_control" title="Home"><img src="<?=base_url()?>images/logo.png"/></a>
            </div>
            <?php //print_r($this->session->userdata('logged')); ?>
            <?php $this->client_access = $this->session->userdata('aktif');?>
            <?php if($this->client_access=='1'){?>
            	<div id="logout" class="top-menu right"><a href="<?=base_url();?>logout" title="Log out">Log Out</a></div>
            	<?php if($this->session->userdata('logged') == 'stbgr9'){ ?>
            		<div id="watch" class="top-menu right"><a href="<?=base_url();?>watch_control" title="Watch Online TV">Watch TV</a></div>
            	<?php };?>
            	<div id="selfcare" class="top-menu right"><a href="<?=base_url();?>login_control" title="Home Selfcare">Selfcare</a></div>
                <div id="home" class="top-menu right"><a href="http://www.cepat.net.id" title="Home CEPATnet">CEPATnet</a></div>
            <?php }else{ ?>
				<div id="selfcare" class="top-menu right"><a href="<?=base_url();?>login_control" title="Home Selfcare">Selfcare</a></div>
				<div id="home" class="top-menu right"><a href="http://www.cepat.net.id" title="Home CEPATnet">Home</a></div>
			<?php } ?>
            <div class="clear"></div>
		</div>
    </div>
      
    <div id="content">
    	<?php if($this->client_access=='1'){?>
			<?php $this->client_cluster=$this->session->userdata('daerah'); ?>
			<?php if ($this->client_cluster=="CIBUBUR"){ ?>
            <ul id="user-menu" class="cibubur">
			<?php }else{ ?>
			<ul id="user-menu" class="bsd">
			<?php }; ?>
                <li id="user"><a href="<?=base_url();?>customer_control" title="Lihat profil">Lihat <br />Profil</a></li>
                <?php if ($this->client_cluster=="CIBUBUR"){ ?>
                <li id="package"><a href="<?=base_url();?>package_control" title="Modifikasi paket">Modifikasi <br />Paket</a></li>
				<?php }; ?>
                <li id="billing"><a href="<?=base_url();?>billing_control" title="Lihat tagihan">Lihat <br />Tagihan</a></li>
            </ul> 	
        <?php }?>
    	