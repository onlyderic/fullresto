<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Deals_model extends CI_Model {
    
    private $deals_table = 'deals';

    function __construct() {
        parent::__construct();
    }
    
    function get_record($deal_id = '') {
        return $this->db->get_where($this->deals_table, array('deal_id' => $deal_id, 'status' => DEAL_STATUS_ACTIVE))->row();
    }
    
    /**
     * 
     * @param type $filters
     * @param type $mode - 'list' or 'count' only
     * @param type $offset
     * @param type $limit
     * @return type
     */
    function get_search_result($filters = array(), $mode = 'list', $offset = 0, $limit = 10) {
    	if($mode == 'count') {
            $querystr = "SELECT COUNT(DISTINCT mp.merchant_profile_id) AS count
                        FROM merchant_profiles mp
                        LEFT JOIN deals d ON d.merchant_profile_id = mp.merchant_profile_id
                        WHERE d.status = 1
                        AND mp.status_subscription = " . MERCHANT_SUBSCRIPTION_STATUS_ACTIVE . "
                        AND mp.status = " . MERCHANT_STATUS_ACTIVE . "
                        AND mp.status_public = " . MERCHANT_PROFILE_PUBLIC_STATUS_APPROVED . "
                        AND mp.admin_approved = " . MERCHANT_PROFILE_ADMIN_STATUS_APPROVED;
        } elseif($mode == 'list') {
            
            $latitude = $this->db->escape($filters['latitude']);
            $longitude = $this->db->escape($filters['longitude']);
            $latitude = (is_numeric($latitude) ? $latitude : 0);
            $latitude = $latitude * 0.0174532925;
            $longitude = (is_numeric($longitude) ? $longitude : 0);
            if(isset($filters['searchtype']) && $filters['searchtype'] == 'nearby') {
				$querystr_nearby = " (
                        (
                        ACOS(
                            SIN($latitude) * SIN(map_latitude * 0.0174532925) + 
                            COS($latitude) * COS(map_latitude * 0.0174532925) * 
                            COS(($longitude - map_longitude) * 0.0174532925)
                            ) * 0.0174532925
                        ) * 69.0900
                        ) AS nearby ";
			} else {
				$querystr_nearby = " 0 AS nearby ";
            }
            $querystr_nearby_where = " OR (
                    (
                    ACOS(
                        SIN($latitude) * SIN(map_latitude * 0.0174532925) + 
                        COS($latitude) * COS(map_latitude * 0.0174532925) * 
                        COS(($longitude - map_longitude) * 0.0174532925)
                        ) * 0.0174532925
                    ) * 69.0900
                    ) <= 2 ";
            
            if(isset($filters['searchtype']) && $filters['searchtype'] == 'recentviews') {
				$querystr_recentviews = " mv.view_date";
				$querystr_join_recentviews = " LEFT JOIN merchant_views mv ON mv.merchant_profile_id = mp.merchant_profile_id ";
				$querystr_groupby_recentviews = " GROUP BY d.deal_id ";
            } else {
				$querystr_recentviews = " NULL AS view_date ";
				$querystr_join_recentviews = "";
				$querystr_groupby_recentviews = "";
            }
            
            $querystr = "SELECT GROUP_CONCAT(deal_id ORDER BY time_start SEPARATOR '|') AS deal_ids, 
                                GROUP_CONCAT(label ORDER BY time_start SEPARATOR '|') AS deal_labels,
                                /*GROUP_CONCAT(CONCAT(time_start, ' - ', time_end) ORDER BY time_start SEPARATOR '|') AS deal_times,*/
                                GROUP_CONCAT(time_start ORDER BY time_start SEPARATOR '|') AS deal_times,
                                merchant_profile_id,
                                display_name,
                                cuisine,
                                rating,
                                price_rating,
                                num_rating,
                                num_price_rating,
                                num_bookings,
                                date_created,
                                date_created_deal,
                                popularity,
                                map_latitude,
                                map_longitude,
                                city,
                                recommended,
                                nearby,
                                view_date,
                                active_paid
                        FROM (
                            SELECT d.deal_id, 
                                d.label, 
                                TIME_FORMAT(d.time_start, '%H:%i') AS time_start, 
                                TIME_FORMAT(d.time_end, '%H:%i') AS time_end, 
                                mp.merchant_profile_id, 
                                mp.display_name, 
                                mp.cuisine, 
                                mp.rating, 
                                mp.price_rating, 
                                mp.num_rating, 
                                mp.num_price_rating, 
                                mp.num_bookings, 
                                mp.date_created,
                                d.date_created AS date_created_deal, 
                                ((num_bookings*40) + ((rating/5)*20) + ((price_rating/5)*20) + ((num_favorites/COALESCE(num_views,1))*20)) AS popularity,
                                mp.map_latitude,
                                mp.map_longitude,
                                mp.city,
                                mp.recommended,
                                mp.active_paid,
                                $querystr_nearby,
                                $querystr_recentviews
                            FROM deals d
                            LEFT JOIN merchant_profiles mp ON mp.merchant_profile_id = d.merchant_profile_id
                            $querystr_join_recentviews
                            WHERE d.status = " . DEAL_STATUS_ACTIVE . "
                            AND mp.status_subscription = " . MERCHANT_SUBSCRIPTION_STATUS_ACTIVE . "
                            AND mp.status = " . MERCHANT_STATUS_ACTIVE . "
                            AND mp.status_public = " . MERCHANT_PROFILE_PUBLIC_STATUS_APPROVED . "
                            AND mp.admin_approved = " . MERCHANT_PROFILE_ADMIN_STATUS_APPROVED;
            
            $day = date('w');
            $where_day = '';
            //0-everyday, 1-monday, 2-tuesday, 3-wednesday, 4-thursday, 5-friday, 
            //6-saturday, 7-sunday, 8-mwf, 9-tth, 10-weekends, 11-weekdays
            switch($day) {
                case 0: $where_day = "day = '7' OR day = '10'"; break; //Sunday
                case 1: $where_day = "day = '1' OR day = '8' OR day = '11'"; break;
                case 2: $where_day = "day = '2' OR day = '9' OR day = '11'"; break;
                case 3: $where_day = "day = '3' OR day = '8' OR day = '11'"; break;
                case 4: $where_day = "day = '4' OR day = '9' OR day = '11'"; break;
                case 5: $where_day = "day = '5' OR day = '8' OR day = '11'"; break;
                case 6: $where_day = "day = '6' OR day = '10'"; break;
            }
            $querystr .= " AND (day = '0' OR $where_day) ";
            
            if(isset($filters['merchantprofileids']) && $filters['merchantprofileids'] != "") {
				$querystr .= " AND d.merchant_profile_id NOT IN (".$filters['merchantprofileids'].") ";
			}
            
            if(isset($filters['bookingpax']) && !empty($filters['bookingpax']) && is_numeric($filters['bookingpax'])) {
				$querystr .= " AND ".$filters['bookingpax']." BETWEEN d.min_pax_per_book AND d.max_pax_per_book";
            }
            
            if(isset($filters['bookingdate']) && !empty($filters['bookingdate'])) {
                $booking_date = $this->db->escape($filters['bookingdate']);
				$querystr .= " AND (d.deal_end_date > $booking_date
                               OR (d.deal_end_date = $booking_date AND d.deal_end_date > CURRENT_DATE)
                               OR (d.deal_end_date = $booking_date AND d.deal_end_date = CURRENT_DATE AND d.time_start > CURRENT_TIME))";
            } else {
				$querystr .= " AND (d.deal_end_date > CURRENT_DATE 
                               OR (d.deal_end_date = CURRENT_DATE AND time_start > CURRENT_TIME))"; //TODO: Add hours to current time
			}
            
           	if(isset($filters['keyword']) && !empty($filters['keyword']) && trim($filters['keyword']) != '') {
                $keywords = explode(' ', $filters['keyword']);
                $keywords_query = '';
                foreach($keywords as $keyword) {
                    $keyword = strtolower(trim($keyword));
                    $keyword = preg_replace('/^(a|an|and|or)$/', '', $keyword);
                    if(!empty($keyword)) {
                        $keywords_query .= " OR LOWER(mp.display_name) LIKE ".$this->db->escape("%".$keyword."%");
                    }
                }
                $querystr .= " AND (1=0 $keywords_query)";
			}
			
			if($filters['searchsort'] == "recommended") {
				$querystr .= " AND mp.recommended = " . YES; 
			}
			if($filters['searchtype'] == "recentviews") {
				$querystr .= " AND mv.user_id = '" . $filters['user_id'] . "'"; 
			}
			
			if(!empty($filters['city']) && $filters['city'] == $filters['curr_city']) {
                $querystr .= " AND (mp.city = '".$filters['city']."' $querystr_nearby_where)"; 
			} elseif(!empty($filters['city'])) {
                $querystr .= " AND mp.city = '".$filters['city']."'"; 
            }
			
			if(!empty($filters['country'])) {
                $querystr .= " AND mp.country = '".$filters['country']."'"; 
			}
			
            $querystr .= $querystr_groupby_recentviews;
			$querystr .= " ORDER BY d.time_start ASC, d.discount_rate ASC";
            $querystr .= " ) tbl ";
            $querystr .= " WHERE 1=1 ";
            
            $querystr .= " GROUP BY merchant_profile_id";
            
           	if($filters['searchtype'] == 'new') {
				$querystr .= " ORDER BY date_created_deal DESC, date_created DESC";  
			} elseif($filters['searchtype'] == 'popular') {
				$querystr .= " ORDER BY popularity DESC";  
			} elseif($filters['searchtype'] == 'nearby' && empty($filters['searchsort'])) {
				$querystr .= " ORDER BY nearby ASC";
			} elseif($filters['searchtype'] == "recentviews") {
				$querystr .= " ORDER BY view_date ASC "; 
			} else {
				if($filters['searchsort'] != "recommended"){ // && !empty($filters['city'])
					if($filters['searchsort'] == "name") {
						$querystr .= " ORDER BY display_name ASC";  
					} elseif($filters['searchsort'] == "affordable") {
						$querystr .= " ORDER BY price_rating DESC";  
					} elseif($filters['searchsort'] == "expensive") {
						$querystr .= " ORDER BY price_rating ASC";  
					} elseif($filters['searchsort'] == "low") {
						$querystr .= " ORDER BY popularity ASC";  
					} elseif($filters['searchsort'] == "high") {
						$querystr .= " ORDER BY popularity DESC";  
					}		
				} else {
					$querystr .= " ORDER BY RAND()";
				}
            }
            
            //TODO: Exclude holidays of the restaurant
            
            if( is_numeric($offset) && is_numeric($limit) ) {
                $querystr .= " LIMIT " . (int)$offset . ", " . (int)$limit;
            }
		}
        
        $query = $this->db->query($querystr);
        
        if($mode == 'count') {
            return $query->row();
        } else {
            return $query->result();
        }
    }
    
    function get_deals_merchant($merchant_profile_id = '') {
        $sql = "SELECT deal_id, merchant_profile_id, deal_type, label, day,
                    TIME_FORMAT(time_start, '%H:%i') as time_start, TIME_FORMAT(time_end, '%H:%i') as time_end,
                    discount_rate, discount_rate_type, discount_type, min_pax_per_book, max_pax_per_book,
                    min_pax_per_deal, max_pax_per_deal, min_price_per_book, max_price_per_book,
                    deal_end_date, status, date_created
				FROM deals 
				WHERE merchant_profile_id = '".$merchant_profile_id."' 
				AND (deal_end_date > CURRENT_DATE 
				OR (deal_end_date = CURRENT_DATE AND time_start > CURRENT_TIME))
                AND status = " . DEAL_STATUS_ACTIVE; //TODO: Add hours to current time
			
		$query = $this->db->query($sql);
		
		return $query->result();
    }
}