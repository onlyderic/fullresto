<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Favorite extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    
	public function index() {
        $http_status = HTTP_ERROR;
        $favorite = '';
        if($this->auth->is_logged_in() && isset($_POST['code'])) {
            $this->load->model('Merchants_model', 'merchants');
            $this->load->model('Favorites_model', 'favorites');
            $row = $this->merchants->get_record('summary', $this->input->post('code'));
            if($row) {
                $return = $this->favorites->create($this->input->post('code'), $this->auth->get_user_id());
                $http_status = $return == NULL || $return ? HTTP_SUCCESS : HTTP_ERROR;
                $favorite = $return ? true : false;
            }
        }
        $json['status'] = $http_status;
        $json['favorite'] = $favorite;
        header('Content-Type: application/json');
        echo json_encode($json);
	}
}
