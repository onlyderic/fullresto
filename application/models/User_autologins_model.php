<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class User_autologins_model extends CI_Model {
    
	private $user_autologin_table = 'user_autologins';
	private $users_table_name = 'users';

	function __construct() {
		parent::__construct();
	}

	function get($user_id, $key) {
		$this->db->select($this->users_table_name.'.user_id');
		$this->db->select($this->users_table_name.'.email');
		$this->db->from($this->users_table_name);
		$this->db->join($this->user_autologin_table, $this->user_autologin_table.'.user_id = '.$this->users_table_name.'.user_id');
		$this->db->where($this->user_autologin_table.'.user_id', $user_id);
		$this->db->where($this->user_autologin_table.'.key_id', $key);
		$query = $this->db->get();
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}

	function set($user_id, $key) {
		return $this->db->insert($this->user_autologin_table, array(
			'user_id' 		=> $user_id,
			'key_id'	 	=> $key,
			'user_agent' 	=> substr($this->input->user_agent(), 0, 149),
			'last_ip' 		=> $this->input->ip_address(),
		));
	}

	function delete($user_id, $key) {
		$this->db->where('user_id', $user_id);
		$this->db->where('key_id', $key);
		$this->db->delete($this->user_autologin_table);
	}

	function purge($user_id) {
		$this->db->where('user_id', $user_id);
		$this->db->where('user_agent', substr($this->input->user_agent(), 0, 149));
		$this->db->where('last_ip', $this->input->ip_address());
		$this->db->delete($this->user_autologin_table);
	}
}