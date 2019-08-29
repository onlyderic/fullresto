<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<li>
    <a href="<?php echo site_url('search'); ?>"><span class="icon icon-search"></span></a>
</li>
<?php if($logged_in) { ?>
<li>
    <a href="<?php echo site_url('bookings'); ?>">My Bookings</a>
</li>
<li>
    <a href="<?php echo site_url('profile'); ?>">Profile</a>
</li>
<li>
    <a href="<?php echo site_url('logout'); ?>">Logout</a>
</li>
<?php } else { ?>
<li>
    <a href="<?php echo site_url('register'); ?>">Register</a>
</li>
<li>
    <a href="<?php echo site_url('login'); ?>">Login</a>
</li>
<?php } ?>