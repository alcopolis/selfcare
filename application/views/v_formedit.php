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
    
    
    <style type="text/css">
	
	.cat-box{
		margin:0 10px 20px 10px;
		width:240px;
		padding:0;
		float:left;
		
		border-radius:0 0 10px 10px;
		overflow:hidden;
	}
	
	.cat-box h3, .cat-box ul{
		margin: 0;	
	}
	
	.cat-box h3{
		color:#FFF;
		padding:5px 0 5px 10px;
		background:#333;
	}
	
	.cat-box ul{
		list-style:none;
		list-style-position:inside;
		padding:0 0 5px 0;
		
		font-size:12px;
		color:#333;
	}
	
	.cat-box ul li{
		margin:0 10px;
		padding:5px 0 5px 10px;
		display:block;
		cursor: pointer;
		
		border-top:1px solid rgba(220,220,220,0.75);
		border-bottom:1px solid rgba(80,80,80,0.4);
	}
	
	.cat-box ul li.first{
		border-top:none !important;
	}
	
	.cat-box ul li.last{
		border-bottom:none !important;
	}
	
	.cat-box ul li.selected{
		background-image:url(<?php echo base_url(); ?>/images/actived.png);
		background-position:right center;
		background-repeat: no-repeat;	
	}
	
	.cat-box ul li.disabled{
		background-image:url(<?php echo base_url(); ?>/images/basic.png);
		background-position:right center;
		background-repeat: no-repeat;	
	}
	
	.cat-box ul li:hover{
		font-weight:bold;
	}
	
	/* ========================================= Category Style ==================================== */
	.cat-box.movie{
		background:#DDD1C6 !important;
	}
	.cat-box.movie h3{
		background:#6F5840 !important;
	}
	
	.cat-box.entertainment h3{
		background:#242553 !important;
	}
	.cat-box.entertainment{
		background:#C8C8E6 !important;
	}
	
	.cat-box.sport h3{
		background:#CC0 !important;
	}
	.cat-box.sport{
		background:#F5FABE !important;
	}
	
	.cat-box.knowledge h3{
		background:#F90 !important;
	}
	.cat-box.knowledge{
		background:#FFDFA4 !important;
	}
	
	.cat-box.lifestyle h3{
		background:#C00 !important;
	}
	.cat-box.lifestyle{
		background:#FFC6C6 !important;
	}
	
	.cat-box.kids h3{
		background:#060 !important;
	}
	.cat-box.kids{
		background:#D6EFD1 !important;
	}

</style>

    
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