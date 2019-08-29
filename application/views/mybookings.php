<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container manage-bookings">
    <div class="page-header">
      <h1>Manage Bookings</h1>
    </div>
    
    <div class="row">
        <div class="col-md-8">

            <?php if(count($booking_records) > 0) { ?>
            <strong>Current Bookings</strong>
            <div class="spacer-20"></div>
            <table class="table table-condensed">
            <?php
            $booking_records_simplified = array();
            foreach($booking_records as $booking_record) {
                $booking_records_simplified[$booking_record->booking_id] = array(
                    'code' => '<a href="' . set_url(URL_BOOKINGS, $booking_record->city, '', $booking_record->display_name, $booking_record->booking_id) . '">' . $booking_record->booking_id . '</a>',
                    'merchant' => '<a href="' . set_url(URL_MERCHANT, $booking_record->city, '', $booking_record->display_name, $booking_record->merchant_profile_id) . '">' . $booking_record->display_name . '</a>',
                    'date_booked' => $booking_record->date_booked,
                    'time_booked_from' => get_time_display($booking_record->time_booked_from),
                    'deal' => ($booking_record->deal_discount_rate_type == DEAL_RATE_TYPE_FIX_AMOUNT ? 'P' . $booking_record->deal_discount_rate : $booking_record->deal_discount_rate . '%'),
                    'pax_booked' => $booking_record->pax_booked,
                    'booking_name' => $booking_record->booking_name,
                    'booking_email' => $booking_record->booking_email,
                    'booking_contact_number' => $booking_record->booking_contact_number,
                    'promo_code' => $booking_record->promo_code,
                    'status' => get_booking_status($booking_record->user_status, $booking_record->merchant_status)
                );
                $is_rated = !empty($booking_record->rating_id) ? true : false;
                $is_ratable_reviewable = ($booking_record->merchant_status == BOOK_MERCHANT_STATUS_FULFILLED);
                $rate_box = $is_rated ? '' : 'hidden';
                $pls_rate_box = $is_rated ? 'hidden' : '';
                $rate_merchant = !empty($booking_record->rate_merchant) ? 'rate-' . $booking_record->rate_merchant : '';
                $rate_price = !empty($booking_record->rate_price) ? 'price-rate-' . $booking_record->rate_price : '';
            ?>
                <tbody>
                    <tr>
                        <th colspan="5">
                            <div class="row bg-info">
                                <div class="col-sm-2">
                                    <?php echo $booking_records_simplified[$booking_record->booking_id]['code']; ?>
                                </div>
                                <div class="col-sm-7">
                                    <?php echo $booking_records_simplified[$booking_record->booking_id]['merchant']; ?>
                                </div>
                                <div class="col-sm-3 text-right fullresto-rating <?php echo $rate_merchant . ' ' . $rate_price; ?>" data-id="<?php echo $booking_record->booking_id; ?>">
                                    <div class="ratings <?php echo $rate_box; ?>">
                                        <div>
                                            <div></div>
                                        </div>
                                        <div>
                                            <div></div>
                                        </div>
                                    </div>
                                    <span class="<?php echo $pls_rate_box; ?>">
                                        <?php if($is_ratable_reviewable) { ?>
                                        Please rate your experience
                                        <?php } else { ?>
                                        <small>Rate &amp; review upon completion</small>
                                        <?php } ?>
                                    </span>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                        <td><?php echo $booking_record->date_booked; ?></td>
                        <td><?php echo $booking_records_simplified[$booking_record->booking_id]['time_booked_from']; ?></td>
                        <td><?php echo $booking_records_simplified[$booking_record->booking_id]['deal']; ?></td>
                        <td><?php echo $booking_records_simplified[$booking_record->booking_id]['status']; ?></td><!--TODO: MERCHANT AND USER STATUSES?-->
                        <td>
                            <div class="btn-group dropup pull-right booking-action" data-id="<?php echo $booking_record->booking_id; ?>">
                              <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                              </button>
                                <?php //TODO: Should not be able to rate if cancelled ?>
                              <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#" data-btn="booking-detail">View Detail</a></li>
                                <?php if($booking_record->user_status != BOOK_USER_STATUS_CANCELLED && 
                                        $booking_record->merchant_status == BOOK_MERCHANT_STATUS_TAKEN &&
                                        date_timestamp_get(date_create($booking_record->date_booked . ' ' . $booking_record->time_booked_from)) > time()) { ?>
                                <li><a href="#" data-btn="cancel-booking">Cancel Booking</a></li>
                                <?php } ?>
                                <?php if(!$is_rated && $is_ratable_reviewable) { ?>
                                <li><a href="#" data-btn="booking-rating" data-id="<?php echo $booking_record->booking_id; ?>">Ratings &amp; Review</a></li>
                                <?php } ?>
                              </ul>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th colspan="5">&nbsp;</th>
                    </tr>
                </tbody>
            <?php } ?>
            </table>
            <script type="text/javascript">
            var br = <?php echo json_encode($booking_records_simplified); ?>;
            </script>
            <?php } else { ?>
            <div class="row">
                <div class="col-md-12">
                    You're still eating, right?<br>
                    Claim your discounts when you eat at your favorite restaurants! <a href="search">Search for deals now.</a>
                </div>
            </div>
            <?php } ?>
            
        </div>
        <div class="col-md-4">
            <?php if(count($recent_views_records['merchants']) > 0) { ?>
            <strong>Recently Viewed</strong>
            <?php } ?>
            <div class="spacer-30"></div>
            <div class="row">
                <?php 
                foreach($recent_views_records['merchants'] as $key => $merchant) {
                    $this->load->view('merchantlistitem', array('merchant' => $merchant, 'deals' => $recent_views_records['deals'], 'is_full_width' => TRUE));
                }
                ?>
            </div>
        </div>
    </div>

</div>