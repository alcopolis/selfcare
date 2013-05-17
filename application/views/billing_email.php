<div class="page">
    <section id="billing-email" class="content-section">
        <header>Contact</header>
        <div class="content-body">
        	
			<?php if($msg != ''){ ?>
                <div style="border-radius:5px; background:#F00; margin:0 auto 20px auto; font-size:12px; font-weight:bold; color:#FFF; width:88%; padding:1%;"><?php echo $msg; ?></div>
            <?php }; ?>
            
            <div id="email-form">
            	<?php 
					$form = array('name' => 'billing_mail');
					echo form_open('billing_control/send_billingmail',$form);
					
					$custname = array('name'=>'custname', 'maxlength'=> '100','size'=> '50', 'value'=>isset($nmcust) ? $nmcust : '', 'readonly'=>'readonly');
					$custcode = array('name'=>'custcode', 'value'=>$kdcust, 'readonly'=>'readonly');
					$custinvoice = array('name'=>'invoice', 'value'=>$invoice . '(' . $invno . ')', 'readonly'=>'readonly');
					$custemail = array('name'=>'custemail', 'value'=>$email);
					$custmsg = array('name'=>'custmsg', 'value'=>'', 'rows'=>'15', 'cols'=>'100');
					$kirim = array('name'=>'kirim','value'=>'Kirim', 'class'=>'right', 'style'=>'margin:20px 0 0 0; width:120px;');
				?> 
                
                    <div class="inv-info left">
                        <label>Nama</label>
                        <?=form_input($custname);?> 
                    </div>
                    <div class="inv-info left">
                        <label>ID Pelanggan</label>
                        <?=form_input($custcode);?>
                    </div>
                    <div class="inv-info left">
                        <label>Invoice No.</label>
                        <?=form_input($custinvoice);?>
                    </div>
                    
                    <?=form_submit($kirim);?>
                    
                    <div class="clear"></div>
                    
                    <div style="margin-top:20px;">
                        <label>Pesan</label>
                        <?=form_textarea($custmsg);?>
                    </div>
                    
                    <input type="hidden" name="custemail" value="<?=$email;?>" />
                    <input type="hidden" name="invid" value="<?=$invid;?>" />
                <?=form_close()?> 
            </div>
        </div>
    </section>
</div>