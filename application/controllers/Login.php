<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    private $folder = 'login/';

    public function _remap($method, $params = array()) {
        if( $method == 'forgot-password' ) {
            $this->_forgot_password();
            return true;
        }
        elseif( $method == 'reset-password' && count($params) == 1 ) {
            $this->_reset_password($params[0]);
            return true;
        }
        elseif( $method == 'auth-book' ) {
            $this->_auth_book();
            return true;
        }
        if(method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            show_404();
        }
    }
    
    function __construct() {
        parent::__construct();
    }
    
	public function index() {   
        if($this->auth->is_logged_in()) {
            redirect('');
        }
        
        $this->load->helper('form');
        
        $data['logged_in'] = $this->auth->is_logged_in();
        $call_reference = str_replace(base_url(), '', (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''));
        if(strpos($call_reference, 'register') !== false || strpos($call_reference, 'login') !== false) {
            $call_reference = '';
        }
        $data['call_reference'] = $call_reference;
        
		$this->load->view('header', $data);
		$this->load->view($this->folder . 'login', $data);
		$this->load->view('footer', $data);
	}
    
	public function auth() {
        $http_status = HTTP_ERROR;
        $view_data = array();
        $this->load->helper('form');
        
        if($this->auth->is_logged_in()) {
            $http_status = HTTP_SUCCESS;
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('userlogin', 'Email', 'required|xss_clean');
            $this->form_validation->set_rules('userpass', 'Password', 'required|xss_clean');
            $this->form_validation->set_rules('userremember', 'Remember me', 'xss_clean');
            
            if($this->form_validation->run() !== FALSE) {
                if($this->auth->login(
                        $this->form_validation->set_value('userlogin'),
                        $this->form_validation->set_value('userpass'),
                        $this->form_validation->set_value('userremember')
                        )) {
                    $http_status = HTTP_SUCCESS;
                } else {
                    $view_data['error_message'] = $this->lang->line('error_user_login');
                }
            }
        
        }
        
        $json['status'] = $http_status;
		$json['view'] = $this->load->view($this->folder . 'login', $view_data, TRUE);
        
        header('Content-Type: application/json');
        echo json_encode($json);
    }
    
	protected function _auth_book() {
        $http_status = HTTP_ERROR;
        $message = array();
        
        if($this->auth->is_logged_in()) {
            $http_status = HTTP_SUCCESS;
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('userlogin', 'Email', 'required|xss_clean');
            $this->form_validation->set_rules('userpass', 'Password', 'required|xss_clean');
            $this->form_validation->set_rules('userremember', 'Remember me', 'xss_clean');
            
            $message = $this->lang->line('error_user_login');
            if($this->form_validation->run() !== FALSE) {
                if($this->auth->login(
                        $this->form_validation->set_value('userlogin'),
                        $this->form_validation->set_value('userpass'),
                        $this->form_validation->set_value('userremember')
                        )) {
                    $http_status = HTTP_SUCCESS;
                }
            }
        
        }
        
        $json['status'] = $http_status;
        $json['message'] = $message;
        
        header('Content-Type: application/json');
        echo json_encode($json);
    }
    
    protected function _forgot_password() {
        if($this->auth->is_logged_in()) {
            redirect('');
        }
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('userlogin', 'Email Address', 'required|valid_email|xss_clean');
        
        $call_reference = $this->session->flashdata('call_reference');
        if(isset($_POST['submit'])) {
            $call_reference = $this->input->post('call_reference');
        }
                       
        if($this->form_validation->run() !== FALSE) {
            $this->load->model('Users_model', 'user');
            $row = $this->user->get_user_by_email($this->input->post('userlogin'));
            if($row && $row->status == USER_STATUS_ACTIVE) {
                $data['new_password_key'] = generate_code(CODE_PASSWORD);
                $data['new_password_requested'] = date(DATETIME_DB_FORMAT);
                $return = $this->user->update($data, array(), $row->user_id);
            
                if($return) {
                    send_email_notification('forgotpassword', 
                            $row->email, 
                            $row->first_name, 
                            $this->config->item('email_from_forgotpassword'), 
                            $this->config->item('email_from_name_forgotpassword'), 
                            $this->config->item('email_subject_forgotpassword'), 
                            array('password_key' => site_url('login/reset-password/' . $data['new_password_key'])));

                    $this->session->set_flashdata('redirect_message_status', 'success');
                    $this->session->set_flashdata('redirect_message', $this->lang->line('success_forgot_password'));
                } else {
                    $this->session->set_flashdata('redirect_message_status', 'error');
                    $this->session->set_flashdata('redirect_message', $this->lang->line('error_user_update'));
                }
                
                if($call_reference == '') {
                    redirect('');
                } else {
                    redirect($call_reference);
                }
            } else {
                $data['error_message'] = $this->lang->line('error_user_email_forgot_password');
            }
        }

        $data['logged_in'] = $this->auth->is_logged_in();
        $data['call_reference'] = $call_reference;
        
		$this->load->view('header', $data);
		$this->load->view($this->folder . 'forgot_password', $data);
		$this->load->view('footer', $data);
    }
    
    protected function _reset_password($password_key = '') {
        if($this->auth->is_logged_in()) {
            redirect('');
        }

        $data = array();
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('userpass', 'Password', 'required|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('usercpass', 'Confirm Password', 'required|matches[userpass]');
                      
        $this->load->model('Users_model', 'user');
        $row = $this->user->get_user_by_password_key($password_key);
        $valid = false;
        if($row && $row->hours_past <= 24) {
            $data['password_key'] = $password_key;
            $valid = true;
        }
        
        if(!$valid) {
            $this->session->set_flashdata('redirect_message_status', 'error');
            $this->session->set_flashdata('redirect_message', 'error');
            redirect('');
        }
        
        if($this->form_validation->run() !== FALSE) {
            $record['password'] = create_password($this->input->post('userpass'));
            $record['new_password_key'] = '';
            $result = $this->user->update($record, array(), $row->user_id);
            
            if($result) {
                $this->session->set_flashdata('redirect_message_status', 'success');
                $this->session->set_flashdata('redirect_message', $this->lang->line('success_password_update'));
                redirect('');
            } else {
                $this->session->set_flashdata('redirect_message_status', 'error');
                $this->session->set_flashdata('redirect_message', $this->lang->line('error_user_update'));
                redirect('login/reset-password/' . $password_key);
            }
        }
        
        $data['logged_in'] = $this->auth->is_logged_in();
        $data['redirect_message_status'] = $this->session->flashdata('redirect_message_status');
        $data['redirect_message'] = $this->session->flashdata('redirect_message');
        
		$this->load->view('header', $data);
		$this->load->view($this->folder . 'reset_password', $data);
		$this->load->view('footer', $data);
    }
}
