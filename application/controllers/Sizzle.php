<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sizzle extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    
	public function index() {
        $data['logged_in'] = $this->auth->is_logged_in();
        $tools = $this->load->view('headertools', $data, TRUE);
        
        $name = '';
        $email = '';
        $contact_number = '';
        $favorite = '';
        if(isset($_POST['id']) && $_POST['id']) { //Merchant Detail View
            $this->load->model('Users_model', 'users');
            $this->load->model('Favorites_model', 'favorites');
            
            $user = $this->users->get_user_by_id($this->auth->get_user_id());
            if($user) {
                $name = $user->first_name . ' ' . $user->last_name;
                $email = $user->email;
                $contact_number = $user->contact_number;
            }
            if($this->favorites->check_is_favorited($_POST['id'], $this->auth->get_user_id())) {
                $favorite = 'favorite';
            }
        }
        
        $json['name'] = $name;
        $json['email'] = $email;
        $json['contact_number'] = $contact_number;
        $json['favorite'] = $favorite;
        $json['tools'] = $tools;
        $json['larzianian'] = ($data['logged_in'] ? md5(random_string()) : '');
        header('Content-Type: application/json');
        echo json_encode($json);
	}
    
    function cities() {
        $this->load->helper('cities');
        $country = $this->input->get('country');
        $json['status'] = HTTP_SUCCESS;
        $json['cities'] = get_city_list($country);
        header('Content-Type: application/json');
        echo json_encode($json);
    }
}
