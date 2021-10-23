<?php  
	if(!defined('SOURCES')) die("Error");

	$popup = $d->rawQueryOne("select ten$lang, photo, link, hienthi from #_photo where type = ? and act = ? limit 0,1",array('popup','photo_static'));

    $slogan = $d->rawQueryOne("select ten$lang from #_static where type = ? limit 0,1",array('slogan'));
    
    $about_index = $d->rawQueryOne("select ten$lang,mota$lang,photo from #_static where type = ? limit 0,1",array('gioi-thieu'));

    $splistnb = $d->rawQuery("select ten$lang,mota$lang, tenkhongdauvi, tenkhongdauen, id,photo from #_product_list where type = ? and noibat > 0 and hienthi > 0 order by stt,id desc",array('tour'));
    
    $album_index = $d->rawQuery("select ten$lang, photo,tenkhongdauvi from #_product where type = ? and hienthi > 0  and noibat > 0 order by stt,id desc",array('thu-vien-anh'));

    $criteria = $d->rawQuery("select ten$lang, photo, link from #_photo where type = ? and hienthi > 0 order by stt,id desc",array('tieubieu'));

    $newsnb = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, mota$lang, ngaytao, id, photo from #_news where type = ? and noibat > 0 and hienthi > 0 order by stt,id desc",array('tin-tuc'));
    
    $service_nb = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, mota$lang, ngaytao, id, photo from #_news where type = ? and hienthi > 0 and noibat > 0 order by stt,id asc limit 5",array('dich-vu'));

    $videonb = $d->rawQuery("select id,ten$lang,link_video,photo from #_photo where noibat > 0 and type = ? and hienthi > 0",array('video'));

    $partner = $d->rawQuery("select ten$lang, photo, link from #_photo where type = ? and hienthi > 0 order by stt,id desc",array('partner'));

    /* SEO */
    $seoDB = $seo->getSeoDB(0,'setting','capnhat','setting');
    $seo->setSeo('h1',$seoDB['title'.$seolang]);
    $seo->setSeo('title',$seoDB['title'.$seolang]);
    $seo->setSeo('keywords',$seoDB['keywords'.$seolang]);
    $seo->setSeo('description',$seoDB['description'.$seolang]);
    $seo->setSeo('url',$func->getPageURL());
    $img_json_bar = (isset($logo['options']) && $logo['options'] != '') ? json_decode($logo['options'],true) : null;
    if($img_json_bar['p'] != $logo['photo'])
    {
        $img_json_bar = $func->getImgSize($logo['photo'],UPLOAD_PHOTO_L.$logo['photo']);
        $seo->updateSeoDB(json_encode($img_json_bar),'photo',$logo['id']);
    }
    $seo->setSeo('photo',$config_base.THUMBS.'/'.$img_json_bar['w'].'x'.$img_json_bar['h'].'x2/'.UPLOAD_PHOTO_L.$logo['photo']);
    $seo->setSeo('photo:width',$img_json_bar['w']);
    $seo->setSeo('photo:height',$img_json_bar['h']);
    $seo->setSeo('photo:type',$img_json_bar['m']);
?>