<?php if(count($newsnb)){ ?>
<section id="news">
	<div class="maxwidth wow fadeInUp">
		<div class="title-main">
			<h2>Tin tức - sự kiện</h2>
		</div>
		<div class="owl-carousel owl-theme owl-news">
			<?php foreach($newsnb as $v) { ?>
				<a class="newshome-normal text-decoration-none w-clear" href="<?=$v[$sluglang]?>" title="<?=$v['ten'.$lang]?>">
					<p class="pic-newshome-normal scale-img"><img onerror="this.src='<?=THUMBS?>/385x270x2/assets/images/noimage.png';" src="<?=THUMBS?>/385x270x1/<?=UPLOAD_NEWS_L.$v['photo']?>" alt="<?=$v['ten'.$lang]?>"></p>
					<div class="info-newshome-normal">
						<h3 class="name-newshome text-split"><?=$v['ten'.$lang]?></h3>
						<p class="desc-newshome text-split"><?=$v['mota'.$lang]?></p>
					</div>
				</a>
			<?php } ?>
		</div>
	</div>
</section>
<?php } ?>