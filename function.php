<?php
function getCountryFromIP($ip)
{
    $accessKey = '28fc85b3730c66';
    $geoData = file_get_contents("http://ipinfo.io/{$ip}/json?token={$accessKey}");
    $location = json_decode($geoData);
    return $location->country;
}
function getClientIP()
{

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}
function getCurrencyExchangeRates()
{
    $apiUrl = "https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/usd.json";
    $exchangeData = file_get_contents($apiUrl);
    $decodedData = json_decode($exchangeData, true);

    return $decodedData['usd'];
}
$ip = getClientIP();
if (!$ip) {
    $ip = "178.238.11.6";
}
// $ip = "125.22.51.250";
// $ip = "178.238.11.6";

$country = getCountryFromIP($ip);
$currencyCodes = [
    'US' => 'usd',
    'IN' => 'inr',
    'GB' => 'gbp',
    'CA' => 'cad'
];
$currencyCode = isset($currencyCodes[$country]) ? $currencyCodes[$country] : 'USD';
$exchangeRates = getCurrencyExchangeRates();
$exchangeRate = isset($exchangeRates[$currencyCode]) ? $exchangeRates[$currencyCode] : 1;
$priceInUSD = 10;
$roundedceilvalue = round($exchangeRate * 100);
