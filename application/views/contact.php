<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value' => set_value('email'),
	'placeholder' => 'Your Email Address'
);
$name = array(
	'name'	=> 'name',
	'id'	=> 'name',
	'value' => set_value('name'),
	'placeholder' => 'Your Name'
);
$message = array(
	'name'	=> 'message',
	'id'	=> 'message',
	'value' => set_value('message'),
	'placeholder' => 'What can we do for you?'
);
$captcha = array(
	'name'	=> 'image',
	'id'	=> 'image',
	'value' => set_value('image'),
	'placeholder' => 'Type the letters above'
);
?>
<div class="container basic-form">
    <div class="spacer-30"></div>
    <div class="contact-pane">
        <div class="row" data-in="<?php echo (isset($captcha_word) ? $captcha_word : ''); ?>">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                
                <?php if(isset($success_message) && $success_message != '') { ?>
                <div class="alert alert-success" role="alert"><?php echo $success_message; ?></div>
                <?php } else { ?>
                
                    <?php if(isset($error_message) && $error_message != '') { ?>
                    <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
                    <?php } ?>

                    <div class="well well-sm">
                        <div class="spacer-10"></div>
                        <?php echo form_open($this->uri->uri_string(), array('id' => 'frmfullresto', 'class' => 'form-horizontal')); ?>
                          <div class="form-group <?php $error = form_error('email'); echo ($error != '' ? 'has-error' : ''); ?>">
                            <label for="email" class="col-sm-4 control-label">Email Address</label>
                            <div class="col-sm-8">
                              <?php echo form_input($email, '', 'class="form-control"') . $error; ?>
                            </div>
                          </div>
                          <div class="form-group <?php $error = form_error('name'); echo ($error != '' ? 'has-error' : ''); ?>">
                            <label for="name" class="col-sm-4 control-label">Name</label>
                            <div class="col-sm-8">
                              <?php echo form_input($name, '', 'class="form-control"') . $error; ?>
                            </div>
                          </div>
                          <div class="form-group <?php $error = form_error('message'); echo ($error != '' ? 'has-error' : ''); ?>">
                            <label for="message" class="col-sm-4 control-label">Your Message</label>
                            <div class="col-sm-8">
                              <?php echo form_textarea($message, '', 'class="form-control"') . $error; ?>
                            </div>
                          </div>
                          <div class="form-group <?php $error = form_error('image'); echo ($error != '' ? 'has-error' : ''); ?>">
                            <label for="image" class="col-sm-4 control-label">Please type what you see on the image</label>
                            <div class="col-sm-8">
                                <div class="center-block text-center">
                                    <?php echo $captcha_image; ?>
                                </div>
                                <div class="spacer-10"></div>
                                <?php echo form_input($captcha, '', 'class="form-control"') . $error; ?>
                            </div>
                          </div>
                          <div class="spacer-10"></div>
                          <div class="form-group">
                            <div class="controls">
                              <?php echo form_button('submit', 'Send', 'class="contact-us btn btn-danger center-block"'); ?>
                            </div>
                          </div>
                        <?php echo form_close(); ?>
                        <div class="spacer-10"></div>
                    </div>
                    
                <?php } ?>

            </div>
            <div class="col-md-3"></div>

        </div>
    </div>
</div>
<script type="text/javascript">
$(function() {
    fullresto.setup.contact();
});
</script>