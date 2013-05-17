
    <div class="page">
    	<section class="content-section">
            <header>Package Services</header>
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
        	<header>Channel List</header>
        	<div class="content-body">
        		<iframe id="frame-content" src="" frameborder="0"/></iframe>
            </div>
        </section>
    </div>
