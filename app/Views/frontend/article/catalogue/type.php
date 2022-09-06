<div class="background-news mb30">
    <div class="img-cover">
        <img src="<?php echo $general['another_banner_intro'] ?>" alt="banner">
    </div>
    <div class="banner-song ">
        <img src="/public/frontend/resources/img/song.png" alt="song">
    </div>
</div>
<section id="introduce" class="lazyloading_box">
    <div class="head-page">
        <div class="uk-container uk-container-center">
            <h1 class="title-page"><?php echo $detailCatalogue['title'] ?></h1>
        </div>
    </div>
    <div class="body-page">
        <div class="introducepage-1">
            <div class="uk-container uk-container-center">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-1-2">
                        <div class="img-cover img">
                            <img src="<?php echo $detailCatalogue['image'] ?>" alt="">
                        </div>
                    </div>
                    <div class="uk-width-large-1-2">
                        <div class="introduce-title">
                            <h2 class="introduce-text"><?php echo strip_tags(base64_decode($detailCatalogue['description'])) ?></h2>
                        </div>
                        <div class="introduce-content">
                            <?php echo base64_decode($detailCatalogue['content']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-container uk-container-center">
            <div class="border-cut"></div>
        </div>
        <?php if(isset($panel['video-intro']['data']) && is_array($panel['video-intro']['data']) && count($panel['video-intro']['data'])){ ?>
        <section class="demo-panel-2" style="background-image: url(<?php echo $panel['video-intro']['image'] ?>);">
            <div class="uk-container-center uk-container">
                <div class="uk-grid uk-grid-large uk-grid-match dt-reverse">
                    <div class="uk-width-large-1-2">
                        <div class="right-side">
                            <header class="secondary-header mb30">
                                <h2 class="heading">
                                <?php echo $panel['video-intro']['data'][0]['title'] ?>
                                </h2>
                            </header>
                            <div class="right-side-content">
                                <div class="description">
                                    <p>
                                        <?php echo strip_tags(base64_decode($panel['video-intro']['data'][0]['description'])) ?>
                                    </p>
                                </div>
                                <div class="more">
                                    <a href="<?php echo $panel['video-intro']['data'][0]['canonical'].HTSUFFIX ?>">
                                        Xem Thêm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-1-2">
                        <div class="left-side video">
                            <a href="<?php echo $panel['video-intro']['data'][0]['canonical'].HTSUFFIX ?>" class="img img-cover">
                                <img src="<?php echo $panel['video-intro']['data'][0]['image'] ?>">
                            </a>
                            <div class="button">
                                <a href="<?php echo $panel['video-intro']['data'][0]['canonical'].HTSUFFIX ?>">
                                    <i class="fa fa-play" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php } ?>
        <?php if(isset($panel['intro-box-2']['data']) && is_array($panel['intro-box-2']['data']) && count($panel['intro-box-2']['data'])){ ?>
        <div class="introducepage-3">
            <div class="introduce-banner">
                <img src="<?php echo $panel['intro-box-2']['data'][0]['image'] ?>" alt="<?php echo $panel['intro-box-2']['data']['0']['title'] ?>">
                <div class="introduce-banner-content">
                    <h4 class="introduce-banner-title"><?php echo $panel['intro-box-2']['data']['0']['title'] ?></h4>
                    <?php echo base64_decode($panel['intro-box-2']['data']['0']['description']) ?>
                    <?php echo base64_decode($panel['intro-box-2']['data']['0']['content']) ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if(isset($panel['intro-box-3']['data']) && is_array($panel['intro-box-3']['data']) && count($panel['intro-box-3']['data'])){ ?>
        <div class="introducepage-4 pb50">
            <div class="uk-container uk-container-center">
                <div class="introduce-title mb20">
                    <h3 class="introduce-text2"><?php echo $panel['intro-box-3']['data'][0]['title'] ?></h3>
                </div>
                <div class="introduce-content4">
                    <?php echo base64_decode($panel['intro-box-3']['data']['0']['description']) ?>
                    <?php echo base64_decode($panel['intro-box-3']['data']['0']['content']) ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>