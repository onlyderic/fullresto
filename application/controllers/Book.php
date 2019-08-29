<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends CI_Controller {

    public function _remap($method, $params = array()) {
        if( $method == 'merchant' && count($params) == 1 ) {
            $this->_view($params[0]);
            return true;
        }
        elseif( $method == 'now' && count($params) == 0 ) {
            $this->_booking();
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
        redirect('');
    }
    
	public function viewings() {
        $current_nums = 0;
        if(isset($_GET['code'])) {
            $merchant_profile_id = $_GET['code'];
            $mode = $_GET['mode'];
            if($mode == 1) {
                $this->load->model('Merchants_model', 'merchants');
                $current_nums = $this->merchants->get_num_current_views($merchant_profile_id);
            } else {
                $this->load->model('Bookings_model', 'bookings');
                $current_nums = $this->bookings->get_num_current_bookings($merchant_profile_id);
            }
        }
        $json['num'] = $current_nums;
        header('Content-Type: application/json');
        echo json_encode($json);
    }
    
	protected function _booking() {
        if(isset($_POST['deal'])) {
            $continue = true;
            $error_message = $success_message = '';
            
            $this->load->model('Users_model', 'users');
            $this->load->model('Deals_model', 'deals');
            $this->load->model('Bookings_model', 'bookings');
            
            $booking_date = isset($_POST['date']) ? trim($_POST['date']) : '';
            $booking_pax = isset($_POST['pax']) ? trim($_POST['pax']) : '';
            $booking_deal = isset($_POST['deal']) ? trim($_POST['deal']) : '';
            $booking_name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $booking_email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $booking_contactnum = isset($_POST['contactnum']) ? trim($_POST['contactnum']) : '';
            $booking_promocode = isset($_POST['promocode']) ? trim($_POST['promocode']) : '';
            
            //check psoted data
            $this->load->helper('email');
            if(empty($booking_date)) {
                $continue = false;
                $error_message = 'Select the date when you will go.';
            } else if(empty($booking_pax) || !is_numeric($booking_pax)) {
                $continue = false;
                $error_message = 'Select how many people are going.';
            } else if(empty($booking_deal)) {
                $continue = false;
                $error_message = 'Select the deal and time.';
            } else if(empty($booking_name) || strlen($booking_name) <= 3) {
                $continue = false;
                $error_message = 'Type in your fullname.';
            } else if(empty($booking_email)) {
                $continue = false;
                $error_message = 'Type in your email.';
            } else if(!valid_email($booking_email) || is_temp_email($booking_email)) {
                $continue = false;
                $error_message = 'Type a valid and active email.';
            } else if(empty($booking_contactnum)) {
                $continue = false;
                $error_message = 'Type in your contact number.';
            } else if(!is_numeric($booking_contactnum)) {
                $continue = false;
                $error_message = 'Type in a valid number.';
            }
            
            if($continue) {
                if(!$this->auth->is_logged_in()) {
                    $user_record = $this->users->get_user_by_email($booking_email);
                    
                    $fb_email = isset($_POST['fb_email']) ? trim($_POST['fb_email']) : '';
                    $fb_id = isset($_POST['fb_id']) ? trim($_POST['fb_id']) : '';
                    
                    if(!$user_record && !empty($fb_email) && !empty($fb_id)) {
                        $user_record = $this->users->get_user_by_email_or_fb_id($booking_email, $fb_id);
                    }
                    
                    if(!$user_record) {
                        $fb_accessToken = isset($_POST['fb_accessToken']) ? trim($_POST['fb_accessToken']) : '';
                        $fb_first_name = isset($_POST['fb_first_name']) ? trim($_POST['fb_first_name']) : '';
                        $fb_last_name = isset($_POST['fb_last_name']) ? trim($_POST['fb_last_name']) : '';
                        $fb_address_street = isset($_POST['fb_address_street']) ? trim($_POST['fb_address_street']) : '';
                        $fb_address_city = isset($_POST['fb_address_city']) ? trim($_POST['fb_address_city']) : '';
                        $fb_address_state = isset($_POST['fb_address_state']) ? trim($_POST['fb_address_state']) : '';
                        $fb_address_country = isset($_POST['fb_address_country']) ? trim($_POST['fb_address_country']) : '';
                        $fb_address_zip = isset($_POST['fb_address_zip']) ? trim($_POST['fb_address_zip']) : '';
                        $fb_mobile_phone = isset($_POST['fb_mobile_phone']) ? trim($_POST['fb_mobile_phone']) : '';
                        $fb_birthday = isset($_POST['fb_birthday']) ? trim($_POST['fb_birthday']) : '';
                        $fb_gender = isset($_POST['fb_gender']) ? trim($_POST['fb_gender']) : '';
                        $fb_link = isset($_POST['fb_link']) ? trim($_POST['fb_link']) : '';
                        $address1 = trim($fb_address_street . ' ' . $fb_address_city . ' ' . $fb_address_state);
                        $address2 = trim($fb_address_country . ' ' . $fb_address_zip);
                        
                        $user_data = array(
                            'user_id'	=> generate_code(CODE_USERS),
                            'first_name'=> $booking_name,
                            'last_name' => $fb_last_name,
                            'password' => generate_hash('auto'),
                            'email' => $booking_email,
                            'contact_number' => $booking_contactnum,
                            'address1' => $address1,
                            'address2' => $address2,
                            'birthdate' => $fb_birthday,
                            'gender' => strtoupper($fb_gender),
                            'url_facebook' => $fb_link,
                            'last_ip' => $this->input->ip_address(),
                            'auto_created' => YES,
                            'oauthprovider' => (!empty($fb_id) ? 'F' : ''),
                            'oauthuid' => $fb_id,
                            'oauthtoken' => $fb_accessToken,
                            'oauthsecret' => ''
                        );

                        if (!is_null($res = $this->users->create($user_data))) {
                            $user_record = $this->users->get_user_by_id($user_data['user_id']);
                        } else {
                            $continue = false;
                            $error_message = 'OMG! We\'re unable to create your record this time.';
                        }
                    }
                    if($continue) {
                        $this->session->set_userdata(array(
                                'user_id'	=> $user_record->user_id,
                                'email'	=> $user_record->email
                        ));
                    }
                } else {
                    $user_record = $this->users->get_user_by_id($this->auth->get_user_id());
                }
            }
            
            if($continue) {
                //check user is not using email address of other existing users
                $is_my_email = $this->users->check_email($booking_email, $this->auth->get_user_id());
                if(!$is_my_email) {
                    $continue = false;
                    $error_message = 'The email address belongs to an existing user. Please login as that user if you want to use that email.';
                }
            }
            
            if($continue) {
                //check user if banned, suspended from booking
                if($user_record->banned == USER_BANNED) {
                    $continue = false;
                    $error_message = 'We\'re sorry. You have been disallowed to use this platform for the moment.';
                } else if($user_record->deal_status == USER_DEAL_SUSPEND) {
                    $continue = false;
                    $error_message = 'We\'re sorry. You have been suspended to book for the moment. Please check again soon.';
                }
            }

            if($continue) {
                $deal_record = $this->deals->get_record($booking_deal);
                
                $booking_records = $this->bookings->get_list_by_user($user_record->user_id);
                
                if(count($booking_records) >= 3) {
                    $continue = false;
                    $error_message = 'Take it easy! Let\'s give others a chance for this deal. You currently have 3 bookings.';
                } else {
                    $booking_date_timestamp = date_timestamp_get(date_create($booking_date));
                    $booking_date_timestamp2 = date_timestamp_get(date_create($booking_date . ' ' . $deal_record->time_start));
                    foreach($booking_records as $booked) {
                        if(date_timestamp_get(date_create($booked->date_booked)) == $booking_date_timestamp) {
                            $booked_timestamp = date_timestamp_get(date_create($booked->date_booked . ' ' . $booked->time_booked_from));
                            if((abs($booked_timestamp - $booking_date_timestamp2) / 60 / 60) <= 4) {
                                $continue = false;
                                $error_message = 'Consecutive booking is not allowed. You already have a booking within 4 hours.';
                                break;
                            }
                        }
                    }
                }
            }

            if($continue) {
                $booking_date_timestamp = date_timestamp_get(date_create($booking_date . ' ' . $deal_record->time_start));
                if($booking_date_timestamp < time()) {
                    $continue = false;
                    $error_message = 'Invalid date and time';
                } elseif($booking_date == date('Y-m-d') && (abs(time() - $booking_date_timestamp) / 60 / 60) <= 4) {
                    //TODO: Allow merchant to set the number of hours (with 0 to disable this checking)
                    $continue = false;
                    $error_message = 'Sorry, you\'re only allowed to book 4 hours before. Please select a different deal';
                } elseif (!is_numeric($booking_pax) || ($deal_record->max_pax_per_book != 0 && ($booking_pax < $deal_record->min_pax_per_book || $booking_pax > $deal_record->max_pax_per_book)) || ($deal_record->max_pax_per_book == 0 && $booking_pax < $deal_record->min_pax_per_book) ) {
                    $continue = false;
                    $error_message = 'Invalid number of people';
                } else {
                    $bookings_count = $this->bookings->get_count_bookings_per_deal($booking_deal);
                    if ($deal_record->max_pax_per_deal != 0 && ($bookings_count + $booking_pax) > $deal_record->max_pax_per_deal) {
                        $continue = false;
                        $error_message = 'OMG! This deal has been fully booked! Please choose a different deal.';
                    }
                }
            }
            
            $booking_id = $link = '';
            if($continue) {
                $data = array(
                    'date_booked' => $booking_date,
                    'pax_booked' => $booking_pax,
                    'deal_id' => $booking_deal,
                    'name' => $booking_name,
                    'email' => $booking_email,
                    'contact_number' => $booking_contactnum,
                    'promo_code' => $booking_promocode,
                    'user_id' => $user_record->user_id
                );
                $booking_record = $this->bookings->create($data);
                
                if($booking_record) {
                    $this->load->model('Merchants_model', 'merchants');
                    $merchant_record = $this->merchants->get_record('detail', $deal_record->merchant_profile_id);
                    
                    if($merchant_record) {
                        $booking_id = $booking_record->booking_id;
                        $booking_time = get_time_display($booking_record->time_booked_from);
                        
                        $link = set_url(URL_BOOKINGS, $merchant_record->city, '', $merchant_record->display_name, $booking_id);

                        $data['booking_id'] = $booking_id;
                        $data['link'] = $link;
                        $data['deal'] = ($booking_record->deal_discount_rate_type == DEAL_RATE_TYPE_FIX_AMOUNT ? 'P' . $booking_record->deal_discount_rate : $booking_record->deal_discount_rate . '%');
                        $data['status'] = get_booking_status($booking_record->user_status, $booking_record->merchant_status);
                        $data['time_booked_from'] = $booking_time;
                        $data['time_booked_to'] = $booking_record->time_booked_to;
                        $data['merchant_name'] = $merchant_record->display_name;
                        $data['merchant_link'] = set_url(URL_MERCHANT, $merchant_record->city, '', $merchant_record->display_name, $merchant_record->merchant_profile_id); //base_url('book/' . url_title($merchant_record->display_name) . '/' . url_title($deal_record->merchant_profile_id));

                        //Send email notification to customer, bcc admin
                        send_email_notification('booking', $booking_email, $booking_name, 
                                $this->config->item('email_from_booking'), 
                                $this->config->item('email_from_name_booking'), 
                                $this->config->item('email_subject_booking'),
                                $data);

                        //Send email notification to merchant
                        if($merchant_record) {
                            //TODO: Give option to merchant to unsubscribe sending of booking notifications
                            send_email_notification('booking-merchant', $merchant_record->email, $merchant_record->display_name, 
                                    $this->config->item('email_from_booking'), 
                                    $this->config->item('email_from_name_booking'), 
                                    $this->config->item('email_subject_booking_merchant') . " - [$booking_id on $booking_date " . $booking_time . "]",
                                    $data);    
                        }

                        //Send SMS to customer
                        if(is_philippine_number($booking_contactnum)) {
                            $this->load->library('Semaphore');
                            $merchant_name_short = cut_words($merchant_record->display_name);
                            $booking_contactnum = format_phone($booking_contactnum, 'PH');
                            $text_msg = "Confirmation of booking: $merchant_name_short on $booking_date " . $booking_record->time_booked_from . ". Ref#: $booking_id. Thank you for using!"; //TODO: Format and rephrase
                            $output = $this->semaphore->send($booking_contactnum, $text_msg);

                            $message_id = isset($output->message_id) ? $output->message_id : '';
                            if(!empty($message_id)) {
                                $this->bookings->update(array('message_id' => $message_id), array(), $booking_id);
                            }
                        }
                        
                        $success_message = 'Your booking is successful! Thank you for booking with us.';
                    } else {
                        $success_message = 'Booking was successfull. However, the confirmation email and SMS were not sent out. Please check your bookings records.';
                    }
                } else {
                    $continue = false;
                    $error_message = 'OMG! Sorry, your booking was not successfull as we encountered a technical issue. Please check again soon.';
                    //TODO: Send notification to admin
                }
            }
            
            $json['id'] = $booking_id;
            $json['link'] = $link;
            $json['status'] = ($continue ? HTTP_SUCCESS : HTTP_ERROR);
            $json['message'] = ($error_message != '' ? $error_message : $success_message);
            header('Content-Type: application/json');
            echo json_encode($json);
        } else {
            redirect('');
        }
	}
	
    protected function _view($merchant_profile_id = '') {
        //TODO: Pre-select Deal ID in the booking panel
        //TODO: Sync server time
        $cache_filename = 'merchant_' . $merchant_profile_id;

        $this->load->model('Merchants_model', 'merchants');
        $merchant_profile = $this->merchants->get_record('detail', $merchant_profile_id);

        if(!$merchant_profile) {
            redirect('');
        }
            
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        if(!$view = $this->cache->get($cache_filename)) {
            
            $data['logged_in'] = $this->auth->is_logged_in();

            $this->load->model('Deals_model', 'deals');
            $data['merchant_profile'] = $merchant_profile;
            $data['merchant_deals'] = $this->deals->get_deals_merchant($merchant_profile_id);
            if($merchant_profile->active_paid == NO) {
                $data['merchant_deals'] = array_slice($data['merchant_deals'], 0, config_item('deals_limit_free'));
            }
            $data['merchant_services'] = $this->merchants->get_list_services($merchant_profile_id);
            $data['currency'] = get_currency_symbol($merchant_profile->currency);

            $data['merchant_name'] = isset($data['merchant_profile']->display_name) ? $data['merchant_profile']->display_name : '';

            $this->_set_merchant_views($merchant_profile_id);

            $data['map'] = get_map('detail', $merchant_profile->city, $merchant_profile->map_latitude, $merchant_profile->map_longitude, $merchant_profile->city, $merchant_profile->display_name, $merchant_profile->merchant_profile_id);
        
            $view = $this->load->view('header', $data, TRUE);
            $view .= $this->load->view('merchantdetail', $data, TRUE);
            $view .= $this->load->view('footer', $data, TRUE);
        	
            $this->cache->save($cache_filename, $view, $this->config->item('cache_time'));
        }
        
        echo $view;
	}

    private function _set_merchant_views($merchant_profile_id = '') {
        try {
            $this->load->model('Merchants_model', 'merchants');
            $this->merchants->set_views($merchant_profile_id, $this->auth->get_user_id(), $this->input->ip_address());
        } catch(Exception $e) {}
    }
        
}
