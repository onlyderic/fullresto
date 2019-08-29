<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Merchants_model extends CI_Model {
    
    private $merchant_profiles_table = 'merchant_profiles';
    private $merchant_profile_details_table = 'merchant_profile_details';
    private $merchant_services_table = 'merchant_services';
    private $merchant_service_categories_table = 'merchant_service_categories';
    private $merchant_views_table = 'merchant_views';

    function __construct() {
        parent::__construct();
    }
    
    /**
     * 
     * @param type $mode = 'summary', 'detail'
     * @param type $merchant_profile_id
     * @return row
     */
    function get_record($mode = 'summary', $merchant_profile_id = '') {
        if($mode == 'detail') {
            $this->db->join($this->merchant_profile_details_table, $this->merchant_profile_details_table . '.merchant_profile_id = ' . $this->merchant_profiles_table . '.merchant_profile_id', 'left');
        }
        $this->db->where($this->merchant_profiles_table . '.merchant_profile_id', $merchant_profile_id);
        $this->db->where($this->merchant_profiles_table . '.status !=', MERCHANT_STATUS_DELETED);
        $this->db->where($this->merchant_profiles_table . '.status_public', MERCHANT_PROFILE_PUBLIC_STATUS_APPROVED);
        $this->db->where($this->merchant_profiles_table . '.admin_approved', MERCHANT_PROFILE_ADMIN_STATUS_APPROVED);
        
        $query = $this->db->get($this->merchant_profiles_table);
        
        if($query->num_rows() == 1) {
            return $query->row();
        }
        return NULL;
    }
    
    /**
     * 
     * @param type $mode = 'summary', 'detail'
     * @param type $city
     * @return rows
     */
    function get_records($mode = 'summary', $city = '') {
        if($mode == 'detail') {
            $this->db->join($this->merchant_profile_details_table, $this->merchant_profile_details_table . '.merchant_profile_id = ' . $this->merchant_profiles_table . '.merchant_profile_id', 'left');
        }
        if($city != ''){
			$this->db->where($this->merchant_profiles_table . '.city =', $city);
		}
        $this->db->where($this->merchant_profiles_table . '.status !=', MERCHANT_STATUS_DELETED);
        $this->db->where($this->merchant_profiles_table . '.status_public', MERCHANT_PROFILE_PUBLIC_STATUS_APPROVED);
        $this->db->where($this->merchant_profiles_table . '.admin_approved', MERCHANT_PROFILE_ADMIN_STATUS_APPROVED);
        
        $this->db->order_by($this->merchant_profiles_table . '.merchant_profile_id', 'random');
        $query = $this->db->get($this->merchant_profiles_table);
        
        if($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function get_records_map($city = '') {
        $columns = array(
            $this->merchant_profiles_table . '.merchant_profile_id',
            $this->merchant_profiles_table . '.display_name',
            $this->merchant_profiles_table . '.map_latitude',
            $this->merchant_profiles_table . '.map_longitude',
            $this->merchant_profiles_table . '.rating',
            $this->merchant_profiles_table . '.price_rating',
            $this->merchant_profiles_table . '.display_name',
            $this->merchant_profiles_table . '.best_deal',
            $this->merchant_profiles_table . '.city'
        );
        $this->db->select($columns);
        $this->db->where($this->merchant_profiles_table . '.status !=', MERCHANT_STATUS_DELETED);
        $this->db->where($this->merchant_profiles_table . '.status_public', MERCHANT_PROFILE_PUBLIC_STATUS_APPROVED);
        $this->db->where($this->merchant_profiles_table . '.admin_approved', MERCHANT_PROFILE_ADMIN_STATUS_APPROVED);
        
        if($city != ''){
			$this->db->where($this->merchant_profiles_table . '.city =', $city);
		}
        
        $query = $this->db->get($this->merchant_profiles_table);
        
        if($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }
    
    function get_list_cities() {
		$this->db->order_by($this->merchant_profiles_table.".city", "asc"); 
    	return $this->db->distinct()->select($this->merchant_profiles_table.".city")->where('city IS NOT NULL', NULL, FALSE)->where('city != \'\'', NULL, FALSE)->get_where($this->merchant_profiles_table, array('status !=' => MERCHANT_STATUS_DELETED))->result();
    }
    
    function get_list_services($merchant_profile_id = '') {
        $this->db->join($this->merchant_service_categories_table, $this->merchant_service_categories_table . '.category_id = ' . $this->merchant_services_table . '.category_id', 'left');
		$this->db->order_by($this->merchant_services_table.".sort_order", "asc"); 
    	return $this->db->get_where($this->merchant_services_table, array('merchant_profile_id' => $merchant_profile_id))->result();
    }
    
    function get_num_current_views($merchant_profile_id = '') {
        $this->db->where('DATE(view_date)', 'CURRENT_DATE', FALSE);
        $this->db->where('TIME_TO_SEC(TIMEDIFF(NOW(), view_date)) <=', '7200', FALSE); //7200seconds or 2hours
        $row = $this->db->select('COUNT(merchant_profile_id) AS count', false)->get_where($this->merchant_views_table, array('merchant_profile_id' => $merchant_profile_id), 1)->row();
        return ($row ? $row->count : 0);
    }
    
    function set_views($merchant_profile_id = '', $user_id = '', $ip_address = '') {
        try {
            $where = (empty($user_id) ? array('ip_address' => $ip_address) : array('user_id' => $user_id));
            $this->db->select('merchant_profile_id');
            $this->db->where('DATE(view_date)', 'CURRENT_DATE', FALSE);
            $this->db->where('merchant_profile_id', $merchant_profile_id);

            if($this->db->get_where($this->merchant_views_table, $where, 1)->num_rows() == 0) {
                $this->db->reset_query();
                $this->db->set('num_views', 'num_views + 1', FALSE);
                $this->db->where('merchant_profile_id', $merchant_profile_id);
                $this->db->update($this->merchant_profiles_table);

                $data = array(
                    'merchant_profile_id' => $merchant_profile_id,
                    'user_id' => $user_id,
                    'ip_address' => $ip_address
                );
                $this->db->insert('merchant_views', $data); 
            }
        } catch(Exception $e) {
            throw $e;
        }
    }
}