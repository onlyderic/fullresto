<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    
	public function index() {
        //TODO: Cache
        $filters['bookingdate'] = $data['bookingdate'] = $this->input->get("bookingdate");
        $filters['bookingpax'] = $data['bookingpax'] = $this->input->get("bookingpax");
        $filters['city'] = $data['bookingcity'] = urldecode($this->input->get("bookingcity"));
        $filters['keyword'] = $data['keyword'] = $this->input->get("keyword");
        $filters['searchsort'] = $data['searchsort'] = $this->input->get("sortby");
    
        $data['list'] = get_list_deals($filters);
        $data['map'] = get_map('search', $filters['city'], $this->session->userdata("curr_lat"), $this->session->userdata("curr_long"));
        
        $data['cities'] = get_list_existing_cities();
        $data['logged_in'] = $this->auth->is_logged_in();
        
		$this->load->view('header', $data);
		$this->load->view('search', $data);
		$this->load->view('footer', $data);
	}
    
	public function quick(){
        if(isset($_POST['searchtype'])) {
            $filters['searchtype'] = $this->input->post("searchtype");
            echo get_list_deals($filters);
        }
	}
	
	public function more() {
        $filters['merchantprofileids'] = $this->input->post("codes");
        $filters['searchtype'] = $this->input->post("searchtype");
        $filters['searchsort'] = $this->input->post("searchsort");
        $filters['city'] = $this->input->post("city");
        $filters['latitude'] = $this->input->post("latitude");
        $filters['longitude'] = $this->input->post("longitude");
        $filters['keyword'] = $this->input->post("keyword");
        $filters['bookingdate'] = $this->input->post("bookingdate");
        $filters['bookingpax'] = $this->input->post("bookingpax");
        
        echo get_list_deals($filters);
	}
}
