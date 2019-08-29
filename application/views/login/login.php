<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$userlogin = array(
	'name'	=> 'userlogin',
	'id'	=> 'userlogin',
	'value' => set_value('userlogin'),
	'placeholder' => 'Email Address'
);
$userpass = array(
	'name'	=> 'userpass',
	'id'	=> 'userpass',
	'value' => set_value('userpass'),
	'placeholder' => 'Password'
);
$userremember = array(
	'name'	=> 'userremember',
	'id'	=> 'userremember',
	'value'	=> 1,
	'checked'	=> set_value('userremember')
);
?>
<div class="container basic-form">
    <div class="spacer-30"></div>
    <div class="login-pane">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php if(isset($error_message)) { ?>
                <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
                <?php } ?>
                <div class="well well-sm">
                    <div class="spacer-10"></div>
                    <div class="form-group">
                        <button class="btn btn-large fb-login center-block" type="button">
                            <img src="" class="facebook-pic hidden img-circle" /><span class="icon icon-facebook-f hidden"></span> Login with your Facebook account
                        </button>
                    </div>
                    <hr>
                    <?php echo form_open($this->uri->uri_string(), array('id' => 'frmfullresto', 'class' => 'form-horizontal')); ?>
                      <div class="form-group <?php $error = form_error('userlogin'); echo ($error != '' ? 'has-error' : ''); ?>">
                        <label for="userlogin" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                          <?php echo form_input($userlogin, '', 'class="form-control"') . $error; ?>
                        </div>
                      </div>
                      <div class="form-group <?php $error = form_error('userpass'); echo ($error != '' ? 'has-error' : ''); ?>">
                        <label for="userpass" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                          <?php echo form_password($userpass, '', 'class="form-control"') . $error; ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="userpass" class="col-sm-2 control-label">&nbsp;</label>
                        <div class="col-sm-10">
                            <?php echo form_checkbox($userremember); ?> Remember me
                        </div>
                      </div>
                      <div class="spacer-10"></div>
                      <div class="form-group">
                        <div class="controls">
                          <?php echo form_button('submit', 'Login', 'class="login btn btn-danger center-block"'); ?>
                        </div>
                      </div>
                      <input type="hidden" id="call_reference" name="call_reference" value="<?php echo (isset($call_reference) ? $call_reference : ''); ?>" />
                      <hr>
                      <div class="row">
                          <div class="col-md-5">
                              <a href="<?php echo site_url('login/forgot-password'); ?>">Forgot your password?</a>
                          </div>
                          <div class="col-md-7">
                              Don't have an account yet? <a href="<?php echo site_url('register'); ?>">Sign up here!</a>
                          </div>
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
    fullresto.setup.login();
});
</script>