<?php
namespace App\Libraries;
$path = substr(APPPATH, 0, -4);
require $path.'thirdparty/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

class AppotaPay
{

    const API_URL = 'https://payment.dev.appotapay.com';
    private $partnerCode;
    private $apiKey;
    private $secretKey;

    /**
     * @param array config(partner_code, api_key, secret_key)
     */
    public function __construct(array $config)
    {
        $this->partnerCode = $config['partner_code'];
        $this->apiKey = $config['api_key'];
        $this->secretKey = $config['secret_key'];

    }

    /**
     * @param array $orderDetails(order_id, order_info, amount)
     * @param array $paymentDetails(bank_code, method)
     */
    public function makeBankPayment(array $orderDetails, array $paymentDetails)
    {
        $params =[
            'orderId' => $orderDetails['order_id'],
            'orderInfo' => $orderDetails['order_info'],
            'amount' => $orderDetails['amount'],
            'bankCode' => $paymentDetails['bank_code'],
            'paymentMethod' => $paymentDetails['method'],
            'notifyUrl' => 'http://nhatnammarket.com/ipn',
            'redirectUrl' => 'http://nhatnammarket.com/redirect',
            'clientIp' => $paymentDetails['client_ip']
        ];



        ksort($params);
        $signData = $this->generateSignData($params);


        $params['signature'] = hash_hmac('sha256', $signData, $this->secretKey);



        $headers = [
            'X-APPOTAPAY-AUTH: Bearer '.$this->generateJWT($this->partnerCode, $this->apiKey, $this->secretKey),
            'Content-Type: application/json'
        ];


        $apiUrl = self::API_URL . '/api/v1/orders/payment/bank';
        $result = $this->makeRequest($apiUrl, json_encode($params), $headers);
        $result = json_decode($result);


        if (isset($result->errorCode) && $result->errorCode === 0) {
            return $result->paymentUrl;
        }

        return null;
    }

    /**
     * @param array $params
     * @return string
     */
    public function generateSignData(array $params)
    {
        ksort($params);
        array_walk($params, function(&$item, $key) {
            $item = $key.'='.$item;
        });
        return implode('&', $params);
    }


    public function generateJWT( $partnerCode,  $apiKey,  $secretKey)
    {



        //
        // return  'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImN0eSI6ImFwcG90YXBheS1hcGk7dj0xIn0.eyJpc3MiOiJURVNUIiwiYXBpX2tleSI6Im9NaEpwa3o3SzZIRGNSNlMiLCJleHAiOjE2MTQzNDY1ODN9.h4ffsl8j9eMMdTkK0D493qXhkol9FQaJg3kXXqs6Wds';


        $now = time();
        $exp = $now + 600;
        $header = array(
            'typ' => 'JWT',
            'alg' => 'HS256',
            'cty' => "appotapay-api;v=1"
        );
        $payload = array(
            'iss' => $partnerCode,
            'jti' => $apiKey . '-' . $now,
            'api_key' => $apiKey,
            'exp' => $exp
        );


        return JWT::encode($payload, $secretKey, 'HS256', null, $header);
    }

    /*
     * function make request
     * url : string | url request
     * params : array | params request
     * method : string(POST,GET) | method request
     */
    private function makeRequest($url, $params, $headers)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); // Time out 60s
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); // connect time out 5s

        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_error($ch)) {
            return false;
        }

        if ($status !== 200) {
            curl_close($ch);
            return false;
        }
        // close curl
        curl_close($ch);

        return $result;
    }

}
