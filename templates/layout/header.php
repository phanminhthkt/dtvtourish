<div id="header">
	<div class="maxwidth">

		<a id="logo" href="index.php">
			<img src="<?=THUMBS?>/180x90x2/<?=UPLOAD_PHOTO_L.$logo['photo']?>"/>
		</a>
		
		<div id="header-right" class="hidden-lg hidden-md hidden-sm hidden-xs">
			<div class="box-info">
				<p><span><?=$optsetting['dienthoai']?></span></p>
				<p><span><?=$optsetting['dienthoai']?></span></p>
				<p><span>Skype:<?=$optsetting['skype']?></span></p>
			</div>
		</div>
		<?php include TEMPLATE.LAYOUT."mmenu.php";   ?>
	</div>
	<div class="clear"></div>
</div>
<style type="text/css">
	#header{
		background:url(<?=UPLOAD_PHOTO_L.$banner['photo']?>) no-repeat;
		background-size: cover;
	}
</style>