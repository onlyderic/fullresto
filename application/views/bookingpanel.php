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
<form class="form-horizontal" role="form">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Book now! Deals are quickly sold out</h3>
        </div>
        <div class="panel-form">
            <div class="panel-body">			
                <div class="form-group has-feedback bookingdate">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div><span class="icon icon-calendar-o"></span></div>
                            </span>
                            <select id="bookingdate" class="form-control" placeholder="When are you going?" <?php echo $status_dummy; ?>>
                                <option value="">When are you going?</option>
                                <option value="<?php echo date('Y-m-d'); ?>">Today (<?php echo date('d M, D'); ?>)</option>
                                <option value="<?php $date =  date('Y-m-d', strtotime("+1 day")); echo $date; ?>">Tomorrow (<?php echo date('d M, D', strtotime($date)); ?>)</option>
                                <?php for($ctr = 2; $ctr <= 30; $ctr++) { ?>
                                <option value="<?php $date =  date('Y-m-d', strtotime("+$ctr day")); echo $date; ?>"><?php echo date('d M, D', strtotime($date)); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group has-feedback bookingpax">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div><span class="icon icon-users"></span></div>
                            </span>
                            <select id="bookingpax" class="form-control" placeholder="How many people?" <?php echo $status_dummy; ?>>
                                <option value="">How many people?</option>
                                <?php for($ctr = 1; $ctr <= 20; $ctr++) { ?>
                                <option value="<?php echo $ctr; ?>"><?php echo $ctr; ?> pax</option>
                                <?php } ?>
                            </select>
                        </div>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group has-feedback bookingdeal">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div><span class="icon icon-gift"></span></div>
                            </span>
                            <input class="form-control" id="bookingdeal" type="text" placeholder="Select a deal" readonly="readonly" <?php echo $status_dummy; ?> />
                        </div>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <!--<div class="fullresto-nav" data-nav="left">
                            <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                        </div>-->
                        <div class="deals deals-panel" data-opted-deal="">
                            <div class="deals-scroll">
                            <?php
                            foreach($merchant_deals as $deals) { 
                                $ftime = get_time_display($deals->time_start);
                            ?>
                                <div class="deal" data-deal="<?php echo $deals->deal_id; ?>" data-discount="<?php echo $deals->label; ?>" data-day="<?php echo $deals->day; ?>" data-stime="<?php echo $deals->time_start; ?>" data-ftime="<?php echo $ftime; ?>" data-spax="<?php echo $deals->min_pax_per_book; ?>" data-epax="<?php echo $deals->max_pax_per_book; ?>">
                                    <?php echo $deals->label; ?>
                                    <div>
                                        <?php echo $ftime; ?>
                                    </div>
                                </div>
                            <?php } ?>	
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <!--<div class="fullresto-nav" data-nav="right">
                            <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                        </div>-->
                    </div>
                </div>
                <?php 
                    //if(!$logged_in) {
                ?>
                <div class="form-group fullresto-fb-login hidden">
                    <div class="col-sm-12">
                        <button data-btn="facebook-booking" class="btn btn-default btn-block" <?php echo $status_dummy; ?>>
                            <img src="" class="facebook-pic hidden img-circle" /><span class="icon icon-facebook-f hidden"></span> Login with your Facebook account
                        </button>
                        <div id="booking-fb-logged-in" class="hidden"><img src="" class="facebook-pic hidden img-circle" /><span class="hidden"></span> <span class="facebook-name"></span></div>
                    </div>
                </div>
                <?php 
                    //}
                ?>
                <div class="form-group has-feedback guestname">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div><span class="icon icon-user"></span></div>
                            </span>
                            <input class="form-control" id="guestname" type="text" placeholder="Your name" value="" <?php echo $status_dummy; ?> />
                        </div>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group has-feedback guestemail">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div><span class="icon icon-envelope"></span></div>
                            </span>
                            <input class="form-control is-email" id="guestemail" type="email" placeholder="Your email" value="" <?php echo $status_dummy; ?> />
                        </div>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group has-feedback guestcontactnum">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div><span class="icon icon-mobile"></span></div>
                            </span>
                            <input class="form-control is-number" id="guestcontactnum" type="text" placeholder="Your phone number" value="<?php //echo $contact_number; ?>" <?php echo $status_dummy; ?> />
                        </div>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div><span class="icon icon-tag"></span></div>
                            </span>
                            <input class="form-control" id="promotioncode" type="text" placeholder="Promo code (optional)" <?php echo $status_dummy; ?> />
                        </div>
                    </div>
                </div>
                <div class="bookingterms hidden">
                    <small>
                        <p class="text-info">
                            <span class="icon icon-exclamation-circle"></span> You should be at the store at least 5 minutes before the schedule
                        </p>
                        <p class="text-info">
                            <span class="icon icon-exclamation-circle"></span> The store has the right to change the terms of the deal without prior notice
                        </p>
                        <p class="text-info">
                            <span class="icon icon-exclamation-circle"></span> Improper use of our booking system will subject you to suspension or ban
                        </p>
                    </small>
                </div>
            </div>
            <div class="panel-footer text-center">
                <button data-btn="review" class="btn btn-success btn-block" type="button" <?php echo $status_dummy; ?>>Review your booking &raquo;</button> 
            </div>
        </div>
        <div class="panel-final">
            <div class="panel-body">
                <h5>Please confirm your booking...</h5>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div><span class="icon icon-calendar-o"></span></div>
                            </span>
                            <input class="form-control bookingdate" type="text" value="" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div><span class="icon icon-users"></span></div>
                            </span>
                            <input class="form-control bookingpax" type="text" value="" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div><span class="icon icon-gift"></span></div>
                            </span>
                            <input class="form-control bookingdeal" type="text" value="" readonly="readonly" />
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
                            <input class="form-control guestname" type="text" value="" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div><span class="icon icon-envelope"></span></div>
                            </span>
                            <input class="form-control guestemail" type="text" value="" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div><span class="icon icon-mobile"></span></div>
                            </span>
                            <input class="form-control guestcontactnum" type="text" value="" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <?php 
                    //}
                ?>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div><span class="icon icon-tag"></span></div>
                            </span>
                            <input class="form-control promotioncode" type="text" value="" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <div>
                    <small>
                        <p class="text-info">
                            <span class="icon icon-exclamation-circle"></span> You should be at the store at least 5 minutes before the schedule
                        </p>
                        <p class="text-info">
                            <span class="icon icon-exclamation-circle"></span> The store has the right to change the terms of the deal without prior notice
                        </p>
                        <p class="text-info">
                            <span class="icon icon-exclamation-circle"></span> Improper use of our booking system will subject you to suspension or ban
                        </p>
                    </small>
                </div>
            </div>
            <div class="panel-footer text-center">
                <div class="btn-group btn-group-justified" role="group">
                    <div class="btn-group" role="group">
                        <button data-btn="edit" class="btn btn-primary" type="button">Edit</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button data-btn="confirm" class="btn btn-success" type="button">Confirm booking</button> 
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-process hidden">
            <div></div>
            <div>Processing...</div>
        </div>
    </div>
</form>