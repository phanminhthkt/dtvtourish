<div class="maxwidth">
    <div class="content-main w-clear">
        <div class="row">
             
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12 col-sm-12 w-clear">
                        <div class="right-pro-detail">
                            <p class="title-pro-detail">
                                <?=$row_detail['ten'.$lang]?>
                            </p>
                            <div class="social-plugin social-plugin-pro-detail w-clear">
                                <div class="addthis_inline_share_toolbox_qj48"></div>
                                <div class="zalo-share-button" data-href="<?=$func->getCurrentPageURL()?>" data-oaid="<?=($optsetting['oaidzalo']!='')?$optsetting['oaidzalo']:'579745863508352884'?>" data-layout="1" data-color="blue" data-customize=false></div>
                            </div>
                            <ul class="attr-pro-detail">
                                <li class="w-clear">
                                    <label class="attr-label-pro-detail">
                                        <?=gia?>:</label>
                                    <div class="attr-content-pro-detail">
                                        <span class="price-new-pro-detail">
                                            <?=($row_detail['gianguoilon']) ? $func->format_money($row_detail['gianguoilon']) : lienhe?></span>
                                    </div>
                                </li>
                                <li class="w-clear">
                                    <label class="attr-label-pro-detail">
                                        <?=masp?>:</label>
                                    <div class="attr-content-pro-detail">
                                        <span class="tourcode">
                                            <?=($row_detail['masp'])?></span>
                                    </div>
                                </li>
                                <li class="w-clear">
                                    <label class="attr-label-pro-detail">
                                        <?=socho?>:</label>
                                    <div class="attr-content-pro-detail">
                                        <span class="socho">
                                            <?=($row_detail['socho']) ? $row_detail['socho'] : lienhe?></span>
                                    </div>
                                </li>
                                <li class="w-clear">
                                    <label class="attr-label-pro-detail">
                                        <?=noikhoihanh?>:</label>
                                    <div class="attr-content-pro-detail">
                                        <?=$func->getValueAttribute($row_detail['id_khoihanh'],'tenvi')?>
                                    </div>
                                </li>
                                <li class="w-clear">
                                    <label class="attr-label-pro-detail">
                                        <?=noiden?>:</label>
                                    <div class="attr-content-pro-detail">
                                        <?=$func->getValueAttribute($row_detail['id_noiden'],'tenvi')?>
                                    </div>
                                </li>
                                <li class="w-clear">
                                    <label class="attr-label-pro-detail">
                                        <?=phuongtien?>:</label>
                                    <div class="attr-content-pro-detail">
                                        <?=$row_detail['phuongtien'.$lang]?>
                                    </div>
                                </li>
                                <li class="w-clear">
                                    <label class="attr-label-pro-detail">
                                        <?=ngaykhoihanh?>:</label>
                                    <div class="attr-content-pro-detail ngaykhoihanh">
                                        <?=$row_detail['ngaykhoihanh'.$lang]?>
                                    </div>
                                </li>
                                <li class="w-clear">
                                    <label class="attr-label-pro-detail">
                                        <?=luotxem?>:</label>
                                    <div class="attr-content-pro-detail">
                                        <?=$row_detail['luotxem']?>
                                    </div>
                                </li>
                            </ul>
                            <div class="cart-pro-detail">
                                <a class="transition buynow addcart text-decoration-none" href="dat-tour?id=<?=$row_detail['id']?>"><i class="fas fa-shopping-bag"></i><span><?=dattour?></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(isset($pro_tags) && count($pro_tags) > 0){ ?>
                <div class="clear20"></div>
                <div class="tags-pro-detail w-clear">
                    <?php foreach($pro_tags as $v) { ?>
                        <a class="transition text-decoration-none w-clear" href="<?=$v[$sluglang]?>" title="<?=$v['ten'.$lang]?>"><i class="fas fa-tags"></i><?=$v['ten'.$lang]?></a>
                    <?php } ?>
                </div>
                 <?php } ?>
                <div class="clear20"></div>
                <div class="tabs-pro-detail">
                    <ul class="ul-tabs-pro-detail w-clear">
                        <li class="active transition" data-tabs="info-lichtrinh-detail">
                            <?=lichtrinh?>
                        </li>
                        <li class="transition" data-tabs="info-quydinh-detail">
                            <?=quydinh?>
                        </li>
                        <li class="transition" data-tabs="commentfb-pro-detail">
                            <?=binhluan?>
                        </li>
                    </ul>
                    <div class="content-tabs-pro-detail info-lichtrinh-detail active">
                        <?=(isset($row_detail['lichtrinh'.$lang]) && $row_detail['lichtrinh'.$lang] != '') ? htmlspecialchars_decode($row_detail['lichtrinh'.$lang]) : ''?>
                    </div>
                    <div class="content-tabs-pro-detail info-quydinh-detail">
                        <?=(isset($row_detail['quydinh'.$lang]) && $row_detail['quydinh'.$lang] != '') ? htmlspecialchars_decode($row_detail['quydinh'.$lang]) : ''?>
                    </div>
                    <div class="content-tabs-pro-detail commentfb-pro-detail">
                        <div class="fb-comments" data-href="<?=$func->getCurrentPageURL()?>" data-numposts="3" data-colorscheme="light" data-width="100%"></div>
                    </div>
                </div>
                <div class="content-main w-clear mt-3">
                     <h3 class="title-right mb-4">
                        <?=sanphamcungloai?>
                    </h3>
                    <?php if(isset($product) && count($product) > 0) {  
                        echo $func->get_product($product,'col-md-4 col-sm-6','');
                    }else{ ?>
                    <div class="alert alert-warning" role="alert">
                        <strong>
                            <?=khongtimthayketqua?></strong>
                    </div>
                    <?php } ?>
                    <div class="clear"></div>
                    <div class="pagination-home">
                        <?=(isset($paging) && $paging != '') ? $paging : ''?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="sticky-75">
                    <div class="list_01">
                        <h3><?=lidochon?> <?=$setting['ten'.$lang]?> ?</h3>
                        <ul class="listnew">
                            <?php foreach ($reasons as $key => $value): ?>
                            <li>
                                <p><?=$value['ten'.$lang]?></p>
                            </li>
                            <?php endforeach ?>
                        </ul>     
                    </div>
                    <div class="tour-promotions">
                        <h3 class="title-right"><?=tourkhuyenmai?></h3>
                        <?php foreach ($tourPromotion as $key => $value): ?>
                        <p><a href="<?=$value[$sluglang]?>"><i class="fa fa-caret-right"></i><?=$value['ten'.$lang]?></a></p>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>