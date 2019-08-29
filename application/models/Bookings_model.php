<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Bookings_model extends CI_Model {
    
    private $bookings_table = 'bookings';
    private $deals_table = 'deals';
    private $merchant_profiles_table = 'merchant_profiles';
    private $booking_ratings_table = 'booking_ratings';

    function __construct() {
        parent::__construct();
    }
    
    function update($data, $where, $booking_id) {
        $where['booking_id'] = $booking_id;
        return $this->db->update($this->bookings_table, $data, $where);
    }
    
	function create($data = array()) {
        $query = $this->db->get_where($this->deals_table, array('deal_id' => $data['deal_id'], 'status' => DEAL_STATUS_ACTIVE));
        $deal = $query->row();
        if(!$deal) {
            return NULL;
        }
        
        //$date_now = date('Y-m-d H:i:s');
		$record['booking_id'] = generate_code(CODE_TRANSACTION);
		$record['user_id'] = $data['user_id'];
		$record['merchant_profile_id'] = $deal->merchant_profile_id;
		$record['deal_id'] = $data['deal_id'];
		//$record['datetime_booking'] = $date_now;
        $this->db->set('datetime_booking', 'NOW()', FALSE);
		$record['date_booked'] = $data['date_booked'];
		$record['time_booked_from'] = $deal->time_start;
		$record['time_booked_to'] = $deal->time_end;
		$record['pax_booked'] = $data['pax_booked'];
		$record['name'] = $data['name'];
		$record['contact_number'] = $data['contact_number'];
		$record['email'] = $data['email'];
		$record['promo_code'] = $data['promo_code'];
		$record['user_status'] = BOOK_USER_STATUS_CONFIRMED;
		//$record['user_status_date'] = $date_now;
        $this->db->set('user_status_date', 'NOW()', FALSE);
		$record['user_reason'] = '';
		$record['merchant_status'] = BOOK_MERCHANT_STATUS_TAKEN;
		//$record['merchant_status_date'] = $date_now;
        $this->db->set('merchant_status_date', 'NOW()', FALSE);
		$record['merchant_reason'] = '';
		$record['deal_type'] = $deal->deal_type;
		$record['deal_day'] = $deal->day;
		$record['deal_time_start'] = $deal->time_start;
		$record['deal_time_end'] = $deal->time_end;
		$record['deal_discount_rate'] = $deal->discount_rate;
		$record['deal_discount_rate_type'] = $deal->discount_rate_type;
		$record['deal_discount_type'] = $deal->discount_type;
		$record['deal_min_pax_per_book'] = $deal->min_pax_per_book;
		$record['deal_max_pax_per_book'] = $deal->max_pax_per_book;
		$record['deal_min_pax_per_deal'] = $deal->min_pax_per_deal;
		$record['deal_max_pax_per_deal'] = $deal->max_pax_per_deal;
		$record['deal_min_price_per_book'] = $deal->min_price_per_book;
		$record['deal_max_price_per_book'] = $deal->max_price_per_book;

		if($this->db->insert($this->bookings_table, $record)) {
            
            //TODO: Update contact number if not the same in record..
            //TODO: Keep track of email address changes...
            $this->db->reset_query();
            $this->db->set('num_bookings', 'num_bookings + 1', FALSE);
            $this->db->where('merchant_profile_id', $deal->merchant_profile_id);
            $this->db->update($this->merchant_profiles_table);
            
            $this->db->reset_query();
			return $this->db->get_where($this->bookings_table, array('booking_id' => $record['booking_id']))->row();
		}
		return NULL;
	}
    
    function get_record($booking_id = '') {
        $query = $this->db->get_where($this->bookings_table, array('booking_id' => $booking_id));
        
        if($query->num_rows() == 1) {
            return $query->row();
        }
        return NULL;
    }
    
    function get_list_by_user($user_id = '', $filters = array()) {
		$this->db->from($this->bookings_table);
        $this->db->join($this->deals_table, $this->deals_table . '.deal_id = ' . $this->bookings_table . '.deal_id', 'left');
        $this->db->where($this->bookings_table . '.user_id', $user_id);
        
        if(isset($filters['searchtype']) && $filters['searchtype'] == 'all') {
            $this->db->select('*, ' . $this->bookings_table . '.name AS booking_name, ' . $this->bookings_table . '.email AS booking_email, ' . $this->bookings_table . '.contact_number AS booking_contact_number');
            $this->db->join($this->merchant_profiles_table, $this->merchant_profiles_table . '.merchant_profile_id = ' . $this->bookings_table . '.merchant_profile_id', 'left');
            $this->db->order_by($this->bookings_table . '.datetime_booking', 'DESC');
        } else {
            $this->db->where($this->bookings_table . '.user_status', BOOK_USER_STATUS_CONFIRMED);
            $this->db->where($this->bookings_table . '.merchant_status', BOOK_MERCHANT_STATUS_TAKEN);
            $this->db->where('DATE(' . $this->bookings_table . '.datetime_booking) >=', 'CURRENT_DATE', false);
        }
        $this->db->where($this->deals_table . '.status', DEAL_STATUS_ACTIVE);

        return $this->db->get()->result();
    }
    
    function get_list_my_bookings($user_id = '') {
        $this->db->select('*, ' . 
                $this->bookings_table . '.name AS booking_name, ' . 
                $this->bookings_table . '.email AS booking_email, ' . 
                $this->bookings_table . '.contact_number AS booking_contact_number, ' . 
                $this->bookings_table . '.booking_id AS booking_id');
		$this->db->from($this->bookings_table);
        $this->db->join($this->deals_table, $this->deals_table . '.deal_id = ' . $this->bookings_table . '.deal_id', 'left');
        $this->db->join($this->merchant_profiles_table, $this->merchant_profiles_table . '.merchant_profile_id = ' . $this->bookings_table . '.merchant_profile_id', 'left');
        $this->db->join($this->booking_ratings_table, $this->booking_ratings_table . '.booking_id = ' . $this->bookings_table . '.booking_id', 'left');
        $this->db->where($this->bookings_table . '.user_id', $user_id);
        $this->db->where($this->deals_table . '.status', DEAL_STATUS_ACTIVE);
        $this->db->order_by($this->bookings_table . '.datetime_booking', 'DESC');

        return $this->db->get()->result();
    }
    
    function get_num_current_bookings($merchant_profile_id = '') {
        $this->db->where('DATE(datetime_booking)', 'CURRENT_DATE', FALSE);
        $this->db->where('TIME_TO_SEC(TIMEDIFF(NOW(), datetime_booking)) <=', '7200', FALSE); //7200seconds or 2hours
        $row = $this->db->select('COUNT(merchant_profile_id) AS count', false)->get_where($this->bookings_table, array('merchant_profile_id' => $merchant_profile_id), 1)->row();
        return ($row ? $row->count : 0);
    }
    
    function get_count_bookings_per_deal($deal_id = '') {
    	$this->db->select("booking_id");
		$this->db->from($this->bookings_table);
        $this->db->where($this->bookings_table . '.deal_id', $deal_id);
        $this->db->where($this->bookings_table . '.user_status', BOOK_USER_STATUS_CONFIRMED);
        $this->db->where($this->bookings_table . '.merchant_status', BOOK_MERCHANT_STATUS_TAKEN);
		$query = $this->db->get();
        
        return $query->num_rows();
    }
    
    function cancel($booking_id = '', $reason = '') {
        $data = array(
            'user_status' => BOOK_USER_STATUS_CANCELLED,
            'user_reason' => $reason
        );
        $this->db->set('user_status_date', 'NOW()', FALSE);

        $this->db->where('booking_id', $booking_id);
        $this->db->update($this->bookings_table, $data);
        
        return $this->db->affected_rows() > 0;
    }
}