<form class="form-horizontal" role="form">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Recently viewed merchants...</h3>
        </div>
        <div class="panel-form">
            <div class="panel-body">
            	<ul class="media-list">
                    <?php
                        if(!empty($recentviews)){
                            foreach($recentviews as $merchant){
                                $url = set_url(URL_MERCHANT, $merchant->city, '', $merchant->display_name, $merchant->merchant_profile_id);
                                $url_pic = site_url().'images/' . url_title($merchant->merchant_profile_id) . '/' . $merchant->display_pic;
                                $rating = $merchant->rating ? ' rate-' . $merchant->rating : '';
                                $price_rating = $merchant->price_rating ? ' price-rate-' . $merchant->price_rating : '';
                                $num_rating = $merchant->num_rating ? 'Rated by ' . $merchant->num_rating . ' customers' : '';
                    
                                echo "<li class='media'>
                						<div class='media-left'>
                							<a href='".$url."'><img width='100px' class='media-object img-thumbnail' alt='".$merchant->display_name."' src='".$url_pic."'></a>
                						</div>
                						<div class='media-body'>
                							<a href='".$url."'>
                                                <h4 class='media-heading'>".$merchant->display_name."</h4>
                                            </a>
                							<div data-id='".$merchant->merchant_profile_id."' class='text-right perx-item".$rating . $price_rating."'>
                                                <div class='fullresto-detail recent'>
                                                    <div class='ratings' title='".$num_rating."'>
                                                        <div>
                                                            <div></div>
                                                        </div>
                                                        <div>
                                                            <div></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                						</div>
                						<hr/>
                					</li>";
                            }
                        } else {
                            echo "<li class='media'>
                						<div class='media-body'>
                							No recently viewed merchants.
                						</div>
                						<hr/>
                					</li>";
                        }
                    ?>
				</ul>
            </div>
        </div>
    </div>
</form>