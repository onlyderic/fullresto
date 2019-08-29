<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
    
	public function sms_output() {
        $this->load->library('Semaphore');
        $output = $this->semaphore->test_output('test', 'abc');
        $output = json_decode($output);
        $message_id = isset($output->message_id) ? $output->message_id : '';
        $code = isset($output->code) ? $output->code : '';
        
        echo '$message_id = '.$message_id;
        echo '<br>';
        echo '$code = '.$code;
    }
    
	public function sms_real() {
        $this->load->library('Semaphore');
        $output = $this->semaphore->test_send(00, "Test from Test Function");
        print_r($output);
        $message_id = isset($output->message_id) ? $output->message_id : '';
        $code = isset($output->code) ? $output->code : '';
        
        echo '<br>';
        echo '$message_id = '.$message_id;
        echo '<br>';
        echo '$code = '.$code;
    }
    
    public function cut_words() {
        echo cut_words("The quick brown fox jumps over the lazy dog near the river bank");
    }
    
    public function is_philippine_number() {
        $nums = array();
        foreach($nums as $num) {
            echo $num . ' = ' . (is_philippine_number($num) ? 'true' : 'false');
            echo '<br>';
        }
    }
    
    public function format_number() {
        $nums = array();
        foreach($nums as $num) {
            echo $num . ' = ' . format_phone($num, 'PH');
            echo '<br>';
        }
    }
    
	public function location() {
        $this->load->library('Location');
        $location = $this->location->get("");
        print_r($location);
    }
}
