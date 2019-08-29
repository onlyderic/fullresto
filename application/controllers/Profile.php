<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    
	public function index() {
        if(!$this->auth->is_logged_in()) {
            redirect('login');
        }
        
        $this->load->helper('cities');
        $this->load->model('Users_model', 'users');
        $user_record = $this->users->get_user_by_id($this->auth->get_user_id());
        if(!$user_record) {
            $this->auth->logout();
            redirect('login');
        }
        
        $filters = array('searchtype' => 'recentviews');
        $data['recent_views_records'] = get_list_deal_records($filters, 5);
        
        $data['countries'] = get_country_list();
        $data['cities'] = get_city_list($user_record->country);
    	$data['logged_in'] = $this->auth->is_logged_in();
        $data['user_record'] = $user_record;
        
        $this->load->view('header', $data);
        $this->load->view('profile', $data);
        $this->load->view('footer', $data);
    }
    
    public function update() {
        if(!$this->auth->is_logged_in()) {
            return true;
        }
        
        if(isset($_POST['email'])) {
            $continue = true;
            $error_message = $success_message = '';
        
            $data['email'] = $_POST['email'];
            $data['first_name'] = (isset($_POST['firstname']) ? trim($_POST['firstname']) : '');
            $data['last_name'] = (isset($_POST['lastname']) ? trim($_POST['lastname']) : '');
            $data['contact_number'] = (isset($_POST['phone']) ? trim($_POST['phone']) : '');
            $data['address1'] = (isset($_POST['address1']) ? trim($_POST['address1']) : '');
            $data['address2'] = (isset($_POST['address2']) ? trim($_POST['address2']) : '');
            $data['country'] = (isset($_POST['country']) ? trim($_POST['country']) : '');
            $data['city'] = (isset($_POST['city']) ? trim($_POST['city']) : '');
            $data['city'] = ($data['city'] == 'OTHER' ? trim($_POST['othercity']) : $data['city']);
            $data['url_facebook'] = (isset($_POST['facebook']) ? trim($_POST['facebook']) : '');
            $data['url_twitter'] = (isset($_POST['twitter']) ? trim($_POST['twitter']) : '');
            $password = (isset($_POST['password']) ? trim($_POST['password']) : '');
            $password2 = (isset($_POST['password2']) ? trim($_POST['password2']) : '');
            
            $this->load->helper('email');
            if(empty($data['first_name'])) {
                $continue = false;
                $error_message = 'Provide your first name.';
            } else if(empty($data['last_name'])) {
                $continue = false;
                $error_message = 'Provide your last name.';
            } else if(empty($data['email']) || !valid_email($data['email'])) {
                $continue = false;
                $error_message = 'Provide your email.';
            } else if(empty($data['contact_number']) || !is_numeric($data['contact_number'])) {
                $continue = false;
                $error_message = 'Provide your contact number.';
            } else if(!empty($password) && count($password) <= 1 && $password != $password2) {
                $continue = false;
                $error_message = 'Provide a valid password and match it in the confirmation field.';
            }
            
            if($continue) {
                if(!empty($password)) {
                    $data['password'] = generate_hash($password);
                }
                
                $this->load->model('Users_model', 'users');
                $result = $this->users->update($data, array(), $this->auth->get_user_id());
                if($result) {
                    $success_message = 'Your profile has been updated';
                } else {
                    $continue = false;
                    $error_message = 'Unable to update your profile. Please check again later';
                }
            }
            
            $json['status'] = ($continue ? HTTP_SUCCESS : HTTP_ERROR);
            $json['message'] = ($error_message != '' ? $error_message : $success_message);
            header('Content-Type: application/json');
            echo json_encode($json);
            return true;
        } else {
            show_404();
        }
    }
}
