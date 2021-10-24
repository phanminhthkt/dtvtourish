<link rel="stylesheet" type="text/css" href="css/cart.css?v=<?=time()?>" media="screen"/>
<div class="maxwidth">
    <div class="maxwidth-560 mt-3">
        <div class="cover-shadow">
            <div class="completed-status">Đặt hàng thành công</div>
            <div id="product-detail" >
                <div class="tt-right maxwidth-480">
                    <div class="list-procart">
                        <div class="item-procart">
                            <div class="pic-procart">
                                <a href="<?=$pnamekodau?>" target="_blank" title="<?=$pname?>">
                                    <img class="img-responsive" src="thumb/75x100/1/<?=_upload_product_l.get_hinh($pid,(int)$idmau,(int)$size);?>" alt="<?=$pname?>" />
                                </a>
                            </div>
                            <div class="info-procart">
                                <h3 class="name-procart"><a href="<?=$pnamekodau?>" target="_blank" title="<?=$pname?>"><?=$pname?></a></h3>
                                <div class="price-procart">
                                    <p class="price-new-cart"><?=number_format(get_price($pid,$idmau,$idsize,$size),0, ',', '.') ?>&nbsp;đ</p>
                                </div>
                                <div class="khuyenmai-procart">
                                    <?php if($idmau && $idmau!=0){ ?>
                                    <p>Loại: <?=get_attr_table((int)$idsize,'ten_vi','table_attribute')?></p>
                                    <?php } ?>
                                    <?php if($idmau && $idmau!=0){ ?>
                                    <p><?=_mau.': '.get_attr_table((int)$idmau,'ten_vi','table_color')?></p>
                                    <?php } ?>
                                </div>
                                
                            </div>
                        </div>
                        <div class="promo-cart-repay">
                            <div class="preferences">
                                <div class="promotion">
                                    <p class="title-prefrences_promotion"><b>ƯU ĐÃI KHI ĐẶT HÀNG</b></p>
                                    <div class="preferences_promotion">
                                        <?=$info_product['uudai_'.$lang]?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="money-procart">
                        <div class="total-procart">
                            <p><?=_tongtien?>:</p>
                            <p class="total-price load-price-final "><?php echo number_format($bill['vnp_Amount']/100,0,',','.').'VNĐ'; ?></p>
                        </div>
                    </div>
               </div>
            </div>
            <div class="customer-info-container">
                <p><?=$row_setting['ten_'.$lang]?> sẽ liên hệ lại cùng quý khách để xác nhận đơn hàng và hỗ trợ hình thức nhận hàng tiện lơi và nhanh nhất cho quý khách</p><p>Mọi thắc mắc về đặt hàng, quý khách vui lòng phản hồi về hotline <?=$row_setting['hotline_vi']?> hoặc email <?=$row_setting['email']?>
                </p>
            </div>
        </div>
    
    </div>  
</div>  

 <div class="vnpay">
    <div class="vnpay__header">
        <h3 class="vnpay__title">VNPAY RESPONSE</h3>
    </div>
    <div class="table-responsive">
        <div class="vnpay__box">
            <div class="vnpay__item">
                <label>Mã đặt hàng:</label>

                <label><?php echo $bill['vnp_TxnRef'] ?></label>
            </div>    
            
            <div class="vnpay__item">
                <label >Nội dung thanh toán:</label>
                <label><?php echo str_replace('+',' ',$bill['vnp_OrderInfo']) ?></label>
            </div> 
        </div>
        <div class="vnpay__box1">
            <div class="vnpay__item">
                <label >Mã phản hồi (vnp_ResponseCode):</label>
                <label><?php echo $bill['vnp_ResponseCode'] ?></label>
            </div> 
            <div class="vnpay__item">
                <label >Mã giao dịch tại VNPAY:</label>
                <label><?php echo $bill['vnp_TransactionNo'] ?></label>
            </div> 
            <div class="vnpay__item">
                <label >Mã ngân hàng:</label>
                <label><?php echo $bill['vnp_BankCode'] ?></label>
            </div> 
        <div class="vnpay__item">
            <label >Thời gian thanh toán:</label>
            <label><?php echo $bill['vnp_PayDate'] ?></label>
        </div> 
        <img class="vnpay__icon" src="images/vnpay.png">
        </div>
        <div class="vnpay__bold">
         <div class="vnpay__item">
            <label >Số tiền:</label>
            <label><?php echo number_format($bill['vnp_Amount']/100,0,',','.').'VNĐ'; ?></label>
        </div> 
        </div>
        <div class="vnpay__box2">
            <div class="vnpay__item">
                <label >Kết quả:</label>
                <label>
                    <?php
                    if ($secureHash == $vnp_SecureHash) {
                        if ($bill['vnp_ResponseCode'] == '00') {
                            echo "<span class='cl__1'>Giao dịch thành công</span>";
                        } else {
                            echo "<span class='cl__2'>Giao dịch lỗi</span>";
                        }
                    } else {
                        echo "<span class='cl__2'>Lỗi chữ ký</span>";
                    }
                    ?>

                </label>
            </div> 
        </div> 
    </div>
    <p>
        &nbsp;
    </p>
    <div class="vnpay__footer">
        <p><a href="index.php">TẠO ĐƠN HÀNG MỚI</a></p>
    </div>
</div>  


<style type="text/css">

    .vnpay{    max-width: 560px;
        margin: 0px auto;
        border: 1px solid #f2f2f2;

        margin-bottom: 20px;}
       .vnpay__title {
                font-weight:bold;
    font-weight: 700;
    color: #0053A3;
    font-size: 26px;
        }
        .vnpay__header{
          text-align: center;
          background: #f2f2f2;
          padding: 15px;
          text-transform: uppercase;
      }
      .vnpay__box{
       padding: 10px 20px;
        border-bottom: 1px solid #f2f2f2;
    }
    .vnpay__box1{
       padding: 10px 20px;
        border-bottom: 1px solid #f2f2f2;
    }
    .vnpay__box2{
           padding: 10px 20px;
    border-bottom: 1px solid #f2f2f2;
    background: #f2f2f2;
    }
    .vnpay__item label:first-child{font-weight: bold;color:#000;}
    .vnpay__item{      
        font-weight: 600 !important;
        color: #1963ab;
        font-size: 14px;
        margin-bottom: 5px;
    }
    .vnpay__footer{    border-top: 1px solid #f2f2f2;
    text-align: center;
    padding: 12px;
    }
  	.vnpay__footer p{    
      	background: #efb525;
	    padding: 10px;
	    text-transform: uppercase;
	    font-size: 1.5rem;
	    color: #fff;
	}
    .vnpay__footer p a{color: #000;font-weight: bold;}
    .vnpay__icon{
    max-width: 120px;
    height: auto;
    float: right;
    background: #fff;
    border: 1px solid #ee9835;
    padding: 10px;
    }
    .cl__1{color:#0053A3;}
.cl__2{color:#d00;}
.vnpay__bold{font-size: 20px;font-weight:bold;padding: 10px 20px;}
</style>