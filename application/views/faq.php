<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container how-to">
    <div class="spacer-30"></div>
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>How may we help you?</h1>
        </div>
    </div>
    <div class="spacer-30"></div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            <?php
            $faqs_registration = array(
                "What are the needed information?" => "You just need to provide your name, email address and your chosen password for your fullresto.com account. You can also use your Facebook account to automatically register with us.",
                "Are there any fees?" => "Absolutely no fees!"
            );
            $faqs_booking = array(
                "Do I need to pay in order to book?" => "No. The use of our booking system is for free.",
                "Are there any hidden charges when I book a restaurant?" => "No. Don't worry, we are not even collecting any credit card information.",
                "What do I need to pay?" => "You pay to the restaurant the price of your orders minus the discount indicated on your booked deal.",
                "How do I book a restaurant?" => "First, choose a restaurant and go to its detail page on fullresto.com. On the right hand side, you'll find the booking panel.<br/><br/>Fill in the information being asked. Choose the discount and the time you want.<br/><br/>You can only book a deal when it's still at least 4 hours before the time.<br/><br/>Confirm the information and submit!",
                "I booked a restaurant. Now what?" => "After successful booking, you will receive an email that confirms the booking with the details you have provided together with the restaurant's name and addrses, the discount, and the date and time of your booking.<br/><br/>If the restaurant has availed of our SMS confirmation facility, you would also be able to receive an SMS informing you about the successful booking.",
                "What do I need to show to the restaurant on the date and time of my booking?" => "You only need to show the email or SMS confirmation, and then your valid identification just in case the restaurant requires it.<br/><br/>You can always access your booking details from your fullresto.com account.",
                "Can I cancel the booking I made? How?" => "Yes, you can cancel your booking at least 1 hour before the schedule.<br/><br/>Access your 'My Bookings' and look for the booking record. It will have a 'Cancel Booking' option if it's still valid for cancellation.",
                "How many times can I make a booking?" => "You are allowed to make at most 3 bookings, which should also be 4 hours apart."
            );
            $faqs_rating = array(
                "How can I give a rating to a restaurant?" => "You can only give after consuming the booking. The restaurant will confirm that you've made it to their restaurant as booked.<br/><br/>To give a rating, go to your 'My Bookings', find the booking record and select 'Ratings & Review'.",
                "Why do I need to give a rating?" => "Your ratings and reviews can help improve the restaurants' services"
            );
            ?>
            
            <h2>Registration</h2>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php
                $faqs = 1;
                $ctr = 1;
                foreach($faqs_registration as $q => $a) {
                    $heading = 'heading' . $faqs . '_' . $ctr;
                    $collapse = 'collapse' . $faqs . '_' . $ctr++;
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="<?php echo $heading; ?>">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion<?php echo $faqs; ?>" href="#<?php echo $collapse; ?>" aria-expanded="true" aria-controls="<?php echo $collapse; ?>">
                                <?php echo $q; ?>
                            </a>
                        </h4>
                    </div>
                    <div id="<?php echo $collapse; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php echo $heading; ?>">
                        <div class="panel-body">
                            <?php echo $a; ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            
            <div class="spacer-10"></div>
            
            <h2>Booking</h2>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php
                $faqs = 2;
                $ctr = 1;
                foreach($faqs_booking as $q => $a) {
                    $heading = 'heading' . $faqs . '_' . $ctr;
                    $collapse = 'collapse' . $faqs . '_' . $ctr++;
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="<?php echo $heading; ?>">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion<?php echo $faqs; ?>" href="#<?php echo $collapse; ?>" aria-expanded="true" aria-controls="<?php echo $collapse; ?>">
                                <?php echo $q; ?>
                            </a>
                        </h4>
                    </div>
                    <div id="<?php echo $collapse; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php echo $heading; ?>">
                        <div class="panel-body">
                            <?php echo $a; ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            
            <div class="spacer-10"></div>
            
            <h2>Rating</h2>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php
                $faqs = 3;
                $ctr = 1;
                foreach($faqs_rating as $q => $a) {
                    $heading = 'heading' . $faqs . '_' . $ctr;
                    $collapse = 'collapse' . $faqs . '_' . $ctr++;
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="<?php echo $heading; ?>">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion<?php echo $faqs; ?>" href="#<?php echo $collapse; ?>" aria-expanded="true" aria-controls="<?php echo $collapse; ?>">
                                <?php echo $q; ?>
                            </a>
                        </h4>
                    </div>
                    <div id="<?php echo $collapse; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php echo $heading; ?>">
                        <div class="panel-body">
                            <?php echo $a; ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            
        </div>
    </div>
</div>