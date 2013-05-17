			<div id="content-wrap" class="right">
				<div id="content-body">
                	<h3>Change password</h3>
                	<div id="pass-form">
                    <?php 
						$form = array('name' => 'password_form');
						echo form_open('welcome/change_pwd',$form);						
						$curpwd = array('name'=>'curr-pass', 'maxlength'=> '50','size'=> '20','value'=>'');
						$newpwd = array('name'=>'new-pass', 'maxlength'=> '50','size'=> '20','value'=>'');
						$confpwd = array('name'=>'confirm-pass', 'maxlength'=> '50','size'=> '20','value'=>'');
						$login = array('name'=>'button-save','value'=>'SAVE');
					?>                   
                        <table class="cust-profile">
                        	<tr>
                            	<td colspan="2"><?=$err_msg?></td>
                            </tr>
                            <tr>
                                <td class="label-field">Current Password :</td>
                                <td class="content-field"><?=form_password($curpwd)?></td>
                            </tr>
                            <tr>
                                <td class="label-field">New Password :</td>
                                <td class="content-field"><?=form_password($newpwd)?></td>
                            </tr>
                            <tr>
                                <td class="label-field">Confirm Password :</td>
                                <td class="content-field"><?=form_password($confpwd)?></td>
                            </tr>
                            <tr>
                            	<td colspan="2"><?=form_submit($login)?></td>
                            </tr>
                        </table>
                     <?=form_close()?>   
                    </div> 
				</div>	    
                
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>