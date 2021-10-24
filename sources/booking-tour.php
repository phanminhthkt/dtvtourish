<?php 
	if(!defined('SOURCES')) die("Error");

	$httt = $d->rawQuery("select ten$lang, mota$lang, id from #_news where type = ? order by stt,id desc",array('hinh-thuc-thanh-toan'));
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
		    $chitietdonhang = '';

		    	$pid = $id;
				$q_treem = $sotreem;
				$q_nguoilon = $songuoilon;
				$q_embe = $soembe;
				$proinfo = $cart->get_product_info($pid);
				$gianguoilon = (double)$proinfo['gianguoilon'];
				$giatreem = (double)$proinfo['giatreem'];
				$giaembe = (double)$proinfo['giaembe'];
				
				$chiphikhac = (double)$proinfo['chiphikhac'];
				$phuthuphongdon = (double)$proinfo['phuthuphongdon'];
		    	$chitietdonhang.='<tbody bgcolor="';
		    	$chitietdonhang.='#e6e6e6';

		    	$chitietdonhang.='" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px"><tr>';
		    	$chitietdonhang.='<td align="left" style="padding:3px 9px" valign="middle">';
		    	$chitietdonhang.='<span style="display:block;font-weight:bold">'.$proinfo['ten'.$lang].'</span>';
		    	if($textsm!='') $chitietdonhang.='<span style="display:block;font-size:12px">'.$textsm.'</span>';
		    	$chitietdonhang.='</td>';
		    	
	    		$chitietdonhang.='<td align="left" style="padding:3px 9px" valign="top">';
		    	$chitietdonhang.='<span style="display:block;color:#004eff;">Người lớn: '.$func->format_money($proinfo['gianguoilon'],' đ').' x '.$songuoilon.'</span>';
		    	$chitietdonhang.='<span style="display:block;color:#004eff;">Trẻ em: '.$func->format_money($proinfo['giatreem'],' đ').' x '.$sotreem.'</span>';
		    	$chitietdonhang.='<span style="display:block;color:#004eff;">Em bé: '.$func->format_money($proinfo['giaembe'],' đ').' x '.$soembe.'</span>';
		    	$chitietdonhang.='<span style="display:block;color:#004eff;">Phụ thu phòng dọn: '.$func->format_money($proinfo['phuthuphongdon'],' đ').'</span>';
		    	$chitietdonhang.='<span style="display:block;color:#004eff;">Chi phí khác: '.$func->format_money($proinfo['chiphikhac'],' đ').'</span>';
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
																	<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><strong>Hình thức thanh toán: </strong> '.$htttText.'';
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
															<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><strong>Hình thức thanh toán: </strong> '.$htttText.'';
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

			/* Send email admin */
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
		    /* Xóa giỏ hàng */
			$func->transfer("Thông tin đặt tour đã được gửi thành công.", $config_base);
		}
	}
	$tourItem = $d->rawQueryOne("select ten$lang,id,gianguoilon,giaembe,giatreem,phuthuphongdon,chiphikhac,ngaykhoihanh$lang,phuongtien$lang,id_songaydi from #_product where type = ? and id= ? limit 0,1",array('tour',$_GET['id']));
	/* breadCrumbs */
	if(isset($title_crumb) && $title_crumb != '') $breadcr->setBreadCrumbs($com,$title_crumb);
	$breadcrumbs = $breadcr->getBreadCrumbs();
?>