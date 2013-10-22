<?php $this->load->view('admin/parts/header', $this->data); ?>

<body>
	
	<div id="header" class="navbar navbar-static-top navbar-inverse">
    	<div class="navbar-inner">
            <a class="brand" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            
            <ul class="nav">
                <li><?php echo anchor('admin/products', 'Products'); ?></li>
                <li><?php echo anchor('admin/pages', 'Pages'); ?></li>
                <li><?php echo anchor('admin/promo', 'Promo'); ?></li>
                <li><?php echo anchor('admin/epg', 'EPG'); ?></li>
                <li><?php echo anchor('admin/news', 'News'); ?></li>
                <li><?php echo anchor('admin/users', 'Users'); ?></li>
            </ul>
        </div>
    </div>
    
    <div id="content" class="container">
    	<div class="row">
            <div class="span10">
                <?php $this->load->view($subview, $this->data); ?>
            </div>
            <div class="span2">
                <section id="user">
                	<?php echo anchor('admin/users/profile/' . $this->session->userdata('id'), '<i class="icon-user"></i> ' . $this->session->userdata('name')); ?><br/>
                	<?php echo anchor('admin/users/logout', '<i class="icon-off"></i> Logout'); ?>
                </section>
            </div>
		</div>
        
<?php $this->load->view('admin/parts/footer'); ?>