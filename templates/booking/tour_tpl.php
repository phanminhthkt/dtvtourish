<div class="maxwidth">
    <div class="content-main w-clear">
    <div class="title-main"><h2><?=$title_crumb?></h2></div>
        <div class="noidung_hienthi">
            <div>
                <div class="quytrinhdatve">
                    <span class="active"><img src="assets/images/circle-check-128_3.png" alt="Chọn vé" align="absmiddle"> <b><?=chonve?></b> </span>
                    <span class="active"><img src="assets/images/circle-check-128_3.png" alt="Đặt vé" align="absmiddle"> <b><?=datve?></b> </span>
                    <span><img src="assets/images/circle-check-128_1.png" alt="Thanh toán" align="absmiddle"> <b><?=thanhtoan?></b> </span>
                </div>
                <div class="title"><h2><?=thongtintour?></h2></div>
                
                <div class="info_tour">
                    <div class="info_tour">
                        <h3><?=$tourItem['ten'.$lang]?></h3>
                        <p>
                            <span> <?=gia?>: <b >
                                <?=($tourItem['gianguoilon']) ? $func->format_money($tourItem['gianguoilon']) : lienhe?></b></span>
                            <span> <?=ngaykhoihanh?>: <b><?=$tourItem['ngaykhoihanh'.$lang]?></b></span>
                        </p>

                        <p>
                            <span> <?=songaydi?>: <b><?=$func->getValueAttribute($tourItem['id_songaydi'],'tenvi')?></b> </span>
                            <span> <?=phuongtien?>: <b><?=$tourItem['phuongtien'.$lang]?></b></span>
                        </p>
                        
                        <form class="form-contact validation-booktour" novalidate method="post" action="dat-tour" enctype="multipart/form-data">
                            <input type="hidden" name="idsp" value="<?=$tourItem['id']?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="title mt-3"><h2><?=thongtinnguoidat?></h2></div>
                                <div class="row">
                                    <div class="input-contact col-sm-6">
                                        <input type="text" class="form-control" id="ten" name="ten" placeholder="<?=hoten?>" required />
                                        <div class="invalid-feedback"><?=vuilongnhaphoten?></div>
                                    </div>
                                    <div class="input-contact col-sm-6">
                                        <input type="number" class="form-control" id="dienthoai" name="dienthoai" placeholder="<?=sodienthoai?>" required />
                                        <div class="invalid-feedback"><?=vuilongnhapsodienthoai?></div>
                                    </div>         
                                </div>
                                <div class="row">
                                    <div class="input-contact col-sm-6">
                                        <input type="text" class="form-control" id="diachi" name="diachi" placeholder="<?=diachi?>" required />
                                        <div class="invalid-feedback"><?=vuilongnhapdiachi?></div>
                                    </div>
                                    <div class="input-contact col-sm-6">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required />
                                        <div class="invalid-feedback"><?=vuilongnhapdiachiemail?></div>
                                    </div>
                                </div>
                                <div class="input-contact">
                                    <textarea class="form-control" id="noidung" name="noidung" placeholder="<?=noidung?>" required /></textarea>
                                    <div class="invalid-feedback"><?=vuilongnhapnoidung?></div>
                                </div>
                                <div class="title mt-3"><h2><?=soluongnguoi?></h2></div>
                                <div class="row">
                                    <div class="input-contact col-sm-6">
                                        <label for="nguoilon"><?=so?> <?=nguoilon?></label>
                                        <input type="number" onkeyup="getTotalOrder()" class="form-control" id="nguoilon" name="nguoilon" value="1" placeholder="<?=nguoilon?>"/>
                                        <div class="invalid-feedback"><?=vuilongnhapsonguoilon?></div>
                                    </div>
                                    <div class="input-contact col-sm-6">
                                        <label for="treem"><?=so?> <?=treem?></label>
                                        <input type="number" onkeyup="getTotalOrder()" class="form-control" id="treem" name="treem" value="0" placeholder="<?=treem?>"/>
                                        <div class="invalid-feedback"><?=vuilongnhapsotreem?></div>
                                    </div>
                                    <div class="input-contact col-sm-6">
                                        <label for="embe"><?=so?> <?=embe?></label>
                                        <input type="number" onkeyup="getTotalOrder()" class="form-control" id="embe" name="embe" value="0" placeholder="<?=embe?>"/>
                                        <div class="invalid-feedback"><?=vuilongnhapsoembe?></div>
                                    </div>
                                </div>

                                <div class="title mt-3"><h2><?=hinhthucthanhtoan?></h2></div>

                                <div class="content-box">
                                    <?php foreach ($httt as $key => $value): ?>
                                    <div class="radio-wrapper content-box-row">
                                        <label class="container-cart"><?=$value['ten'.$lang]?>
                                        <input type="radio" class="custom-control-input" name="payments" value="<?=$value['id']?>" required>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <?php endforeach ?>
                                    <div class="radio-wrapper content-box-row">
                                        <label class="container-cart">Thanh toán online 
                                            <input type="radio" name="payments" class="custom-control-input" value="payment_vnp" required>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sticky-75">
                                    <div class="table-tour-responsive">
                                    <div class="title mt-3"><h2><?=giatour?></h2></div>
                                    <div class="chitiet_giatour">
                                        <div class="thongtin1 rogn1"><?=nguoilon?></div>
                                        <div class="thongtin1 rogn2"><?=treem?></div>
                                        <div class="thongtin1 rogn3"><?=embe?></div>
                                        <div class="thongtin1 rogn4"><?=chiphikhac?></div>
                                        <div class="thongtin1"><?=phuthu?></div>
                                        
                                    </div>
                                    <div class="chitiet_giatour">
                                        <div class="thongtin1 rogn1">
                                            <?=($tourItem['gianguoilon']) ? $func->format_money($tourItem['gianguoilon']) : lienhe?>
                                        </div>
                                        <div class="thongtin1 rogn2">
                                            <?=($tourItem['giatreem']) ? $func->format_money($tourItem['giatreem']) : lienhe?>                         
                                        </div>
                                        <div class="thongtin1 rogn3">
                                            <?=($tourItem['giaembe']) ? $func->format_money($tourItem['giaembe']) : mienphi?> 
                                        </div>
                                        <div class="thongtin1 rogn4">
                                            <?=($tourItem['phuthuphongdon']) ? $func->format_money($tourItem['phuthuphongdon']) : mienphi?> 
                                        </div>
                                        <div class="thongtin1">
                                            <?=($tourItem['chiphikhac']) ? $func->format_money($tourItem['chiphikhac']) : mienphi?>
                                        </div>
                                        
                                    </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="total-tour">
                                        <?=tongtien?>: <span><?=($tourItem['gianguoilon']) ? $func->format_money($tourItem['gianguoilon']) : lienhe?></span>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="note mt-3">
                                        <h3><?=ghichu?>:</h3> 
                                        <div class="content-note">
                                            <p><i class="fa fa-check"></i><?=songuoilon?></p>
                                            <p><i class="fa fa-check"></i><?=sotreem?></p>
                                            <p><i class="fa fa-check"></i><?=soembe?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary mt-2" name="submit-tour" value="<?=thanhtoan?>" disabled/>
                        <input type="hidden" name="recaptcha_response_tour" id="recaptchaResponseTour">
                    </div>
                    </div>
                </form>
            </div>   
            <div class="clear"></div>
        </div>
    </div>
</div>