			<div class="page">
				<section id="profile-account" class="content-section">
                	<header>Profil Info</header>
                    <div class="content-body">
                        <div id="util"><a id="pass-change" href="<?=base_url();?>customer/change_pwd" class="btn-edit">Edit Profil</a></div>
                        
                		<h3>Selamat Datang <br/> <span class="tx-medium"><?php echo set_value('customername', isset($default['customername']) ? $default['customername'] : ''); ?></span></h2>
                        
                        <table id="tbl-view" class="static" cellspacing="10">
                            <tr>
                                <td class="label-field">Kode Pelanggan</td>
                                <td class="content-field"><?php echo set_value('customercode', isset($default['customercode']) ? $default['customercode'] : ''); ?></td>
                            </tr>
                            <tr>
                                <td class="label-field">E-mail</td>
                                <td class="content-field"><?php echo set_value('email', isset($default['email']) ? $default['email'] : ''); ?></td>
                            </tr>
                            <tr>
                                <td class="label-field">Terakhir Perubahan Paket</td>
                                <td class="content-field"><?php echo set_value('lastupdate', isset($default['lastupdate']) ? $default['lastupdate'] : ''); ?></td>
                            </tr>
                            <tr>
                                <td class="label-field">Alamat</td>
                                <td class="content-field"><?php echo set_value('address', isset($default['address']) ? $default['address'] : ''); ?></td>
                            </tr>
                            <tr>
                                <td class="label-field">No Identitas</td>
                                <td class="content-field"><?php echo set_value('idtype', isset($default['idtype']) ? $default['idtype'] : ''); ?> / <?php echo set_value('idno', isset($default['idno']) ? $default['idno'] : ''); ?></td>
                            </tr>
                            <tr>
                                <td class="label-field">Telepon</td>
                                <td class="content-field"><?php echo set_value('phone', isset($default['phone']) ? $default['phone'] : ''); ?></td>
                            </tr>
                            <tr>
                                <td class="label-field">No HP</td>
                                <td class="content-field"><?php echo set_value('mobile', isset($default['mobile']) ? $default['mobile'] : ''); ?></td>
                            </tr>
                            <tr>
                                <td class="label-field">Alamat Penagihan</td>
                                <td class="content-field"><?php echo set_value('billing', isset($default['billing']) ? $default['billing'] : ''); ?></td>
                            </tr>
                        </table>
                    </div>
                </section>
                
                <!--<section id="profile-personal" class="content-section">
                	<header>Personal Info</header>
                    <div class="content-body">
                        <table id="tbl-view" class="static" cellspacing="10">
                            
                        </table>
                    </div>
                </section>-->
			</div>
