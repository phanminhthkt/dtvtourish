<?php 
	if(!defined('SOURCES')) die("Error");

	if(isset($_POST['submit-newsletter']))
    {
        $responseCaptcha = $_POST['recaptcha_response_newsletter'];
        $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
        $scoreCaptcha = (isset($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
        $actionCaptcha = (isset($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
        $testCaptcha = (isset($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;

        if(($scoreCaptcha >= 0.5 && $actionCaptcha == 'Newsletter') || $testCaptcha == true)
        {
            $data = array();
            $data['email'] = (isset($_REQUEST['email-newsletter']) && $_REQUEST['email-newsletter'] != '') ? htmlspecialchars($_REQUEST['email-newsletter']) : '';
            $data['chude'] = (isset($_REQUEST['topic-newsletter']) && $_REQUEST['topic-newsletter'] != '') ? htmlspecialchars($_REQUEST['topic-newsletter']) : '';
            $data['ten'] = (isset($_REQUEST['name-newsletter']) && $_REQUEST['name-newsletter'] != '') ? htmlspecialchars($_REQUEST['name-newsletter']) : '';
            $data['diachi'] = (isset($_REQUEST['address-newsletter']) && $_REQUEST['address-newsletter'] != '') ? htmlspecialchars($_REQUEST['address-newsletter']) : '';
            $data['dienthoai'] = (isset($_REQUEST['phone-newsletter']) && $_REQUEST['phone-newsletter'] != '') ? htmlspecialchars($_REQUEST['phone-newsletter']) : '';
            $data['noidung'] = (isset($_REQUEST['noidung-newsletter']) && $_REQUEST['noidung-newsletter'] != '') ? htmlspecialchars($_REQUEST['noidung-newsletter']) : '';
            $data['ngaytao'] = time();
            $data['type'] = (isset($_REQUEST['type-newsletter']) && $_REQUEST['type-newsletter'] != '') ? htmlspecialchars($_REQUEST['type-newsletter']) : 'dangkynhantin';
            if($d->insert('newsletter',$data))
            {
                $func->transfer("Thông tin gửi thành công. Chúng tôi sẽ liên hệ với bạn sớm.",$config_base);
            }
            else
            {
                $func->transfer("Thông tin gửi thất bại. Vui lòng thử lại sau.",$config_base, false);
            }
        }
        else
        {
            $func->transfer("Thông tin gửi thất bại. Vui lòng thử lại sau.",$config_base, false);
        }
    }
?>