<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookings extends CI_Controller {

    public function _remap($method, $params = array()) {
        if( $method == 'my-booking' && count($params) == 1 ) {
            $booking_id = isset($params[0]) ? trim($params[0]) : '';
            $this->_view($booking_id);
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
        if(!$this->auth->is_logged_in()) {
            redirect('login');
        }
        
    	$data['logged_in'] = $this->auth->is_logged_in();
        
        $this->load->model('Bookings_model', 'bookings');
        $data['booking_records'] = $this->bookings->get_list_my_bookings($this->auth->get_user_id());
        
        $filters = array('searchtype' => 'recentviews');
        $data['recent_views_records'] = get_list_deal_records($filters, 5);
        
        $this->load->view('header', $data);
        $this->load->view('mybookings', $data);
        $this->load->view('footer', $data);
    }
    
    public function cancel() {
        if(!$this->auth->is_logged_in()) {
            return true;
        }
        
        if(isset($_POST['booking-number'])) {
            
            $this->load->model('Bookings_model', 'bookings');
            
            $booking_id = $this->input->post('booking-number');
            $booking_record = $this->bookings->get_record($booking_id);
        
            $continue = true;
            $error_message = $success_message = '';
            
            if($booking_record) {
                
                if($booking_record->user_id != $this->auth->get_user_id()) {
                    $continue = false;
                    $error_message = 'This is not your booking';
                }
                
                if($continue &&
                    date_timestamp_get(date_create(date('Y-m-d H:i'))) >= date_timestamp_get(date_create($booking_record->date_booked . ' ' . $booking_record->time_booked_from))) {
                    $continue = false;
                    $error_message = 'This booking has passed';
                }
                
                if($continue &&
                    date_timestamp_get(date_create(date('Y-m-d H:i', strtotime('+1 hours')))) >= date_timestamp_get(date_create($booking_record->date_booked . ' ' . $booking_record->time_booked_from))) {
                    $continue = false;
                    $error_message = 'Cancellation can only be done at least 1 hour before';
                }
                
                if($continue && $booking_record->user_status == BOOK_USER_STATUS_CANCELLED) {
                    $continue = false;
                    $error_message = 'This booking has been cancelled previously';
                }
                
                if($continue && $booking_record->merchant_status == BOOK_MERCHANT_STATUS_CANCELLED) {
                    $continue = false;
                    $error_message = 'This booking has been cancelled by the Restaurant';
                }
                
                if($continue && $booking_record->merchant_status == BOOK_MERCHANT_STATUS_DENIED) {
                    $continue = false;
                    $error_message = 'This booking has been denied by the Restaurant';
                }
                
                if($continue) {
                    $result = $this->bookings->cancel($booking_record->booking_id);
                    if($result) {
                        $success_message = 'The booking has been cancelled';
                    } else {
                        $continue = false;
                        $error_message = 'Please check again later';
                    }
                }
                
            } else {
                $continue = false;
                $error_message = 'Could not find the booking record with that reference code';
            }
            
            $json['status'] = ($continue ? HTTP_SUCCESS : HTTP_ERROR);
            $json['message'] = ($error_message != '' ? 'Unable to cancel the booking.<br/>' . $error_message : $success_message);
            header('Content-Type: application/json');
            echo json_encode($json);
            return true;
            
        } else {
            redirect('bookings');
        }
    }
	
    protected function _view($booking_id = '') {
        $cache_filename = 'booking_' . $booking_id . '_' . $this->auth->get_user_id();
        
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        if(!$view = $this->cache->get($cache_filename)) {
            
            $this->load->model('Bookings_model', 'bookings');
            $booking_record = $this->bookings->get_record($booking_id);

            if($booking_record && $booking_record->user_id == $this->auth->get_user_id()) { 
                
                $data['logged_in'] = $this->auth->is_logged_in();

                $this->load->model('Merchants_model', 'merchants');

                $data['booking_record'] = $booking_record;
                $data['merchant_profile'] = $merchant_profile = $this->merchants->get_record('detail', $booking_record->merchant_profile_id);
                $data['merchant_url'] = set_url(URL_MERCHANT, $merchant_profile->city, '', $merchant_profile->display_name, $booking_id);
                $data['merchant_services'] = $this->merchants->get_list_services($booking_record->merchant_profile_id);
                $data['currency'] = get_currency_symbol($merchant_profile->currency);

				$data['merchant_name'] = isset($data['merchant_profile']->display_name) ? $data['merchant_profile']->display_name : '';

                $data['map'] = get_map('detail', $this->session->userdata("current_city"), $merchant_profile->map_latitude, $merchant_profile->map_longitude, $merchant_profile->city, $merchant_profile->display_name, $merchant_profile->merchant_profile_id);

	            $view = $this->load->view('header', $data, TRUE);
                $view .= $this->load->view('bookingdetail', $data, TRUE);
                $view .= $this->load->view('footer', $data, TRUE);
                
                $this->cache->save($cache_filename, $view, $this->config->item('cache_time'));
                echo $view;
                return true;
            }
		} else {
       		echo $view;		
			return true;
        }
        show_404();
	}
}
