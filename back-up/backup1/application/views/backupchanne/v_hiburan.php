<?php
	foreach($anak as $row)
		{
			if ($row->categoryid == 'Entertainment'){ ?>
				<p id="<?php echo $row->serviceid;?>">
				    <span><?php echo $row->servicename;?></span>
				</p>
			<?php }
		}
?>