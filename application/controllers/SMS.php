<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SMS extends CI_Controller {
    
	public function callback() {
        if(isset($_POST['message_id']) && isset($_POST['code'])) {
            $message_id = $this->input->post('message_id');
            $code = $this->input->post('code');
            
            $this->load->library('Semaphore');
            $result = $this->semaphore->status($message_id, $code);
        }
	}
}
