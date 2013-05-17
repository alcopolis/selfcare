<?php
/**
 * model for customer service
 *
 */
class Cs_model extends CI_Model {
	/**
	 * Constructor
	 */
	function __construct()
    {
        parent::__construct();
		$this->baca = $this->load->database('altdb', TRUE);
    }
	
		
}
// END Cs_model Class

/* End of file Cs_model.php */ 
/* Location: ./system/application/model/cs_model.php */