<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
	public function index() {
        if(isset($_POST['accessToken'])) {
            $http_status = HTTP_ERROR;
            $user_id = '';
            
            $access_token = $this->input->post('accessToken');
            $id = $this->input->post('id');
            $email = $this->input->post('email');
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            
            $this->load->model('Users_model', 'user');
            $user_record = $this->user->get_user_by_email_or_fb_id($email, $id);
            
            if($user_record) {
                $http_status = HTTP_SUCCESS;
                $this->auth->login_user($user_record->user_id, $user_record->email);
                $user_id = $user_record->user_id;
            } else {
                if (!is_null($record = $this->auth->create_user(
                                $email,
                                '',
                                $first_name,
                                $last_name,
                                'F', $id, $access_token))) {
                    
                    $http_status = HTTP_SUCCESS;
                    $this->auth->login_user($record['user_id'], $record['email']);
                    $user_id = $record['user_id'];

                    send_email_notification('register', $record['email'], $record['first_name'], 
                            $this->config->item('email_from_register'), 
                            $this->config->item('email_from_name_register'), 
                            $this->config->item('email_subject_register'));
                }
            }
            
            if($http_status == HTTP_SUCCESS) {
                $street = $this->input->post('address_street');
                $city = $this->input->post('address_city');
                $state = $this->input->post('address_state');
                $country = $this->input->post('address_country');
                $zip = $this->input->post('address_zip');
                $mobile_phone = $this->input->post('mobile_phone');
                $birthday = $this->input->post('birthday');
                $gender = $this->input->post('gender');
                $link = $this->input->post('link');
                $address1 = trim($street . ' ' . $city . ' ' . $state);
                $address2 = trim($country . ' ' . $zip);
                if(!empty($address1)) {
                    $data['address1'] = $address1;
                }
                if(!empty($address1)) {
                    $data['address2'] = $address2;
                }
                if(!empty($mobile_phone)) {
                    $data['contact_number'] = $mobile_phone;
                }
                if(!empty($birthday)) {
                    $data['birthdate'] = $birthday;
                }
                if(!empty($gender)) {
                    $data['gender'] = strtoupper($gender);
                }
                if(!empty($link)) {
                    $data['url_facebook'] = $link;
                }
                
                $user_record = $this->user->update($data, array(), $user_id);
            }
        
            $json['status'] = $http_status;
            header('Content-Type: application/json');
            echo json_encode($json);
        }
    }
}
