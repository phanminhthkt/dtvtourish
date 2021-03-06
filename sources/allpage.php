<?php
    if(!defined('SOURCES')) die("Error");

    /* Query allpage */
    $favicon = $d->rawQueryOne("select photo from #_photo where type = ? and act = ? and hienthi > 0 limit 0,1",array('favicon','photo_static'));
    
    $logo = $d->rawQueryOne("select id, photo from #_photo where type = ? and act = ? limit 0,1",array('logo','photo_static'));
    $bct = $d->rawQueryOne("select id, photo,hienthi,link from #_photo where type = ? and act = ? limit 0,1",array('bct','photo_static'));

    $banner = $d->rawQueryOne("select id, photo from #_photo where type = ? and act = ? limit 0,1",array('banner','photo_static'));

    $slogan = $d->rawQueryOne("select ten$lang from #_static where type = ? limit 0,1",array('slogan'));

    $slider = $d->rawQuery("select ten$lang, photo, link from #_photo where type = ? and hienthi > 0 order by stt,id desc",array('slide'));
    

    $footer = $d->rawQueryOne("select ten$lang, noidung$lang from #_static where type = ? limit 0,1",array('footer'));
    
    

    $splistmenu = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, id from #_product_list where type = ? and hienthi > 0 and noibat1 > 0 order by stt,id asc",array('tour'));

    $kdlistmenu = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, id from #_news_list where type = ? and hienthi > 0 order by stt,id asc",array('khach-doan'));

    $hdvlistmenu = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, id from #_news_list where type = ? and hienthi > 0 order by stt,id asc",array('huong-dan-vien'));

    $dvlistmenu = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, id from #_news_list where type = ? and hienthi > 0 order by stt,id asc",array('dich-vu'));

    $cs = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, id, photo from #_news where type = ? and hienthi > 0 order by stt,id desc",array('chinh-sach'));

    $social = $d->rawQuery("select ten$lang, photo, link from #_photo where type = ? and hienthi > 0 order by stt,id desc",array('mangxahoi'));
    $social_top = $d->rawQuery("select ten$lang, photo, link from #_photo where type = ? and hienthi > 0 order by stt,id desc",array('mangxahoitop'));
    $social_footer = $d->rawQuery("select ten$lang, photo, link from #_photo where type = ? and hienthi > 0 order by stt,id desc",array('mangxahoifooter'));
    /* Get statistic */
    $counter = $statistic->getCounter();
    $online = $statistic->getOnline();

    /* Newsletter */
    if(isset($_POST['submit-newsletter']) && !isset($_POST['type-newsletter']))
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
            $data['ten'] = (isset($_REQUEST['name-newsletter']) && $_REQUEST['name-newsletter'] != '') ? htmlspecialchars($_REQUEST['name-newsletter']) : '';
            $data['diachi'] = (isset($_REQUEST['address-newsletter']) && $_REQUEST['address-newsletter'] != '') ? htmlspecialchars($_REQUEST['address-newsletter']) : '';
            $data['dienthoai'] = (isset($_REQUEST['phone-newsletter']) && $_REQUEST['phone-newsletter'] != '') ? htmlspecialchars($_REQUEST['phone-newsletter']) : '';
            $data['noidung'] = (isset($_REQUEST['noidung-newsletter']) && $_REQUEST['noidung-newsletter'] != '') ? htmlspecialchars($_REQUEST['noidung-newsletter']) : '';
            $data['ngaytao'] = time();
            $data['type'] = 'dangkynhantin';

            if($d->insert('newsletter',$data))
            {
                $func->transfer("????ng k?? nh???n tin th??nh c??ng. Ch??ng t??i s??? li??n h??? v???i b???n s???m.",$config_base);
            }
            else
            {
                $func->transfer("????ng k?? nh???n tin th???t b???i. Vui l??ng th??? l???i sau.",$config_base, false);
            }
        }
        else
        {
            $func->transfer("????ng k?? nh???n tin th???t b???i. Vui l??ng th??? l???i sau.",$config_base, false);
        }
    }
?>