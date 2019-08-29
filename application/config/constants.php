<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('MIN_RANDOM',8); // minimum length of the random ID generator
define('MAX_RANDOM',16); // maximum length of the random ID generator

/*
|--------------------------------------------------------------------------
| HTTP STATUS CODES
|--------------------------------------------------------------------------
|
*/
define('HTTP_SUCCESS', '200');
define('HTTP_ERROR', '500');
define('HTTP_NOT_FOUND', '404');

/*
|--------------------------------------------------------------------------
| FORMATS
|--------------------------------------------------------------------------
|
*/
define('DATETIME_DB_FORMAT', 'Y-m-d H:i:s');

/*
|--------------------------------------------------------------------------
| STATUS
|--------------------------------------------------------------------------
|
*/
define('NO', '0');
define('YES', '1');

define('USER_STATUS_DELETED', '0');
define('USER_STATUS_ACTIVE', '1');
define('USER_STATUS_INACTIVE', '2');
define('USER_STATUS_UNSUBSCRIBED', '3');

define('USER_NOT_BANNED', NO);
define('USER_BANNED', YES);

define('USER_DEAL_SUSPEND', NO);
define('USER_DEAL_ALLOWED', YES);

define('MERCHANT_STATUS_DELETED', '0');
define('MERCHANT_STATUS_ACTIVE', '1');
define('MERCHANT_STATUS_UNSUBSCRIBED', '2');

define('MERCHANT_PROFILE_PUBLIC_STATUS_HOLD', NO);
define('MERCHANT_PROFILE_PUBLIC_STATUS_APPROVED', YES);

define('MERCHANT_PROFILE_ADMIN_STATUS_HOLD', NO);
define('MERCHANT_PROFILE_ADMIN_STATUS_APPROVED', YES);

define('MERCHANT_SUBSCRIPTION_STATUS_SUSPEND', '0');
define('MERCHANT_SUBSCRIPTION_STATUS_ACTIVE', '1');
define('MERCHANT_SUBSCRIPTION_STATUS_PENDING', '2');
define('MERCHANT_SUBSCRIPTION_STATUS_EXPIRED', '3');

define('DEAL_STATUS_DELETED', '0');
define('DEAL_STATUS_ACTIVE', '1');
define('DEAL_STATUS_HOLD', '2');

define('DEAL_RATE_TYPE_FIX_AMOUNT', '0');
define('DEAL_RATE_TYPE_PERCENTAGE', '1');

define('BOOK_USER_STATUS_CANCELLED', NO);
define('BOOK_USER_STATUS_CONFIRMED', YES);
define('BOOK_MERCHANT_STATUS_DENIED', '0');
define('BOOK_MERCHANT_STATUS_TAKEN', '1');
define('BOOK_MERCHANT_STATUS_CANCELLED', '2');
define('BOOK_MERCHANT_STATUS_FULFILLED', '3');

/*
|--------------------------------------------------------------------------
| RECORD CODES' PREFIXES
|--------------------------------------------------------------------------
|
*/

define('CODE_USERS',  		'C');
define('CODE_MERCHANTS',    'M');
define('CODE_TRANSACTION',  'X');
define('CODE_PASSWORD',  	'P');

/*
|--------------------------------------------------------------------------
| URL
|--------------------------------------------------------------------------
|
*/

define('URL_MERCHANT',  		'merchant');
define('URL_USER',  		'user');
define('URL_BOOKINGS',  		'bookings');