<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

define('STATUS_DELIVERED', '203');
define('STATUS_SENT_TO_NETWORK', '200');
define('STATUS_MESSAGE_QUEUED', '201');
define('STATUS_NOT_AUTHORIZED', '100');
define('STATUS_NOT_ENOUGH_BALANCE', '101');
define('STATUS_FEATURE_NOT_ALLOWED', '102');
define('STATUS_INVALID_OPTIONS', '103');
define('STATUS_GATEWAY_DOWN', '104');

class Semaphore {

	function __construct() {
		$this->ci =& get_instance();
        $this->ci->load->model('Sms_model', 'sms');
	}

	function send($to_one_number, $message_body) {
        if($this->ci->config->item('sms_enable')) {
            $fields = array();
            $fields["api"] = $this->ci->config->item('sms_api');
            $fields["number"] = $to_one_number; //safe use 63
            $fields["message"] = $message_body;
            $fields["from"] = $this->ci->config->item('sms_from');
            $fields_string = http_build_query($fields);
            $outbound_endpoint = $this->ci->config->item('sms_outbound_endpoint');
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $outbound_endpoint);
            curl_setopt($ch,CURLOPT_POST, count($fields));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            
            $output = json_decode($output);
            $message_id = isset($output->message_id) ? $output->message_id : '';
            $code = isset($output->code) ? $output->code : '';
            
            $this->ci->sms->create($message_id, $code);
            
            return $output;
        }
	}
    
    function status($message_id = '', $code = '') {
        return $this->ci->sms->create($message_id, $code);
    }
    
    function test_output($message_id = '', $code = '') {
        $this->ci->sms->create($message_id, $code);
        return '{"status":"success","message":"Message Queued","code":"201","message_id":"==","from":"SEMAPHORE","to":"","body":"Test SMS"}';
    }
    
    function test_send($to_one_number, $message_body) {
        $fields = array();
        $fields["api"] = "";
        $fields["number"] = $to_one_number; //safe use 63
        $fields["message"] = $message_body;
        $fields["from"] = "";
        $fields_string = http_build_query($fields);
        $outbound_endpoint = "http://api.semaphore.co/api/sms";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $outbound_endpoint);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $output = json_decode($output);
        $message_id = isset($output->message_id) ? $output->message_id : '';
        $code = isset($output->code) ? $output->code : '';

        $this->ci->sms->create($message_id, $code);

        return $output;
    }
}