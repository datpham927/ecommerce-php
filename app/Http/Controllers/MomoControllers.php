<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\Request;

class MomoControllers extends Controller
{

    // xử lý thanh toán
     public function momo_return(Request $request){
        //Put your secret key in there
        $momoConfig= momoConfig();
        $partnerCode =  $momoConfig['partnerCode'];
        $accessKey =  $momoConfig['accessKey'];
        $secretKey = $momoConfig['secretKey'];
        $momoQuery=$request->query();  
        if (!empty($momoQuery)) {
            $rawData = "accessKey=" . $accessKey;
            $rawData .= "&amount=" . $momoQuery['amount'];
            $rawData .= "&extraData=" . $momoQuery['extraData'];
            $rawData .= "&message=" . $momoQuery['message'];
            $rawData .= "&orderId=" . $momoQuery['orderId'];
            $rawData .= "&orderInfo=" . $momoQuery['orderInfo'];
            $rawData .= "&orderType=" . $momoQuery['orderType'];
            $rawData .= "&partnerCode=" . $momoQuery['partnerCode'];
            $rawData .= "&payType=" . $momoQuery['payType'];
            $rawData .= "&requestId=" . $momoQuery['requestId'];
            $rawData .= "&responseTime=" . $momoQuery['responseTime'];
            $rawData .= "&resultCode=" . $momoQuery['resultCode'];
            $rawData .= "&transId=" . $momoQuery['transId'];
            
            $partnerSignature = hash_hmac("sha256", $rawData, $secretKey);
            $m2signature = $momoQuery['signature'];
            
            if ($m2signature == $partnerSignature) {
                    if ($momoQuery['resultCode'] == '0') {
                       Order::find($momoQuery['orderId'])->update([
                        'od_is_pay' =>1,
                        'od_paymentMethod' => 'MOMO',
                       ]);
                    } 
                }
            if ($m2signature == $partnerSignature) {
                if ($momoQuery['resultCode'] == '0') {
                    return redirect()->route('order.order_list')->with('success', 'Thanh toán thành công!');
                } else {
                    return redirect()->route('order.order_list')->with('success', $rawData['message']);
                }
            } else {
                return redirect()->route('order.order_list')->with('success', "Thanh toán không thành công!");
            }
        }
        }


    // Hàm momo_ipn trong đoạn mã này được sử dụng để xử lý các thông báo
    //  thanh toán ngay lập tức (IPN - Instant Payment Notification) từ MoMo, 
    //  một cổng thanh toán trực tuyến. Đây là một dạng callback, nơi mà hệ thống
    //   MoMo gửi thông tin về giao dịch trở lại máy chủ của bạn để thông báo về
    //    trạng thái của giao dịch (thành công hoặc thất bại).
    // ----- liên hệ kỹ thuật bên momo -----------
     public function momo_ipn(Request $request){
        if (!empty($_POST)) {
            $response = array();
            try {
                $partnerCode = $_POST["partnerCode"];
                $accessKey = $_POST["accessKey"];
                $serectkey = '';
                $orderId = $_POST["orderId"];
                $localMessage = $_POST["localMessage"];
                $message = $_POST["message"];
                $transId = $_POST["transId"];
                $orderInfo = $_POST["orderInfo"];
                $amount = $_POST["amount"];
                $errorCode = $_POST["errorCode"];
                $responseTime = $_POST["responseTime"];
                $requestId = $_POST["requestId"];
                $extraData = $_POST["extraData"];
                $payType = $_POST["payType"];
                $orderType = $_POST["orderType"];
                $extraData = $_POST["extraData"];
                $m2signature = $_POST["signature"]; //MoMo signature
                //Checksum
                $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
                    "&orderType=" . $orderType . "&transId=" . $transId . "&message=" . $message . "&localMessage=" . $localMessage . "&responseTime=" . $responseTime . "&errorCode=" . $errorCode .
                    "&payType=" . $payType . "&extraData=" . $extraData;
        
                $partnerSignature = hash_hmac("sha256", $rawHash, 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa');
        
                if ($m2signature == $partnerSignature) {
                    if ($errorCode == '0') {
                        $result = '<div class="alert alert-success">Capture Payment Success</div>';
                    } else {
                        $result = '<div class="alert alert-danger">' . $message . '</div>';
                    }
                } else {
                    $result = '<div class="alert alert-danger">This transaction could be hacked, please check your signature and returned signature</div>';
                }
        
            } catch (Exception $e) {
                echo $response['message'] = $e;
            }
        
            $debugger = array();
            $debugger['rawData'] = $rawHash;
            $debugger['momoSignature'] = $m2signature;
            $debugger['partnerSignature'] = $partnerSignature;
        
            if ($m2signature == $partnerSignature) {
                $response['message'] = "Received payment result success";
            } else {
                $response['message'] = "ERROR! Fail checksum";
            }
            $response['debugger'] = $debugger;
            echo json_encode($response);
        }
     }
}