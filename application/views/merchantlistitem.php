<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$url = set_url(URL_MERCHANT, $merchant->city, '', $merchant->display_name, $merchant->merchant_profile_id);
$url_pic = './images/' . $merchant->merchant_profile_id . '/t/' . $merchant->merchant_profile_id . '.jpg';
$rating = $merchant->rating ? ' rate-' . $merchant->rating : '';
$price_rating = $merchant->price_rating ? ' price-rate-' . $merchant->price_rating : '';
$num_rating = $merchant->num_rating ? 'Rated by ' . $merchant->num_rating . ' customers' : '';
$col_widths = (isset($is_full_width) && $is_full_width ? 'col-xs-12 col-sm-12 col-md-12' : 'col-xs-12 col-sm-6 col-md-4');
?>
<div class="<?php echo $col_widths; ?> perx-item<?php echo $rating . $price_rating; ?>" data-id="<?php echo $merchant->merchant_profile_id; ?>">
    <div>
        <a href="<?php echo $url; ?>" target="_self">
            <div style="background-image: url(<?php echo $url_pic; ?>);"></div>
        </a>
        <div class="fullresto-detail">
            <div>
                <h4>
                    <a href="<?php echo $url; ?>">
                        <?php echo $merchant->display_name; ?>
                    </a>
                </h4>
                <div class="ratings" title="<?php echo $num_rating; ?>">
                    <div>
                        <div></div>
                    </div>
                    <div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="fullresto-summary">
                <div class="pull-left">
                    <?php echo $merchant->city; ?>
                </div>
                <div class="pull-left">
                    &nbsp;<?php echo $merchant->cuisine; ?>
                </div>
            </div>
            <div class="fullresto-nav" data-nav="left">
                <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
            </div>
            <div class="deals">
                <div class="deals-scroll">
                    <?php foreach($deals[$merchant->merchant_profile_id] as $deal) { ?>
                    <div class="deal">
                        <a href="<?php echo $url . '?deal=' . $deal[0]; ?>">
                            <?php echo $deal[1]; ?>
                            <div>
                                <?php echo $deal[3]; ?>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="fullresto-nav" data-nav="right">
                <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
            </div>
        </div>
        <?php if($merchant->num_bookings > 0) { ?>
        <div>
            <?php echo $merchant->num_bookings; ?> recent <?php echo ($merchant->num_bookings > 1 ? 'bookings' : 'booking'); ?>
        </div>
        <?php } ?>
    </div>
</div>