<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    
	public function index() {
        $data['logged_in'] = $this->auth->is_logged_in();
		$this->load->view('header', $data);
		$this->load->view('aboutus', $data);
		$this->load->view('footer', $data);
	}
}
