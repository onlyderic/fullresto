<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Login_attempts_model extends CI_Model {
    
	private $login_attempts_table = 'login_attempts';

	function __construct() {
		parent::__construct();
	}

	function get_attempts_num($ip_address, $login) {
		$this->db->select('1', FALSE);
		$this->db->where('ip_address', $ip_address);
		if (strlen($login) > 0) $this->db->or_where('login', $login);

		$qres = $this->db->get($this->login_attempts_table);
		return $qres->num_rows();
	}

	function increase_attempt($ip_address, $login) {
		$this->db->insert($this->login_attempts_table, array('ip_address' => $ip_address, 'login' => $login));
	}

	function clear_attempts($ip_address, $login, $expire_period = 86400) {
		$this->db->where(array('ip_address' => $ip_address, 'login' => $login));

		$this->db->or_where('UNIX_TIMESTAMP(time) <', time() - $expire_period);

		$this->db->delete($this->login_attempts_table);
	}
}