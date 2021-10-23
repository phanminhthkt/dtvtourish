<div class="support-online">
    <div class="support-content" style="display: block;">
        <a target="_blank" href="tel:<?=preg_replace('/[^0-9]/','',$optsetting['hotline']);?>" class="not-loading call-now" rel="nofollow">
            <i class="fab fa-whatsapp"></i>
            <div class="animated infinite zoomIn kenit-alo-circle"></div>
            <div class="animated infinite pulse kenit-alo-circle-fill"></div>
            <span>Hotline: <?=preg_replace('/[^0-9]/','',$optsetting['hotline']);?></span>
        </a>
        <a class="mes not-loading" target="_blank" href="lien-he">
            <i class="fa fa-map-marker"></i>
            <span>Chỉ đường</span>
        </a>
        <a class="mes not-loading" target="_blank" href="//zalo.me/<?=preg_replace('/[^0-9]/','',$optsetting['zalo']);?>">
            <img src="assets/images/zalo-combo.png" alt="icon zalo">
            <span>Zalo</span>
        </a>
        <a class="sms not-loading" target="_blank" href="sms:<?=preg_replace('/[^0-9]/','',$optsetting['hotline']);?>">
            <i class="fab fa-weixin"></i>
            <span>SMS: <?=preg_replace('/[^0-9]/','',$optsetting['hotline']);?></span>
        </a>
    </div>
    <a class="btn-support not-loading">
        <div class="animated infinite zoomIn kenit-alo-circle"></div>
        <div class="animated infinite pulse kenit-alo-circle-fill"></div>
        <i class="fa fa-user-circle"></i>
    </a>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        /* Phone support */
        $('.support-content').hide();
        $('a.btn-support').click(function (e) {
            e.stopPropagation();
            $('.support-content').slideToggle();
        });
        $('.support-content').click(function (e) {
            e.stopPropagation();
        });
        $(document).click(function () {
            $('.support-content').slideUp();
        });
    })
</script>