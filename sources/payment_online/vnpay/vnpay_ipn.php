<?php

if($_SERVER["REQUEST_METHOD"] == 'GET'){
    $txt_return = $_SERVER["REQUEST_URI"];
    $txt_return = str_replace("/vnp-ipn?", "", $txt_return);
    $txt_return_p = explode("&", $txt_return);
    foreach( $txt_return_p as $p){
        $_tmp = explode("=", $p);
        $bill[$_tmp[0]] = $_tmp[1];
    }
}else{
    foreach($_POST as $k=> $p){
        $bill[$k] = $p;
    }
}

$inputData = array();
$returnData = array();
$data = $bill;

foreach ($data as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}

$vnp_SecureHash = $inputData['vnp_SecureHash'];
unset($inputData['vnp_SecureHashType']);
unset($inputData['vnp_SecureHash']);
ksort($inputData);
$i = 0;
$hashData = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashData = $hashData . '&' . $key . "=" . $value;
    } else {
        $hashData = $hashData . $key . "=" . $value;
        $i = 1;
    }
}
$hashData = str_replace('+',' ',$hashData);
$vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
$vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
// echo $vnp_HashSecret;
// echo '<br>';
// echo $hashData;
$secureHash = hash('sha256',$vnp_HashSecret . $hashData);
$Status = 0;
$orderId = $inputData['vnp_TxnRef'];
//
$vnp_Amount = $inputData['vnp_Amount']; 
$vnp_Amount = (int)$vnp_Amount / 100;


try {
    // checksum
    if ($secureHash == $vnp_SecureHash) {
        $order = $d->rawQueryOne("select status_vnpay,tonggia from table_order where matour='".$orderId."' ");
        
        // check OrderId
        if (!empty($order)) {
            // check StatusMUPUOQ
        	if($order['tonggia'] == $vnp_Amount ){
            	
            	if ($order["status_vnpay"] == 0) {
                // check amount
                    if ($inputData['vnp_ResponseCode'] == '00') {
                        $Status = 1;
                        $d->reset();
                        $d->query("UPDATE table_order SET  status_vnpay= 1 WHERE matour ='".$orderId."' ");
                        
                        $returnData['RspCode'] = '00';
                        $returnData['Message'] = 'Confirm Success';
                    } else {
                        $Status = 2;
                        $d->reset();
                        $d->query("UPDATE table_order SET  status_vnpay= 2 WHERE matour ='".$orderId."' ");
                        
                        $returnData['RspCode'] = '00';
                        $returnData['Message'] = 'Confirm Success';
                    }
                
            } else {
                $returnData['RspCode'] = '02';
                $returnData['Message'] = 'Order already confirmed';
            }
            }
                else
                {
                    $returnData['RspCode'] = '04';
                    $returnData['Message'] = 'Invalid Amount';
                }
        } else {
            $returnData['RspCode'] = '01';
            $returnData['Message'] = 'Order not found';
        }
    } else {
        $returnData['RspCode'] = '97';
        $returnData['Message'] = 'Chu ky khong hop le';
    }
} catch (Exception $e) {
    $returnData['RspCode'] = '99';
    $returnData['Message'] = 'Unknow error';
}

echo json_encode($returnData);
exit();