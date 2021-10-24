<?php
if(!isset($_SESSION['madonhang'])){
    $func->transfer('Bạn chưa có đơn hàng nào.', "index.php",false);
}
if($_SERVER["REQUEST_METHOD"] == 'GET'){
    $txt_return = $_SERVER["REQUEST_URI"];
    $txt_return = str_replace("/vnpay-return?", "", $txt_return);
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
$vnp_SecureHash = $bill['vnp_SecureHash'];

$madonhang=$bill['vnp_TxnRef'];

$inputData = array();
foreach ($bill as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}

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
$secureHash = hash('sha256',$vnp_HashSecret . $hashData);
if ($bill['vnp_ResponseCode'] == '00') {
    $result = _giaodichthanhcong;

    $code_order = $bill['vnp_TxnRef'];
    $order = $d->rawQueryOne("select * from #_booktour where matour = '".$code_order."'");
    $order_detail = $d->rawQueryOne("select * from #_booktour_detail where id_order = '".$order['id']."'");

    $email = $order['email'];
    $diachi = $order['diachi'];
    $hoten = $order['hoten'];
    $dienthoai = $order['dienthoai'];
    $tonggia = $order['tonggia'];
    $noidung = $order['noidung'];
}else{
   $func->transfer('Đặt hàng lỗi', "index.php",false);
}
    $order = $d->rawQueryOne("select * from table_booktour where madonhang='".$bill['vnp_TxnRef']."' ");
    $order_detail = $d->rawQueryOne("select * from table_booktour_detail where id_booktour='".$order['id']."' ");
    $chitietdonhang = '';

    $pid = $order_detail['id_product'];
    $q_treem = $order_detail['sotreem'];
    $q_nguoilon = $order_detail['songuoilon'];
    $q_embe = $order_detail['soembe'];
    $proinfo = $cart->get_product_info($pid);
    $gianguoilon = (double)$order_detail['gianguoilon'];
    $giatreem = (double)$order_detail['giatreem'];
    $giaembe = (double)$order_detail['giaembe'];
    
    $chiphikhac = (double)$order_detail['chiphikhac'];
    $phuthuphongdon = (double)$order_detail['phuthuphongdon'];
    $chitietdonhang.='<tbody bgcolor="';
    $chitietdonhang.='#e6e6e6';

    $chitietdonhang.='" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px"><tr>';
    $chitietdonhang.='<td align="left" style="padding:3px 9px" valign="middle">';
    $chitietdonhang.='<span style="display:block;font-weight:bold">'.$order_detail['ten'.$lang].'</span>';
    if($textsm!='') $chitietdonhang.='<span style="display:block;font-size:12px">'.$textsm.'</span>';
    $chitietdonhang.='</td>';
    
    $chitietdonhang.='<td align="left" style="padding:3px 9px" valign="top">';
    $chitietdonhang.='<span style="display:block;color:#004eff;">Người lớn: '.$func->format_money($order_detail['gianguoilon'],' đ').' x '.$songuoilon.'</span>';
    $chitietdonhang.='<span style="display:block;color:#004eff;">Trẻ em: '.$func->format_money($order_detail['giatreem'],' đ').' x '.$sotreem.'</span>';
    $chitietdonhang.='<span style="display:block;color:#004eff;">Em bé: '.$func->format_money($order_detail['giaembe'],' đ').' x '.$soembe.'</span>';
    $chitietdonhang.='<span style="display:block;color:#004eff;">Phụ thu phòng dọn: '.$func->format_money($order_detail['phuthuphongdon'],' đ').'</span>';
    $chitietdonhang.='<span style="display:block;color:#004eff;">Chi phí khác: '.$func->format_money($order_detail['chiphikhac'],' đ').'</span>';
    $chitietdonhang.='</td>';
    
    $chitietdonhang.='<td align="right" style="padding:3px 9px" valign="center"><span style="color:#ff0000;font-weight:bold;font-size:14px;">'.$func->format_money($total).'</span></td>';
    $chitietdonhang.='</tr></tbody>';

$chitietdonhang.='<tfoot style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">';
    $chitietdonhang.='
    <tr bgcolor="#eee">
        <td align="right" colspan="2" style="padding:7px 9px"><strong><big>Tổng giá trị tour</big> </strong></td>
        <td align="right" style="padding:7px 9px"><strong><big><span>'.$func->format_money($total).'</span> </big> </strong></td>
    </tr>
</tfoot>';

/* Nội dung gửi email cho admin */
$contentAdmin = '
<table align="center" bgcolor="#dcf0f8" border="0" cellpadding="0" cellspacing="0" style="margin:0;padding:0;background-color:#f2f2f2;width:100%!important;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px" width="100%">
    <tbody>
        <tr>
            <td align="center" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" style="margin-top:15px" width="600">
                    <tbody>
                        <tr>
                            <td align="center" id="m_-6357629121201466163headerImage" valign="bottom">
                                <table cellpadding="0" cellspacing="0" style="border-bottom:3px solid '.$emailer->getEmail('color').';padding-bottom:10px;background-color:#fff" width="100%">
                                    <tbody>
                                        <tr>
                                            <td bgcolor="#FFFFFF" style="padding:0" valign="top" width="100%">
                                                <div style="color:#fff;background-color:f2f2f2;font-size:11px">&nbsp;</div>
                                                <div style="display:flex;justify-content:space-between;align-items:center;">
                                                    <table style="width:100%;">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <a href="'.$emailer->getEmail('home').'" style="border:medium none;text-decoration:none;color:#007ed3;margin:0px 0px 0px 20px" target="_blank">'.$emailer->getEmail('logo').'</a>
                                                                </td>
                                                                <td style="padding:15px 20px 0 0;text-align:right">'.$emailer->getEmail('social').'</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr style="background:#fff">
                            <td align="left" height="auto" style="padding:15px" width="600">
                                <table style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h1 style="font-size:17px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">Kính chào</h1>
                                                <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">Quý khách nhận được thông tin đặt tour tại website '.$emailer->getEmail('company:website').'</p>
                                                <h3 style="font-size:13px;font-weight:bold;color:'.$emailer->getEmail('color').';text-transform:uppercase;margin:20px 0 0 0;padding: 0 0 5px;border-bottom:1px solid #ddd">Thông tin tour #'.$madonhang.' <span style="font-size:12px;color:#777;text-transform:none;font-weight:normal">(Ngày '.date('d',$emailer->getEmail('datesend')).' tháng '.date('m',$emailer->getEmail('datesend')).' năm '.date('Y H:i:s',$emailer->getEmail('datesend')).')</span></h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th align="left" style="padding:6px 9px 0px 0px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold" width="50%">Thông tin thanh toán</th>
                                                        <th align="left" style="padding:6px 0px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold" width="50%">Địa chỉ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="padding:3px 9px 9px 0px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top"><span style="text-transform:capitalize">'.$hoten.'</span><br>
                                                        <a href="mailto:'.$email.'" target="_blank">'.$email.'</a><br>
                                                        '.$dienthoai.'</td>
                                                        <td style="padding:3px 0px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top"><span style="text-transform:capitalize">'.$hoten.'</span><br>
                                                         <a href="mailto:'.$email.'" target="_blank">'.$email.'</a><br>
                                                        '.$diachi.'<br>
                                                         Tel: '.$dienthoai.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="padding:7px 0px 0px 0px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444" valign="top">
                                                        <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><strong>Hình thức thanh toán: </strong> Thanh toán online';
                                                        if($ship)
                                                        {
                                                            $contentAdmin.='<br><strong>Phí vận chuyển: </strong> '.$func->format_money($ship);
                                                        }
                                                        $contentAdmin.='</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><strong>Nội dung:</strong> <i>'.$noidung.'</i></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <h2 style="text-align:left;margin:10px 0;border-bottom:1px solid #ddd;padding-bottom:5px;font-size:13px;color:'.$emailer->getEmail('color').'">Tour của bạn</h2>
                                            <table border="0" cellpadding="0" cellspacing="0" style="background:#f5f5f5" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th align="left" bgcolor="'.$emailer->getEmail('color').'" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Tên tour</th>
                                                        <th align="left" bgcolor="'.$emailer->getEmail('color').'" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Giá x Số lượng</th>
                                                        <th align="right" bgcolor="'.$emailer->getEmail('color').'" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Tổng tạm</th>
                                                    </tr>
                                                </thead>
                                                '.$chitietdonhang.'
                                            </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;margin-top:10px;text-align:right"><strong><a href="'.$emailer->getEmail('home').'" style="color:'.$emailer->getEmail('color').';text-decoration:none;font-size:14px" target="_blank">'.$emailer->getEmail('company').'</a> </strong></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                </tbody>
            </table>
            </td>
        </tr>
        <tr>
            <td align="center">
            <table width="600">
                <tbody>
                    <tr>
                        <td>
                        <p align="left" style="font-family:Arial,Helvetica,sans-serif;font-size:11px;line-height:18px;color:#4b8da5;padding:10px 0;margin:0px;font-weight:normal">Quý khách nhận được email này vì đã mua tour tại '.$emailer->getEmail('company:website').'.<br>
                        Để chắc chắn luôn nhận được email thông báo, xác nhận mua tour từ '.$emailer->getEmail('company:website').', quý khách vui lòng thêm địa chỉ <strong><a href="mailto:'.$emailer->getEmail('email').'" target="_blank">'.$emailer->getEmail('email').'</a></strong> vào số địa chỉ (Address Book, Contacts) của hộp email.<br>
                        <b>Địa chỉ:</b> '.$emailer->getEmail('company:address').'</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
    </tbody>
</table>';

/* Nội dung gửi email cho khách hàng */
$contentCustomer = '
<table align="center" bgcolor="#dcf0f8" border="0" cellpadding="0" cellspacing="0" style="margin:0;padding:0;background-color:#f2f2f2;width:100%!important;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px" width="100%">
    <tbody>
        <tr>
            <td align="center" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" style="margin-top:15px" width="600">
                    <tbody>
                        <tr>
                            <td align="center" id="m_-6357629121201466163headerImage" valign="bottom">
                                <table cellpadding="0" cellspacing="0" style="border-bottom:3px solid '.$emailer->getEmail('color').';padding-bottom:10px;background-color:#fff" width="100%">
                                    <tbody>
                                        <tr>
                                            <td bgcolor="#FFFFFF" style="padding:0" valign="top" width="100%">
                                                <div style="color:#fff;background-color:f2f2f2;font-size:11px">&nbsp;</div>
                                                <div style="display:flex;justify-content:space-between;align-items:center;">
                                                    <table style="width:100%;">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <a href="'.$emailer->getEmail('home').'" style="border:medium none;text-decoration:none;color:#007ed3;margin:0px 0px 0px 20px" target="_blank">'.$emailer->getEmail('logo').'</a>
                                                                </td>
                                                                <td style="padding:15px 20px 0 0;text-align:right">'.$emailer->getEmail('social').'</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr style="background:#fff">
                            <td align="left" height="auto" style="padding:15px" width="600">
                                <table style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h1 style="font-size:17px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">Cảm ơn quý khách đã đặt tour tại '.$emailer->getEmail('company:website').'</h1>
                                                <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">Chúng tôi rất vui thông báo tour #'.$madonhang.' của quý khách đã được tiếp nhận và đang trong quá trình xử lý.</p>
                                                <h3 style="font-size:13px;font-weight:bold;color:'.$emailer->getEmail('color').';text-transform:uppercase;margin:20px 0 0 0;padding: 0 0 5px;border-bottom:1px solid #ddd">Thông tin tour #'.$madonhang.' <span style="font-size:12px;color:#777;text-transform:none;font-weight:normal">(Ngày '.date('d',$emailer->getEmail('datesend')).' tháng '.date('m',$emailer->getEmail('datesend')).' năm '.date('Y H:i:s',$emailer->getEmail('datesend')).')</span></h3>
                                            </td>
                                        </tr>
                                    <tr>
                                    <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th align="left" style="padding:6px 9px 0px 0px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold" width="50%">Thông tin thanh toán</th>
                                                <th align="left" style="padding:6px 0px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold" width="50%">Địa chỉ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="padding:3px 9px 9px 0px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top"><span style="text-transform:capitalize">'.$hoten.'</span><br>
                                                <a href="mailto:'.$email.'" target="_blank">'.$email.'</a><br>
                                                '.$dienthoai.'</td>
                                                <td style="padding:3px 0px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top"><span style="text-transform:capitalize">'.$hoten.'</span><br>
                                                 <a href="mailto:'.$email.'" target="_blank">'.$email.'</a><br>
                                                '.$diachi.'<br>
                                                 Tel: '.$dienthoai.'</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding:7px 0px 0px 0px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444" valign="top">
                                                <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><strong>Hình thức thanh toán: </strong> Thanh toán online';
                                                if($ship)
                                                {
                                                    $contentCustomer.='<br><strong>Phí vận chuyển: </strong> '.$func->format_money($ship);
                                                }
                                                $contentCustomer.='</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><strong>Nội dung:</strong> <i>'.$noidung.'</i></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <h2 style="text-align:left;margin:10px 0;border-bottom:1px solid #ddd;padding-bottom:5px;font-size:13px;color:'.$emailer->getEmail('color').'">Tour của bạn</h2>

                                    <table border="0" cellpadding="0" cellspacing="0" style="background:#f5f5f5" width="100%">
                                        <thead>
                                            <tr>
                                                <th align="left" bgcolor="'.$emailer->getEmail('color').'" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Tên tour</th>
                                                <th align="left" bgcolor="'.$emailer->getEmail('color').'" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Giá người lớn</th>
                                                <th align="right" bgcolor="'.$emailer->getEmail('color').'" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Tổng tạm</th>
                                            </tr>
                                        </thead>
                                        '.$chitietdonhang.'
                                    </table>
                                    <div style="margin:auto;text-align:center"><a href="'.$emailer->getEmail('home').'" style="display:inline-block;text-decoration:none;background-color:'.$emailer->getEmail('color').'!important;text-align:center;border-radius:3px;color:#fff;padding:5px 10px;font-size:12px;font-weight:bold;margin-top:5px" target="_blank">Tour của bạn tại '.$emailer->getEmail('company:website').'</a></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;
                                        <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;border:1px '.$emailer->getEmail('color').' dashed;padding:10px;list-style-type:none">Bạn cần được hỗ trợ ngay? Chỉ cần gửi mail về <a href="mailto:'.$emailer->getEmail('company:email').'" style="color:'.$emailer->getEmail('color').';text-decoration:none" target="_blank"> <strong>'.$emailer->getEmail('company:email').'</strong> </a>, hoặc gọi về hotline <strong style="color:'.$emailer->getEmail('color').'">'.$emailer->getEmail('company:hotline').'</strong> '.$emailer->getEmail('company:worktime').'. '.$emailer->getEmail('company:website').' luôn sẵn sàng hỗ trợ bạn bất kì lúc nào.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;
                                    <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;line-height:18px;color:#444;font-weight:bold">Một lần nữa '.$emailer->getEmail('company:website').' cảm ơn quý khách.</p>
                                    <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;text-align:right"><strong><a href="'.$emailer->getEmail('home').'" style="color:'.$emailer->getEmail('color').';text-decoration:none;font-size:14px" target="_blank">'.$emailer->getEmail('company').'</a> </strong></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
        <tr>
            <td align="center">
            <table width="600">
                <tbody>
                    <tr>
                        <td>
                        <p align="left" style="font-family:Arial,Helvetica,sans-serif;font-size:11px;line-height:18px;color:#4b8da5;padding:10px 0;margin:0px;font-weight:normal">Quý khách nhận được email này vì đã mua hàng tại '.$emailer->getEmail('company:website').'.<br>
                        Để chắc chắn luôn nhận được email thông báo, xác nhận mua hàng từ '.$emailer->getEmail('company:website').', quý khách vui lòng thêm địa chỉ <strong><a href="mailto:'.$emailer->getEmail('email').'" target="_blank">'.$emailer->getEmail('email').'</a></strong> vào số địa chỉ (Address Book, Contacts) của hộp email.<br>
                        <b>Địa chỉ:</b> '.$emailer->getEmail('company:address').'</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
    </tbody>
</table>';
    if ($bill['vnp_ResponseCode'] == '00') {
        $result = _giaodichthanhcong;
        unset($_SESSION['madonhang']);
        $arrayEmail = null;
        $subject = "Thông tin tour từ ".$setting['ten'.$lang];
        $message = $contentAdmin;
        $file = '';
        $emailer->sendEmail("admin", $arrayEmail, $subject, $message, $file);

        /* Send email customer */
        $arrayEmail = array(
            "dataEmail" => array(
                "name" => $hoten,
                "email" => $email
            )
        );
        $subject = "Thông tin tour từ ".$setting['ten'.$lang];
        $message = $contentCustomer;
        $file = '';
        $emailer->sendEmail("customer", $arrayEmail, $subject, $message, $file);
    }else{
        $func->transfer('Đặt hàng lỗi', "index.php",false);
    }
    

?>