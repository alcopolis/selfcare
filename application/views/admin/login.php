<body>
<div id="page-wrapper">
	<div id="content-wrapper">
		Body Content
		<div id="validation-errors" style="background:#F00; color:#FFF;">
			<?php echo validation_errors(); ?>
	    </div>
    
		<?php echo form_open(); ?>
	        <label>Email</label>
	        <?php echo form_input('email'); ?>
	        
	        <label>Password</label>
	        <?php echo form_password('password'); ?>
	        
	        <label></label>
	        <?php echo form_submit('submit', 'Log in', 'class="btn btn-primary"'); ?>
	    <?php echo form_close(); ?>
	</div>
</div>