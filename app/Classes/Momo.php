<?php
namespace App\Classes;

class Momo {
    public function method($order){
        header('Content-type: text/html; charset=utf-8'); 
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $momoConfig= momoConfig();
        $partnerCode =  $momoConfig['partnerCode'];
        $accessKey =  $momoConfig['accessKey'];
        $secretKey = $momoConfig['secretKey'];
        $orderInfo = "Thanh toán qua MoMo";
        $amount = (string)$order['od_price_total'];
        $orderId =  $order['id'];
        $redirectUrl  = $this->writeUrl('return/momo');
        $ipnUrl =$this->writeUrl('return/momo_ipn');
        // Lưu ý: link notifyUrl không phải là dạng localhost
        $requestId = time()."";
        $requestType = "payWithMoMoATM";
        $extraData = "";
        $requestId = time() . "";
        $requestType = "payWithATM";
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . 
        $amount . "&extraData=" . $extraData . "&ipnUrl=" .
         $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . 
         $orderInfo . "&partnerCode=" . $partnerCode . 
         "&redirectUrl=" . $redirectUrl . "&requestId=" . 
         $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array('partnerCode' => $partnerCode,
        'partnerName' => "Test",
        "storeId" => "MomoTestStore",
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature);
        $result = execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json
        //Just a example, please check more in there
        header('Location: ' . $jsonResult['payUrl']);
        return $jsonResult;
    }
 private function writeUrl($path) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        $baseUrl = $protocol . $host . '/';
        return $baseUrl . $path;
    }
}