<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Paket Pilihan</title>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.8.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>scripts/main.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.masonry.min.js"></script>
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/popup.css" type="text/css" />
    <script type="text/javascript">
		var activeCH  = new Array("<?php echo $chjs;?> ");
		var chPrem  = new Array("<?php echo $chjs;?>");
		var baseurl  = "<?php echo base_url() ;?>";
	</script>
    <script type="text/javascript" src="<?php echo base_url(); ?>scripts/ticker-new.js"></script>   
</head>
<body>
<!-- ####################################################################################################### -->
<div id="modify-window">
    <div id="status-bar">
			<h3 id="pack-name">Paket : <?php echo $starter; ?></h3>
            <div id="util" class="right">
            <?php //if ($savelink!=''){ ?>
			    <form action="<?php echo $savelink; ?>" method="post">
                    <input type="hidden" value="" id="packdet" name="packdet"/>
                    <input id="save" class="btn" type="submit" value="Simpan"/>
					<a href="<?php echo $packagelink; ?>" id="cancel" class="btn">Batal</a>
                    <input type="hidden" value="" id="chremain" name="chremain"/>
                	<input type="hidden" value="" id="editdata" name="editdata"/>
                </form>
             <?php // }?>
            </div>
        	<div id="pack-count" class="right">Sisa Channel <span id="ch-counter"></span></div>            
            <div class="clear"></div>
  	</div>
  <div id="ch-content">
    <?php
        echo $chdefault;
    ?>    
  </div>
</div>
<!-- ####################################################################################################### -->