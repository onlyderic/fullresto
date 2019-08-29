<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    </div><!-- /.container -->
    
    <div class="container-fluid">
        <footer>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                        <div class="btn-group" role="group">
                            <a href="<?php echo site_url('about'); ?>" class="btn btn-link">About</a>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="<?php echo site_url('how'); ?>" class="btn btn-link">How To</a>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="<?php echo site_url('faq'); ?>" class="btn btn-link">FAQ</a>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="<?php echo site_url('contact'); ?>" class="btn btn-link">Contact</a>
                        </div>
                        <div class="btn-group fullresto-footer-register hidden" role="group">
                            <a href="<?php echo site_url('register'); ?>" class="btn btn-link">Register</a>
                        </div>
                        <div class="btn-group fullresto-footer-find hidden" role="group">
                            <a href="<?php echo site_url('search'); ?>" class="btn btn-link">Find</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </footer>
    </div>
    <div id="notify-wrapper"></div>

    <script src="<?php echo site_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo site_url(); ?>assets/js/bootbox.min.js"></script>
    <script src="<?php echo site_url(); ?>assets/js/fullresto.js"></script>

    <?php $this->load->view('modals', array()); ?>
</body>

</html>