			<div class="page">
            	<section class="content-section">
            		<header>Change Password</header>
                    <div class="content-body">
                        <div id="pass-form" class="content-view">
                        <?php 
                            $form = array('name' => 'password_form');
                            echo form_open('welcome/change_pwd',$form);						
                            $curpwd = array('name'=>'curr-pass', 'maxlength'=> '50','size'=> '20','value'=>'');
                            $newpwd = array('name'=>'new-pass', 'maxlength'=> '50','size'=> '20','value'=>'');
                            $confpwd = array('name'=>'confirm-pass', 'maxlength'=> '50','size'=> '20','value'=>'');
                            $login = array('name'=>'button-save','value'=>'Save');
                        ?>                   
                            <table id="profile-pass" cellspacing="10">
                                <tr class="full-row">
                                    <td colspan="2"><?=$err_msg?></td>
                                </tr>
                                <tr>
                                    <td class="label-field">Current Password</td>
                                    <td class="content-field"><?=form_password($curpwd)?></td>
                                </tr>
                                <tr>
                                    <td class="label-field">New Password</td>
                                    <td class="content-field"><?=form_password($newpwd)?></td>
                                </tr>
                                <tr>
                                    <td class="label-field">Confirm Password</td>
                                    <td class="content-field"><?=form_password($confpwd)?></td>
                                </tr>
                                <tr>
                                    <td class="label-field"></td>
                                    <td class="content-field"><?=form_submit($login)?> &nbsp; 
                                        <input type="button" value="Cancel" onclick="window.open('<?=base_url();?>welcome','_self','resizable=yes')"/>
                                    </td>
                                </tr>
                            </table>
                         <?=form_close()?>   
                        </div> 
                    </div>	    
            	</section>    
			</div>