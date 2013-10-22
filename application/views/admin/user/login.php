<div class="modal-header">
	<h2>User Login</h2>
</div>

<div class="modal-body">
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