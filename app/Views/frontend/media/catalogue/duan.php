<div class="background-news mb30">
    <div class="img-cover">
        <img src="<?php echo $general['another_banner_news'] ?>" alt="banner">
    </div>
    <div class="banner-song ">
        <img src="/public/frontend/resources/img/song.png" alt="song">
    </div>
</div>
<?php if(isset($articleList) && is_array($articleList) && count($articleList)){ ?>
<section class="new-video-panel mt40">
    <div class="uk-container uk-container-center">
        <header class="main-header mb50">
            <h2 class="heading">
                <?php echo $detailCatalogue['title'] ?>
            </h2>
        </header>
        <div class="panel-body">
            <div class="uk-grid uk-grid-medium">
                <?php foreach ($articleList as $key => $value) {  ?>
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