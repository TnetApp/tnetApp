<?php
error_reporting(0);
// Be sure to include the file you've just downloaded
require_once('AfricasTalkingGateway.php');

// Specify your authentication credentials
$username   = "olakenya";
$apikey     = "3486db0407b5f8f53cb2e5d855afbc8fbe8458a52d3ee1b6b03ec5e8ca6f19cd";

// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)
$recipients = "+254$user_phone";

// And of course we want our recipients to know what we really do
$message    = "HI, $user_name .YOUR RENTAPP VERIFICATION CODE IS: $user_vcode.PLEASE ENTER THIS CODE TO CONTINUE...";

// Create a new instance of our awesome gateway class
$gateway    = new AfricasTalkingGateway($username, $apikey);

/*************************************************************************************
  NOTE: If connecting to the sandbox:

  1. Use "sandbox" as the username
  2. Use the apiKey generated from your sandbox application
     https://account.africastalking.com/apps/sandbox/settings/key
  3. Add the "sandbox" flag to the constructor

  $gateway  = new AfricasTalkingGateway($username, $apiKey, "sandbox");
**************************************************************************************/

// Any gateway error will be captured by our custom Exception class below, 
// so wrap the call in a try-catch block

try 
{ 
  // Thats it, hit send and we'll take care of the rest. 
  $results = $gateway->sendMessage($recipients, $message);
      
  // foreach($results as $result) {
  //   // status is either "Success" or "error message"
  //   echo " Number: " .$result->number;
  //   echo " Status: " .$result->status;
  //   echo " StatusCode: " .$result->statusCode;
  //   echo " MessageId: " .$result->messageId;
  //   echo " Cost: "   .$result->cost."\n";
  // }
}
catch ( AfricasTalkingGatewayException $e )
{
  echo "Please Check Internet Connection: ".$e->getMessage();
}

// DONE!!! 
