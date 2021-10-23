<div id="footer">
    <div class="footer-article">
        <div class="maxwidth wow fadeInUp">
            <div class="row">
                <div class="col-md-6">
                    <div class="footer-news">
                        <div class="info-footer"><?=htmlspecialchars_decode($footer['noidung'.$lang])?></div>
                        <div class="follow-us">
                            <?php foreach($social_footer as $v) { ?>
                                <div>
                                    <a href="<?=$v['link']?>" target="_blank" title="<?=$v['ten'.$lang]?>"><img onerror="this.src='<?=THUMBS?>/38x38x2/assets/images/noimage.png';" src="<?=THUMBS?>/38x38x2/<?=UPLOAD_PHOTO_L.$v['photo']?>" alt="<?=$v['ten'.$lang]?>" title="<?=$v['ten'.$lang]?>"/></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-footer">
                        <h2 class="title-footer"><?=chinhsach?></h2>
                        <div class="footer-news">
                            <ul class="footer-ul">
                                <?php foreach($cs as $v) { ?>
                                    <li><a class="text-decoration-none" href="<?=$v[$sluglang]?>" title="<?=$v['ten'.$lang]?>"><?=$v['ten'.$lang]?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php if ($bct['hienthi']==1): ?>
                        <div class="footer-news">
                            <a  href="<?=$bct['link']?>">
                                <img src="<?=THUMBS?>/158x60x2/<?=UPLOAD_PHOTO_L.$bct['photo']?>"/>
                            </a>
                        </div>     
                        <?php endif ?>
                             
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-news">
                        <h2 class="title-footer">FANPAGE FACEBOOK</h2>
                        <?=$addons->setAddons('fanpage-facebook', 'fanpage-facebook', 10);?>
                    </div>
                    <div class="info-footer">
                        <h2 class="title-footer"><?=dangkynhantin?></h2>
                        <form class="form-newsletter validation-newsletter" novalidate method="post" action="" enctype="multipart/form-data">
                            <div class="newsletter-input">
                                <input type="email" class="form-control" id="email-newsletter" name="email-newsletter" placeholder="<?=nhapemail?>" required />
                                <div class="invalid-feedback"><?=vuilongnhapdiachiemail?></div>
                            </div>
                           <div class="newsletter-button">
                                <input type="submit" name="submit-newsletter" value="Đăng ký" disabled>
                                <input type="hidden" name="recaptcha_response_newsletter" id="recaptchaResponseNewsletter">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-powered">
        <div class="maxwidth wow fadeInUp">
            <p class="copyright">2021 Copyright <?=$setting['ten'.$lang]?>.</p>
            <p class="statistic">
                <span><?=dangonline?>:<?=$online?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span><?=trongthang?>:<?=$counter['month']?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span><?=tongtruycap?>:<?=$counter['total']?></span>
            </p>
        </div>
    </div>
</div>
<?=$addons->setAddons('footer-map', 'footer-map', 10);?>
<?=$addons->setAddons('messages-facebook', 'messages-facebook', 10);?>

<div class="hidden-xs">
    <?=$addons->setAddons('messages-facebook', 'messages-facebook', 10);?>
</div>
<a class="btn-zalo btn-frame text-decoration-none hidden-xs" target="_blank" href="https://zalo.me/<?=preg_replace('/[^0-9]/','',$optsetting['zalo']);?>">
    <div class="animated infinite zoomIn kenit-alo-circle"></div>
    <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    <i><img src="assets/images/zl.png" alt="Zalo"></i>
</a>
<a class="btn-phone btn-frame text-decoration-none hidden-xs" href="tel:<?=preg_replace('/[^0-9]/','',$optsetting['hotline']);?>">
    <div class="animated infinite zoomIn kenit-alo-circle"></div>
    <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    <i><img src="assets/images/hl.png" alt="Hotline"></i>
</a>
