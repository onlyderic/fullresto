<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    
	public function index() {
        $data['logged_in'] = $this->auth->is_logged_in();
        
        $this->load->helper('form');
        $this->load->helper('captcha');
        
        $vals = array(
            'img_path'      => './captcha/',
            'img_url'       => site_url() . '/captcha/',
            'img_width'     => '150',
            'img_height'    => 30,
            'expiration'    => 7200,
            'word_length'   => 4,
            'font_size'     => 16,
            'img_id'        => 'Imageid',
            'pool'          => '',

            // White background, border and grid, and black text
            'colors'        => array(
                    'background' => array(255, 255, 255),
                    'border' => array(255, 255, 255),
                    'text' => array(0, 0, 0),
                    'grid' => array(255, 255, 255)
            )
        );

        $cap = create_captcha($vals);
        $data['captcha_image'] = $cap['image'];
        $data['captcha_word'] = md5($cap['word']);
        
		$this->load->view('header', $data);
		$this->load->view('contact', $data);
		$this->load->view('footer', $data);
	}
    
    public function send() {
        $http_status = HTTP_ERROR;
        $view_data = array();
        $error_message = '';
        $success_message = '';
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|max_length[64]|valid_email');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[64]');
        $this->form_validation->set_rules('message', 'Your Message', 'trim|required');
        $this->form_validation->set_rules('image', 'Letters on the image', 'required|min_length[4]|max_length[4]|callback__check_captcha');
        $this->form_validation->set_rules('in', 'In', 'trim|min_length[1]');
        
        if($this->form_validation->run() !== FALSE) {
            $data = array('name' => $_POST['name'],
                'email' => $_POST['email'],
                'message' => nl2br($_POST['message']));
            send_email_notification('contact', 
                    $this->config->item('email_to_contactus'), 
                    $this->config->item('email_to_name_contactus'), 
                    $this->config->item('email_from_contactus'), 
                    $this->config->item('email_from_name_contactus'), 
                    $this->config->item('email_subject_contactus'), 
                    $data);
            
            $http_status = HTTP_SUCCESS;
            $success_message = "Your message has been sent!<br/><br/>Thank you for sending us a message. We will respond to you soon.";
        }
        
        if($http_status != HTTP_SUCCESS) {
            $this->load->helper('captcha');

            $vals = array(
                'img_path'      => './captcha/',
                'img_url'       => site_url() . '/captcha/',
                'img_width'     => '150',
                'img_height'    => 30,
                'expiration'    => 7200,
                'word_length'   => 4,
                'font_size'     => 16,
                'img_id'        => 'Imageid',
                'pool'          => '',

                // White background, border and grid, and black text
                'colors'        => array(
                        'background' => array(255, 255, 255),
                        'border' => array(255, 255, 255),
                        'text' => array(0, 0, 0),
                        'grid' => array(255, 255, 255)
                )
            );

            $cap = create_captcha($vals);
            $view_data['captcha_image'] = $cap['image'];
            $view_data['captcha_word'] = md5($cap['word']);
        }
        
        $view_data['error_message'] = $error_message;
        $view_data['success_message'] = $success_message;
        
        $json['status'] = $http_status;
		$json['view'] = $this->load->view('contact', $view_data, TRUE);
        
        header('Content-Type: application/json');
        echo json_encode($json);
    }
    
    public function _check_captcha($str) {
        $original_captcha = $this->input->post('in');
        if($original_captcha != md5($str)) {
            $this->form_validation->set_message('_check_captcha', $this->lang->line('error_captcha_invalid') );
            return FALSE;
        }
        return TRUE;
    }
}
