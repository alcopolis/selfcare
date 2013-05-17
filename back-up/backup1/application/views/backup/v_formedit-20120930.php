<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Paket Pilihan</title>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.8.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>scripts/main.js"></script>    
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/popup.css" type="text/css" />
    <script type="text/javascript">
		var activeCH  = new Array("<?php echo $chjs;?> ");
		var chPrem  = new Array("<?php echo $chjs;?>");
		var baseurl  = "<?php echo base_url() ;?>";
		
	</script>
    <script type="text/javascript" src="<?php echo base_url(); ?>scripts/ticker.js"></script>
    
</head>
<body>
<!-- ####################################################################################################### -->
<div id="modify-window">
    <ul id="ch-tab-head">
		<?php 
			echo $tabchanel;
		?>
    </ul>
    <div id="status-bar">
			<h3 id="pack-name">Paket Starter 15+</h3>
        	<div id="pack-count">Remaining Channels <span id="ch-counter">15</span></div>
            <div id="util">
            
            <form action="<?php echo $savelink; ?>" method="post">
                <input type="hidden" value="" id="packdet" name="packdet"/>
                <input type="hidden" value="" id="chremain" name="chremain"/>
                <input type="submit" value="submit"/>
                <a href="<?php echo $savelink;?>" class="edit">Save</a></div>
            </form>
            <div class="clear"></div>
  	</div>
  <div id="ch-content">
  	<?php
    	echo $chdefault;
	?>    
  </div>
</div>
<!-- ####################################################################################################### -->
