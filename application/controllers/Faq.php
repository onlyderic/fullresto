<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    
	public function index() {
        $data['logged_in'] = $this->auth->is_logged_in();
		$this->load->view('header', $data);
		$this->load->view('faq', $data);
		$this->load->view('footer', $data);
	}
}
