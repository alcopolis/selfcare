<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Paket Pilihan</title>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.8.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>scripts/main.js"></script>    
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/popup.css" type="text/css" />
    
    <?php	
	echo '<script type="text/javascript">';
	echo '		$(function(){';
	echo '		var activeCH  = new Array("' . $chjs . '");';
	echo '		var chPrem  = new Array ("' . $chjs . '");';
	echo '		var arrCHSubs = new Array();';
	echo '		var maxCH = activeCH.length;';
	echo '		var chadd;';
									
	echo '		$("#ch-counter").html(maxCH-activeCH.length);';
	echo '		console.log(maxCH); ';
				
	echo '		$(".ch-tab-content p.premium").click(function(){';
					
	echo '			chadd = $(this).attr("id"); ';
					
	echo '			if(activeCH.length != maxCH){';
	echo '				if($(this).children(".selected").length > 0){';
	echo '					$(this).children(".selected").remove();';
	echo '					activeCH.splice(activeCH.indexOf($(this).attr("id")), 1); ';
	
	echo '					if(jQuery.inArray(chadd, chPrem)>=0){ ';
	echo '						if(jQuery.inArray(chadd+ ":REMOVE", arrCHSubs) < 0){arrCHSubs.push(chadd + ":REMOVE");}';
	echo '						else{arrCHSubs.splice(arrCHSubs.indexOf(chadd + ":REMOVE"), 1);}';								
	echo '					}else{
								arrCHSubs.splice(arrCHSubs.indexOf(chadd + ":ADD"), 1);
							}';

	echo '				}else{ ';
	echo '$(this).prepend("' . '<img class=' . "'selected'" . 'src=' . "'http://localhost/webselfcare/images/actived.png'/>" . '");' . 'activeCH.push($(this).attr("id"));';
	
	echo '					if(jQuery.inArray(chadd, chPrem)<0){
								if(jQuery.inArray(chadd+ ":ON", arrCHSubs) < 0){arrCHSubs.push(chadd + ":ADD");}';
	echo '						else{arrCHSubs.splice(arrCHSubs.indexOf(chadd + ":ADD"), 1);}';
	echo '					}else{
								arrCHSubs.splice(arrCHSubs.indexOf(chadd + ":REMOVE"), 1);
							}';
	
	echo '				};';
						
	echo '			}else{ ;';
	echo '				if($(this).children(".selected").length > 0){ ;';
	echo '					$(this).children(".selected").remove();';
	echo '					activeCH.splice(activeCH.indexOf($(this).attr("id")), 1);';
	
	echo '					if(jQuery.inArray(chadd, chPrem)>=0){
								if(jQuery.inArray(chadd+ ":REMOVE", arrCHSubs)< 0){arrCHSubs.push(chadd + ":REMOVE");}';
	echo '						else{arrCHSubs.splice(arrCHSubs.indexOf(chadd + ":REMOVE"), 1);}';
	echo '					}else{
								arrCHSubs.splice(arrCHSubs.indexOf(chadd + ":REMOVE"), 1);
							}';
	
	echo '				}';
	echo '			}';
					
	echo '			$("#ch-counter").html(maxCH-activeCH.length);';
//	echo '			console.log(activeCH.length);';
	echo '			console.log(arrCHSubs); ';
	echo '		});';
	echo '	});';
	echo '	</script> ';
	?>
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
            <div id="util"><a href="<?php echo $savelink;?>" class="edit">Save</a></div>
            <div class="clear"></div>
  </div>
  <div id="ch-content">
  	<?php
    	echo $chdefault;
	?>    
  </div>
</div>
<!-- ####################################################################################################### -->
