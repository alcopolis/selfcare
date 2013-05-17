<div id="login">
    <img src="<?=base_url();?>images/welcome.png" style="position:relative;" />
    <?php 
        $form = array('name' => 'login-form', 'id' => 'login-form');
        echo form_open('login_control/login',$form);						
        $username = array('name'=>'username','id'=> 'username', 'maxlength'=> '100','size'=> '20',
                'value'=>set_value('username'));
        $password = array('name'=>'password','size'=>'20','value'=>set_value('password'));
        $login = array('name'=>'login','id'=>'button','value'=>' Masuk ');  
		$remember = array('name'=>'remember','id'=> 'remember','value'=> '1','checked'=>TRUE,);
		
    ?>
    
     <div style="margin:0; padding:20px; border-left:1px solid rgba(255,255,255,.5);">
    	<p class="tx-bold" style="margin-bottom:20px; line-height:1.25;">Masukkan ID dan password untuk mengelola layanan online Webselfcare Anda</p>
		
    	<p><span class="tx-bold">ID Pelanggan</span> <br/> 
		<?=form_input($username)?></p>
        <p><span class="tx-bold">Password</span> <br/> 
		<?=form_password($password)?></p> 
        <p><span class="tx-bold"><?=form_checkbox($remeber);?>Ingat Saya</span></p><br />
        <p>
            <?=form_submit($login)?> &nbsp;|&nbsp; 
            <a href="<?=base_url()?>login_control/forgetpwd" class="tx-yellow tx-bold">Lupa Password?</a>
        </p>
        
		<p style="margin:20px 0 0 0; width:100%; padding:5px; color:#FF0"><?=isset($pesan) ? $pesan : ''?></p>
    </div>
    
    <?=form_close()?>
    
    <!--<div id="login-info" class="tx-white tx-bold">
    	<h3 class="tx-medium">Layanan ini memberikan Anda<span class="tx-yellow"> kemudahan </span>untuk:</h3>
        <ul>
            <li><span class="tx-yellow">Modifikasi</span> saluran TV kabel Anda</li>
            <li>Dapatkan informasi mengenai <span class="tx-yellow">tagihan</span> Anda</li>
            <li><span class="tx-yellow">Bayar</span> tagihan Anda secara online</li>
            <li>Perbaharui<span class="tx-yellow"> profil</span>  Anda secara online</li>
        </ul>
    </div>-->
    
    <!--<ul style="margin-top:40px; text-align:right; font-size:10px; list-style:none;color:#07114A;">
        <span style="padding:10px 0 0 40px; border-top:3px solid #07114A; font-size:12px; font-weight:bold;">This service gives you easiness to:</span>
        <li>Modify your TV Cable package channels</li>
        <li>Get information on your current billing statement</li>
        <li>Pay your bills online</li>
        <li>Check your profile on our database</li>
    </ul>-->
 </div>