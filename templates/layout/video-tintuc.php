<?php if(count($newsnb) || $videonb){ ?>
<section id="video-news">
	<div class="maxwidth">
		<div class="row">
			<div class="col-md-8 col-sm-12 col-12">
				<p class="title-intro"><span><?=tintucsukien?></span></p>
				<div class="newshome-intro w-clear">
					<a class="newshome-best text-decoration-none" href="<?=$newsnb[0][$sluglang]?>" title="<?=$newsnb[0]['ten'.$lang]?>">
						<p class="pic-newshome-best scale-img"><img class="w-100" onerror="this.src='<?=THUMBS?>/375x245x1/assets/images/noimage.png';" src="<?=WATERMARK?>/news/375x245x1/<?=UPLOAD_NEWS_L.$newsnb[0]['photo']?>" alt="<?=$newsnb[0]['ten'.$lang]?>"></p>
						<h3 class="name-newshome text-split"><?=$newsnb[0]['ten'.$lang]?></h3>
						<p class="desc-newshome text-split"><?=$newsnb[0]['mota'.$lang]?></p>
						<span class="view-newshome transition"><?=xemthem?></span>
					</a>

					<ul class="owl-carousel owl-theme owl-news">
						<?php foreach($newsnb as $v) { ?>
							<li>
								<a class="news text-decoration-none w-clear" href="<?=$v['tenkhongdauvi']?>" title="<?=$v['ten'.$lang]?>">
						            <p class="pic-news scale-img"><img onerror="this.src='<?=THUMBS?>/150x110x1/assets/images/noimage.png';" src="<?=THUMBS?>/150x110x1/<?=UPLOAD_NEWS_L.$v['photo']?>" alt="<?=$v['ten'.$lang]?>"></p>
						            <div class="info-news">
						                <h3 class="name-news"><?=$v['ten'.$lang]?></h3>
						                <div class="desc-news text-split"><?=$func->catchuoi($v['mota'.$lang],70)?></div>
						            </div>
						        </a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 col-12">
				<p class="title-intro"><span><?=video?></span></p>
				<div class="videohome-intro">
					<?=$addons->setAddons('video-fotorama', 'video-fotorama', 10);?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php } ?>