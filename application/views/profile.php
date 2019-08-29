<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container manage-profile">
    <div class="page-header">
      <h1>Edit Profile</h1>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <form data-form="profile" class="form-horizontal">
                <div class="well">
                    <?php if(!empty($user_record->fb_id)) { ?>
                    <div class="form-group has-feedback">
                        <div class="col-sm-12">
                            <img src="<?php echo 'https://graph.facebook.com/' . $user_record->fb_id . '/picture'; ?>" class="center-block" />
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-group has-feedback firstname">
                        <label for="firstname" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="firstname" name="firstname" type="text" placeholder="First Name" value="<?php echo $user_record->first_name; ?>" />
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback lastname">
                        <label for="lastname" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="lastname" name="lastname" type="text" placeholder="Last Name" value="<?php echo $user_record->last_name; ?>" />
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback email">
                        <label for="email" class="col-sm-3 control-label">Email Address</label>
                        <div class="col-sm-9">
                            <input class="form-control is-email" id="email" name="email" type="text" placeholder="Email Address" value="<?php echo $user_record->email; ?>" />
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback phone">
                        <label for="phone" class="col-sm-3 control-label">Contact Number</label>
                        <div class="col-sm-9">
                            <input class="form-control is-number" id="phone" name="phone" type="text" placeholder="Contact Number" value="<?php echo $user_record->contact_number; ?>" />
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback address1">
                        <label for="address1" class="col-sm-3 control-label">Address</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="address1" name="address1" type="text" placeholder="Address" value="<?php echo $user_record->address1; ?>" />
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback address2">
                        <label for="address2" class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="address2" name="address2" type="text" placeholder="Address" value="<?php echo $user_record->address2; ?>" />
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback country">
                        <label for="city" class="col-sm-3 control-label">Country</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="country" name="country" placeholder="Country">
                                <option value=""></option>
                                <?php foreach($countries as $code => $name) { ?>
                                <option value="<?php echo $code; ?>" <?php echo ($user_record->country == $code ? 'selected="selected"' : ''); ?> ><?php echo $name; ?></option>
                                <?php } ?>
                            </select>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback city">
                        <label for="city" class="col-sm-3 control-label">City</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="city" name="city" placeholder="City">
                                <option value=""></option>
                                <?php
                                $has_city = FALSE;
                                foreach($cities as $city) {
                                    $has_city = ($user_record->city == $city || $has_city);
                                ?>
                                <option value="<?php echo $city; ?>" <?php echo ($user_record->city == $city ? 'selected="selected"' : ''); ?> ><?php echo $city; ?></option>
                                <?php } ?>
                                <option value="OTHER" <?php echo (!empty($user_record->city) && !$has_city ? 'selected="selected"' : ''); ?>>Other city</option>
                            </select>
                            <input type="text" class="form-control <?php if($has_city || empty($user_record->city)) { ?>hidden<?php } ?>" id="othercity" name="othercity" placeholder="City" value="<?php echo $user_record->city; ?>">
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                </div>
                <div class="well">
                    <div class="form-group has-feedback password">
                        <label for="password" class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="password" name="password" type="password" placeholder="Password" value="" />
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback password2">
                        <label for="password2" class="col-sm-3 control-label">Confirm Password</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="password2" name="password2" type="password" placeholder="Confirm Password" value="" />
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                </div>
                <div class="well">
                    <div class="form-group has-feedback facebook">
                        <label for="facebook" class="col-sm-3 control-label">Facebook</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="facebook" name="facebook" type="text" placeholder="Link to your Facebook" value="<?php echo $user_record->url_facebook; ?>" />
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback twitter">
                        <label for="twitter" class="col-sm-3 control-label">Twitter</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="twitter" name="twitter" type="text" placeholder="Link to your Twitter" value="<?php echo $user_record->url_twitter; ?>" />
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                </div>
                <button data-btn="save-profile" class="btn btn-success center-block" type="button">Update Profile</button> 
            </form>
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