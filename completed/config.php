<?php


require_once('vendor/autoload.php');

$stripe = array(
  "secret_key"      => " sk_test_28CiHMUAh8IO4vEr6081A3oD",
  "publishable_key" => " pk_test_JEvbFGh6wv6oYAPl560imzq3"
);
/*$stripe = array(
  "secret_key"      => " sk_live_LUcOCsfyEfGT3aZjHiwS3YES",
  "publishable_key" => " pk_live_sSPy8AX64XaRQRgD3ZgoxvcE"
);*/
\Stripe\Stripe::setApiKey($stripe['secret_key']);

//$payment_url  = "https://www.sandbox.paypal.com/cgi-bin/webscr"; // Paypal API URL
/* Please note that after complete developement change the above URL and remove ".sandbox" from the url
or comment the above line and uncomment the below line. */

//$payment_url  = "https://www.paypal.com/cgi-bin/webscr"; // Paypal API URL

//$merchant_email = "usamerchant1@email.com" ; // merchant email id

?>