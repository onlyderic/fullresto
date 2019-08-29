<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$recommended = "btn-default";
$name = "btn-default";
$pricerating = "btn-default";
$pricerating_affordable = "";
$pricerating_expensive = "";
$starrating = "btn-default";
$starrating_low = "";
$starrating_high = "";

switch($searchsort){
	case "recommended":
		$recommended = "btn-danger active";
		break;
	case "name":
		$name = "btn-danger active";
		break;
	case "affordable":
		$pricerating = "btn-danger active";
		$pricerating_affordable = "list-group-item-danger";
		break;
	case "expensive":
		$pricerating = "btn-danger active";
		$pricerating_expensive = "list-group-item-danger";
		break;
	case "low":
		$starrating = "btn-danger active";
		$starrating_low = "list-group-item-danger";
		break;
	case "high":
		$starrating = "btn-danger active";
		$starrating_high = "list-group-item-danger";
		break;
}

?>
<link href="<?php echo site_url(); ?>assets/css/jquery-ui.min.css" rel="stylesheet">
<script src="<?php echo site_url(); ?>assets/js/jquery-ui.min.js"></script>
<div class="row">
    <div class="col-lg-12 fullresto-search">
        <div class="center-block">
            <form method="GET" id="frmmain" action="<?php echo site_url('search'); ?>">
                <div>
                    <div class="pull-left">
                        Find a restaurant that matches your need:
                    </div>
                    <div class="pull-right text-muted text-right">
                        You may also locate restaurants on the <a href="#merchant-map" data-toggle="modal"><span class="glyphicon glyphicon-map-marker"></span> Map</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="form-group col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="icon icon-calendar-o"></span>
                            </span>
                            <input type="text" id="bookingdate" name="bookingdate" class="form-control" value="<?php echo $bookingdate; ?>" placeholder="When?" />
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="icon icon-users"></span>
                            </span>
                            <select id="bookingpax" name="bookingpax" class="form-control" placeholder="How many people?">
                                <option value="">How many people?</option>
                                <?php 
                                    for($ctr = 1; $ctr <= 20; $ctr++) { 
                                        $selected = "";
                                        if($ctr == $bookingpax) {
                                            $selected = " selected='selected'";
                                        }
                                ?>
                                <option value="<?php echo $ctr; ?>" <?php echo $selected; ?>><?php echo $ctr; ?> pax</option>
                                <?php 
                                    } 
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="icon icon-map-marker"></span>
                            </span>
                            <select id="bookingcity" name="bookingcity" class="form-control" placeholder="Which city?">
                                <option value="">Which city?</option>
                                <?php
                                	if(!empty($cities)){
										foreach($cities as $city){
											$selectedcity = "";
	                                        if($city->city == $bookingcity) {
	                                            $selectedcity = " selected='selected'";
	                                        }
											
											echo "<option value='".$city->city."' ".$selectedcity.">".$city->city."</option>";
										}
									}
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" id="keyword" name="keyword" class="form-control" data-mod="search" value="<?php echo $keyword; ?>" placeholder="Type restaurant's name" />
                    </div>
                    <div class="form-group col-md-1">
                        <button type="submit" class="btn btn-success btn-block" id="btnsearch">Search &raquo;</button>
                    </div>
                </div>
                <input type="hidden" id="sortby" name="sortby" value="<?php echo $searchsort; ?>" />
            </form>
        </div>
    </div>
</div>

<div class="fullresto-access row">
    <div class="btn-group btn-group-justified" role="group" aria-label="...">
        <div class="btn-group fullresto-sort-label" role="group">
            Sort by:
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn <?php echo $recommended; ?> no-border no-focus btn-search-sort" value="recommended">FullResto Recommended</button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn <?php echo $name; ?> no-border no-focus btn-search-sort" value="name">Restaurant Name</button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn <?php echo $pricerating; ?> no-border no-focus dropdown-toggle btn-search-sort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Price Rating <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li class="btn-search-sort <?php echo $pricerating_expensive; ?>" value="affordable"><a href="#">Premium (1 to 5)</a></li>
                <li class="btn-search-sort <?php echo $pricerating_affordable; ?>" value="expensive"><a href="#">Affordable (5 to 1)</a></li>
            </ul>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn <?php echo $starrating; ?> no-border no-focus dropdown-toggle btn-search-sort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Stars Rating <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li class="btn-search-sort <?php echo $starrating_low; ?>" value="low"><a href="#">Less popular (1 to 5)</a></li>
                <li class="btn-search-sort <?php echo $starrating_high; ?>" value="high"><a href="#">Most popular (5 to 1)</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="container">
    <div id="merchantlist" class="row">
        <?php echo $list; ?>
    </div>
</div>

</div><?php //This is the closing of the .container-fluid from header ?>

<div id="google_canvas"></div>

<div class="container-fluid"><?php //And, let's add another container-fluid so that it will pair with the closing tag in the footer ?>