<?php
	if(!defined('SOURCES')) die("Error");

	/* Kiểm tra active attribute */
	if(isset($config['attribute']))
	{
		$arrCheck = array();
		foreach($config['attribute'] as $k => $v) $arrCheck[] = $k;
		if(!count($arrCheck) || !in_array($type,$arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);
	}
	else
	{
		$func->transfer("Trang không tồn tại", "index.php", false);
	}

	/* Cấu hình đường dẫn trả về */
	$strUrl = "";
	$arrUrl = array('id_list');
	if(isset($_POST['data']))
	{
		$dataUrl = isset($_POST['data']) ? $_POST['data'] : null;
		if($dataUrl)
		{
			foreach($arrUrl as $k => $v)
			{
				if(isset($dataUrl[$arrUrl[$k]])) $strUrl .= "&".$arrUrl[$k]."=".htmlspecialchars($dataUrl[$arrUrl[$k]]);
			}
		}
	}
	else
	{
		foreach($arrUrl as $k => $v)
		{
			if(isset($_REQUEST[$arrUrl[$k]])) $strUrl .= "&".$arrUrl[$k]."=".htmlspecialchars($_REQUEST[$arrUrl[$k]]);
		}
		if(isset($_REQUEST['keyword'])) $strUrl .= "&keyword=".htmlspecialchars($_REQUEST['keyword']);
	}

	switch($act)
	{
		case "man":
			get_items();
			$template = "attribute/man/items";
			break;

		case "add":		
			$template = "attribute/man/item_add";
			break;

		case "edit":		
			get_item();
			$template = "attribute/man/item_add";
			break;

		case "save":
			save_item();
			break;

		case "delete":
			delete_item();
			break;

		
		/* List */
		case "man_list":
			get_lists();
			$template = "attribute/list/lists";
			break;
		case "add_list":
			$template = "attribute/list/list_add";
			break;
		case "edit_list":
			get_list();
			$template = "attribute/list/list_add";
			break;
		case "save_list":
			save_list();
			break;
		case "delete_list":
			delete_list();
			break;	
		default:
			$template = "404";
	}

	/* Get attribute */
	function get_items()
	{
		global $d, $func, $curPage, $items, $paging, $type;

		$where = "";
		$idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
		if($idlist) $where .= " and id_list=$idlist";
		if(isset($_REQUEST['keyword']))
		{
			$keyword = htmlspecialchars($_REQUEST['keyword']);
			$where .= " and (tenvi LIKE '%$keyword%' or tenen LIKE '%$keyword%')";
		}

		$per_page = 10;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select * from #_attribute where type = ? $where order by stt,id desc $limit";
		$items = $d->rawQuery($sql,array($type));
		$sqlNum = "select count(*) as 'num' from #_attribute where type = ? $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,array($type));
		$total = $count['num'];
		$url = "index.php?com=attribute&act=man&type=".$type;
		$paging = $func->pagination($total,$per_page,$curPage,$url);
	}

	/* Edit attribute */
	function get_item()
	{
		global $d, $func, $curPage, $item, $type;

		$id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

		if(!$id) $func->transfer("Không nhận được dữ liệu", "index.php?com=attribute&act=man&type=".$type."&p=".$curPage, false);

		$item = $d->rawQueryOne("select * from #_attribute where id = ? and type = ? limit 0,1",array($id,$type));

		if(!$item['id']) $func->transfer("Dữ liệu không có thực", "index.php?com=attribute&act=man&type=".$type."&p=".$curPage, false);
	}

	/* Save attribute */
	function save_item()
	{
		global $d, $curPage, $func, $config, $com, $type;

		if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=attribute&act=man&type=".$type."&p=".$curPage, false);
		
		/* Post dữ liệu */
		$data = (isset($_POST['data'])) ? $_POST['data'] : null;
		if($data)
		{
			foreach($data as $column => $value)
			{
				$data[$column] = htmlspecialchars($value);
			}

			if(isset($_POST['slugvi'])) $data['tenkhongdauvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
			else $data['tenkhongdauvi'] = (isset($data['tenvi'])) ? $func->changeTitle($data['tenvi']) : '';
			if(isset($_POST['slugen'])) $data['tenkhongdauen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
			else $data['tenkhongdauen'] = (isset($data['tenen'])) ? $func->changeTitle($data['tenen']) : '';
			$data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;
			$data['type'] = $type;
		}

		/* Post seo */
		if(isset($config['attribute'][$type]['seo']) && $config['attribute'][$type]['seo'] == true)
		{
			$dataSeo = (isset($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
			if($dataSeo)
			{
				foreach($dataSeo as $column => $value)
				{
					$dataSeo[$column] = htmlspecialchars($value);
				}
			}
		}

		$id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;

		if($id)
		{
			if(isset($_FILES['file']))
			{
				$file_name = $func->uploadName($_FILES['file']["name"]);
				if($photo = $func->uploadImage("file", $config['attribute'][$type]['img_type'], UPLOAD_ATTRIBUTE,$file_name))
				{
					$data['photo'] = $photo;
					$row = $d->rawQueryOne("select id, photo from #_attribute where id = ? and type = ? limit 0,1",array($id,$type));
					if($row['id']) $func->delete_file(UPLOAD_ATTRIBUTE.$row['photo']);
				}
			}

			$data['ngaysua'] = time();

			$d->where('id', $id);
			$d->where('type', $type);
			if($d->update('attribute',$data))
			{
				/* SEO */
				if(isset($config['attribute'][$type]['seo']) && $config['attribute'][$type]['seo'] == true)
				{
					$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man',$type));

					$dataSeo['idmuc'] = $id;
					$dataSeo['com'] = $com;
					$dataSeo['act'] = 'man';
					$dataSeo['type'] = $type;
					$d->insert('seo',$dataSeo);
				}

				$func->transfer("Cập nhật dữ liệu thành công", "index.php?com=attribute&act=man&type=".$type."&p=".$curPage);
			}
			else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=attribute&act=man&type=".$type."&p=".$curPage, false);
		}
		else
		{
			if(isset($_FILES['file']))
			{
				$file_name = $func->uploadName($_FILES['file']["name"]);
				if($photo = $func->uploadImage("file", $config['attribute'][$type]['img_type'], UPLOAD_ATTRIBUTE,$file_name))
				{
					$data['photo'] = $photo;
				}
			}
			
			$data['ngaytao'] = time();

			if($d->insert('attribute',$data))
			{
				$id_insert = $d->getLastInsertId();

				/* SEO */
				if(isset($config['attribute'][$type]['seo']) && $config['attribute'][$type]['seo'] == true)
				{
					$dataSeo['idmuc'] = $id_insert;
					$dataSeo['com'] = $com;
					$dataSeo['act'] = 'man';
					$dataSeo['type'] = $type;
					$d->insert('seo',$dataSeo);
				}

				$func->transfer("Lưu dữ liệu thành công", "index.php?com=attribute&act=man&type=".$type."&p=".$curPage);
			}
			else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=attribute&act=man&type=".$type."&p=".$curPage, false);
		}
	}

	/* Delete attribute */
	function delete_item()
	{
		global $d, $curPage, $func, $com, $type;

		$id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
		
		if($id)
		{
			/* Xóa SEO */
			$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man',$type));

			/* Lấy dữ liệu */
			$row = $d->rawQueryOne("select id, photo from #_attribute where id = ? and type = ? limit 0,1",array($id,$type));

			if($row['id'])
			{
				$func->delete_file(UPLOAD_ATTRIBUTE.$row['photo']);
				$d->rawQuery("delete from #_attribute where id = ?",array($id));

				$func->transfer("Xóa dữ liệu thành công", "index.php?com=attribute&act=man&type=".$type."&p=".$curPage);
			}
			else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=attribute&act=man&type=".$type."&p=".$curPage, false);
		}
		elseif(isset($_GET['listid']))
		{
			$listid = explode(",",$_GET['listid']);

			for($i=0;$i<count($listid);$i++)
			{
				$id = htmlspecialchars($listid[$i]);

				/* Xóa SEO */
				$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man',$type));

				/* Lấy dữ liệu */
				$row = $d->rawQueryOne("select id, photo from #_attribute where id = ? and type = ? limit 0,1",array($id,$type));

				if($row['id'])
				{
					$func->delete_file(UPLOAD_ATTRIBUTE.$row['photo']);
					$d->rawQuery("delete from #_attribute where id = ?",array($id));
				}
			}
			
			$func->transfer("Xóa dữ liệu thành công", "index.php?com=attribute&act=man&type=".$type."&p=".$curPage);
		} 
		else $func->transfer("Không nhận được dữ liệu", "index.php?com=attribute&act=man&type=".$type."&p=".$curPage, false);
	}


	/* Get list */
	function get_lists()
	{
		global $d, $func, $strUrl, $curPage, $items, $paging, $type;
		
		$where = "";

		if(isset($_REQUEST['keyword']))
		{
			$keyword = htmlspecialchars($_REQUEST['keyword']);
			$where .= " and (tenvi LIKE '%$keyword%' or tenen LIKE '%$keyword%')";
		}

		$per_page = 10;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select * from #_attribute_list where type = ? $where order by stt,id desc $limit";
		$items = $d->rawQuery($sql,array($type));
		$sqlNum = "select count(*) as 'num' from #_attribute_list where type = ? $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,array($type));
		$total = $count['num'];
		$url = "index.php?com=attribute&act=man_list&type=".$type;
		$paging = $func->pagination($total,$per_page,$curPage,$url);
	}

	/* Edit list */
	function get_list()
	{
		global $d, $func, $strUrl, $curPage, $item, $gallery, $type, $com;

		$id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

		if(!$id) $func->transfer("Không nhận được dữ liệu", "index.php?com=attribute&act=man_list&type=".$type."&p=".$curPage.$strUrl, false);

		$item = $d->rawQueryOne("select * from #_attribute_list where id = ? and type = ? limit 0,1",array($id,$type));
		
		if(!$item['id']) $func->transfer("Dữ liệu không có thực", "index.php?com=attribute&act=man_list&type=".$type."&p=".$curPage.$strUrl, false);

		/* Lấy hình ảnh con */
		$gallery = $d->rawQuery("select * from #_gallery where id_photo = ? and com = ? and type = ? and kind = ? and val = ? order by stt,id desc",array($id,$com,$type,'man_list',$type));
	}

	/* Save list */
	function save_list()
	{
		global $d, $strUrl, $func, $curPage, $config, $com, $type;

		if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=attribute&act=man_list&type=".$type."&p=".$curPage.$strUrl, false);

		/* Post dữ liệu */
		$data = (isset($_POST['data'])) ? $_POST['data'] : null;
		if($data)
		{
			foreach($data as $column => $value)
			{
				$data[$column] = htmlspecialchars($value);
			}

			if(isset($_POST['slugvi'])) $data['tenkhongdauvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
			else $data['tenkhongdauvi'] = (isset($data['tenvi'])) ? $func->changeTitle($data['tenvi']) : '';
			if(isset($_POST['slugen'])) $data['tenkhongdauen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
			else $data['tenkhongdauen'] = (isset($data['tenen'])) ? $func->changeTitle($data['tenen']) : '';
			$data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;
			$data['type'] = $type;
		}

		$id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;

		/* Post seo */
		if(isset($config['attribute'][$type]['seo_list']) && $config['attribute'][$type]['seo_list'] == true)
		{
			$dataSeo = (isset($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
			if($dataSeo)
			{
				foreach($dataSeo as $column => $value)
				{
					$dataSeo[$column] = htmlspecialchars($value);
				}
			}
		}

		if($id)
		{
			if(isset($_FILES['file']))
			{
				$file_name = $func->uploadName($_FILES['file']["name"]);
				if($photo = $func->uploadImage("file", $config['attribute'][$type]['img_type_list'], UPLOAD_ATTRIBUTE,$file_name))
				{
					$data['photo'] = $photo;
					$row = $d->rawQueryOne("select id, photo from #_attribute_list where id = ? and type = ? limit 0,1",array($id,$type));
					if($row['id']) $func->delete_file(UPLOAD_ATTRIBUTE.$row['photo']);
				}
			}
			if(isset($_FILES['file_icon']))
			{
				$file_icon = $func->uploadName($_FILES['file_icon']["name"]);
				if($icon = $func->uploadImage("file_icon", $config['attribute'][$type]['img_type_list'], UPLOAD_ATTRIBUTE,$file_icon))
				{
					$data['icon'] = $icon;
					$row = $d->rawQueryOne("select id, icon from #_attribute_list where id = ? and type = ? limit 0,1",array($id,$type));
					if($row['id']) $func->delete_file(UPLOAD_ATTRIBUTE.$row['icon']);
				}
			}
			$data['ngaysua'] = time();
			
			$d->where('id', $id);
			$d->where('type', $type);
			if($d->update('attribute_list',$data))
			{
				/* SEO */
				if(isset($config['attribute'][$type]['seo_list']) && $config['attribute'][$type]['seo_list'] == true)
				{
					$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_list',$type));

					$dataSeo['idmuc'] = $id;
					$dataSeo['com'] = $com;
					$dataSeo['act'] = 'man_list';
					$dataSeo['type'] = $type;
					$d->insert('seo',$dataSeo);
				}

				$func->transfer("Cập nhật dữ liệu thành công", "index.php?com=attribute&act=man_list&type=".$type."&p=".$curPage.$strUrl);
			}
			else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=attribute&act=man_list&type=".$type."&p=".$curPage.$strUrl, false);
		}
		else
		{
			if(isset($_FILES['file']))
			{
				$file_name = $func->uploadName($_FILES['file']["name"]);
				if($photo = $func->uploadImage("file", $config['attribute'][$type]['img_type_list'], UPLOAD_ATTRIBUTE,$file_name))
				{
					$data['photo'] = $photo;
				}
			}
			if(isset($_FILES['file_icon']))
			{
				$file_icon = $func->uploadName($_FILES['file_icon']["name"]);
				if($icon = $func->uploadImage("file_icon", $config['attribute'][$type]['img_type_list'], UPLOAD_ATTRIBUTE,$file_icon))
				{
					$data['icon'] = $icon;
				}
			}
			$data['ngaytao'] = time();
			
			if($d->insert('attribute_list',$data))
			{
				$id_insert = $d->getLastInsertId();

				/* SEO */
				if(isset($config['attribute'][$type]['seo_list']) && $config['attribute'][$type]['seo_list'] == true)
				{
					$dataSeo['idmuc'] = $id_insert;
					$dataSeo['com'] = $com;
					$dataSeo['act'] = 'man_list';
					$dataSeo['type'] = $type;
					$d->insert('seo',$dataSeo);
				}

				/* Cập nhật hash khi upload multi */
				$hash = (isset($_POST['hash']) && $_POST['hash'] != '') ? addslashes($_POST['hash']) : null;
				if($hash)
				{
					$d->rawQuery("update #_gallery set hash = ?, id_photo = ? where hash = ?",array('',$id_insert,$hash));
				}

				$func->transfer("Lưu dữ liệu thành công", "index.php?com=attribute&act=man_list&type=".$type."&p=".$curPage.$strUrl);
			}
			else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=attribute&act=man_list&type=".$type."&p=".$curPage.$strUrl, false);
		}
	}

	/* Delete list */
	function delete_list()
	{
		global $d, $strUrl, $func, $curPage, $com, $type;

		$id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

		if($id)
		{
			/* Xóa SEO */
			$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_list',$type));

			/* Lấy dữ liệu */
			$row = $d->rawQueryOne("select id, photo,icon from #_attribute_list where id = ? and type = ? limit 0,1",array($id,$type));

			if($row['id'])
			{
				$func->delete_file(UPLOAD_ATTRIBUTE.$row['photo']);
				$func->delete_file(UPLOAD_ATTRIBUTE.$row['icon']);
				$d->rawQuery("delete from #_attribute_list where id = ?",array($id));

				/* Xóa gallery */
				$row = $d->rawQuery("select id, photo, taptin from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man_list',$com));

				if(count($row))
				{
					foreach($row as $v)
					{
						$func->delete_file(UPLOAD_ATTRIBUTE.$v['photo']);
						$func->delete_file(UPLOAD_FILE.$v['taptin']);
					}

					$d->rawQuery("delete from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man_list',$com));
				}

				$func->transfer("Xóa dữ liệu thành công", "index.php?com=attribute&act=man_list&type=".$type."&p=".$curPage.$strUrl);
			}
			else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=attribute&act=man_list&type=".$type."&p=".$curPage.$strUrl, false);
		}
		elseif(isset($_GET['listid']))
		{
			$listid = explode(",",$_GET['listid']);

			for($i=0;$i<count($listid);$i++)
			{
				$id = htmlspecialchars($listid[$i]);

				/* Xóa SEO */
				$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_list',$type));

				/* Lấy dữ liệu */
				$row = $d->rawQueryOne("select id, photo from #_attribute_list where id = ? and type = ? limit 0,1",array($id,$type));

				if($row['id'])
				{
					$func->delete_file(UPLOAD_ATTRIBUTE.$row['photo']);
					$func->delete_file(UPLOAD_ATTRIBUTE.$row['icon']);
					$d->rawQuery("delete from #_attribute_list where id = ?",array($id));

					/* Xóa gallery */
					$row = $d->rawQuery("select id, photo, taptin from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man_list',$com));

					if(count($row))
					{
						foreach($row as $v)
						{
							$func->delete_file(UPLOAD_ATTRIBUTE.$v['photo']);
							$func->delete_file(UPLOAD_FILE.$v['taptin']);
						}

						$d->rawQuery("delete from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man_list',$com));
					}
				}
			}

			$func->transfer("Xóa dữ liệu thành công", "index.php?com=attribute&act=man_list&type=".$type."&p=".$curPage.$strUrl);
		}
		else $func->transfer("Không nhận được dữ liệu", "index.php?com=attribute&act=man_list&type=".$type."&p=".$curPage.$strUrl, false);
	}
?>