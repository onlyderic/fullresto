<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Sms_model extends CI_Model {
    
    private $sms_table = 'sms';

    function __construct() {
        parent::__construct();
    }
    
	function create($message_id = '', $code = '') {
        if(!empty($message_id)) {
            if($this->db->insert($this->sms_table, array('message_id' => $message_id, 'code' => $code))) {
                return TRUE;
            }
		}
		return NULL;
	}
}