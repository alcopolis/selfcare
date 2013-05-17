			<div class="page">
            	<section class="content-section">
            		<header>Ganti Password</header>
                    <div class="content-body">
                    	<div class="tx-bold" style="font-size:12px; width:95%; margin:0 auto; background:#EFEFEF; padding:20px;">
                            <h4 class="tx-red tx-bold tx-medium" style="margin:0;">Demi peningkatan keamanan dan kemudahan Anda.</h4>
                            <p style="margin:0;margin-top:5px; font-size:14px;">Lakukan Perubahan Password Anda Sekarang</p>
                        </div>
                        <div id="pass-form" class="content-view">
                        <?php 
                            $form = array('name' => 'password_form');
                            echo form_open('welcome/change_pwd',$form);						
                            $curpwd = array('name'=>'curr-pass', 'maxlength'=> '50','size'=> '20','value'=>'');
                            $newpwd = array('name'=>'new-pass', 'maxlength'=> '50','size'=> '20','value'=>'');
                            $confpwd = array('name'=>'confirm-pass', 'maxlength'=> '50','size'=> '20','value'=>'');
                            $login = array('name'=>'button-save','value'=>'Simpan');
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
                                    <td class="content-field"><?=form_password($confpwd)?></td>
                                </tr>
                                <tr>
                                    <td class="label-field">Nomor Ponsel <span class="tx-red">*</span></td>
                                    <td class="content-field"><?=form_password($confpwd)?></td>
                                </tr>
                                <tr>
                                	<td></td>
                                	<td><span style="font-size:10px; font-weight:normal;">Contoh: 08123456789</span></td>
                                </tr>
                                <tr></tr>
                                <tr>
                                    <td class="tx-red tx-bold" style="font-size:12px;">* Wajib diisi</td>
                                    <td class="content-field"><?=form_submit($login)?> &nbsp; 
                                        <input type="button" value="Batal" onclick="window.open('<?=base_url();?>welcome','_self','resizable=yes')"/>
                                    </td>
                                </tr>
                            </table>
                         <?=form_close()?>  
                        
                        </div>
                        
                        
                        <div class="tx-black" style="font-size:12px; width:95%; margin:0 auto; background:#EFEFEF; padding:20px;">Alamat email dan nomor telepon Anda akan digunakan untuk mengirimkan informasi terkini mengenai tagihan, promo, event, dan layanan lainnya dari CEPATNet.</div>
                    </div>	    
            	</section>    
			</div>