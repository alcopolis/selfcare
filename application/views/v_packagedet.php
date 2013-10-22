<!DOCTYPE html>
<html>
<head>
	<title>Paket Pilihan</title>  
	<link rel="stylesheet" href="<?=base_url()?>styles/popup.css" type="text/css" />
	<script type="text/javascript" src="<?=base_url()?>scripts/jquery-1.8.1.min.js"></script>    
    <script type="text/javascript" src="<?=base_url()?>scripts/main.js"></script>
	<script type="text/javascript" src="<?=base_url()?>scripts/jquery.masonry.min.js"></script>
    
<style type="text/css">
		
	
	
	/* ========================================= Category Style ==================================== */
/*	.cat-box.movie{
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
	}*/

</style>

<script type="text/javascript">
	$(function(){
		var h = $(document).height();
		parent.resizeIFrame(h);
		console.log(h);
	});
</script>


</head>
<body>
<!-- ####################################################################################################### -->
<div id="modify-window">
	<div id="status-bar">
		<h3 id="pack-name">Package : <?php echo $starter; ?></h3>	
		<div id="util" class="right">
        	<?php  if ($editlink!=''){ ?>
				<a href="<?php echo $editlink;?>" id="edit" class="btn">Edit</a>
			<?php }?>
		</div>
		<div class="clear"></div>
	</div>
    <p id="notif">
		<?php if($err_msg != ''){
				echo $err_msg;
			}else{
				echo '<span class="notif-msg" style="padding-left:0; color:#666;">Perhatian: Anda bisa melakukan modifikasi channel maksimal 1x dalam 1 bulan.</span>'; 
			}
		?>
    </p>
	<div id="ch-content" class="masonry">
		<?php
			echo $chdefault;
		?>    
	</div>
</div>
<!-- ####################################################################################################### -->
</body>
</html>