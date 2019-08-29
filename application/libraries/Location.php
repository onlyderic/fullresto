<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Location {
	function __construct() {
		$this->ci =& get_instance();
	}

	function get($ip = '') {
        $ip = (empty($ip) ? $_SERVER['REMOTE_ADDR'] : $ip);
        $this->ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        if (!$result = $this->ci->cache->get('loc_' . $ip)) {
            $url = $this->ci->config->item('location_url') . $ip;
            try {
				$result = file_get_contents($url);
				$result = json_decode($result);
                $this->ci->cache->save('loc_' . $ip, $result, 0); //0 for infinite
            } catch(Exception $e) {}
        }
        return $result;
    }
}