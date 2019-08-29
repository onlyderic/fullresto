<!--
deal_type = 0-dine/in, 1-delivery, 2-take/out
day = 0-everyday, 1-monday, 2-tuesday, 3-wednesday, 4-thursday, 5-friday, 6-saturday, 7-sunday, 8-mwf, 9-tth, 10-weekends, 11-weekdays
discount_rate_type = 0-fix amount, 1-percentage
discount_type = 0-all, 1-food, 2-drinks

min_pax_per_book
max_pax_per_book

min_pax_per_deal
max_pax_per_deal

min_price_per_book
max_price_per_book
-->
<?php
$deal = ($booking_record->deal_discount_rate_type == DEAL_RATE_TYPE_FIX_AMOUNT ? 'P' . $booking_record->deal_discount_rate : $booking_record->deal_discount_rate . '%');
?>
<div class="row">
    <div class="col-md-12 text-center">
        <h2><?php echo $booking_record->booking_id; ?></h2>
        <small>Booking Reference Number</small>
    </div>
</div>
<div class="spacer-20"></div>
<div class="row">
    <div class="col-md-12">
        <div><label>Status:</label> <?php echo get_booking_status($booking_record->user_status, $booking_record->merchant_status); ?></div>
        <div><label>Date Booked:</label> <?php echo $booking_record->datetime_booking; ?></div>
    </div>
</div>

<div class="spacer-20"></div>

<div class="form-horizontal">
    <div class="panel panel-default panel-final show">
        <div class="panel-heading">
            <h3 class="panel-title">Your booking details</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <div><span class="icon icon-calendar-o"></span></div>
                        </span>
                        <input class="form-control bookingdate" type="text" value="<?php echo $booking_record->date_booked; ?>" readonly="readonly" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <div><span class="icon icon-users"></span></div>
                        </span>
                        <input class="form-control bookingpax" type="text" value="<?php echo $booking_record->pax_booked; ?>" readonly="readonly" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <div><span class="icon icon-gift"></span></div>
                        </span>
                        <input class="form-control bookingdeal" type="text" value="<?php echo $deal . ' @ ' . get_time_display($booking_record->time_booked_from); ?>" readonly="readonly" />
                    </div>
                </div>
            </div>
            <?php 
                //if(!$logged_in) {							
            ?>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <div><span class="icon icon-user"></span></div>
                        </span>
                        <input class="form-control guestname" type="text" value="<?php echo $booking_record->name; ?>" readonly="readonly" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <div><span class="icon icon-envelope"></span></div>
                        </span>
                        <input class="form-control guestemail" type="text" value="<?php echo $booking_record->email; ?>" readonly="readonly" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <div><span class="icon icon-mobile"></span></div>
                        </span>
                        <input class="form-control guestcontactnum" type="text" value="<?php echo $booking_record->contact_number; ?>" readonly="readonly" />
                    </div>
                </div>
            </div>
            <?php 
                //}
            ?>
            <?php if(!empty($booking_record->promo_code)) { ?>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <div><span class="icon icon-tag"></span></div>
                        </span>
                        <input class="form-control promotioncode" type="text" value="<?php echo $booking_record->promo_code; ?>" readonly="readonly" />
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="text-center">
    <a href="#" class="share-booking" data-url="<?php echo $merchant_url; ?>" data-deal="<?php echo $deal; ?>" data-name="<?php echo $merchant_profile->display_name; ?>">Let your friends on Facebook know about this deal!</a>
</div>
<script type="text/javascript">
$(function() {
    fullresto.util.share_booking('<?php echo substr($booking_record->datetime_booking, 0, 10); ?>', '<?php echo $booking_record->booking_id; ?>', $('[name=disqus_title]').val());
});
</script>