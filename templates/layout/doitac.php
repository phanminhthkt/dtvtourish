<?php if(count($partner)) { ?>
	<div id="doitac">
		<div class="maxwidth wow fadeInUp">
			<div class="title-main">
				<h2>Đối tác</h2>
			</div>
			<div class='relative'>
				<p class="control-carousel prev-carousel prev-partner transition"><i class="fas fa-chevron-left"></i></p>
				<div class="owl-carousel owl-theme owl-partner">
					<?php foreach($partner as $v) { ?>
						<div>
							<a class="partner text-decoration-none" href="<?=$v['tenkhongdauvi']?>" title="<?=$v['ten'.$lang]?>">
								<img onerror="this.src='<?=THUMBS?>/180x75x2/assets/images/noimage.png';" src="<?=THUMBS?>/180x75x2/<?=UPLOAD_PHOTO_L.$v['photo']?>" alt="<?=$v['ten'.$lang]?>"/>
							</a>
						</div>
					<?php } ?>
				</div>
				<p class="control-carousel next-carousel next-partner transition"><i class="fas fa-chevron-right"></i></p>
			</div>
		</div>
	</div>
<?php } ?>