<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Booking_ratings_model extends CI_Model {
    
    private $booking_ratings_table = 'booking_ratings';
    private $bookings_table = 'bookings';
    private $merchant_profiles_table = 'merchant_profiles';

    function __construct() {
        parent::__construct();
    }
    
    function get_record($booking_id = '') {
        $query = $this->db->get_where($this->booking_ratings_table, array('booking_id' => $booking_id));
        
        if($query->num_rows() == 1) {
            return $query->row();
        }
        return NULL;
    }
    
    function create($booking_id = '', $rate1 = 0, $rate2 = 0, $user_id = '') {
        $row = $this->db->select('rating_id')->get_where($this->booking_ratings_table, array('booking_id' => $booking_id))->row();
        $booking_record = $this->db->select('merchant_profile_id')->get_where($this->bookings_table, array('booking_id' => $booking_id, 'user_id' => $user_id))->row();
        if(!$row && $booking_record) {
            $booking_id = $this->db->escape_str($booking_id);
            $rate1 = ($rate1 < 1 || $rate1 > 5 ? 5 : $rate1);
            $rate2 = ($rate2 < 1 || $rate2 > 5 ? 5 : $rate2);
            if($this->db->insert($this->booking_ratings_table, array('booking_id' => $booking_id, 'rate_merchant' => $rate1, 'rate_price' => $rate2))) {
                $this->db->reset_query();
                $merchant_profile_id = $booking_record->merchant_profile_id;
                $this->db->set('rating', '(rating + ' . $rate1 . ') / (num_rating + 1)', FALSE);
                $this->db->set('price_rating', '(price_rating + ' . $rate2 . ') / (num_price_rating + 1)', FALSE);
                $this->db->set('num_rating', 'num_rating + 1', FALSE);
                $this->db->set('num_price_rating', 'num_price_rating + 1', FALSE);
                $this->db->where('merchant_profile_id', $merchant_profile_id);
                $this->db->update($this->merchant_profiles_table);
                
                $this->db->reset_query();
                $query = $this->db->select('rating AS rate1, price_rating AS rate2')->get_where($this->merchant_profiles_table, array('merchant_profile_id' => $merchant_profile_id));
                if($query->num_rows() == 1) {
                    return $query->row();
                }
                return true;
            }
        }
        return false;
    }
}