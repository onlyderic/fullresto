<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$userpass = array(
	'name'	=> 'userpass',
	'id'	=> 'userpass',
	'value' => set_value('userpass'),
	'placeholder' => 'Password'
);
$usercpass = array(
	'name'	=> 'usercpass',
	'id'	=> 'usercpass',
	'value' => set_value('usercpass'),
	'placeholder' => 'Confirm Password'
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
                    
                    <?php echo form_open($this->uri->uri_string(), array('id' => 'frmfullresto', 'class' => 'form-horizontal')); ?>
                        <div class="form-group <?php $error = form_error('userpass'); echo ($error != '' ? 'has-error' : ''); ?>">
                          <label for="userpass" class="col-sm-4 control-label">Password</label>
                          <div class="col-sm-8">
                              <?php echo form_password($userpass, '', 'class="form-control"') . $error; ?>
                          </div>
                        </div>
                        <div class="form-group <?php $error = form_error('usercpass'); echo ($error != '' ? 'has-error' : ''); ?>">
                          <label for="usercpass" class="col-sm-4 control-label">Confirm Password</label>
                          <div class="col-sm-8">
                              <?php echo form_password($usercpass, '', 'class="form-control"') . $error; ?>
                          </div>
                        </div>
                        <div class="spacer-10"></div>
                        <div class="form-group">
                          <div class="controls">
                            <?php echo form_submit('submit', 'Reset password', 'class="reset-password btn btn-danger center-block"'); ?>
                          </div>
                        </div>
                        <input type="hidden" id="call_reference" name="call_reference" value="<?php echo (isset($call_reference) ? $call_reference : ''); ?>" />
                        <hr>
                        <div class="text-center">
                          <a href="<?php echo site_url('register'); ?>">Register</a> or <a href="<?php echo site_url('login'); ?>">Login</a>
                        </div>
                    <?php echo form_close(); ?>
                    <div class="spacer-10"></div>
                </div>

            </div>
            <div class="col-md-3"></div>

        </div>
    </div>
</div>