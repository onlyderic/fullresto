<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    private $folder = '';

    function __construct() {
        parent::__construct();
    }
    
	public function index() {
        $cache_filename = 'home_' . rand(0, 5);
        
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        if(!$view = $this->cache->get($cache_filename)) {
            $data['logged_in'] = $this->auth->is_logged_in();
	        $data['list'] = get_list_deals();

	        $view = $this->load->view('header', $data, TRUE);
	        $view .= $this->load->view('main', $data, TRUE);
	        $view .= $this->load->view('footer', $data, TRUE);
	        
	   		$this->cache->save($cache_filename, $view, $this->config->item('cache_time_home'));
	    }
	    echo $view;
	}
}
