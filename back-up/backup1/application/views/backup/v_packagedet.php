<!DOCTYPE html>
<html>
<head>
	<title>Paket Pilihan</title>  
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/popup.css" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.8.1.min.js"></script>    
    <script type="text/javascript" src="<?php echo base_url(); ?>scripts/main.js"></script>
</head>
<body>
<!-- ####################################################################################################### -->
<div id="modify-window">
    <div id="nav-left" class="tab-nav">&lt;</div>
    <div id="tab-container">
        <ul id="ch-tab-head">
            <?php 
                echo $tabchanel;
            ?>
        </ul>
    </div>
    <div id="nav-right" class="tab-nav">&gt;</div>
    
    <div id="status-bar">
        	<h3 id="pack-name">Paket Starter 15+</h3>
        	<!--<div id="pack-count">Remaining Channels <span id="ch-counter">15</span></div>-->
            
            <div id="util" class="right">
            	<a href="<?php echo $editlink;?>" class="edit">Edit</a>
            </div>

            <div class="clear"></div>
    </div>

  <div id="ch-content">
  	<?php
    	echo $chdefault;
	?>    
  </div>
</div>
<!-- ####################################################################################################### -->
</body>
</html>