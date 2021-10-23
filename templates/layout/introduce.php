<section id="gioithieu">
	<div class="maxwidth wow fadeInUp">
		<div class="title-about">
			<span>Giới thiệu</span>
		</div>
		<div class="desc-about">
			<?=(isset($about_index['mota'.$lang]) && $about_index['mota'.$lang] != '') ? htmlspecialchars_decode($about_index['mota'.$lang]) : ''?>
		</div>
		<?php if(count($criteria)){ ?>
		<div class="mw-600">
			<div class="owl-carousel owl-theme owl-criteria">
			<?php foreach($criteria as $k => $v){ ?>
				<div class="tieuchi-items">
					<a>
						<div class="tieuchi-items__img">
							<img onerror="this.src='<?=THUMBS?>/92x100x2/assets/images/noimage.png';" src="<?=THUMBS?>/92x100x2/<?=UPLOAD_PHOTO_L.$v['photo']?>" alt="<?=$v['ten'.$lang]?>">
						</div>
					</a>
				</div>
			<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
</section>