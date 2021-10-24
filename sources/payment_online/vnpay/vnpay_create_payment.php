<?php  
if(!defined('SOURCES')) die("Error");

if(isset($_POST['submit-tour']))
{
    $responseCaptcha = $_POST['recaptcha_response_tour'];
    $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
    $scoreCaptcha = (isset($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
    $actionCaptcha = (isset($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
    $testCaptcha = (isset($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;

    if(($scoreCaptcha >= 0.5 && $actionCaptcha == 'booking-tour') || $testCaptcha == true)
    {
        /* Gán giá trị gửi email */
        $madonhang = strtoupper($func->stringRandom(6));
        $hoten = (isset($_POST['ten'])) ? htmlspecialchars($_POST['ten']) : '';
        $email = (isset($_POST['email'])) ? htmlspecialchars($_POST['email']) : '';
        $dienthoai = (isset($_POST['dienthoai'])) ? htmlspecialchars($_POST['dienthoai']) : '';
        $city = (isset($_POST['city'])) ? htmlspecialchars($_POST['city']) : 0;
        $district = (isset($_POST['district'])) ? htmlspecialchars($_POST['district']) : 0;
        $wards = (isset($_POST['wards'])) ? htmlspecialchars($_POST['wards']) : 0;
        $diachi = htmlspecialchars($_POST['diachi']);
        $httt = (isset($_POST['payments'])) ? htmlspecialchars($_POST['payments']) : 0;
        $htttText = ($httt) ? $func->get_payments($httt) : '';
        $noidung = (isset($_POST['noidung'])) ? htmlspecialchars($_POST['noidung']) : '';

        $id = (isset($_POST['idsp']) && $_POST['idsp'] > 0) ? htmlspecialchars($_POST['idsp']) : 0;
        $sotreem = (isset($_POST['treem']) && $_POST['treem'] > 0) ? htmlspecialchars($_POST['treem']) : 0;
        $songuoilon = (isset($_POST['nguoilon']) && $_POST['nguoilon'] > 0) ? htmlspecialchars($_POST['nguoilon']) : 0;
        $soembe = (isset($_POST['embe']) && $_POST['embe'] > 0) ? htmlspecialchars($_POST['embe']) : 0;
        $total = $func->getOrderTour($id,$sotreem,$songuoilon,$soembe);
        $ngaydangky = time();
        
        /* lưu tour */
        $data_donhang = array();
        $data_donhang['id_user'] = (isset($_SESSION[$login_member]['id'])) ? $_SESSION[$login_member]['id'] : 0;
        $data_donhang['matour'] = $madonhang;
        $data_donhang['hoten'] = $hoten;
        $data_donhang['dienthoai'] = $dienthoai;
        $data_donhang['diachi'] = $diachi;
        $data_donhang['email'] = $email;
        $data_donhang['httt'] = $httt;
        $data_donhang['phiship'] = (double)$ship;
        $data_donhang['tamtinh'] = $tamtinh;
        $data_donhang['tonggia'] = $total;
        $data_donhang['yeucaukhac'] = $noidung;
        $data_donhang['ngaytao'] = $ngaydangky;
        $data_donhang['tinhtrang'] = 1;
        $data_donhang['city'] = $city;
        $data_donhang['district'] = $district;
        $data_donhang['wards'] = $wards;
        $data_donhang['status_vnpay'] = 0;
        $data_donhang['stt'] = 1;
        $id_insert = $d->insert('booktour',$data_donhang);

        /* lưu tour chi tiết */
        if($id_insert)
        {
            $pid = $id;
            $q_treem = $sotreem;
            $q_nguoilon = $songuoilon;
            $q_embe = $soembe;
            $proinfo = $cart->get_product_info($pid);
            $gianguoilon = $proinfo['gianguoilon'];
            $giatreem = $proinfo['giatreem'];
            $giaembe = $proinfo['giaembe'];
            $chiphikhac = $proinfo['chiphikhac'];
            $phuthuphongdon = $proinfo['phuthuphongdon'];

            $data_donhangchitiet = array();
            $data_donhangchitiet['id_product'] = $pid;
            $data_donhangchitiet['id_booktour'] = $id_insert;
            $data_donhangchitiet['photo'] = $proinfo['photo'];
            $data_donhangchitiet['ten'] = $proinfo['ten'.$lang];
            $data_donhangchitiet['gianguoilon'] = $gianguoilon;
            $data_donhangchitiet['giatreem'] = $giatreem;
            $data_donhangchitiet['giaembe'] = $giaembe;
            $data_donhangchitiet['chiphikhac'] = $chiphikhac;
            $data_donhangchitiet['phuthuphongdon'] = $phuthuphongdon;
            $data_donhangchitiet['sotreem'] = $q_treem;
            $data_donhangchitiet['soembe'] = $q_embe;
            $data_donhangchitiet['songuoilon'] = $q_nguoilon;
            $d->insert('booktour_detail',$data_donhangchitiet);
        }
    }
}
$_SESSION['madonhang']=$mahoadon;
   
    


$vnp_TxnRef    = $madonhang; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
$vnp_OrderInfo = "Thanh toan don tour";
$vnp_OrderType = 'other';
$vnp_Amount    = $total * 100;
$vnp_Locale = "vn";
// if ($_SESSION['lang'] == 'vi') {
//     $vnp_Locale = "vn";
// } else {
//     $vnp_Locale = "en";
// }
$vnp_IpAddr   = $_SERVER['REMOTE_ADDR'];

$inputData = array(
    "vnp_Version" => "2.0.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef,
);

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}

ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . $key . "=" . $value;
    } else {
        $hashdata .= $key . "=" . $value;
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
    $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
    $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
}
// $returnData = array(
//     'code' => '00',
//     'message' => 'success',
//     'data' => $vnp_Url
// );
redirect($vnp_Url);