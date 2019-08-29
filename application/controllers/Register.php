<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    private $folder = 'register/';
    
    function __construct() {
        parent::__construct();
    }
    
	public function index($error_message = '') {    
        if($this->auth->is_logged_in()) {
            redirect('main');
        }
        
        $this->load->helper('form');
        
        $data['logged_in'] = $this->auth->is_logged_in();
        $call_reference = str_replace(base_url(), '', (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''));
        if(strpos($call_reference, 'register') !== false || strpos($call_reference, 'login') !== false) {
            $call_reference = '';
        }
        $data['call_reference'] = $call_reference;
        $data['error_message'] = $error_message;
        
		$this->load->view('header', $data);
		$this->load->view($this->folder . 'register', $data);
		$this->load->view('footer', $data);
	}
    
	public function now() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|max_length[64]|valid_email|callback__check_email');
        $this->form_validation->set_rules('firstname', 'First Name', 'trim|max_length[64]');
        $this->form_validation->set_rules('firstname', 'Last Name', 'trim|max_length[64]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[1]|max_length[30]');
        
        $error_message = '';
        if($this->form_validation->run() !== FALSE) {
            if (!is_null($record = $this->auth->create_user(
                            $this->input->post('email'),
                            $this->input->post('password'),
                            $this->input->post('firstname'),
                            $this->input->post('lastname')))) {

                send_email_notification('register', $record['email'], $record['first_name'], 
                        $this->config->item('email_from_register'), 
                        $this->config->item('email_from_name_register'), 
                        $this->config->item('email_subject_register'));

                redirect('');
            } else {
                $error_message = $this->lang->line('error_user_save');
            }
        }
        $this->index($error_message);
    }
    
	public function auth() {
        $http_status = HTTP_ERROR;
        $view_data = array();
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|max_length[64]|valid_email|callback__check_email');
        $this->form_validation->set_rules('firstname', 'First Name', 'trim|max_length[64]');
        $this->form_validation->set_rules('firstname', 'Last Name', 'trim|max_length[64]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[password]');

        if($this->form_validation->run() !== FALSE) {
            if (!is_null($record = $this->auth->create_user(
                            $this->input->post('email'),
                            $this->input->post('password'),
                            $this->input->post('firstname'),
                            $this->input->post('lastname')))) {

                send_email_notification('register', $record['email'], $record['first_name'], 
                        $this->config->item('email_from_register'), 
                        $this->config->item('email_from_name_register'), 
                        $this->config->item('email_subject_register'));

                unset($record['password']); // Clear password (just in case)
                $http_status = HTTP_SUCCESS;
            } else {
                $view_data['error_message'] = $this->lang->line('error_user_save');
            }
        }
        
        $json['status'] = $http_status;
		$json['view'] = $this->load->view($this->folder . 'register', $view_data, TRUE);
        
        header('Content-Type: application/json');
        echo json_encode($json);
    }
    
    public function _check_email($str) {
        $this->load->model('Users_model', 'user');
        if(is_temp_email($str)) {
            $this->form_validation->set_message('_check_email', $this->lang->line('error_email_temporary') );
            return FALSE;
        }
        $result = $this->user->check_email($str);
        if(!$result) {
            $this->form_validation->set_message('_check_email', $this->lang->line('error_email_used') );
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
