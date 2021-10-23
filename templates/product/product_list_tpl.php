<div class="maxwidth">
    <div class="content-main w-clear">
        <div class="row">
            <div class="col-lg-3 hidden-xs hidden-sm hidden-md"><?php include TEMPLATE.LAYOUT."left.php"; ?></div>
            <div class="col-lg-9">
                <div class="title-main"><h2><?=(@$title_cat!='')?$title_cat:@$title_crumb?></h2></div>
                    <?php if(isset($product_cat) && count($product_cat) > 0) {  
                        echo $func->get_product_cat($product_cat,'','');
                    }else{ ?>
                        <div class="alert alert-warning" role="alert">
                            <strong><?=khongtimthayketqua?></strong>
                        </div>
                    <?php } ?>
                <div class="clear"></div>
                <div class="pagination-home"><?=(isset($paging) && $paging != '') ? $paging : ''?></div>
            </div>
        </div>
    </div>
</div>