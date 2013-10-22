<body>
<div id="page-wrapper">
	<div id="content-wrapper">
		Body Content
		<div id="validation-errors" style="background:#F00; color:#FFF;">
			<?php isset($pesan) ? $pesan : ''; ?>
	    </div>
    
		<?php 
	        $form = array('name' => 'login-form', 'id' => 'login-form');					
	        $email = array('name'=>'email','id'=> 'email-input', 'maxlength'=> '100','size'=> '20',
	                'value'=>set_value('email'));
	        $password = array('name'=>'password','size'=>'20','value'=>set_value('password'));
	        $login = array('name'=>'login','id'=>'button-login','value'=>' Log in ', 'class' => 'btn btn-primary');  
			$remember = array('name'=>'remember','id'=> 'remember','value'=> '1','checked'=>TRUE,);	
			
			echo form_open('admin/login/',$form);
	    ?>
	    
	        <label>Email</label>
	        <?php echo form_input($email); ?>
	        
	        <label>Password</label>
	        <?php echo form_password($password); ?>
	        
	        <label></label>
	        <?php echo form_submit($login); ?>
	    <?php echo form_close(); ?>
	</div>
</div>