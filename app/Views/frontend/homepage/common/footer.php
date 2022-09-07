<?php $main_menu = get_menu(array('keyword' => 'menu-footer','language' => $language, 'output' => 'array')); ?>
<?php $learn = get_menu(array('keyword' => 'learn','language' => $language, 'output' => 'array')); ?>
<?php $partner = get_slide(['keyword' => 'partner' , 'language' => $language ]); ?>
<?php
    $panel = get_panel([
        'locate' => 'footer',
        'language' => $language
    ]);
    if(isset($panel) && is_array($panel) && count($panel)){
        foreach ($panel as $key => $value) {
            $panel_footer[$value['keyword']] = $value;
        }
    }
?>
<div class="global-footer-group">
    <div class="container">
        <?php if(isset($panel_footer['news']['data']) && is_array($panel_footer['news']['data']) && count($panel_footer['news']['data'])){ ?>
            <div class="footer-art-group d-flex">
                <div class="item-gorup footer-art-holder">
                    <div class="box-title">
                        <p class="title"><?php echo $panel_footer['news']['title'] ?></p>
                        <a href="<?php echo $panel_footer['news']['canonical'] ?>" class="blue font-300">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
                    </div>
                    <div class="d-flex flex-wrap" id="js-global-article">
                        <?php foreach ($panel_footer['news']['data'] as $value) { ?>
                            <div class="item">
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="img"><img src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>"></a>
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="title"><?php echo $value['title'] ?></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="item-gorup global-video-group">
                    <a href="<?php echo $panel_footer['news']['description'] ?>" data-fancybox>
                        <img data-src="<?php echo $panel_footer['news']['image'] ?>" alt="video" class="lazy w-auto h-auto" width="1" height="1" />
                    </a>
                </div>
            </div>
        <?php } ?>
        <?php if(isset($partner) && is_array($partner) && count($partner)){ ?>
            <div class="footer-brand-group">
                <p class="title">ĐỐI TÁC CỦA CHÚNG TÔI</p>

                <div class="owl-carousel owl-theme custom-nav hover-img" id="js-footer-brand">
                    <?php foreach ($partner as $value) { ?>
                        <a href="<?php echo $value['canonical'] ?>">
                            <img data-src="<?php echo $value['image'] ?>" alt="brand" width="178" height="52" class="owl-lazy" />
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php if(isset($learn['data']) && is_array($learn['data']) && count($learn['data'])){ ?>
        <div class="footer-tag-group">
            <b>Tìm hiểu thêm:</b>
            <?php foreach ($learn['data'] as $value) { ?>
                <a href="<?php echo $value['canonical'] ?>"><?php echo $value['title'] ?></a>
            <?php } ?>
        </div>
        <?php } ?>
    </div>

    <div class="footer-newsletter-group">
        <p class="title">ĐĂNG KÝ NHẬN EMAIL THÔNG BÁO KHUYẾN MẠI HOẶC ĐỂ ĐƯỢC TƯ VẤN MIỄN PHÍ</p>

        <div class="newsletter-form position-relative">
            <input type="text" id="js-email-newsletter" class="newsletter-input email_contact_va" placeholder="Nhập email của bạn" />
            <a href="javascript:void(0)" class="contact_email_va">GỬI</a>
        </div>
    </div>

    <div class="footer-content-group">
        <div class="container">
            <div class="row">
                <?php if(isset($main_menu['data']) && is_array($main_menu['data']) && count($main_menu['data'])){ ?>
                    <?php foreach ($main_menu['data'] as $value) { ?>
                        <div class="col">
                            <p class="title"><?php echo $value['title'] ?></p>
                            <?php if(isset($value['children']) && is_array($value['children']) && count($value['children'])){ ?>
                                <div class="content">
                                    <?php foreach ($value['children'] as $valueChild) { ?>
                                        <a href="<?php echo $valueChild['canonical'] ?>"><?php echo $valueChild['title'] ?></a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
                <div class="col">
                    <div class="fb-page" data-href="<?php echo $general['social_facebook'] ?>" data-tabs="" data-width="250" data-height="105" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" >
                        <blockquote cite="<?php echo $general['social_facebook'] ?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $general['social_facebook'] ?>"><?php echo BASE_URL ?></a></blockquote>
                    </div>

                    <div class="footer-social-group">
                        <a href="<?php echo $general['social_facebook'] ?>" class="icons icon-fb" target="_blank"></a>
                        <a href="<?php echo $general['social_tiktok'] ?>" class="icons icon-tiktok" target="_blank"></a>
                        <a href="<?php echo $general['social_insta'] ?>" class="icons icon-instagram" target="_blank"></a>
                    </div>

                    <p class="title font-700" style="line-height: 30px;">CHẤP NHẬN THANH TOÁN QUA:</p>

                    <div class="footer-bank-group">
                        <i class="icons icon-visa"></i>
                        <i class="icons icon-mastercard"></i>
                        <i class="icons icon-techcombank"></i>
                        <i class="icons icon-vietcombank"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer-end-group container d-flex flex-wrap align-items-center justify-content-between" style="padding: 10px 6px;">
    <p class="m-0 text-13" style="line-height: 24px;">
        <b class="d-block"><?php echo $general['homepage_ft'] ?></b>
    </p>

    <a href="<?php echo $general['contact_bct'] ?>" target="_blank"><img data-src="/resources/template/2022/images/bct.png" alt="bct" width="115" height="44" class="lazy" /></a>
</div>
<div class="success-form" style="display: none;">
    <div class="content-container">
        <div class="success-checkmark">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
        </div>

        <div class="text-center content-text text-24"> Thêm sản phẩm vào giỏ hàng thành công !</div>
    </div>
</div>
<a href="javascript:void(0)" class="global-goTop fas fa-angle-up" id="js-goTop"></a>

