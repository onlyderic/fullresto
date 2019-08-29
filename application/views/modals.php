<div class="modal fade" id="booking-login-modal" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Please login</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="alert alert-danger hidden login-message" role="alert"></div>
                        <div class="spacer-10"></div>
                        <form action="#" id="frmfullresto" class="form-horizontal" method="post" accept-charset="utf-8">
                            <div class="form-group">
                                <label for="userlogin" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" name="userlogin" value="" id="userlogin" placeholder="Email Address" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="userpass" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" name="userpass" value="" id="userpass" placeholder="Password" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="userpass" class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" name="userremember" value="1" id="userremember"> Remember me
                                </div>
                            </div>
                            <div class="spacer-10"></div>
                            <div class="form-group">
                                <div class="controls">
                                    <button id="login" type="button" class="login btn btn-danger center-block">Login</button>
                                </div>
                            </div>
                        </form>
                        <div class="spacer-10"></div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="booking-detail" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Booking Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9"><h2 class="booking-code"></h2></div>
                    <div class="col-md-3 text-center fullresto-qrcode">
                        <?php #<span class="glyphicon glyphicon-qrcode center-block"></span> ?>
                    </div>
                </div>
                <table class="table table-condensed table-striped booking-table"></table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="booking-rating" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rate your experience</h4>
            </div>
            <div class="modal-body">
                <div class="text-center processing">
                    Loading...
                </div>
                <div id="booking-rating" class="hidden">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>How do you feel about the restaurant and the offered discounts?</h6>
                            <div class="btn-group btn-block" data-toggle="buttons">
                                <label class="btn btn-default btn-block">
                                    <input type="radio" name="rate1" autocomplete="off" value="1"> Unsatisfied
                                </label>
                                <label class="btn btn-default btn-block">
                                    <input type="radio" name="rate1" autocomplete="off" value="2"> Less satisfied
                                </label>
                                <label class="btn btn-default btn-block">
                                    <input type="radio" name="rate1" autocomplete="off" value="3"> Normal
                                </label>
                                <label class="btn btn-default btn-block">
                                    <input type="radio" name="rate1" autocomplete="off" value="4"> Satisfied
                                </label>
                                <label class="btn btn-default btn-block">
                                    <input type="radio" name="rate1" autocomplete="off" value="5"> Very satisfied
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>What do you think about the prices of the items in the restaurant?</h6>
                            <div class="btn-group btn-block" data-toggle="buttons">
                                <label class="btn btn-default btn-block">
                                    <input type="radio" name="rate2" autocomplete="off" value="1"> Unsatisfied
                                </label>
                                <label class="btn btn-default btn-block">
                                    <input type="radio" name="rate2" autocomplete="off" value="2"> Less satisfied
                                </label>
                                <label class="btn btn-default btn-block">
                                    <input type="radio" name="rate2" autocomplete="off" value="3"> Normal
                                </label>
                                <label class="btn btn-default btn-block">
                                    <input type="radio" name="rate2" autocomplete="off" value="4"> Satisfied
                                </label>
                                <label class="btn btn-default btn-block">
                                    <input type="radio" name="rate2" autocomplete="off" value="5"> Very satisfied
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-mod="rating-submit">Submit ratings</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-mod="no" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" data-mod="yes">Yes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="merchant-map" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <script type="text/javascript">
                    var centreGot = false;
                </script>
                <?php if(isset($map)) { 
                    echo $map['html']; 
                    echo $map['js']; 
                } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>