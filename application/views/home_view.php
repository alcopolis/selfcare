        <div class="page">		
           <div id="welcome">
				<h1 class="tx-medium tx-blue" style="margin:0; text-align:left; position:relative; top:135px; right:-649px">Selamat Datang di layanan<br /> Webselfcare Anda</h1>
				
                <div id="intro">
                    <div id="login-info" class="tx-black tx-bold" style="padding:10px 0; position:relative; top:140px; right:10px">
                        <h3 style="margin: -28px 0 20px 41px;">Layanan ini memberikan Anda<span class="tx-blue"> kemudahan </span>untuk:</h3>
                        <ul style="font-size:0.8em;">
                            <ul>
                            <?php if ($this->client_cluster=="CIBUBUR"){ ?>
                            <li><span class="tx-blue">Modifikasi</span> saluran TV kabel Anda</li>
                            <?php } ?>
                                <li>Dapatkan informasi mengenai <span class="tx-blue">tagihan</span> Anda</li>
                                <!--<li><span class="tx-yellow">Bayar</span> tagihan Anda secara online</li>-->
                                <li>Perbaharui<span class="tx-blue"> profil</span>  Anda secara online</li>
                            </ul>
                        </ul>
                    </div>
                    
                    <div id="nav" style="text-align:right; position:relative; top:120px; right:40px">
						<?php if ($this->client_cluster=="CIBUBUR"){ ?>
                        <ul id="user-menu" class="home-welcome" >
						<?php }else{ ?>
						<ul id="user-menu" class="home-welcome-bsd" >
						<?php } ?>
                            <li id="user"><a href="<?=base_url();?>customer_control" title="Lihat profil">Lihat <br />Profil</a></li>
                            <?php if ($this->client_cluster=="CIBUBUR"){ ?>
                            <li id="package"><a href="<?=base_url();?>package_control" title="Modifikasi paket">Modifikasi <br />Paket</a></li>
                            <?php } ?>
                            <li id="billing"><a href="<?=base_url();?>billing_control" title="Lihat tagihan">Lihat <br />Tagihan</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="clear"></div>
            </div>
        </div>
    
