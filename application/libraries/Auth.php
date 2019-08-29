<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('phpass-0.1/PasswordHash.php');

class Auth {
	private $error = array();

	function __construct() {
		$this->ci =& get_instance();

		$this->ci->load->helper('string');
		$this->ci->load->library('session');
		$this->ci->load->database();
        $this->ci->load->model('Users_model', 'users');

		$this->autologin();
	}

	function login($login, $password, $remember) {
		if ((strlen($login) > 0) AND (strlen($password) > 0)) {
			if (!is_null($user = $this->ci->users->get_user_by_email($login))) {

				$hasher = new PasswordHash(
						$this->ci->config->item('phpass_hash_strength'),
						$this->ci->config->item('phpass_hash_portable'));
				if ($hasher->CheckPassword($password, $user->password)) {
					if ($user->banned == 1) {
						$this->error = array('banned' => $user->ban_reason);
					} else {
						$this->ci->session->set_userdata(array(
								'user_id'	=> $user->user_id,
                                'email'	=> $user->email
						));

						if ($user->status != USER_STATUS_ACTIVE) {
							$this->error = array('not_active' => '');
						} else {
							if ($remember) {
								$this->create_autologin($user->user_id);
							}

							$this->clear_login_attempts($login);

							$this->ci->users->update_login_info(
									$user->user_id,
									$this->ci->config->item('login_record_ip'),
									$this->ci->config->item('login_record_time'));
							return TRUE;
						}
					}
				} else {
					$this->increase_login_attempt($login);
					$this->error = array('password' => 'Incorrect password');
				}
			} else {
				$this->increase_login_attempt($login);
				$this->error = array('login' => 'Incorrect login');
			}
		}
		return FALSE;
	}

	function logout() {
		$this->delete_autologin();
		$this->ci->session->set_userdata(array('user_id' => '', 'email' => ''));
		$this->ci->session->sess_destroy();
	}

	function is_logged_in() {
		return $this->ci->session->userdata('user_id') != '';
	}

	function get_user_id() {
		return $this->ci->session->userdata('user_id');
	}

	function create_user($email, $password, $firstname = '', $lastname = '', $oauthprovider = '', $oauthuid = '', $oauthtoken = '', $oauthsecret = '') {
        if (!$this->ci->users->is_email_available($email)) {
			$this->error = array('email' => 'Email is already used by another user. Please choose another email.');
		} else {
			$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength'),
					$this->ci->config->item('phpass_hash_portable'));
			$hashed_password = $hasher->HashPassword($password);

			$data = array(
				'user_id'	=> generate_code(CODE_USERS),
				'first_name'	=> $firstname,
				'last_name'	=> $lastname,
				'password'	=> $hashed_password,
				'email'		=> $email,
				'last_ip'	=> $this->ci->input->ip_address()
			);
            
			$data_oauth = array(
				'oauth_provider' => $oauthprovider,
				'oauth_uid' => $oauthuid,
				'oauth_token' => $oauthtoken,
				'oauth_secret' => $oauthsecret
			);

			if (!is_null($res = $this->ci->users->create_user($data, $data_oauth))) {
				$data['user_id'] = $res['user_id'];
				$data['password'] = $password;
				unset($data['last_ip']);
                
                // Login user
                $this->ci->session->set_userdata(array(
                        'user_id'	=> $data['user_id'],
                        'email'	=> $email
                ));
                        
				return $data;
			}
		}
		return NULL;
	}

	function get_error_message() {
		return $this->error;
	}
    
    function login_user($user_id, $email) {
        $this->ci->session->set_userdata(array(
                'user_id'	=> $user_id,
                'email'	=> $email
        ));
    }

	private function create_autologin($user_id) {
		$this->ci->load->helper('cookie');
		$key = substr(md5(uniqid(rand().get_cookie($this->ci->config->item('sess_cookie_name')))), 0, 16);

        $this->ci->load->model('User_autologins_model', 'user_autologin');
		$this->ci->user_autologin->purge($user_id);

        if ($this->ci->user_autologin->set($user_id, md5($key))) {
			set_cookie(array(
					'name' 		=> $this->ci->config->item('autologin_cookie_name'),
					'value'		=> serialize(array('user_id' => $user_id, 'key' => $key)),
					'expire'	=> $this->ci->config->item('autologin_cookie_life'),
			));
			return TRUE;
		}
		return FALSE;
	}

	private function delete_autologin() {
		$this->ci->load->helper('cookie');
		if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name'), TRUE)) {
			$data = unserialize($cookie);

			$this->ci->load->model('User_autologins_model', 'user_autologin');
			$this->ci->user_autologin->delete($data['user_id'], md5($data['key']));

			delete_cookie($this->ci->config->item('autologin_cookie_name'));
		}
	}

	private function autologin() {
		if (!$this->is_logged_in() AND !$this->is_logged_in(FALSE)) {

			$this->ci->load->helper('cookie');
			if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name'), TRUE)) {

				$data = unserialize($cookie);

				if (isset($data['key']) AND isset($data['user_id'])) {
					$this->ci->load->model('User_autologins_model', 'user_autologin');
					if (!is_null($user = $this->ci->user_autologin->get($data['user_id'], md5($data['key'])))) {

						// Login user
						$this->ci->session->set_userdata(array(
								'user_id'	=> $user->user_id,
								'email'	=> $user->email
						));

						// Renew users cookie to prevent it from expiring
						set_cookie(array(
								'name' 		=> $this->ci->config->item('autologin_cookie_name'),
								'email'		=> $cookie,
								'expire'	=> $this->ci->config->item('autologin_cookie_life'),
						));
                        
						$this->ci->users->update_login_info(
								$user->user_id,
								$this->ci->config->item('login_record_ip'),
								$this->ci->config->item('login_record_time'));
						return TRUE;
					}
				}
			}
		}
		return FALSE;
	}

	function is_max_login_attempts_exceeded($login) {
		if ($this->ci->config->item('login_count_attempts')) {
			$this->ci->load->model('Login_attempts_model', 'login_attempts');
			return $this->ci->login_attempts->get_attempts_num($this->ci->input->ip_address(), $login)
					>= $this->ci->config->item('login_max_attempts');
		}
		return FALSE;
	}

	private function increase_login_attempt($login) {
		if ($this->ci->config->item('login_count_attempts')) {
			if (!$this->is_max_login_attempts_exceeded($login)) {
				$this->ci->load->model('Login_attempts_model', 'login_attempts');
				$this->ci->login_attempts->increase_attempt($this->ci->input->ip_address(), $login);
			}
		}
	}

	private function clear_login_attempts($login) {
		if ($this->ci->config->item('login_count_attempts')) {
			$this->ci->load->model('Login_attempts_model', 'login_attempts');
			$this->ci->login_attempts->clear_attempts(
					$this->ci->input->ip_address(),
					$login,
					$this->ci->config->item('login_attempt_expire'));
		}
	}
}