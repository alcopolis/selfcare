			<div class="page">
            	<section class="content-section">
            		<header>Reset Password</header>
                    <div class="content-body">
                    	<div class="tx-bold" style="font-size:12px; width:95%; margin:0 auto; padding:20px;">
                            <h4 class="tx-red tx-bold tx-medium" style="margin:0;">Reset Password</h4>
                            <p style="margin:0; font-size:14px;">Perubahan password anda akan kami kirimkan ke alamat email anda.</p>
                        </div>
                        <div id="pass-form" class="content-view">
                        <?php 
                            $form = array('name' => 'password_form');
                            echo form_open('login_control/resetpwd',$form);
							$email = array('name'=>'email', 'maxlength'=> '100','size'=> '30','value'=>'');
							//'value'=>isset($default['email']) ? $default['email'] : '');
							$loginid = array('name'=>'loginid', 'maxlength'=> '50','size'=> '30','value'=>'');
							//	'value'=>isset($default['hp']) ? $default['hp'] : '');
                            $login = array('name'=>'button-save','value'=>'Kirim');
                        ?>                   
                            <table class="profile-data" cellspacing="10">
                                <tr class="full-row">
                                    <td colspan="2"><span class="tx-red"><?=$msg?></span></td>
                                </tr>
                                <tr>
                                    <td class="label-field">ID Pelanggan anda <span class="tx-red">*</span></td>
                                    <td class="content-field"><?=form_input($loginid)?></td>
                                </tr>
                                <tr>
                                    <td class="label-field">Email yang terdaftar<span class="tx-red">*</span></td>
                                    <td class="content-field"><?=form_input($email)?></td>
                                </tr>
                                <tr>
                                    <td class="tx-red tx-bold" style="font-size:12px;">* Wajib diisi</td>
                                    <td class="content-field"><?=form_submit($login)?> &nbsp; 
                                        <input type="button" value="&nbsp;&nbsp;Batal&nbsp;&nbsp;" onclick="window.open('<?=base_url();?>','_self','resizable=yes')"/>
                                    </td>
                                </tr>
                            </table>
                         <?=form_close()?>  
                        </div>
                    </div>	    
            	</section>    
			</div>