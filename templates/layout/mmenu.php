<div class="menu-res hidden-xl">
    <div class="menu-bar-res">
        
        <div class="lang-header hidden-xl">
            <a href="ngon-ngu/vi/"><img src="assets/images/vi.jpg" alt="Tiếng Việt"></a>
            <a href="ngon-ngu/en/"><img src="assets/images/en.jpg" alt="Tiếng Anh"></a>
        </div>
        <a id="hamburger" href="#menu" class="ml-1" title="Menu"><span></span></a>
    </div>
    <nav id="menu">
        <ul>
        <li><a href="trang-chu" title="<?=trangchu?>"><?=trangchu?></a></li>
            <li><a href="gioi-thieu" title="<?=gioithieu?>"><?=gioithieu?></a></li>
            <?php if(count($splistmenu)) { ?>
                    <?php for($i=0;$i<count($splistmenu); $i++) {
                        $spcatmenu = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, id from #_product_cat where id_list = ? and hienthi > 0 order by stt,id desc",array($splistmenu[$i]['id'])); ?>
                        <li>
                            <a title="<?=$splistmenu[$i]['ten'.$lang]?>" href="<?=$splistmenu[$i][$sluglang]?>"><?=$splistmenu[$i]['ten'.$lang]?></a>
                            <?php if(count($spcatmenu)>0) { ?>
                                <ul>
                                    <?php for($j=0;$j<count($spcatmenu);$j++) {
                                        $spitemmenu = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, id from #_product_item where id_cat = ? and hienthi > 0 order by stt,id desc",array($spcatmenu[$j]['id'])); ?>
                                        <li>
                                            <a title="<?=$spcatmenu[$j]['ten'.$lang]?>" href="<?=$spcatmenu[$j][$sluglang]?>"><?=$spcatmenu[$j]['ten'.$lang]?></a>
                                            <?php if(count($spitemmenu)) { ?>
                                                <ul>
                                                    <?php for($u=0;$u<count($spitemmenu);$u++) {
                                                        $spsubmenu = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, id from #_product_sub where id_item = ? and hienthi > 0 order by stt,id desc",array($spitemmenu[$u]['id'])); ?>
                                                        <li>
                                                            <a title="<?=$spitemmenu[$u]['ten'.$lang]?>" href="<?=$spitemmenu[$u][$sluglang]?>"><?=$spitemmenu[$u]['ten'.$lang]?></a>
                                                            <?php if(count($spsubmenu)) { ?>
                                                                <ul>
                                                                    <?php for($s=0;$s<count($spsubmenu);$s++) { ?>
                                                                        <li>
                                                                            <a title="<?=$spsubmenu[$s]['ten'.$lang]?>" href="<?=$spsubmenu[$s][$sluglang]?>"><?=$spsubmenu[$s]['ten'.$lang]?></a>
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
                            <?php } ?>
                        </li>
                    <?php } ?>
            <?php } ?>
            <li>
                <a href="visa" title="<?=dichvuvisa?>"><?=dichvuvisa?></a>
            </li>
            <li>
                <a href="ve-may-bay" title="<?=vemaybay?>"><?=vemaybay?></a>
            </li>
            <li>
                <a title="<?=dichvukhac?>"><?=dichvukhac?></a>
                <ul>
                    <li><a href="dich-vu" title="<?=khachsan?>"><?=khachsan?></a>
                        <?php if(count($dvlistmenu)){ ?>
                            <ul>
                                <?php foreach($dvlistmenu as $v){ ?>
                                    <li><a href="<?=$v[$sluglang]?>"><?=$v['ten'.$lang]?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                    <li><a href="thue-xe" title="<?=xedulich?>"><?=xedulich?></a></li>
                    <li><a href="huong-dan-vien" title="<?=huongdanvien?>"><?=huongdanvien?></a>
                        <?php if(count($hdvlistmenu)){ ?>
                            <ul>
                                <?php foreach($hdvlistmenu as $v){ ?>
                                    <li><a href="<?=$v[$sluglang]?>"><?=$v['ten'.$lang]?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                    <li><a href="khach-doan" title="<?=dichvukhachdoan?>"><?=dichvukhachdoan?></a>
                        <?php if(count($kdlistmenu)){ ?>
                            <ul>
                                <?php foreach($hdvlistmenu as $v){ ?>
                                    <li><a href="<?=$v[$sluglang]?>"><?=$v['ten'.$lang]?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                </ul>
            </li>
             <li><a href="tuyen-dung" title="<?=tuyendung?>"><?=tuyendung?></a></li>
            <li><a href="lien-he" title="<?=lienhe?>"><?=lienhe?></a></li>
    </ul>
    </nav>
</div>