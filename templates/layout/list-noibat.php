<?php if(count($splistnb)) { ?>
<section id="list-noibat">
    <?php foreach($splistnb as $k_list => $v_list){ 
		$pronb_incat = $d->rawQuery("select ten$lang, tenkhongdauvi,id from #_product_cat where type = ? and id_list= ?  and hienthi > 0 order by stt asc",array('tour',$v_list['id']));
	?>
    <div class="cover-product" data-rel="<?=$k_list?>">
        <div class="maxwidth">
            <div class="title-main title-list">
                <h2><?=$v_list['ten'.$lang]?></h2>
            </div>
            <div class="tab_index_cat">
                <?php foreach($pronb_incat as $k_cat => $v_cat){ ?>
                <a href="#tab_cat<?=$v_cat['id']?>" class="item_tab_index_cat <?=$k_cat == 0 ? 'active':''?>">
                    <?=$v_cat['ten'.$lang]?></a>
                <?php } ?>
            </div>
            <?php foreach($pronb_incat as $k_cat => $v_cat){ 
				$product_ncat = $d->rawQuery("select id from #_product where type = ? and id_cat= ? and noibat > 0 and hienthi > 0 order by stt asc",array('tour',$v_cat['id']));
				if(count($product_ncat) > 0){ ?>
	            <div id="tab_cat<?=$v_cat['id']?>" class="content_tab_index_cat <?=$k_cat == 0 ? 'active':''?>">
	            	<div class="paging-product-category paging-product-category-<?=$v_cat['id']?>" data-cat="<?=$v_cat['id']?>"></div>
	            </div>
        	<?php } } ?>
            <div class="clear"></div>
        </div>
    </div>
    <?php } ?>
</section>
<?php } ?>