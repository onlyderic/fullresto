<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$merchant_name = $merchant_profile->display_name;

$merchant_address1 = $merchant_profile->address1;
if($merchant_profile->address2 != ""){
	$merchant_address1 .= ", ".$merchant_profile->address2;
}
$merchant_address1 = trim($merchant_address1);
$merchant_address2 = $merchant_profile->city;

$merchant_address = $merchant_address1 . (!empty($merchant_address2) ? ' ' : '') . $merchant_address2;
if(trim($merchant_address2) != '') {
    $merchant_address2 = "<div><span class='glyphicon glyphicon-map-marker' aria-hidden='true'></span>&nbsp; ".$merchant_address."</div>";
}

$merchant_contactnumber = $merchant_profile->contact_number1;
if($merchant_profile->contact_number2 != ""){
	$merchant_contactnumber .= ", ".$merchant_profile->contact_number2;
}
if(trim($merchant_contactnumber) != '') {
    $merchant_contactnumber = "<div><span class='glyphicon glyphicon-earphone' aria-hidden='true'></span>&nbsp; ".$merchant_contactnumber."</div>";
}

$merchant_website = "";
if($merchant_profile->url_website != ""){
	$merchant_website = "<a target='_blank' href='http://".$merchant_profile->url_website."'>".$merchant_profile->url_website."</a>";
	$merchant_website = "<div><span class='glyphicon glyphicon-globe' aria-hidden='true'></span>&nbsp; ".$merchant_website."</div>";
}

$merchant_email = "";
if($merchant_profile->email != ""){
	$merchant_email = "<a href='mailto:".$merchant_profile->email."'>".$merchant_profile->email."</a>";	
	$merchant_email = "<abbr title='Email'><span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>&nbsp;</abbr> ".$merchant_email."<br/>";
}

$merchant_facebook = "";
if($merchant_profile->url_facebook != ""){
	$merchant_facebook = "<a target='_blank' title='Share on Facebook' href='".$merchant_profile->url_facebook."'><span class='icon icon-facebook'></span></a>";
}

$merchant_twitter = "";
if($merchant_profile->url_twitter != ""){
	$merchant_twitter = "<a target='_blank' title='Share on Twitter' href='".$merchant_profile->url_twitter."'><span class='icon icon-twitter'></span></a>";
}

$merchant_description = $merchant_profile->description;
$rating = $merchant_profile->rating ? ' rate-' . $merchant_profile->rating : '';
$price_rating = $merchant_profile->price_rating ? ' price-rate-' . $merchant_profile->price_rating : '';
$num_rating = $merchant_profile->num_rating ? 'Rated by ' . $merchant_profile->num_rating . ' customers' : '';

$url = set_url(URL_MERCHANT, $merchant_profile->city, '', $merchant_profile->display_name, $merchant_profile->merchant_profile_id);

$store_type = $merchant_profile->store_type;
$cuisine = $merchant_profile->cuisine;
$has_attributes = ($store_type || $cuisine);
?>
<div class="container fullresto-detail">
    <div class="row">
        <div class="col-md-12">
            <h1>
                <?php echo $merchant_name; ?>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div>
                    <div class="carousel slide" id="merchant_images">
                        <?php
                            $indicators = $items = "";
                            $class = "active";
                            $images = explode(',', $merchant_profile->images);
                            foreach($images as $key => $image_num) {
                                $indicators .= "<li class='".$class."' data-slide-to='".$image_num."' data-target='#merchant_images'></li>";
                                //TODO: Recommend an ideal height for pictures: about 350px
                                $items .= "<div class='item ".$class."'><img alt='' src='".site_url()."images/".$merchant_profile->merchant_profile_id."/p/".$image_num.".jpg' /></div>";
                                $class = "";
                            }
                        ?>
                        <ol class="carousel-indicators">
                            <?php echo $indicators; ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php echo $items; ?>
                        </div> 
                        <a class="left carousel-control" href="#merchant_images" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                        <a class="right carousel-control" href="#merchant_images" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                        
                    <div class="panel-body">
                        <div>
                            <div>
                                <h2>
                                    <?php echo $merchant_name; ?>
                                </h2>

                                <div class="fullresto-location">
                                    <?php echo $merchant_address; ?>&nbsp;<a id="btnmap" href="#merchant-map" data-toggle="modal">View on map</a>
                                </div>
                            </div>
                            <div class="text-right fullresto-rating <?php echo $rating . $price_rating; ?>" data-id="<?php echo $merchant_profile->merchant_profile_id; ?>">
                                <div class="ratings" title="<?php echo $num_rating; ?>">
                                    <div>
                                        <div></div>
                                    </div>
                                    <div>
                                        <div></div>
                                    </div>
                                    <button type="button" data-mod="favorite" class="btn btn-link btn-block no-border">
                                        <span class="glyphicon glyphicon-heart"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tabbable">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#detail" data-toggle="tab">Detail</a>
                                </li>
                                <li>
                                    <a href="#menu" data-toggle="tab">Recommended Menu</a><?php //TODO: Change label for non-F&B merchants ?>
                                </li>
                                <li>
                                    <a href="#reviews" data-toggle="tab">Reviews</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="spacer-20"></div>
                                <div class="tab-pane active" id="detail">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <address>
                                                <?php echo $merchant_address2; ?>
                                                <?php echo $merchant_contactnumber; ?>
                                                <?php echo $merchant_website; ?>
                                            </address>
                                        </div>
                                        <div class="col-md-4" style='text-align:right;'>
                                            <div>
                                                <?php echo $merchant_facebook; ?>
                                                <?php echo $merchant_twitter; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($has_attributes) { ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-condensed">
                                                <?php if(!empty($store_type)) { ?>
                                                <tr>
                                                    <th>Type:</th>
                                                    <td><?php echo $store_type; ?></td>
                                                </tr>
                                                <?php } ?>
                                                <?php if(!empty($cuisine)) { ?>
                                                <tr>
                                                    <th>Cuisine:</th>
                                                    <td><?php echo $cuisine; ?></td>
                                                </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                    <?php } ?>
                                    <p class="text-justify">
                                        <?php echo $merchant_description; ?>
                                    </p>
                                </div>
                                <div class="tab-pane" id="menu">
                                    <p class="text-muted text-right">Prices may change. Discounted prices are only estimates based on the selected deal.</p>
                                    <table class="table table-hover table-condensed">
                                        <?php 
                                        $curr_category = $prev_category = '';
                                        foreach($merchant_services as $serviceitem) {
                                            $curr_category = $serviceitem->category_name;
                                            $discounted_price = number_format($serviceitem->price * (1 - ($booking_record->deal_discount_rate/100)), 2);
                                        ?>
                                        <?php if($curr_category != $prev_category) { ?>
                                            <?php if($prev_category != '') { ?>
                                            <tr>
                                                <td colspan="3">&nbsp;</td>
                                            </tr>
                                            <?php } ?>
                                            <tr class="warning">
                                                <th colspan="3"><?php echo $curr_category; ?></th>
                                            </tr>
                                            <tr>
                                                <th>Dish</th>
                                                <th class="text-right">Price</th>
                                                <th class="text-right">Discounted<span class="discounted"></span></th>
                                            </tr>
                                        <?php } ?>
                                            <tr>
                                                <td><?php echo $serviceitem->label; ?></td>
                                                <td class="text-right"><?php echo $currency . number_format($serviceitem->price, 2); ?></td>
                                                <td class="text-right"><?php echo $currency; ?><span class="regular-price text-muted" style="text-decoration:line-through;"><?php echo $serviceitem->price; ?></span> <span class="discounted-price text-danger"><?php echo $discounted_price; ?></span></td>
                                            </tr>
                                        <?php
                                            $prev_category = $curr_category;
                                        }
                                        ?>
                                    </table>
                                </div>
                                <div class="tab-pane" id="reviews">
                                    <input type="hidden" name="disqus_shortname" value="fullresto" /><?php #required: replace example with your forum shortname ?>
                                    <input type="hidden" name="disqus_identifier" value="<?php echo $merchant_profile->merchant_profile_id; ?>" /><?php #'a unique identifier for each page where Disqus is present'; ?>
                                    <input type="hidden" name="disqus_title" value="<?php echo $merchant_profile->display_name; ?>" /><?php #'a unique title for each page where Disqus is present'; ?>
                                    <input type="hidden" name="disqus_url" value="<?php echo $url; ?>" /><?php #'a unique URL for each page where Disqus is present'; ?>
                                    <div id="disqus_thread"></div>
                                    <script type="text/javascript">
                                        <?php #CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE ?>
                                        var disqus_shortname = $('[name=disqus_shortname]').val();
                                        var disqus_identifier = $('[name=disqus_identifier]').val(); 
                                        var disqus_title = $('[name=disqus_title]').val(); 
                                        var disqus_url = $('[name=disqus_url]').val();

                                        <?php # DON'T EDIT BELOW THIS LINE  ?>
                                        (function() {
                                            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                                            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                                        })();
                                    </script>
                                    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                                    <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
                                </div>
                                <div class="spacer-20"></div>
                            </div>
                        </div>
                    </div>
                        
                </div>
            </div>
        </div>
        <div class="col-md-4">		
            <?php $this->load->view('bookingdetailpanel', array()); ?>  
        </div>
    </div>
</div>

</div><?php //This is the closing of the .container-fluid from header ?>

<div class="container-fluid fullresto-jumbotron fullresto-jumbotron-howto">
    <?php //TODO: Change content ?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div>Book now in 3 simple steps!</div>
            <div class="row">
                <div class="col-md-4">
                    <div class="thumbnail center-block">
                        <span class="icon icon-form"></span>
                        <div>Fill out booking form</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thumbnail center-block">
                        <span class="icon icon-mobile"></span>
                        <div>Receive confirmation email and SMS</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thumbnail center-block">
                        <span class="icon icon-gift"></span>
                        <div>Claim the discount at the restaurant</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

<div class="container-fluid hidden"><?php //And, let's add another container-fluid so that it will pair with the closing tag in the footer ?>