<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value' => set_value('email'),
	'placeholder' => 'Email Address'
);
$first_name = array(
	'name'	=> 'firstname',
	'id'	=> 'firstname',
	'value' => set_value('firstname'),
	'placeholder' => 'First Name'
);
$last_name = array(
	'name'	=> 'lastname',
	'id'	=> 'lastname',
	'value' => set_value('lastname'),
	'placeholder' => 'Last Name'
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'placeholder' => 'Password'
);
$confirm_password = array(
	'name'	=> 'confirmpassword',
	'id'	=> 'confirmpassword',
	'placeholder' => 'Confirm Password'
);
?>
<div class="container basic-form">
    <div class="spacer-30"></div>
    <div class="register-pane">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php if(isset($error_message) && $error_message != '') { ?>
                <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
                <?php } ?>
                <div class="well well-sm">
                    <div class="spacer-10"></div>
                    <div class="form-group">
                        <button class="btn btn-large fb-register center-block" type="button">
                            <img src="" class="facebook-pic hidden img-circle" /><span class="icon icon-facebook-f hidden"></span> Register with your Facebook account
                        </button>
                    </div>
                    <hr>
                    <?php echo form_open($this->uri->uri_string(), array('id' => 'frmfullresto', 'class' => 'form-horizontal')); ?>
                      <div class="form-group <?php $error = form_error('email'); echo ($error != '' ? 'has-error' : ''); ?>">
                        <label for="email" class="col-sm-4 control-label">Email Address</label>
                        <div class="col-sm-8">
                          <?php echo form_input($email, '', 'class="form-control"') . $error; ?>
                        </div>
                      </div>
                      <div class="form-group <?php $error = form_error('firstname'); echo ($error != '' ? 'has-error' : ''); ?>">
                        <label for="firstname" class="col-sm-4 control-label">First Name</label>
                        <div class="col-sm-8">
                          <?php echo form_input($first_name, '', 'class="form-control"') . $error; ?>
                        </div>
                      </div>
                      <div class="form-group <?php $error = form_error('lastname'); echo ($error != '' ? 'has-error' : ''); ?>">
                        <label for="lastname" class="col-sm-4 control-label">Last Name</label>
                        <div class="col-sm-8">
                          <?php echo form_input($last_name, '', 'class="form-control"') . $error; ?>
                        </div>
                      </div>
                      <div class="form-group <?php $error = form_error('password'); echo ($error != '' ? 'has-error' : ''); ?>">
                        <label for="password" class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-8">
                          <?php echo form_password($password, '', 'class="form-control"') . $error; ?>
                        </div>
                      </div>
                      <div class="form-group <?php $error = form_error('confirmpassword'); echo ($error != '' ? 'has-error' : ''); ?>">
                        <label for="confirmpassword" class="col-sm-4 control-label">Confirm Password</label>
                        <div class="col-sm-8">
                          <?php echo form_password($confirm_password, '', 'class="form-control"') . $error; ?>
                        </div>
                      </div>
                      <div class="text-center">
                          <small>By registering, you agree to the terms and conditions of fullresto.com</small>
                      </div>
                      <div class="spacer-10"></div>
                      <div class="form-group">
                        <div class="controls">
                          <?php echo form_button('submit', 'Register', 'class="register btn btn-danger center-block"'); ?>
                        </div>
                      </div>
                      <input type="hidden" id="call_reference" name="call_reference" value="<?php echo (isset($call_reference) ? $call_reference : ''); ?>" />
                      <hr>
                      <div class="text-center">
                        Got a fullresto account? <a href="<?php echo site_url('login'); ?>">Login here!</a>
                      </div>
                    <?php echo form_close(); ?>
                    <div class="spacer-10"></div>
                </div>
                  
            </div>
            <div class="col-md-3"></div>

        </div>
    </div>
</div>
<script type="text/javascript">
$(function() {
    fullresto.setup.register();
});
</script>