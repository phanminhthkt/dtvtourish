<div class="contain-booking">
	<form class="form-newsletter--in validation-newsletter-in" novalidate method="post" action="booking-form" enctype="multipart/form-data">
	<h3 class="title-booking">Đặt <?=$title_crumb?></h3>
		<div class="row">
			<div class="col-md-12">
				<div class="newsletter-input--in">
	                <input type="text" class="form-control" id="topic-newsletter" name="topic-newsletter" placeholder="<?=chude?>" required />
	                <div class="invalid-feedback"><?=vuilongnhapchude?></div>
	            </div>
			</div>
			<div class="col-md-12">
				<div class="newsletter-input--in">
	                <input type="text" class="form-control" id="name-newsletter" name="name-newsletter" placeholder="<?=hoten?>" required />
	                <div class="invalid-feedback"><?=vuilongnhaphoten?></div>
	            </div>
			</div>
			<div class="col-md-12">
				<div class="newsletter-input--in">
			        <input type="email" class="form-control" id="email-newsletter" name="email-newsletter" placeholder="<?=nhapemail?>"/>
			        <div class="invalid-feedback"><?=vuilongnhapdiachiemail?></div>
			    </div>
			</div>
			<div class="col-md-12">
				<div class="newsletter-input--in">
			        <input type="number" class="form-control" id="phone-newsletter" name="phone-newsletter" placeholder="<?=sodienthoai?>" required />
	                <div class="invalid-feedback"><?=vuilongnhapsodienthoai?></div>
			    </div>
			</div>
			<div class="col-md-12">
				<div class="newsletter-input--in">
			        <input type="text" class="form-control" id="address-newsletter" name="address-newsletter" placeholder="<?=diachi?>"/>
	                <div class="invalid-feedback"><?=vuilongnhapdiachi?></div>
			    </div>
			</div>
		</div>
		<div class="newsletter-input--in newsletter-area">
	        <textarea class="form-control" id="noidung-newsletter" name="noidung-newsletter" placeholder="<?=noidung?>" required /></textarea>
		 		<div class="invalid-feedback"><?=vuilongnhapnoidung?></div>
		</div>
	    <div class="newsletter-button--in">
	        <input type="submit" name="submit-newsletter" value="<?=dat?>" disabled>
	        <input type="hidden" name="recaptcha_response_newsletter" id="recaptchaResponseNewsletter">
	        <input type="hidden" name="type-newsletter" value='<?=$type_form?>'>
	    </div>
	</form>
</div>