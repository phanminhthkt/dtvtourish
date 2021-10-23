<?php
	/* Check HTTP */
	$func->checkHTTP($http,$config['arrayDomainSSL'],$config_base,$config_url);

	/* Validate URL */
	$func->checkUrl($config['website']['index']);

	/* Check login */
    $func->checkLogin();

	/* Mobile detect */
    $deviceType = ($detect->isMobile() || $detect->isTablet()) ? 'mobile' : 'computer';
    if($deviceType == 'computer') define('TEMPLATE','./templates/');
    // else define('TEMPLATE','./templates-mobile/');
    else define('TEMPLATE','./templates/');

    /* Watermark */
    $wtmPro = $d->rawQueryOne("select hienthi, photo, options from #_photo where type = ? and act = ? limit 0,1",array('watermark','photo_static'));
	$wtmNews = $d->rawQueryOne("select hienthi, photo, options from #_photo where type = ? and act = ? limit 0,1",array('watermark-news','photo_static'));

    /* Router */
    $router->setBasePath($config['database']['url']);
    $router->map('GET',array('admin/','admin'), function(){
		global $func, $config;
		$func->redirect($config['database']['url']."admin/index.php");
		exit;
	});
	$router->map('GET',array('admin','admin'), function(){
		global $func, $config;
		$func->redirect($config['database']['url']."admin/index.php");
		exit;
	});
    $router->map('GET|POST', '', 'index', 'home');
    $router->map('GET|POST', 'index.php', 'index', 'index');
    $router->map('GET|POST', 'sitemap.xml', 'sitemap', 'sitemap');
    $router->map('GET|POST', '[a:com]', 'allpage', 'show');
    $router->map('GET|POST', '[a:com]/[a:lang]/', 'allpagelang', 'lang');
    $router->map('GET|POST', '[a:com]/[a:action]', 'account', 'account');
    $router->map('GET', THUMBS.'/[i:w]x[i:h]x[i:z]/[**:src]', function($w,$h,$z,$src){
        global $func;
        $func->createThumb($w,$h,$z,$src,null,THUMBS);
    },'thumb');
    $router->map('GET', WATERMARK.'/product/[i:w]x[i:h]x[i:z]/[**:src]', function($w,$h,$z,$src){
        global $func, $wtmPro;
        $func->createThumb($w,$h,$z,$src,$wtmPro,"product");
    },'watermark');
    $router->map('GET', WATERMARK.'/news/[i:w]x[i:h]x[i:z]/[**:src]', function($w,$h,$z,$src){
        global $func, $wtmNews;
        $func->createThumb($w,$h,$z,$src,$wtmNews,"news");
    },'watermarkNews');
    $match = $router->match();
	if(is_array($match))
	{
		if(is_callable($match['target']))
		{
			call_user_func_array($match['target'], $match['params']); 
		}
		else
		{
			$com = (isset($match['params']['com'])) ? htmlspecialchars($match['params']['com']) : htmlspecialchars($match['target']);
			$get_page = isset($_GET['p']) ? htmlspecialchars($_GET['p']) : 1;
		}
	}
	else
	{
		header('HTTP/1.0 404 Not Found', true, 404);
		include("404.php");
		exit;
	}

    /* Setting */
    $sqlCache = "select * from #_setting";
    $setting = $cache->getCache($sqlCache,'fetch',7200);
    $optsetting = (isset($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'],true) : null;

    /* Lang */
    if(isset($match['params']['lang']) && $match['params']['lang'] != '') $_SESSION['lang'] = $match['params']['lang'];
    else if(!isset($_SESSION['lang']) && !isset($match['params']['lang'])) $_SESSION['lang'] = $optsetting['lang_default'];
    $lang = $_SESSION['lang'] ;

    /* Slug lang */
    $sluglang = 'tenkhongdauvi';

    /* SEO Lang */
    $seolang = "vi";

    /* Require datas */
    require_once LIBRARIES."lang/lang$lang.php";
    require_once SOURCES."allpage.php";

	/* Tối ưu link */
	$requick = array(
		/* Sản phẩm */
		array("tbl"=>"product_list","field"=>"idl","source"=>"product","com"=>"tour","type"=>"tour"),
		array("tbl"=>"product_cat","field"=>"idc","source"=>"product","com"=>"tour","type"=>"tour"),
		array("tbl"=>"product_item","field"=>"idi","source"=>"product","com"=>"tour","type"=>"tour"),
		array("tbl"=>"product","field"=>"id","source"=>"product","com"=>"tour","type"=>"tour",'menu'=>true),
		array("tbl"=>"product","field"=>"id","source"=>"product","com"=>"thu-vien-anh","type"=>"thu-vien-anh",'menu'=>true),
		/* Tin tức */
		array("tbl"=>"news_list","field"=>"idl","source"=>"news","com"=>"dich-vu","type"=>"dich-vu",'menu'=>true),
		array("tbl"=>"news","field"=>"id","source"=>"news","com"=>"dich-vu","type"=>"dich-vu",'menu'=>true),
		array("tbl"=>"news_list","field"=>"idl","source"=>"news","com"=>"huong-dan-vien","type"=>"huong-dan-vien",'menu'=>true),
		array("tbl"=>"news","field"=>"id","source"=>"news","com"=>"huong-dan-vien","type"=>"huong-dan-vien",'menu'=>true),

		array("tbl"=>"news_list","field"=>"idl","source"=>"news","com"=>"khach-doan","type"=>"khach-doan",'menu'=>true),
		array("tbl"=>"news","field"=>"id","source"=>"news","com"=>"khach-doan","type"=>"khach-doan",'menu'=>true),

		array("tbl"=>"news","field"=>"id","source"=>"news","com"=>"thue-xe","type"=>"thue-xe",'menu'=>true),

		array("tbl"=>"news","field"=>"id","source"=>"news","com"=>"tin-tuc","type"=>"tin-tuc",'menu'=>true),
		array("tbl"=>"news","field"=>"id","source"=>"news","com"=>"visa","type"=>"visa",'menu'=>true),
		/* Trang tĩnh */
		array("tbl"=>"static","field"=>"id","source"=>"static","com"=>"gioi-thieu","type"=>"gioi-thieu",'menu'=>true),
		array("tbl"=>"static","field"=>"id","source"=>"static","com"=>"ve-may-bay","type"=>"ve-may-bay",'menu'=>true),
		array("tbl"=>"static","field"=>"id","source"=>"static","com"=>"tuyen-dung","type"=>"tuyen-dung",'menu'=>true),
		array("tbl"=>"news","field"=>"id","source"=>"news","com"=>"chinh-sach","type"=>"chinh-sach",'menu'=>false),

		/* Liên hệ */
		array("tbl"=>"","field"=>"id","source"=>"","com"=>"lien-he","type"=>"",'menu'=>true),
	);

	/* Find data */
	if($com != 'tim-kiem' && $com != 'account' && $com != 'sitemap')
	{
		foreach($requick as $k => $v)
		{
			$url_tbl = (isset($v['tbl']) && $v['tbl'] != '') ? $v['tbl'] : '';
			$url_tbltag = (isset($v['tbltag']) && $v['tbltag'] != '') ? $v['tbltag'] : '';
			$url_type = (isset($v['type']) && $v['type'] != '') ? $v['type'] : '';
			$url_field = (isset($v['field']) && $v['field'] != '') ? $v['field'] : '';
			$url_com = (isset($v['com']) && $v['com'] != '') ? $v['com'] : '';
			
			if($url_tbl!='' && $url_tbl!='static' && $url_tbl!='photo')
			{
				$row = $d->rawQueryOne("select id from #_$url_tbl where $sluglang = ? and type = ? and hienthi > 0 limit 0,1",array($com,$url_type));
				
				if($row['id'])
				{
					$_GET[$url_field] = $row['id'];
					$com = $url_com;
					break;
				}
			}
		}
	}

	/* Switch coms */
	switch($com)
	{
		case 'booking-form':
			$source = "booking-form";
			break;
		case 'lien-he':
			$source = "contact";
			$template = "contact/contact";
			$seo->setSeo('type','object');
			$title_crumb = lienhe;
			break;
		case 've-may-bay':
			$source = "static";
			$template = "static/plane";
			$type = $com;
			$seo->setSeo('type','article');
			$title_crumb = vemaybay;
			$type_form = 've-may-bay';
			break;	
		case 'gioi-thieu':
			$source = "static";
			$template = "static/static";
			$type = $com;
			$seo->setSeo('type','article');
			$title_crumb = gioithieu;
			break;
		case 'tuyen-dung':
			$source = "static";
			$template = "static/static";
			$type = $com;
			$seo->setSeo('type','article');
			$title_crumb = tuyendung;
			break;
		case 'tin-tuc':
			$source = "news";
			$template = isset($_GET['id']) ? "news/news_detail" : "news/news";
			$seo->setSeo('type',isset($_GET['id']) ? "article" : "object");
			$type = $com;
			$title_crumb = tintuc;
			break;
		case 'dich-vu':
			$source = "news";
			$template = isset($_GET['id']) ? "news/news2_detail" : "news/news2";
			$seo->setSeo('type',isset($_GET['id']) ? "article" : "object");
			$type = $com;
			$title_crumb = khachsan;
			$type_form = 'dat-phong';
			break;
		case 'huong-dan-vien':
			$source = "news";
			$template = isset($_GET['id']) ? "news/news2_detail" : "news/news2";
			$seo->setSeo('type',isset($_GET['id']) ? "article" : "object");
			$type = $com;
			$title_crumb = huongdanvien;
			$type_form = 'huong-dan-vien';
			break;		
		case 'khach-doan':
			$source = "news";
			$template = isset($_GET['id']) ? "news/news2_detail" : "news/news2";
			$seo->setSeo('type',isset($_GET['id']) ? "article" : "object");
			$type = $com;
			$title_crumb = dichvukhachdoan;
			$type_form = 'khach-doan';
			break;			
		case 'thue-xe':
			$source = "news";
			$template = isset($_GET['id']) ? "news/news2_detail" : "news/news2";
			$seo->setSeo('type',isset($_GET['id']) ? "article" : "object");
			$type = $com;
			$title_crumb = xedulich;
			$type_form = 'dat-xe';
			break;		
		case 'visa':
			$source = "news";
			$template = isset($_GET['id']) ? "news/news2_detail" : "news/news2";
			$seo->setSeo('type',isset($_GET['id']) ? "article" : "object");
			$type = $com;
			$title_crumb = dichvuvisa;
			$type_form = 'visa';
			break;
		case 'chinh-sach':
			$source = "news";
			$template = isset($_GET['id']) ? "news/news_detail" : "news/download";
			$seo->setSeo('type',isset($_GET['id']) ? "article" : "object");
			$type = $com;
			$title_crumb = NULL;
			break;	
		case 'tour':
			$source = "product";
			$template = isset($_GET['id']) ? "product/product_detail" : "product/product";
			$seo->setSeo('type',isset($_GET['id']) ? "article" : "object");
			$type = $com;
			$title_crumb = tour;
			break;
		case 'thu-vien-anh':
			$source = "product";
			$template = isset($_GET['id']) ? "album/album_detail" : "album/album";
			$seo->setSeo('type',isset($_GET['id']) ? "article" : "object");
			$type = $com;
			$title_crumb = thuvienanh;
			break;	
		case 'filter':
			$source = "filter";
			$template = "product/product";
			$seo->setSeo('type','object');
			$title_crumb = timkiem;
			break;		
		case 'tim-kiem':
			$source = "search";
			$template = "product/search";
			$seo->setSeo('type','object');
			$title_crumb = timkiem;
			break;

		case 'video':
			$source = "video";
			$template = "video/video";
			$type = $com;
			$seo->setSeo('type','object');
			$title_crumb = NULL;
			break;

		// case 'gio-hang':
		// 	$source = "order";
		// 	$template = 'order/order';
		// 	$title_crumb = giohang;
		// 	$seo->setSeo('type','object');
		// 	break;

		// case 'account':
		// 	$source = "user";
		// 	break;

		case 'ngon-ngu':
			if(isset($lang))
			{
				switch($lang)
				{
					case 'vi':
						$_SESSION['lang'] = 'vi';
						break;
					case 'en':
						$_SESSION['lang'] = 'en';
						break;
					default:
						$_SESSION['lang'] = 'vi';
						break;
				}
			}
			$func->redirect($_SERVER['HTTP_REFERER']);
			break;

		case 'sitemap':
			include_once LIBRARIES."sitemap.php";
			exit();
			
		case '':
		case 'index':
			$source = "index";
			$template ="index/index";
			$seo->setSeo('type','website');
			break;

		default: 
			header('HTTP/1.0 404 Not Found', true, 404);
			include("404.php");
			exit();
	}

	/* Include sources */
	if($source!='') include SOURCES.$source.".php";
	if($template=='')
	{
		header('HTTP/1.0 404 Not Found', true, 404);
		include("404.php");
		exit();
	}
?>