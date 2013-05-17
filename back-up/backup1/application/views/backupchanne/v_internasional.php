<?php
	foreach($anak as $row)
		{
			if ($row->categoryid == 'International FTA'){ ?>
				<p id="<?php echo $row->serviceid;?>">
    				<img src="<?php echo base_url();?>channel/<?php echo $row->serviceid;?>.jpg" /><br />
				    <span><?php echo $row->servicename;?></span>
				</p>
			<?php }
		}
?>