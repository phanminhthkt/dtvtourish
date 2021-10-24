<?php
	include "ajax_config.php";

    $id = (isset($_POST['id']) && $_POST['id'] > 0) ? htmlspecialchars($_POST['id']) : 0;
    $sotreem = (isset($_POST['sotreem']) && $_POST['sotreem'] > 0) ? htmlspecialchars($_POST['sotreem']) : 0;
    $songuoilon = (isset($_POST['songuoilon']) && $_POST['songuoilon'] > 0) ? htmlspecialchars($_POST['songuoilon']) : 0;
    $soembe = (isset($_POST['soembe']) && $_POST['soembe'] > 0) ? htmlspecialchars($_POST['soembe']) : 0;

    $tonggia = $func->getOrderTour($id,$sotreem,$songuoilon,$soembe);
    
    $totalText = $func->format_money($tonggia);

    $data = ['tonggia' => $tonggia, 'totalText' => $totalText];

	echo json_encode($data);
?>