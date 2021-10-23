<?php  
	if(!defined('SOURCES')) die("Error");

	/* Tìm kiếm sản phẩm */
	if(isset($_GET['id_list']) || isset($_GET['id_khoihanh']) || isset($_GET['id_noiden']) || isset($_GET['id_songaydi']) || isset($_GET['keyword']) )
	{	
		$tukhoa = htmlspecialchars($_GET['keyword']);
		$tukhoa = $func->changeTitle($tukhoa);

		$where = "";
		$where .= "type = ? and hienthi > 0";
		$params = array("tour");
		if($tukhoa){
			$where .= " and (ten$lang LIKE ? or tenkhongdauvi LIKE ? or tenkhongdauen LIKE ? ) ";
			array_push($params,"%$tukhoa%");
			array_push($params,"%$tukhoa%");
			array_push($params,"%$tukhoa%");
		}
		if(isset($_GET['id_list']) && $_GET['id_list'] !='0'){
			$where .= " and id_list = ? ";
			array_push($params,$_GET['id_list']);
		}
		if(isset($_GET['id_khoihanh']) && $_GET['id_khoihanh'] !='0'){
			$where .= " and id_khoihanh = ? ";
			array_push($params,$_GET['id_khoihanh']);
		}
		if(isset($_GET['id_noiden']) && $_GET['id_noiden'] !='0'){
			$where .= " and id_noiden = ? ";
			array_push($params,$_GET['id_noiden']);
		}
		if(isset($_GET['id_songaydi']) && $_GET['id_songaydi'] !='0'){
			$where .= " and id_songaydi = ? ";
			array_push($params,$_GET['id_songaydi']);
		}
		$where .= " and hienthi > 0";
		$curPage = $get_page;
		$per_page = 20;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select ten$lang, tenkhongdauvi, tenkhongdauen,gianguoilon,ngaykhoihanh$lang,id_khoihanh, ngaytao, id, photo,gia,giacu from #_product where $where order by stt,id desc $limit";
		$product = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_product where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = $func->getCurrentPageURL();
		$paging = $func->pagination($total,$per_page,$curPage,$url);
	}

	/* SEO */
	$seo->setSeo('title',$title_crumb);

	/* breadCrumbs */
	$breadcr->setBreadCrumbs('',$title_crumb);
	$breadcrumbs = $breadcr->getBreadCrumbs();
?>