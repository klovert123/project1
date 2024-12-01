<?php
session_start();

// Define your credentials
$consumerKey = 'your_consumer_key';
$consumerSecret = 'your_consumer_secret';
$shortCode = '600000'; // Use 600000 for Pochi la Biashara
$pochiNumber = '0757834831';
$lipanaMpesaOnlinePasskey = 'your_lipa_na_mpesa_online_passkey';
$callbackURL = 'https://your_website.com/callback';

// Function to get Access Token
function getAccessToken($consumerKey, $consumerSecret) {
    $credentials = base64_encode($consumerKey . ':' . $consumerSecret);
    $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $headers = ['Authorization: Basic ' . $credentials];
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($curl);
    curl_close($curl);
    
    return json_decode($response)->access_token;
}

// Function to initiate payment
function initiatePayment($accessToken, $shortCode, $amount, $phoneNumber, $callbackURL, $accountReference, $transactionDesc) {
    $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $headers = ['Authorization: Bearer ' . $accessToken];
    $timestamp = date('YmdHis');
    $password = base64_encode($shortCode . 'your_lipa_na_mpesa_online_passkey' . $timestamp);
    
    $postData = json_encode([
        'BusinessShortCode' => $shortCode,
        'Password' => $password,
        'Timestamp' => $timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $amount,
        'PartyA' => $phoneNumber,
        'PartyB' => $shortCode,
        'PhoneNumber' => $phoneNumber,
        'CallBackURL' => $callbackURL,
        'AccountReference' => $accountReference,
        'TransactionDesc' => $transactionDesc
    ]);
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($curl);
    curl_close($curl);
    
    return json_decode($response);
}

// Usage
$phoneNumber = $_POST['phone']; // Customer phone number from your form
$amount = '10'; // Amount in KES
$accessToken = getAccessToken($consumerKey, $consumerSecret);
$accountReference = 'Fuel Delivery';
$transactionDesc = 'Payment for Fuel Delivery';

$response = initiatePayment($accessToken, $shortCode, $amount, $phoneNumber, $callbackURL, $accountReference, $transactionDesc);
print_r($response);
?>
