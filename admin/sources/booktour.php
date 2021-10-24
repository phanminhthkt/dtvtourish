<?php
	if(!defined('SOURCES')) die("Error");

	/* Kiểm tra active đơn hàng */
	if(!isset($config['booktour']['active']) || $config['booktour']['active'] == false) $func->transfer("Trang không tồn tại", "index.php", false);

	/* Cấu hình đường dẫn trả về */
	$strUrl = "";
	$strUrl .= (isset($_REQUEST['tinhtrang'])) ? "&tinhtrang=".htmlspecialchars($_REQUEST['tinhtrang']) : "";
	$strUrl .= (isset($_REQUEST['httt'])) ? "&httt=".htmlspecialchars($_REQUEST['httt']) : "";
	$strUrl .= (isset($_REQUEST['ngaydat'])) ? "&ngaydat=".htmlspecialchars($_REQUEST['ngaydat']) : "";
	$strUrl .= (isset($_REQUEST['khoanggia'])) ? "&khoanggia=".htmlspecialchars($_REQUEST['khoanggia']) : "";
	$strUrl .= (isset($_REQUEST['city'])) ? "&city=".htmlspecialchars($_REQUEST['city']) : "";
	$strUrl .= (isset($_REQUEST['district'])) ? "&district=".htmlspecialchars($_REQUEST['district']) : "";
	$strUrl .= (isset($_REQUEST['wards'])) ? "&wards=".htmlspecialchars($_REQUEST['wards']) : "";
	$strUrl .= (isset($_REQUEST['keyword'])) ? "&keyword=".htmlspecialchars($_REQUEST['keyword']) : "";

	switch($act)
	{
		case "man":
			get_items();
			$template = "booktour/man/items";
			break;

		case "edit":
			get_item();
			$template = "booktour/man/item_add";
			break;

		case "save":
			save_item();
			break;

		case "delete":
			delete_item();
			break;

		default:
			$template = "404";
	}

	/* Get booktour */
	function get_items()
	{
		global $d, $func, $strUrl, $curPage, $items, $paging, $minTotal, $maxTotal, $giatu, $giaden, $allMoidat, $totalMoidat, $allDaxacnhan, $totalDaxacnhan, $allDagiao, $totalDagiao, $allDahuy, $totalDahuy;
		
		$where = "";

		$tinhtrang = (isset($_REQUEST['tinhtrang'])) ? htmlspecialchars($_REQUEST['tinhtrang']) : 0;
		$httt = (isset($_REQUEST['httt'])) ? htmlspecialchars($_REQUEST['httt']) : 0;
		$ngaydat = (isset($_REQUEST['ngaydat'])) ? htmlspecialchars($_REQUEST['ngaydat']) : 0;
		$khoanggia = (isset($_REQUEST['khoanggia'])) ? htmlspecialchars($_REQUEST['khoanggia']) : 0;
		$city = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
		$district = (isset($_REQUEST['id_district'])) ? htmlspecialchars($_REQUEST['id_district']) : 0;
		$wards = (isset($_REQUEST['id_wards'])) ? htmlspecialchars($_REQUEST['id_wards']) : 0;

		if($tinhtrang) $where .= " and tinhtrang=$tinhtrang";
		if($httt) $where .= " and httt=$httt";
		if($ngaydat)
		{
			$ngaydat = explode("-",$ngaydat);
			$ngaytu = trim($ngaydat[0]);
			$ngayden = trim($ngaydat[1]);
			$ngaytu = strtotime(str_replace("/","-",$ngaytu));
			$ngayden = strtotime(str_replace("/","-",$ngayden));
			$where .= " and ngaytao<=$ngayden and ngaytao>=$ngaytu";
		}
		if($khoanggia)
		{
			$khoanggia = explode(";",$khoanggia);
			$giatu = trim($khoanggia[0]);
			$giaden = trim($khoanggia[1]);
			$where .= " and tonggia<=$giaden and tonggia>=$giatu";
		}
		if($city) $where .= " and city=$city";
		if($district) $where .= " and district=$district";
		if($wards) $where .= " and wards=$wards";
		if(isset($_REQUEST['keyword']))
		{
			$keyword = htmlspecialchars($_REQUEST['keyword']);
			$where .= " and (hoten LIKE '%$keyword%' or email LIKE '%$keyword%' or dienthoai LIKE '%$keyword%' or madonhang LIKE '%$keyword%')";
		}

		$per_page = 10;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select * from #_booktour where id<>0 $where order by ngaytao desc $limit";
		$items = $d->rawQuery($sql);
		$sqlNum = "select count(*) as 'num' from #_booktour where id<>0 $where order by ngaytao desc";
		$count = $d->rawQueryOne($sqlNum);
		$total = $count['num'];
		$url = "index.php?com=booktour&act=man".$strUrl;
		$paging = $func->pagination($total,$per_page,$curPage,$url);
		/* Lấy tổng giá min */
		$minTotal = $d->rawQueryOne("select min(tonggia) from #_booktour");
		if($minTotal['min(tonggia)']) $minTotal = $minTotal['min(tonggia)'];
		else $minTotal = 0;

		/* Lấy tổng giá max */
		$maxTotal = $d->rawQueryOne("select max(tonggia) from #_booktour");
		if($maxTotal['max(tonggia)']) $maxTotal = $maxTotal['max(tonggia)'];
		else $maxTotal = 0;

		/* Lấy đơn hàng - mới đặt */
		$booktourMoidat = $d->rawQueryOne("select count(id), sum(tonggia) from #_booktour where tinhtrang = 1");
		$allMoidat = $booktourMoidat['count(id)'];
		$totalMoidat = $booktourMoidat['sum(tonggia)'];

		/* Lấy đơn hàng - đã xác nhận */
		$booktourDaxacnhan = $d->rawQueryOne("select count(id), sum(tonggia) from #_booktour where tinhtrang = 2");
		$allDaxacnhan = $booktourDaxacnhan['count(id)'];
		$totalDaxacnhan = $booktourDaxacnhan['sum(tonggia)'];

		/* Lấy đơn hàng - đã giao */
		$booktourDagiao = $d->rawQueryOne("select count(id), sum(tonggia) from #_booktour where tinhtrang = 4");
		$allDagiao = $booktourDagiao['count(id)'];
		$totalDagiao = $booktourDagiao['sum(tonggia)'];

		/* Lấy đơn hàng - đã hủy */
		$booktourDahuy = $d->rawQueryOne("select count(id), sum(tonggia) from #_booktour where tinhtrang = 5");
		$allDahuy = $booktourDahuy['count(id)'];
		$totalDahuy = $booktourDahuy['sum(tonggia)'];
	}

	/* Edit booktour */
	function get_item()
	{
		global $d, $func, $curPage, $item, $chitietdonhang;

		$id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

		if(!$id) $func->transfer("Không nhận được dữ liệu", "index.php?com=booktour&act=man&p=".$curPage, false);
		
		$item = $d->rawQueryOne("select * from #_booktour where id = ? limit 0,1",array($id));

		if(!$item['id']) $func->transfer("Dữ liệu không có thực", "index.php?com=booktour&act=man&p=".$curPage, false);

		/* Lấy chi tiết đơn hàng */
		$chitietdonhang = $d->rawQuery("select * from #_booktour_detail where id_booktour = ? order by id desc",array($id));
	}

	/* Save booktour */
	function save_item()
	{
		global $d, $func, $curPage;

		if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=booktour&act=man&p=".$curPage, false);

		$id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;

		/* Post dữ liệu */
		$data = (isset($_POST['data'])) ? $_POST['data'] : null;
		if($data)
		{
			foreach($data as $column => $value)
			{
				$data[$column] = htmlspecialchars($value);
			}
		}

		if($id)
		{
			$d->where('id', $id);
			if($d->update('booktour',$data)) $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=booktour&act=man&p=".$curPage);
			else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=booktour&act=man&p=".$curPage, false);
		}
		else
		{
			$func->transfer("Dữ liệu rỗng", "index.php?com=booktour&act=man&p=".$curPage, false);
		}
	}

	/* Delete booktour */
	function delete_item()
	{
		global $d, $func, $curPage;

		$id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

		if($id)
		{
			$row = $d->rawQueryOne("select id from #_booktour where id = ? limit 0,1",array($id));

			if($row['id'])
			{
				$d->rawQuery("delete from #_booktour_detail where id_booktour = ?",array($id));
				$d->rawQuery("delete from #_booktour where id = ?",array($id));
				$func->transfer("Xóa dữ liệu thành công", "index.php?com=booktour&act=man&p=".$curPage);
			}
			else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=booktour&act=man&p=".$curPage, false);
		}
		elseif(isset($_GET['listid']))
		{
			$listid = explode(",",$_GET['listid']);
			
			for($i=0;$i<count($listid);$i++)
			{
				$id = htmlspecialchars($listid[$i]);
				$row = $d->rawQueryOne("select id from #_booktour where id = ? limit 0,1",array($id));

				if($row['id'])
				{
					$d->rawQuery("delete from #_booktour_detail where id_booktour = ?",array($id));
					$d->rawQuery("delete from #_booktour where id = ?",array($id));
				}
			}
			
			$func->transfer("Xóa dữ liệu thành công", "index.php?com=booktour&act=man&p=".$curPage);
		}
		else $func->transfer("Không nhận được dữ liệu", "index.php?com=booktour&act=man&p=".$curPage, false);
	}
?>