<?php $this->load->view('admin/parts/header', $this->data); ?>

<body>
	<div class="modal show" role="dialog">
        
        <?php $this->load->view($subview); //Subview is set in controller ?>
        
        <div class="modal-footer">
        	<p>Modal footer</p>
        </div>
	</div>

<?php $this->load->view('admin/parts/footer'); ?>