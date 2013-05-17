<?php /*?><div class="wrapper">
    <div id="content-body">    
        <h2 id="content-name">Billing Summary</h2>
        <?php
            echo ! empty($table) ? $table : '';
        ?>
        
        <script type="text/javascript">
			function resizeIFrame(h){
				$('#content-detail').animate({height:h});
				$('#content-detail').height(h);
			}
		</script>
        <div id="content-detail" class="content-view hidden">
            <iframe id="frame-content" src="" frameborder="0"/></iframe>
        </div>
                           
        <div id="pass-form" class="hidden">
            <table class="cust-profile">
                <tr>
                    <td class="label-field">&nbsp;</td>
                    <td class="content-field">&nbsp;</td>
                </tr>
                <tr>
                    <td class="label-field">&nbsp;</td>
                    <td class="content-field">&nbsp;</td>
                </tr>
                <tr>
                    <td class="label-field">&nbsp;</td>
                    <td class="content-field">&nbsp;</td>
                </tr>
            </table>                        
        </div> 
    </div>	
</div><?php */?>

	<div class="page">
    	<section class="content-section">
            <header>Ringkasan Tagihan</header>
        	<div class="content-body">
                <?php
                    echo ! empty($table) ? $table : '';
                ?>
            </div>
        </section>
             
		<script type="text/javascript">
            function resizeIFrame(h){
                $('#frame-content').animate({height:h});
                //$('#content-detail').height(h);
            }
        </script>
        <section id="content-detail" class="content-section hide">
        	<header>Rincian Tagihan</header>
        	<div class="content-body">
        		<iframe id="frame-content" src="" frameborder="0"/></iframe>
            </div>
        </section>
		
		<div style="width:100%; height:1px; background:none;"></div> <!-- helper supaya lebarnya fit dengan ukuran screen mobile -->
    </div>