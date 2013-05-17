<div id="login">
    <img src="<?=base_url();?>images/welcome.png" style="position:relative;" />
    <?php 
        $form = array('name' => 'reset_form', 'id' => 'login-form');
        echo form_open('customer/resetpwd',$form);						
        $email = array('name'=>'email','id'=> 'email', 'maxlength'=> '100','size'=> '30');
        $submit = array('name'=>'submit','id'=>'button','value'=>'Submit')
    ?>
    
    <div style="margin:0; padding:20px; border-left:1px solid rgba(255,255,255,.5);">
    	<p class="tx-bold">Reset your password</p>
    	<p><span class="tx-bold">Your Customer Email</span> <br/> 
		<?=form_input($email)?></p> 
    
        <p>
            <?=form_submit($submit)?> &nbsp;|&nbsp; 
            <a href='<?=base_url()?>' class="tx-yellow tx-bold">&laquo; Back</a>
        </p>
        <p><?=isset($msg) ? $msg : ''?></p>
    </div>
    
    <?=form_close()?>
</div>