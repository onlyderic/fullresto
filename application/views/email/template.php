<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <style>
    body {
      margin: 0;
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      font-size: 14px;
      line-height: 20px;
      color: #333333;
      background-color: #ECEEF2;
    }
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      margin: 0;
      font-family: inherit;
      font-weight: bold;
      line-height: 20px;
      color: inherit;
      text-rendering: optimizelegibility;
    }
    </style>
</head>
<body>
    
    <table border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" width="100%">
        <tr>
            <td width="100%" align="center" style="background-color:#ECEEF2;">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                <table border="0" cellspacing="0" cellpadding="0" width="600">
                    <tr>
                        <td width="100%" align="left" style="background-color:#424242;padding:20px 10px;">
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="padding:0px;margin:0px;"><h2 style="color:#FF6600;padding:0px;margin:0px;">fullresto.com</h2></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" align="center" style="background-color:#999999;height:5px;"></td>
                    </tr>
                    <tr>
                        <td width="100%" style="background-color:#FFFFFF;padding:10px;">

    <?php if($mode == 'register') { ?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td><h3 align="center">Welcome to fullresto.com<?php echo empty($toname) ? '' : ', ' . $toname; ?>!</h3></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td style="text-align: justify;">
                Thank you for creating an account with us.<br/><br/>Now, you can get the discounts for the food, drinks, entertainment, and leisure from your favorite restaurants, clubs, or establishments without any hassle at all!<br/><br/>Best of all, the use of fullresto.com is FREE! And that's the way it will be for ever.<br/><br/>
                <a href="<?php echo site_url(); ?>" style="text-decoration:none;color:#40568B;">Let me start enjoying the perks now &Gt;</a>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
    </table>
                            
    <?php } else if($mode == 'forgotpassword') { ?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td><h3 align="center">You have requested for a password.</h3></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td style="text-align: justify;">
                If you did not create this request, please report this to us.<br/><br/>Please click this link to reset your password or copy and paste it on your browser:<br/><a href="<?php echo $password_key; ?>"><?php echo $password_key; ?></a><br/><br/>
                <a href="<?php echo site_url(); ?>" style="text-decoration:none;color:#40568B;">Login to fullresto.com!</a>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
    </table>
                            
    <?php } else if($mode == 'booking' || $mode == 'booking-merchant') { ?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td><h3 align="center">Confirmation of Booking</h3></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>Booking Code</td>
                        <td><a href="<?php echo $link; ?>" target="_blank"><?php echo $booking_id; ?></a></td>
                    </tr>
                    <tr>
                        <td>Merchant</td>
                        <td><a href="<?php echo $merchant_link; ?>" target="_blank"><?php echo $merchant_name; ?></a></td>
                    </tr>
                    <tr>
                        <td>Deal</td>
                        <td><?php echo $deal; ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><?php echo $status; ?></td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr>
                        <td>Date</td>
                        <td><?php echo $date_booked; ?></td>
                    </tr>
                    <tr>
                        <td>Time</td>
                        <td><?php echo $time_booked_from; // . ' to ' . $time_booked_to; ?></td>
                    </tr>
                    <tr>
                        <td>Number of people</td>
                        <td><?php echo $pax_booked; ?></td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr>
                        <td>Name</td>
                        <td><?php echo $name; ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <td>Contact Number</td>
                        <td><?php echo $contact_number; ?></td>
                    </tr>
                    <?php if(!empty($promo_code)) { ?>
                    <tr>
                        <td>Promo Code</td>
                        <td><?php echo $promo_code; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td>Link</td>
                        <td><a href="<?php echo $link; ?>" target="_blank"><?php echo $link; ?></a></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?php echo site_url(); ?>" style="text-decoration:none;color:#40568B;">Login to fullresto.com!</a>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
    </table>
                            
    <?php } else if($mode == 'contact') { ?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td><h3 align="center">Contact Us</h3></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>Name</td>
                        <td><?php echo $name; ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Message</td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr>
                        <td colspan="2"><?php echo $message; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>
                <a href="<?php echo site_url(); ?>" style="text-decoration:none;color:#40568B;">Login to fullresto.com!</a>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
    </table>
                            
    <?php } ?>
                            
                        </td>
                    </tr>
                </table>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
</body>
</html>
        