<?php

// Be sure to include the file you've just downloaded
require_once('AfricasTalkingGateway.php');

// Specify your authentication credentials
$username   = "olakenya";
$apikey     = "a10946ff861f12b2383ce3f1a65ab9dbbb08efa44b7e86ca432ba50bd56b2128";

// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)
$recipients = "+254$u_db_mobile";

// And of course we want our recipients to know what we really do
$message    = "TNET Verification Code: $vcode";

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
   echo "<script>
          alert('Ooops ! We have notced unusual access to this account, Plase verify if you are the user ...!');
          window.open('verify.php','_self');
          </script>";
  
}
catch ( AfricasTalkingGatewayException $e )
{
  echo "<script>
  alert('Please check your Internet connections....');
  </script>";
   
}

// DONE!!! 
