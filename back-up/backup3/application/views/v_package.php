
    <div class="page">
    	<section class="content-section">
            <header>Paket Layanan</header>
        	<div class="content-body">
                <?php
                    echo ! empty($table) ? $table : '';
                ?>
            </div>
        </section>
             
		<script type="text/javascript">
            function resizeIFrame(h){
                $('#frame-content').animate({height:h});
            }
        </script>
        <section id="content-detail" class="content-section hide">
        	<header>Daftar Channel</header>
        	<div class="content-body">
        		<iframe id="frame-content" src="" frameborder="0"/></iframe>
            </div>
        </section>
        
        <div style="width:100%; height:1px; background:none;"></div> <!-- helper supaya lebarnya fit dengan ukuran screen mobile -->
    </div>
