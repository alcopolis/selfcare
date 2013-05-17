        <div class="page">		
           <div id="welcome">
				<h1 class="tx-medium tx-yellow tx-sh-dark" style="margin:0; text-align:right;"><span class="tx-medium">Selamat Datang</span><br /> di layanan Webselfcare Anda</h1>
				
                <div id="intro">
                    <div id="login-info" class="tx-white tx-bold" style="background:rgba(0,0,0,0.9); padding:10px 0; border-radius:10px;">
                        <h3 style="margin:0 0 20px 20px;">Layanan ini memberikan Anda<span class="tx-yellow"> kemudahan </span>untuk:</h3>
                        <ul style="font-size:0.8em;">
                            <ul>
                            <?php if ($this->client_cluster=="CIBUBUR"){ ?>
                            <li><span class="tx-yellow">Modifikasi</span> saluran TV kabel Anda</li>
                            <?php } ?>
                                <li>Dapatkan informasi mengenai <span class="tx-yellow">tagihan</span> Anda</li>
                                <!--<li><span class="tx-yellow">Bayar</span> tagihan Anda secara online</li>-->
                                <li>Perbaharui<span class="tx-yellow"> profil</span>  Anda secara online</li>
                            </ul>
                        </ul>
                    </div>
                    
                    <div id="nav">
                        <p class="tx-yellow tx-bold">Mulai &raquo;</p>
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
    
