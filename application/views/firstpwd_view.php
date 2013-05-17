			<div class="page">
            	<section class="content-section">
            		<header>Ubah Password</header>
                    <div class="content-body">
                    	<div class="tx-bold" style="font-size:12px; width:95%; margin:0 auto; padding:20px;">
                            <h4 class="tx-red tx-bold tx-medium" style="margin:0;">Mohon Lakukan Perubahan Password Anda Sekarang</h4>
                            <p style="margin:0; font-size:14px;">Demi peningkatan keamanan dan kemudahan Anda, akun Webselfcare akan aktif setelah Anda melakukan perubahan password.</p>
						</div>
                        <div id="pass-form" class="content-view">
                        <?php 
                            $form = array('name' => 'password_form');
                            echo form_open('login_control/activate_pwd',$form);
							$curpwd = array('name'=>'curr-pass','maxlength'=>'50','size'=>'20',
								'value'=>isset($default['customercode']) ? $default['customercode'] : '');
							
							//$email = array('name'=>'email', 'maxlength'=> '100','size'=> '50','value'=>isset($default['email']) ? $default['email'] : '');
							$email = array('name'=>'email', 'maxlength'=> '100','size'=> '50','value'=>'');
							//$hp = array('name'=>'hp', 'maxlength'=> '50','size'=> '50','value'=>isset($default['hp']) ? $default['hp'] : '');
							$hp = array('name'=>'hp', 'maxlength'=> '50','size'=> '50','value'=>'');
                            $newpwd = array('name'=>'new-pass', 'maxlength'=> '50','size'=> '20','value'=>'');
                            $confpwd = array('name'=>'confirm-pass', 'maxlength'=> '50','size'=> '20','value'=>'');
                            $login = array('name'=>'button-save','value'=>'Aktifkan');
                        ?>                   
                            <table class="profile-data" cellspacing="10">
                                <tr class="full-row">
                                    <td colspan="2"><?=$err_msg?></td>
                                </tr>
                                <tr>
                                    <td class="label-field">Password Saat Ini</td>
                                    <td class="content-field"><?=form_password($curpwd)?></td>
                                </tr>
                                <tr>
                                    <td class="label-field">Password Baru</td>
                                    <td class="content-field"><?=form_password($newpwd)?></td>
                                </tr>
                                <tr>
                                    <td class="label-field">Konfirmasi Password</td>
                                    <td class="content-field"><?=form_password($confpwd)?></td>
                                </tr>
                                <tr>
                                    <td class="label-field">Email <span class="tx-red">*</span></td>
                                    <td class="content-field"><?=form_input($email)?> <span style="font-size:10px; font-weight:normal;">Contoh: myemail@mail.com</span></td>
                                </tr>
                                <tr>
                                    <td class="label-field">Nomor Ponsel <span class="tx-red">*</span></td>
                                    <td class="content-field"><?=form_input($hp)?> <span style="font-size:10px; font-weight:normal;">Contoh: 08123456789</span></td>
                                </tr>
                                <tr></tr>
                                <tr>
                                    <td class="tx-red tx-bold">* Wajib diisi</td>
                                    <td class="content-field"><?=form_submit($login)?> &nbsp; 
                                        <input type="button" value="&nbsp;&nbsp;Batal&nbsp;&nbsp;" onclick="window.open('<?=base_url();?>login_control/logout','_self','resizable=yes')"/>
                                    </td>
                                </tr>
                            </table>
                         <?=form_close()?>  
                        
                        </div>
                        
                        
                        <div class="tx-black" style="font-size:12px; width:95%; margin:0 auto; background:#EFEFEF; padding:20px;">Alamat email dan nomor telepon Anda hanya digunakan untuk mengirimkan informasi terkini mengenai tagihan, promo, event, dan layanan lainnya dari CEPATnet.</div>
                    </div>	    
            	</section>    
			</div>