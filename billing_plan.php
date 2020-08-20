<?php
require_once("includes/paypal_config.php");

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

// Create a new billing plan
$plan = new Plan();
$plan->setName('Tsudoflix monthly')
     ->setDescription('Template creation.')
     ->setType('INFINITE');

// Set billing plan definitions
$paymentDefinition = new PaymentDefinition();
$paymentDefinition->setName('Regular Payments')
                  ->setType('REGULAR')
                  ->setFrequency('Month')
                  ->setFrequencyInterval('1')
                  ->setAmount(new Currency(array('value' => 15.99, 'currency' => 'USD')));

$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$return_url = str_replace("billing.php", "profile.php", $current_url);

// Set merchant preferences
$merchantPreferences = new MerchantPreferences();
$merchantPreferences->setReturnUrl($return_url."?success=true")
                    ->setCancelUrl($return_url."?success=false")
                    ->setAutoBillAmount('yes')
                    ->setInitialFailAmountAction('CONTINUE')
                    ->setMaxFailAttempts('0')
                    ->setSetupFee(new Currency(array('value' => 15.99, 'currency' => 'USD')));

$plan->setPaymentDefinitions(array($paymentDefinition));
$plan->setMerchantPreferences($merchantPreferences);

//create plan
try {
    $createdPlan = $plan->create($apiContext);

    try {
        $patch = new Patch();
        $value = new PayPalModel('{"state":"ACTIVE"}');
        $patch->setOp('replace')
              ->setPath('/')
              ->setValue($value);
        $patchRequest = new PatchRequest();
        $patchRequest->addPatch($patch);
        $createdPlan->update($patchRequest, $apiContext);
        $plan = Plan::get($createdPlan->getId(), $apiContext);

        // Output plan id
        echo $plan->getId();
    } catch (PayPal\Exception\PayPalConnectionException $ex) {
        echo $ex->getCode();
        echo $ex->getData();
        die($ex);
    } catch (Exception $ex) {
        die($ex);
    }
} catch (PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getCode();
    echo $ex->getData();
    die($ex);
} catch (Exception $ex) {
    die($ex);
}