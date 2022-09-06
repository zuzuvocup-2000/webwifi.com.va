<div class="background-news mb30">
    <div class="img-cover">
        <img src="<?php echo $general['another_banner_news'] ?>" alt="banner">
    </div>
    <div class="banner-song ">
        <img src="/public/frontend/resources/img/song.png" alt="song">
    </div>
</div>
<section class="img-library-panel">
    <div class="uk-container uk-container-center">
        <header class="main-header mb40 lazyloading_box">
            <h1 class="heading mb15">
            <?php echo $detailCatalogue['title'] ?>
            </h1>
        </header>
        <?php if(isset($mediaList['image']) && is_array($mediaList['image']) && count($mediaList['image'])){ ?>
        <div class="panel-body lazyloading_box">
            <header class="secondary-header mb40">
                <h2 class="heading">
                    <?php echo $mediaList['image'][0]['cat_title'] ?>
                </h2>
                <div class="small-heading">
                    <?php echo strip_tags(base64_decode($mediaList['image'][0]['cat_description'])) ?>
                </div>
            </header>
            <div class="uk-grid uk-grid-large">
                <?php foreach ($mediaList['image'] as $value) { ?>
                <div class="uk-width-large-1-3">
                    <div class="library-item " >
                        <div class="library-content">
                            <div class="library-img">
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="img img-cover va-thumb-1-1" <?php /*data-uk-lightbox="{group:'my-group'}"*/ ?> title="Title">
                                    <img src="<?php echo $value['image'] ?>">
                                </a>
                            </div>
                            <div class="library-text">
                                <span class="name">
                                    <?php echo $value['title'] ?>
                                </span>
                                <div class="text-1">
                                    <?php echo strip_tags(base64_decode($value['description'])) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</section>
<?php if(isset($mediaList['video']) && is_array($mediaList['video']) && count($mediaList['video'])){ ?>
<section class="new-video-panel mt40">
    <div class="uk-container uk-container-center">
        <header class="main-header mb50">
            <h2 class="heading">
                <?php echo $mediaList['video'][0]['cat_title'] ?>
            </h2>
        </header>
        <div class="panel-body">
            <div class="uk-grid uk-grid-medium">
                <?php foreach ($mediaList['video'] as $key => $value) {  ?>
                <div class="uk-width-large-1-3">
                    <div class="body-content video" style="margin-bottom: 30px !important;">
                        <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="img img-cover ">
                            <img src="<?php echo $value['image'] ?>">
                        </a>
                        <div class="button">
                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>">
                                <i class="fa fa-play" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <div id="pagination" class="pagination mb30">
            <?php echo (isset($pagination)) ? $pagination : ''; ?>
        </div>
    </div>
</section>
<?php } ?>