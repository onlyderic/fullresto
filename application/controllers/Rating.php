<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rating extends CI_Controller {

    public function _remap($method, $params = array()) {
        if( $method == 'check' ) {
            $this->_check_rating();
            return true;
        }
        elseif( $method == 'rate' ) {
            $this->_rate();
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
    
    function index() {
        redirect('');
    }
    
	protected function _rate() {
        //TODO: Re-cache merchant detail page (take note of the favorited -- or ratings and favorites are dynamically retrieved each time through ajax)
        $http_status = HTTP_ERROR;
        $rate1 = $rate2 = '';
        if($this->auth->is_logged_in() && isset($_POST['code']) && isset($_POST['rate1']) && isset($_POST['rate2'])) {
            $this->load->model('Merchants_model', 'merchants');
            $this->load->model('Booking_ratings_model', 'ratings');
            $booking_record = $this->ratings->get_record($this->input->post('code'));
            if(!$booking_record) {
                $return_row = $this->ratings->create($this->input->post('code'), 
                        $this->input->post('rate1'), 
                        $this->input->post('rate2'),
                        $this->auth->get_user_id());
                $http_status = $return_row ? HTTP_SUCCESS : HTTP_ERROR;
                if(isset($return_row->rate1)) {
                    $rate1 = $return_row->rate1;
                    $rate2 = $return_row->rate2;
                }
            }
        }
        $json['status'] = $http_status;
        $json['rate1'] = $rate1;
        $json['rate2'] = $rate2;
        header('Content-Type: application/json');
        echo json_encode($json);
	}
    
	protected function _check_rating() {
        $this->load->model('Booking_ratings_model', 'ratings');
        $booking_id = isset($_GET['code']) ? $this->input->get('code') : '';
        $booking_ratings_record = $this->ratings->get_record($booking_id);
        $json['status'] = ($booking_ratings_record ? true : false);
        header('Content-Type: application/json');
        echo json_encode($json);
	}
}
