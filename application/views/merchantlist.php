<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$arrmerchants = array();
if(!empty($codes)) {
	$arrmerchants = explode(",", $codes);
}

foreach($merchants as $key => $merchant) {
    $this->load->view('merchantlistitem', array('merchant' => $merchant, 'deals' => $deals));
    array_push($arrmerchants, "'".$merchant->merchant_profile_id."'");
}
?>

<input type="hidden" id="codes" name="codes" value="<?php echo implode(",", $arrmerchants); ?>" />
<input type="hidden" id="searchtype" name="searchtype" value="<?php echo $searchtype; ?>" />
<input type="hidden" id="searchsort" name="searchsort" value="<?php echo $searchsort; ?>" />
<input type="hidden" id="city" name="city" value="<?php echo $city; ?>" />
<input type="hidden" id="locationlat" name="locationlat" value="<?php echo $locationlat; ?>" />
<input type="hidden" id="locationlong" name="locationlong" value="<?php echo $locationlong; ?>" />

<div class="clearfix loadmore-clear"></div>
<div class="col-md-12 text-center loadmore">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <button id="btnloadmore" type="button" class="btn btn-default btn-block" data-loading-text="Loading...">Load more</button>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>