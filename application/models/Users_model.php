<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model {
    
    private $users_table = 'users';
    private $user_oauths_table = 'user_oauths';
    private $user_emails_table = 'user_emails';
    private $user_phones_table = 'user_phones';

    function __construct() {
        parent::__construct();
    }
    
	function create($data = array()) {
		$data['status'] = 1;
        
        $oauth_data['oauth_provider'] = $data['oauthprovider'];
        $oauth_data['oauth_uid'] = $data['oauthuid'];
        $oauth_data['oauth_token'] = $data['oauthtoken'];
        $oauth_data['oauth_secret'] = $data['oauthsecret'];
        unset($data['oauthprovider']);
        unset($data['oauthuid']);
        unset($data['oauthtoken']);
        unset($data['oauthsecret']);

		if ($this->db->insert($this->users_table, $data)) {
            $oauth_data['user_id'] = $data['user_id'];
            $this->db->insert($this->user_oauths_table, $oauth_data); 
            
			return array('user_id' => $data['user_id']);
		}
		return NULL;
	}
    
    function update($data, $where, $user_id) {
        if((isset($data['email']) && !empty($data['email'])) || (isset($data['contact_number']) && !empty($data['contact_number']))) {
            $user_record = $this->db->get_where($this->users_table, array('user_id' => $user_id))->row();
            $this->db->reset_query();
            if(isset($data['email']) && !empty($data['email']) && $user_record && $user_record->email != $data['email']) {
                $query = $this->db->get_where($this->user_emails_table, array('user_id' => $user_id, 'email' => $user_record->email));
                if($query->num_rows() == 0) {
                    $this->db->insert($this->user_emails_table, array('user_id' => $user_id, 'email' => $user_record->email));
                }
            }
            if(isset($data['contact_number']) && !empty($data['contact_number']) && $user_record && $user_record->contact_number != $data['contact_number']) {
                $query = $this->db->get_where($this->user_phones_table, array('user_id' => $user_id, 'contact_number' => $user_record->contact_number));
                if($query->num_rows() == 0) {
                    $this->db->insert($this->user_phones_table, array('user_id' => $user_id, 'contact_number' => $user_record->contact_number));
                }
            }
        }
        
        $where['user_id'] = $user_id;
        $this->db->set('last_ip', 'last_ip', FALSE);
        return $this->db->update($this->users_table, $data, $where);
    }
    
    function get_user_by_id($user_id = '') {
        $this->db->select($this->users_table . '.*, ' . $this->user_oauths_table . '.oauth_uid AS fb_id', false);
        $this->db->join($this->user_oauths_table, $this->user_oauths_table . '.user_id = ' . $this->users_table . '.user_id', 'left');
        $this->db->where($this->users_table . '.user_id=', $user_id);

        $query = $this->db->get($this->users_table);
        if($query->num_rows() == 1) {
            return $query->row();
        }
        return NULL;
    }
    
    function get_user_by_password_key($password_key = '') {
        $this->db->select($this->users_table . '.*, ( time_to_sec(timediff(now(), ' . $this->users_table . '.new_password_requested )) / 3600 ) AS hours_past', false);
        $this->db->from($this->users_table);
        $this->db->where($this->users_table . '.new_password_key = ' . $this->db->escape($password_key) );
        $this->db->where($this->users_table . '.status = \'' . USER_STATUS_ACTIVE . '\'');

        return $this->db->get()->row();
    }
    
    function get_user_by_email_or_fb_id($email = '', $fb_id = '') {
        $where = "( LOWER(email) = " . $this->db->escape(strtolower($email)) . " OR oauth_uid = " . $this->db->escape($fb_id) . " )";
        $this->db->select($this->users_table . '.*', false);
        $this->db->join($this->user_oauths_table, $this->user_oauths_table . '.user_id = ' . $this->users_table . '.user_id', 'left');
        $this->db->where($where);
        $this->db->where('status', USER_STATUS_ACTIVE);

        return $this->db->get($this->users_table)->row();
    }
    
    function check_email($email = '', $user_id = '') {
        $this->db->select('1', FALSE);
        $this->db->where('LOWER(email)=', strtolower($email)); 
        //$this->db->where('status', USER_STATUS_ACTIVE);
        if($user_id != '') {
            $this->db->where('user_id !=', $user_id);
        }
        $query = $this->db->get($this->users_table);
        return $query->num_rows() == 0;
    }
    
    /**
     * Auth Library Functions
     */
    
	function create_user($data, $data_oauth) {
		$data['status'] = USER_STATUS_ACTIVE;
		if ($this->db->insert($this->users_table, $data)) {
            $data_oauth['user_id'] = $data['user_id'];
            $this->db->insert($this->user_oauths_table, $data_oauth); 
            
			return array('user_id' => $data['user_id']);
		}
		return NULL;
	}
    
    function get_user_by_email($email = '') {
        $this->db->where('LOWER(email)=', strtolower($email));

        $query = $this->db->get($this->users_table);
        if($query->num_rows() == 1) {
            return $query->row();
        }
        return NULL;
    }
    
	function update_login_info($user_id, $record_ip, $record_time) {
		$this->db->set('new_password_key', NULL);
		$this->db->set('new_password_requested', NULL);

		if ($record_ip)		$this->db->set('last_ip', $this->input->ip_address());
		if ($record_time)	$this->db->set('last_login', date('Y-m-d H:i:s'));

		$this->db->where('user_id', $user_id);
		$this->db->update($this->users_table);
	}
    
	function is_email_available($email) {
        $email = strtolower($email);
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(email)=', $email);
		$this->db->or_where('LOWER(new_email)=', $email);

		$query = $this->db->get($this->users_table);
		return $query->num_rows() == 0;
	}
}