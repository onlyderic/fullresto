<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| If this is not set then CodeIgniter will try guess the protocol, domain
| and path to your installation. However, you should always configure this
| explicitly and never rely on auto-guessing, especially in production
| environments.
|
*/
$config['base_url'] = '';

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
|
| Typically this will be your index.php file, unless you've renamed it to
| something else. If you are using mod_rewrite to remove the page set this
| variable so that it is blank.
|
*/
$config['index_page'] = '';

/*
|--------------------------------------------------------------------------
| URI PROTOCOL
|--------------------------------------------------------------------------
|
| This item determines which server global should be used to retrieve the
| URI string.  The default setting of 'REQUEST_URI' works for most servers.
| If your links do not seem to work, try one of the other delicious flavors:
|
| 'REQUEST_URI'    Uses $_SERVER['REQUEST_URI']
| 'QUERY_STRING'   Uses $_SERVER['QUERY_STRING']
| 'PATH_INFO'      Uses $_SERVER['PATH_INFO']
|
| WARNING: If you set this to 'PATH_INFO', URIs will always be URL-decoded!
*/
$config['uri_protocol']	= 'REQUEST_URI';

/*
|--------------------------------------------------------------------------
| URL suffix
|--------------------------------------------------------------------------
|
| This option allows you to add a suffix to all URLs generated by CodeIgniter.
| For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/urls.html
*/

$config['url_suffix'] = '';

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= 'english';

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
|
| This determines which character set is used by default in various methods
| that require a character set to be provided.
|
| See http://php.net/htmlspecialchars for a list of supported charsets.
|
*/
$config['charset'] = 'UTF-8';

/*
|--------------------------------------------------------------------------
| Enable/Disable System Hooks
|--------------------------------------------------------------------------
|
| If you would like to use the 'hooks' feature you must enable it by
| setting this variable to TRUE (boolean).  See the user guide for details.
|
*/
$config['enable_hooks'] = FALSE;

/*
|--------------------------------------------------------------------------
| Class Extension Prefix
|--------------------------------------------------------------------------
|
| This item allows you to set the filename/classname prefix when extending
| native libraries.  For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/core_classes.html
| http://codeigniter.com/user_guide/general/creating_libraries.html
|
*/
$config['subclass_prefix'] = 'MY_';

/*
|--------------------------------------------------------------------------
| Composer auto-loading
|--------------------------------------------------------------------------
|
| Enabling this setting will tell CodeIgniter to look for a Composer
| package auto-loader script in application/vendor/autoload.php.
|
|	$config['composer_autoload'] = TRUE;
|
| Or if you have your vendor/ directory located somewhere else, you
| can opt to set a specific path as well:
|
|	$config['composer_autoload'] = '/path/to/vendor/autoload.php';
|
| For more information about Composer, please visit http://getcomposer.org/
|
| Note: This will NOT disable or override the CodeIgniter-specific
|	autoloading (application/config/autoload.php)
*/
$config['composer_autoload'] = FALSE;

/*
|--------------------------------------------------------------------------
| Allowed URL Characters
|--------------------------------------------------------------------------
|
| This lets you specify which characters are permitted within your URLs.
| When someone tries to submit a URL with disallowed characters they will
| get a warning message.
|
| As a security measure you are STRONGLY encouraged to restrict URLs to
| as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
|
| Leave blank to allow all characters -- but only if you are insane.
|
| The configured value is actually a regular expression character group
| and it will be executed as: ! preg_match('/^[<permitted_uri_chars>]+$/i
|
| DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
|
*/
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';


/*
|--------------------------------------------------------------------------
| Enable Query Strings
|--------------------------------------------------------------------------
|
| By default CodeIgniter uses search-engine friendly segment based URLs:
| example.com/who/what/where/
|
| By default CodeIgniter enables access to the $_GET array.  If for some
| reason you would like to disable it, set 'allow_get_array' to FALSE.
|
| You can optionally enable standard query string based URLs:
| example.com?who=me&what=something&where=here
|
| Options are: TRUE or FALSE (boolean)
|
| The other items let you set the query string 'words' that will
| invoke your controllers and its functions:
| example.com/index.php?c=controller&m=function
|
| Please note that some of the helpers won't work as expected when
| this feature is enabled, since CodeIgniter is designed primarily to
| use segment based URLs.
|
*/
$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| If you have enabled error logging, you can set an error threshold to
| determine what gets logged. Threshold options are:
| You can enable error logging by setting a threshold over zero. The
| threshold determines what gets logged. Threshold options are:
|
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
|
| You can also pass an array with threshold levels to show individual error types
|
| 	array(2) = Debug Messages, without Error Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = 0;

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/logs/ directory. Use a full server path with trailing slash.
|
*/
$config['log_path'] = '';

/*
|--------------------------------------------------------------------------
| Log File Extension
|--------------------------------------------------------------------------
|
| The default filename extension for log files. The default 'php' allows for
| protecting the log files via basic scripting, when they are to be stored
| under a publicly accessible directory.
|
| Note: Leaving it blank will default to 'php'.
|
*/
$config['log_file_extension'] = '';

/*
|--------------------------------------------------------------------------
| Log File Permissions
|--------------------------------------------------------------------------
|
| The file system permissions to be applied on newly created log files.
|
| IMPORTANT: This MUST be an integer (no quotes) and you MUST use octal
|            integer notation (i.e. 0700, 0644, etc.)
*/
$config['log_file_permissions'] = 0644;

/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
|
| Each item that is logged has an associated date. You can use PHP date
| codes to set your own date formatting
|
*/
$config['log_date_format'] = 'Y-m-d H:i:s';

/*
|--------------------------------------------------------------------------
| Error Views Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/views/errors/ directory.  Use a full server path with trailing slash.
|
*/
$config['error_views_path'] = '';

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/cache/ directory.  Use a full server path with trailing slash.
|
*/
$config['cache_path'] = '';

/*
|--------------------------------------------------------------------------
| Cache Include Query String
|--------------------------------------------------------------------------
|
| Set this to TRUE if you want to use different cache files depending on the
| URL query string.  Please be aware this might result in numerous cache files.
|
*/
$config['cache_query_string'] = FALSE;

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class, you must set an encryption key.
| See the user guide for more info.
|
| http://codeigniter.com/user_guide/libraries/encryption.html
|
*/
$config['encryption_key'] = '';

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
|
| 'sess_driver'
|
|	The storage driver to use: files, database, redis, memcached
|
| 'sess_cookie_name'
|
|	The session cookie name, must contain only [0-9a-z_-] characters
|
| 'sess_expiration'
|
|	The number of SECONDS you want the session to last.
|	Setting to 0 (zero) means expire when the browser is closed.
|
| 'sess_save_path'
|
|	The location to save sessions to, driver dependant.
|
|	For the 'files' driver, it's a path to a writable directory.
|	WARNING: Only absolute paths are supported!
|
|	For the 'database' driver, it's a table name.
|	Please read up the manual for the format with other session drivers.
|
|	IMPORTANT: You are REQUIRED to set a valid save path!
|
| 'sess_match_ip'
|
|	Whether to match the user's IP address when reading the session data.
|
| 'sess_time_to_update'
|
|	How many seconds between CI regenerating the session ID.
|
| 'sess_regenerate_destroy'
|
|	Whether to destroy session data associated with the old session ID
|	when auto-regenerating the session ID. When set to FALSE, the data
|	will be later deleted by the garbage collector.
|
| Other session cookie settings are shared with the rest of the application,
| except for 'cookie_prefix' and 'cookie_httponly', which are ignored here.
|
*/
$config['sess_driver'] = 'database';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = 'ci_sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cookie Related Variables
|--------------------------------------------------------------------------
|
| 'cookie_prefix'   = Set a cookie name prefix if you need to avoid collisions
| 'cookie_domain'   = Set to .your-domain.com for site-wide cookies
| 'cookie_path'     = Typically will be a forward slash
| 'cookie_secure'   = Cookie will only be set if a secure HTTPS connection exists.
| 'cookie_httponly' = Cookie will only be accessible via HTTP(S) (no javascript)
|
| Note: These settings (with the exception of 'cookie_prefix' and
|       'cookie_httponly') will also affect sessions.
|
*/
$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;

/*
|--------------------------------------------------------------------------
| Standardize newlines
|--------------------------------------------------------------------------
|
| Determines whether to standardize newline characters in input data,
| meaning to replace \r\n, \r, \n occurences with the PHP_EOL value.
|
| This is particularly useful for portability between UNIX-based OSes,
| (usually \n) and Windows (\r\n).
|
*/
$config['standardize_newlines'] = FALSE;

/*
|--------------------------------------------------------------------------
| Global XSS Filtering
|--------------------------------------------------------------------------
|
| Determines whether the XSS filter is always active when GET, POST or
| COOKIE data is encountered
|
| WARNING: This feature is DEPRECATED and currently available only
|          for backwards compatibility purposes!
|
*/
$config['global_xss_filtering'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
| Enables a CSRF cookie token to be set. When set to TRUE, token will be
| checked on a submitted form. If you are accepting user data, it is strongly
| recommended CSRF protection be enabled.
|
| 'csrf_token_name' = The token name
| 'csrf_cookie_name' = The cookie name
| 'csrf_expire' = The number in seconds the token should expire.
| 'csrf_regenerate' = Regenerate token on every submission
| 'csrf_exclude_uris' = Array of URIs which ignore CSRF checks
*/
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
|
| Enables Gzip output compression for faster page loads.  When enabled,
| the output class will test whether your server supports Gzip.
| Even if it does, however, not all browsers support compression
| so enable only if you are reasonably sure your visitors can handle it.
|
| Only used if zlib.output_compression is turned off in your php.ini.
| Please do not use it together with httpd-level output compression.
|
| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
| means you are prematurely outputting something to your browser. It could
| even be a line of whitespace at the end of one of your scripts.  For
| compression to work, nothing can be sent before the output buffer is called
| by the output class.  Do not 'echo' any values with compression enabled.
|
*/
$config['compress_output'] = FALSE;

/*
|--------------------------------------------------------------------------
| Master Time Reference
|--------------------------------------------------------------------------
|
| Options are 'local' or any PHP supported timezone. This preference tells
| the system whether to use your server's local time as the master 'now'
| reference, or convert it to the configured one timezone. See the 'date
| helper' page of the user guide for information regarding date handling.
|
*/
$config['time_reference'] = 'local';

/*
|--------------------------------------------------------------------------
| Rewrite PHP Short Tags
|--------------------------------------------------------------------------
|
| If your PHP installation does not have short tag support enabled CI
| can rewrite the tags on-the-fly, enabling you to utilize that syntax
| in your view files.  Options are TRUE or FALSE (boolean)
|
*/
$config['rewrite_short_tags'] = FALSE;


/*
|--------------------------------------------------------------------------
| Reverse Proxy IPs
|--------------------------------------------------------------------------
|
| If your server is behind a reverse proxy, you must whitelist the proxy
| IP addresses from which CodeIgniter should trust headers such as
| HTTP_X_FORWARDED_FOR and HTTP_CLIENT_IP in order to properly identify
| the visitor's IP address.
|
| You can use both an array or a comma-separated list of proxy addresses,
| as well as specifying whole subnets. Here are a few examples:
|
| Comma-separated:	'10.0.1.200,192.168.5.0/24'
| Array:		array('10.0.1.200', '192.168.5.0/24')
*/
$config['proxy_ips'] = '';


/*
|--------------------------------------------------------------------------
| Site Settings
|--------------------------------------------------------------------------
|
*/
$config['list_limit']	= "10";
$config['map_radius']	= "5";
$config['location_url'] = 'http://ip-api.com/json/';
$config['cache_time']	= "0";
$config['cache_time_home']	= "86400"; //24hours
$config['cache_time_map']	= "0";
$config['cache_time_cities']	= "86400"; //24hours


/*
|--------------------------------------------------------------------------
| Subscription Settings
|--------------------------------------------------------------------------
|
*/
$config['deals_limit_free']	= "1";


/*
|--------------------------------------------------------------------------
| Records' Codes
|--------------------------------------------------------------------------
|
*/
$config['code_min']	= "6";
$config['code_max']	= "8";


/*
|--------------------------------------------------------------------------
| SMTP/Email
|--------------------------------------------------------------------------
|
*/
$config['smtp_host']	= "";
$config['smtp_port']	= "";
$config['smtp_user']	= "";
$config['smtp_pass']	= "";

$config['email_from_register']	= "";
$config['email_from_name_register']	= "";
$config['email_subject_register']	= "";

$config['email_to_contactus']	= "";
$config['email_to_name_contactus']	= "";
$config['email_from_contactus']	= "";
$config['email_from_name_contactus']	= "";
$config['email_subject_contactus']	= "";

$config['email_from_forgotpassword']	= "";
$config['email_from_name_forgotpassword']	= "";
$config['email_subject_forgotpassword']	= "";

$config['email_from_invoice']	= "";
$config['email_from_name_invoice']	= "";
$config['email_subject_invoice']	= "";

$config['email_from_booking']	= "";
$config['email_from_name_booking']	= "";
$config['email_subject_booking']	= "";
$config['email_subject_booking_merchant']	= "";
$config['email_bcc_booking']	= "";


/*
|--------------------------------------------------------------------------
| PayPal
|--------------------------------------------------------------------------
|
*/
$config['paymentmode']    = 'sandbox'; //paypal, sandbox
$config['paypal_businessemail']    = "";
$config['paypal_return']  = "";
$config['paypal_cancel']  = "";
$config['paypal_notifyurl']  = "";
$config['paypal_currency'] = '';
$config['paypal_country'] = '';


/*
|--------------------------------------------------------------------------
| SMS
|--------------------------------------------------------------------------
|
*/
$config['sms_enable'] = FALSE;
$config['sms_api'] = '';
$config['sms_outbound_endpoint'] = '';
$config['sms_from'] = '';


/*
|--------------------------------------------------------------------------
| Paths
|--------------------------------------------------------------------------
|
*/
$config['image_path'] = '/fullresto/assets/img/';

/**
 * Auth
 */
//Login settings
$config['login_record_ip'] = TRUE;
$config['login_record_time'] = TRUE;
$config['login_count_attempts'] = TRUE;
$config['login_attempt_expire'] = 60*60*24;
$config['login_max_attempts'] = 5;
$config['login_record_ip'] = TRUE;
$config['login_record_time'] = TRUE;
//Auto login settings
$config['autologin_cookie_name'] = 'autologin';
$config['autologin_cookie_life'] = 60*60*24*31*2;
//Security settings
$config['phpass_hash_portable'] = FALSE;
$config['phpass_hash_strength'] = 8;

$config['countries'] = array("AF" => "Afghanistan",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AG" => "Antigua and Barbuda",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AU" => "Australia",
        "AT" => "Austria",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia",
        "BA" => "Bosnia and Herzegovina",
        "BW" => "Botswana",
        "BR" => "Brazil",
        "BN" => "Brunei Darussalam",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo",
        "CD" => "Congo, the Democratic Republic of the",
        "CR" => "Costa Rica",
        "CI" => "Côte d'Ivoire",
        "HR" => "Croatia",
        "CU" => "Cuba",
        "CW" => "Curaçao",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "GA" => "Gabon",
        "GM" => "Gambia",
        "GE" => "Georgia",
        "DE" => "Germany",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GD" => "Grenada",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "VA" => "Vatican",
        "HN" => "Honduras",
        "HK" => "Hong Kong",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Laos",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macao",
        "MK" => "Macedonia",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "MX" => "Mexico",
        "FM" => "Micronesia",
        "MD" => "Moldova",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "ME" => "Montenegro",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "KP" => "North Korea",
        "NO" => "Norway",
        "OM" => "Oman",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PS" => "Palestine",
        "PA" => "Panama",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RO" => "Romania",
        "RU" => "Russia",
        "RW" => "Rwanda",
        "KN" => "Saint Kitts and Nevis",
        "LC" => "Saint Lucia",
        "VC" => "Saint Vincent and the Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "ST" => "Sao Tome and Principe",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "RS" => "Serbia",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SX" => "Sint Maarten",
        "SK" => "Slovakia",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "KR" => "South Korea",
        "SS" => "South Sudan",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syria",
        "TW" => "Taiwan",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania",
        "TH" => "Thailand",
        "TL" => "Timor-Leste",
        "TG" => "Togo",
        "TO" => "Tonga",
        "TT" => "Trinidad and Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TV" => "Tuvalu",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "AE" => "United Arab Emirates",
        "GB" => "United Kingdom",
        "US" => "United States",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VE" => "Venezuela",
        "VN" => "Viet Nam",
        "VG" => "Virgin Islands, British",
        "VI" => "Virgin Islands, U.S.",
        "YE" => "Yemen",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe");

$config['currencies'] = array(
        'PHP' => '₱',
        'USD' => '$',
        'SGD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'XAF' => 'Fr',
        'AED' => 'د.إ',
        'AFN' => '؋',
        'ALL' => 'L',
        'AMD' => 'դր.',
        'ANG' => 'ƒ',
        'AOA' => 'Kz',
        'ARS' => '$',
        'AUD' => '$',
        'AWG' => 'ƒ',
        'AZN' => '',
        'BAM' => 'KM or КМ',
        'BBD' => '$',
        'BDT' => '৳',
        'BGN' => 'лв',
        'BHD' => '.د.ب',
        'BIF' => 'Fr',
        'BMD' => '$',
        'BND' => '$',
        'BOB' => 'Bs.',
        'BRL' => 'R$',
        'BSD' => '$',
        'BTN' => 'Nu.',
        'BWP' => 'P',
        'BYR' => 'Br',
        'BZD' => '$',
        'CAD' => '$',
        'CDF' => 'Fr',
        'CHF' => 'Fr',
        'CLP' => '$',
        'CNY' => '¥',
        'COP' => '$',
        'CRC' => '₡',
        'CUC' => '$',
        'CUP' => '$',
        'CVE' => '$',
        'CZK' => 'Kč',
        'DJF' => 'Fr',
        'DKK' => 'kr',
        'DOP' => '$',
        'DZD' => 'د.ج',
        'EGP' => '£',
        'ERN' => 'Nfk',
        'ETB' => 'Br',
        'FJD' => '$',
        'FKP' => '£',
        'GEL' => 'ლ',
        'GGP' => '£',
        'GHS' => '₵',
        'GIP' => '£',
        'GMD' => 'D',
        'GNF' => 'Fr',
        'GTQ' => 'Q',
        'GYD' => '$',
        'HKD' => '$',
        'HNL' => 'L',
        'HRK' => 'kn',
        'HTG' => 'G',
        'HUF' => 'Ft',
        'IDR' => 'Rp',
        'ILS' => '₪',
        'IMP' => '£',
        'INR' => '',
        'IQD' => 'ع.د',
        'IRR' => '﷼',
        'ISK' => 'kr',
        'JEP' => '£',
        'JMD' => '$',
        'JOD' => 'د.ا',
        'JPY' => '¥',
        'KES' => 'Sh',
        'KGS' => 'лв',
        'KHR' => '៛',
        'KMF' => 'Fr',
        'KPW' => '₩',
        'KRW' => '₩',
        'KWD' => 'د.ك',
        'KYD' => '$',
        'KZT' => '₸',
        'LAK' => '₭',
        'LBP' => 'ل.ل',
        'LKR' => 'Rs',
        'LRD' => '$',
        'LSL' => 'L',
        'LTL' => 'Lt',
        'LVL' => 'Ls',
        'LYD' => 'ل.د',
        'MAD' => 'د.م.',
        'MDL' => 'L',
        'MGA' => 'Ar',
        'MKD' => 'ден',
        'MMK' => 'Ks',
        'MNT' => '₮',
        'MOP' => 'P',
        'MRO' => 'UM',
        'MUR' => '₨',
        'MVR' => '.ރ',
        'MWK' => 'MK',
        'MXN' => '$',
        'MYR' => 'RM',
        'MZN' => 'MT',
        'NAD' => '$',
        'NGN' => '₦',
        'NIO' => 'C$',
        'NOK' => 'kr',
        'NPR' => '₨',
        'NZD' => '$',
        'OMR' => 'ر.ع.',
        'PAB' => 'B/.',
        'PEN' => 'S/.',
        'PGK' => 'K',
        'PKR' => '₨',
        'PLN' => 'zł',
        'PRB' => 'р.',
        'PYG' => '₲',
        'QAR' => 'ر.ق',
        'RON' => 'L',
        'RSD' => 'дин.',
        'RUB' => 'р.',
        'RWF' => 'Fr',
        'SAR' => 'ر.س',
        'SBD' => '$',
        'SCR' => '₨',
        'SDG' => '£',
        'SEK' => 'kr',
        'SHP' => '£',
        'SLL' => 'Le',
        'SOS' => 'Sh',
        'SRD' => '$',
        'SSP' => '£',
        'STD' => 'Db',
        'SVC' => '₡',
        'SYP' => '£',
        'SZL' => 'L',
        'THB' => '฿',
        'TJS' => 'ЅМ',
        'TMT' => 'm',
        'TND' => 'د.ت',
        'TOP' => 'T$',
        'TRY' => '',
        'TTD' => '$',
        'TWD' => '$',
        'TZS' => 'Sh',
        'UAH' => '₴',
        'UGX' => 'Sh',
        'UYU' => '$',
        'UZS' => 'лв',
        'VEF' => 'Bs F',
        'VND' => '₫',
        'VUV' => 'Vt',
        'WST' => 'T',
        'XCD' => '$',
        'XOF' => 'Fr',
        'XPF' => 'Fr',
        'YER' => '﷼',
        'ZAR' => 'R',
        'ZMW' => 'ZK',
        'ZWL' => '$');