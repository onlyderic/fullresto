<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
<div class="row">
    <div class="col-lg-12 fullresto-banner">
        <form method="get" id="frmmain" action="<?php echo base_url(); ?>search">
	        <div class="fullresto-search-quick">
                <h1 class="fullresto-tagline">The best discounts are in the off peak hours!</h1>
                <div>
                    <input name="keyword" id="keyword" class="form-control input-lg" type="text" data-mod="search" placeholder="Find your favorite restaurant!">
                    <span class="icon icon-search"></span>
                </div>
	        </div>
		</form>
    </div>
</div>

<div class="fullresto-access row">
    <div class="btn-group btn-group-justified" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default no-border no-focus btn-quick-search" value="new">New</button>
            <div class="fullresto-arrow"></div>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default no-border no-focus btn-danger active btn-quick-search" value="nearby">Nearby</button>
            <div class="fullresto-arrow"></div>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default no-border no-focus btn-quick-search" value="popular">Popular</button>
            <div class="fullresto-arrow"></div>
        </div>
    </div>
</div>

<div class="container">
    <div id="merchantlist" class="row">
        <?php echo $list; ?>
    </div>
</div>

</div><?php //This is the closing of the .container-fluid from header ?>

<div class="container-fluid fullresto-jumbotron">
    <div class="row">
        <div class="col-xs-6 col-md-3">
            <div class="fullresto-perks">
                <img src="assets/images/get-discounts.jpg" alt="Get discounts" class="img-thumbnail img-circle" />
                <div>Get your discounts when you eat at your favorite restaurant!</div>
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="fullresto-perks">
                <img src="assets/images/free.jpg" alt="Free!" class="img-thumbnail img-circle" />
                <div>No hidden costs. Just book and you're good to go!</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="fullresto-register hidden">
                <form action="<?php echo site_url('register/now'); ?>" id="frmfullresto" class="form-horizontal" method="post" accept-charset="utf-8">
                    <h4>Create an account now. Enjoy the discounts!</h4>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <button type="submit" class="register btn btn-danger">Register</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="fullresto-book-now fullresto-jumbotron-howto hidden">
                <div class="spacer-20"></div>
                <h3 class="text-center">Book now in 3 simple steps!</h3>
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
        </div>
    </div>
</div>
<div class="container-fluid">
    &nbsp;
</div>

<div id="google_canvas"></div>

<div class="container-fluid"><?php //And, let's add another container-fluid so that it will pair with the closing tag in the footer ?>