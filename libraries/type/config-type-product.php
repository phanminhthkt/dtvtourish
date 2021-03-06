<?php
    /* Tour */
    $nametype = "tour";
    $config['product'][$nametype]['title_main'] = "Tour";
    $config['product'][$nametype]['dropdown'] = true;
    $config['product'][$nametype]['list'] = true;
    $config['product'][$nametype]['cat'] = true;
    $config['product'][$nametype]['item'] = true;
    $config['product'][$nametype]['sub'] = false;
    $config['product'][$nametype]['brand'] = false;
    $config['product'][$nametype]['mau'] = false;
    $config['product'][$nametype]['size'] = false;
    $config['product'][$nametype]['tags'] = false;
    $config['product'][$nametype]['import'] = false;
    $config['product'][$nametype]['export'] = false;
    $config['product'][$nametype]['view'] = true;
    $config['product'][$nametype]['copy'] = true;
    $config['product'][$nametype]['copy_image'] = true;
    $config['product'][$nametype]['slug'] = true;
    $config['product'][$nametype]['check'] = array("noibat"=>"Nổi bật","noibat1"=>"Khuyến mãi");
    $config['product'][$nametype]['images'] = true;
    $config['product'][$nametype]['show_images'] = true;
    $config['product'][$nametype]['gallery'] = array
    (
        $nametype => array
        (
            "title_main_photo" => "Hình ảnh tour",
            "title_sub_photo" => "Hình ảnh",
            "number_photo" => 3,
            "images_photo" => true,
            "cart_photo" => false,
            "avatar_photo" => true,
            "tieude_photo" => true,
            "width_photo" => 570,
            "height_photo" => 460,
            "thumb_photo" => '100x100x1',
            "img_type_photo" => '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF'
        ),
    );
    $config['product'][$nametype]['ma'] = true;
    $config['product'][$nametype]['gianguoilon'] = true;
    $config['product'][$nametype]['giatreem'] = true;
    $config['product'][$nametype]['giaembe'] = true;
    $config['product'][$nametype]['phuthuphongdon'] = true;
    $config['product'][$nametype]['chiphikhac'] = true;
    $config['product'][$nametype]['phuongtien'] = true;
    $config['product'][$nametype]['ngaykhoihanh'] = true;
    $config['product'][$nametype]['phuongtien'] = true;
    $config['product'][$nametype]['thongtinhotro'] = true;
    $config['product'][$nametype]['khoihanh'] = true;
    $config['product'][$nametype]['noiden'] = true;
    $config['product'][$nametype]['songaydi'] = true;
    $config['product'][$nametype]['socho'] = true;
    $config['product'][$nametype]['gia'] = false;
    $config['product'][$nametype]['giamoi'] = false;
    $config['product'][$nametype]['giacu'] = false;
    $config['product'][$nametype]['giakm'] = false;
    $config['product'][$nametype]['mota'] = true;
    $config['product'][$nametype]['mota_cke'] = false;
    $config['product'][$nametype]['noidung'] = false;
    $config['product'][$nametype]['noidung_cke'] = false;
    $config['product'][$nametype]['lichtrinh'] = true;
    $config['product'][$nametype]['lichtrinh_cke'] = true;
    $config['product'][$nametype]['quydinh'] = true;
    $config['product'][$nametype]['quydinh_cke'] = true;
    
    $config['product'][$nametype]['seo'] = true;
    $config['product'][$nametype]['width'] = 285;
    $config['product'][$nametype]['height'] = 230;
    $config['product'][$nametype]['thumb'] = '285x230x1';
    $config['product'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

    /* Sản phẩm (Màu) */
    // $config['product'][$nametype]['mau_images'] = true;
    // $config['product'][$nametype]['mau_mau'] = true;
    // $config['product'][$nametype]['mau_loai'] = true;
    // $config['product'][$nametype]['width_mau'] = 30;
    // $config['product'][$nametype]['height_mau'] = 30;
    // $config['product'][$nametype]['thumb_mau'] = '100x100x1';
    // $config['product'][$nametype]['img_type_mau'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

    /* Sản phẩm (List) */
    $config['product'][$nametype]['title_main_list'] = "Sản phẩm cấp 1";
    $config['product'][$nametype]['images_list'] = false;
    // $config['product'][$nametype]['icon_list'] = true;
    $config['product'][$nametype]['show_images_list'] = false;
    $config['product'][$nametype]['slug_list'] = true;
    $config['product'][$nametype]['check_list'] = array('noibat'=>"Nổi bật",'noibat1'=>"Menu");
    // $config['product'][$nametype]['gallery_list'] = array
    // (
    //     $nametype => array
    //     (
    //         "title_main_photo" => "Hình ảnh sản phẩm cấp 1",
    //         "title_sub_photo" => "Hình ảnh",
    //         "number_photo" => 2,
    //         "images_photo" => true,
    //         "avatar_photo" => true,
    //         "tieude_photo" => true,
    //         "width_photo" => 300,
    //         "height_photo" => 200,
    //         "thumb_photo" => '100x100x1',
    //         "img_type_photo" => '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF',
    //     ),
    //     "video" => array
    //     (
    //         "title_main_photo" => "Video sản phẩm cấp 1",
    //         "title_sub_photo" => "Video",
    //         "number_photo" => 2,
    //         "video_photo" => true,
    //         "tieude_photo" => true
    //     )
    // );
    $config['product'][$nametype]['mota_list'] = false;
    $config['product'][$nametype]['seo_list'] = true;
    $config['product'][$nametype]['width_list'] = 300;
    $config['product'][$nametype]['height_list'] = 230;
    $config['product'][$nametype]['width_icon_list'] = 33;
    $config['product'][$nametype]['height_icon_list'] = 33;
    $config['product'][$nametype]['thumb_list'] = '300x230x1';
    $config['product'][$nametype]['img_type_list'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

    /* Sản phẩm (Cat) */
    $config['product'][$nametype]['title_main_cat'] = "Sản phẩm cấp 2";
    $config['product'][$nametype]['images_cat'] = false;
    $config['product'][$nametype]['show_images_cat'] = false;
    $config['product'][$nametype]['slug_cat'] = true;
    $config['product'][$nametype]['check_cat'] = array("noibat"=>"Nổi bật");
    $config['product'][$nametype]['mota_cat'] = false;
    $config['product'][$nametype]['seo_cat'] = true;
    $config['product'][$nametype]['width_cat'] = 300;
    $config['product'][$nametype]['height_cat'] = 230;
    $config['product'][$nametype]['thumb_cat'] = '300x230x1';
    $config['product'][$nametype]['img_type_cat'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

    /* Sản phẩm (Item) */
    $config['product'][$nametype]['title_main_item'] = "Sản phẩm cấp 3";
    $config['product'][$nametype]['images_item'] = false;
    $config['product'][$nametype]['show_images_item'] = false;
    $config['product'][$nametype]['slug_item'] = true;
    $config['product'][$nametype]['check_item'] = array();
    $config['product'][$nametype]['mota_item'] = false;
    $config['product'][$nametype]['seo_item'] = true;
    $config['product'][$nametype]['width_item'] = 250;
    $config['product'][$nametype]['height_item'] = 250;
    $config['product'][$nametype]['thumb_item'] = '100x100x1';
    $config['product'][$nametype]['img_type_item'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

    /* Sản phẩm (Sub) */
    $config['product'][$nametype]['title_main_sub'] = "Sản phẩm cấp 4";
    $config['product'][$nametype]['images_sub'] = true;
    $config['product'][$nametype]['show_images_sub'] = true;
    $config['product'][$nametype]['slug_sub'] = true;
    $config['product'][$nametype]['check_sub'] = array("noibat" => "Nổi bật");
    $config['product'][$nametype]['mota_sub'] = true;
    $config['product'][$nametype]['seo_sub'] = true;
    $config['product'][$nametype]['width_sub'] = 300;
    $config['product'][$nametype]['height_sub'] = 200;
    $config['product'][$nametype]['thumb_sub'] = '100x100x1';
    $config['product'][$nametype]['img_type_sub'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

    /* Sản phẩm (Hãng) */
    $config['product'][$nametype]['title_main_brand'] = "Hãng sản phẩm";
    $config['product'][$nametype]['images_brand'] = true;
    $config['product'][$nametype]['show_images_brand'] = true;
    $config['product'][$nametype]['slug_brand'] = true;
    $config['product'][$nametype]['check_brand'] = array("noibat" => "Nổi bật");
    $config['product'][$nametype]['seo_brand'] = true;
    $config['product'][$nametype]['width_brand'] = 150;
    $config['product'][$nametype]['height_brand'] = 150;
    $config['product'][$nametype]['thumb_brand'] = '100x100x1';
    $config['product'][$nametype]['img_type_brand'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

    /* Thư viện ảnh */
    $nametype = "thu-vien-anh";
    $config['product'][$nametype]['title_main'] = "Thư viện ảnh";
    $config['product'][$nametype]['check'] = array();
    $config['product'][$nametype]['view'] = true;
    $config['product'][$nametype]['slug'] = true;
    $config['product'][$nametype]['copy'] = false;
    $config['product'][$nametype]['copy_image'] = false;
    $config['product'][$nametype]['images'] = true;
    $config['product'][$nametype]['show_images'] = true;
    $config['product'][$nametype]['check'] = array("noibat" => "Nổi bật");
    $config['product'][$nametype]['gallery'] = array
    (
        $nametype => array
        (
            "title_main_photo" => "Hình ảnh thư viện ảnh",
            "title_sub_photo" => "Hình ảnh",
            "number_photo" => 2,
            "images_photo" => true,
            "avatar_photo" => true,
            "tieude_photo" => true,
            "width_photo" => 550,
            "height_photo" => 330,
            "thumb_photo" => '100x100x1',
            "img_type_photo" => '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF'
        )
    );
    $config['product'][$nametype]['seo'] = true;
    $config['product'][$nametype]['width'] = 550;
    $config['product'][$nametype]['height'] = 330;
    $config['product'][$nametype]['thumb'] = '550x330x1';
    $config['product'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
?>