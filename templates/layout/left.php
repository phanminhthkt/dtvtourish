<div class="menu_mega">
<div class="title_menu">
    <span class="title_">Danh mục sản phẩm</span>
</div>
<?php if(count($splistmenu)){ ?>
<div class="menu_all_site">
    <ul class='nav-left accordion'>
        <?php foreach($splistmenu as $v_list){ 
            $spcatmenu = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, id from #_product_cat where id_list = ? and hienthi > 0 order by stt,id desc",array($v_list['id']));
        ?>
        <li class="nav-item lv1">
            <a title="<?=$v_list['ten'.$lang]?>" href="<?=$v_list[$sluglang]?>">
                <?=$v_list['ten'.$lang]?>
            </a>
            <?php if(count($spcatmenu)){ ?>
                <ul class="nav-right_one">
                    <?php  foreach($spcatmenu as $v_cat){ 
                        $spitemmenu = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, id from #_product_item where id_cat = ? and hienthi > 0 order by stt,id desc",array($v_cat['id']));
                    ?>
                    <li class="nav-item lv2">
                        <a title="<?=$v_cat['ten'.$lang]?>" href="<?=$v_cat[$sluglang]?>"><?=$v_cat['ten'.$lang]?></a>
                        <?php if(count($spitemmenu)){ ?>
                            <ul class="nav-right_two">
                                <?php  foreach($spitemmenu as $v_item){  ?>
                                <li class="nav-item lv3">
                                    <a title="<?=$v_item['ten'.$lang]?>" href="<?=$v_item[$sluglang]?>"><?=$v_item['ten'.$lang]?></a>
                                </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </li>
        <?php } ?>
    </ul>
</div>
<?php } ?>
</div>