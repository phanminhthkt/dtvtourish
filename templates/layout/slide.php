<?php if(count($slider)) { ?>
    <div class="slideshow">
        <div class="swiper-container slidertop">
            <div class="swiper-wrapper">
                <?php foreach($slider as $v) { ?>
                    <div class="swiper-slide">
                        <a href="<?=$v['link']?>" target="_blank" title="<?=$v['photo']?>"><img class="imgslide w-100" onerror="this.src='<?=THUMBS?>/1366x465x1/assets/images/noimage.png';" src="<?=THUMBS?>/1366x465x1/<?=UPLOAD_PHOTO_L.$v['photo']?>" alt="<?=$v['ten'.$lang]?>" title="<?=$v['photo']?>"/></a>
                    </div>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>     
        <div class="filter">
            <div class="maxwidth">
                <div class="cover-filter">
                    <div class="filter-top"><?=timkiemtour?></div>
                    <div class="filter-input ">
                        <?php foreach($splistmenu as $v){ 
                            if(isset($_GET['id_list']) && $_GET['id_list']!='' && $_GET['id_list'] == $v['id']){
                                $check ='checked';
                            }else{
                                $check ='';
                            }
                        ?>
                        <div class="box-filter-item d-sm-inline-block d-block mr-2">
                            <label for="list<?=$v['id']?>">
                                <input type="radio" id="list<?=$v['id']?>" class="form-control" name="id_list" value="<?=$v['id']?>" <?=$check?>>
                                <?=$v['ten'.$lang]?>
                            </label>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="filter-input row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="box-filter-item">
                                        <?=$func->get_attribute_input(@$_GET['id_khoihanh'],'id_khoihanh','khoi-hanh',chondiemkhoihanh)?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="box-filter-item">
                                        <?=$func->get_attribute_input(@$_GET['id_noiden'],'id_noiden','noi-den',chondiemden)?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="box-filter-item">
                                        <?=$func->get_attribute_input(@$_GET['id_songaydi'],'id_songaydi','so-ngay-di',chonsongaydi)?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="box-filter-item">
                                        <input type="text" id="keyword_advance" placeholder="<?=nhaptukhoatimkiem?>" onkeypress="doEnterFilter(event,'keyword_advance');" value="<?=@$_GET['keyword']?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <p class="search-adv form-control" onclick="onFilter('keyword_advance');"><?=timkiem?></p>
                        </div>
                    </div>  
                </div>
            </div>
        </div>    
        
    </div>
<?php } ?>