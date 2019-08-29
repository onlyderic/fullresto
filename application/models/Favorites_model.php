<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Favorites_model extends CI_Model {
    
    private $favorites_table = 'favorites';

    function __construct() {
        parent::__construct();
    }
    
    function create($merchant_profile_id = '', $user_id = '') {
        if(!$this->db->select('favorite_id')->get_where($this->favorites_table, array('merchant_profile_id' => $merchant_profile_id, 'user_id' => $user_id))->row()) {
            $merchant_profile_id = $this->db->escape_str($merchant_profile_id);
            $user_id = $this->db->escape_str($user_id);
            if($this->db->insert($this->favorites_table, array('user_id' => $user_id, 'merchant_profile_id' => $merchant_profile_id))) {
                return true;
            }
            return false;
        } else {
            $this->db->delete($this->favorites_table, array('user_id' => $user_id, 'merchant_profile_id' => $merchant_profile_id));
            return NULL;
        }
    }
    
    function check_is_favorited($merchant_profile_id = '', $user_id = '') {
        $query = $this->db->select('1', FALSE)->get_where($this->favorites_table, array('user_id' => $user_id, 'merchant_profile_id' => $merchant_profile_id));
        return $query->num_rows() == 1;
    }
}