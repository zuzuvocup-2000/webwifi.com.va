<section id="body">
    <div id="article-page" class="page-body">
        <div class="breadcrumb">
            <div class="uk-container uk-container-center">
                <ul class="uk-breadcrumb">
                    <li>
                        <a href="#" title=" Trang chủ"><i class="fa fa-home"></i> Trang chủ</a>
                    </li>
                    <?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){
                    foreach ($breadcrumb as $value) {
                    ?>
                    <li class=""><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a></li>
                    <?php }} ?>
                    <li class="uk-active"><a href="<?php echo $object['canonical'].HTSUFFIX ?>" title="<?php echo $object['title'] ?>"><?php echo $object['title'] ?></a></li>
                </ul>
            </div>
        </div>
        <!-- .breadcrumb -->
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-large-1-4 uk-visible-large">
                    <?php echo view('frontend/homepage/common/aside') ?>
                </div>
                <div class="uk-width-large-3-4">
                    <section class="art-detail">
                        <section class="panel-body mb50">
                            <h1 class="main-title"><?php echo $object['title'] ?></h1>
                            <div class="description">
                                <?php echo $object['description'] ?>
                            </div>
                            <div class="video-iframe mb30">
                                <?php echo $object['iframe'] ?>
                            </div>
                            <div class="list-image">
                                <?php if(isset($object['album']) && is_array($object['album']) && count($object['album'])){
                                foreach ($object['album'] as $value) {
                                ?>
                                <div class="img-cover mb20">
                                    <img src="<?php echo $value ?>" alt="">
                                </div>
                                <?php }} ?>
                            </div>
                            <article class="article detail-content ">
                                <?php echo $object['content'] ?>
                            </article>
                            <!-- <footer class="panel-foot">
                                <div class="share-box uk-flex uk-flex-middle">
                                    <div class="facebook">
                                        <div class="fb-like" data-href="<?php echo $canonical ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
                                    </div>
                                    <div class="plus">
                                        <div class="g-plusone" data-size="medium" data-href="<?php echo $canonical ?>"></div>
                                    </div>
                                </div>
                                <div class="comment">
                                    <div class="fb-comments" data-href="<?php echo $canonical ?>" data-width="100%" data-numposts="3"></div>
                                </div>
                            </footer> -->
                        </section>
                        <?php if(isset($articleRelate) && is_array($articleRelate) &&  count($articleRelate)){ ?>
                        <section class="interior-design interior-design-same list">
                            <header class="panel-head">
                                <h2 class="heading"><span>Các bài viết khác</span></h2>
                            </header>
                            <section class="panel-body">
                                <ul class="uk-grid lib-grid-20 uk-grid-width-1-2 uk-grid-width-medium-1-3 list-article" data-uk-grid-match="{target: '.article .title'}">
                                    <?php foreach ($articleRelate as $value) { ?>
                                    <li>
                                        <article class="article">
                                            <div class="thumb">
                                                <a class="image img-cover img-flash" href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><img src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>"></a>
                                            </div>
                                            <div class="infor">
                                                <h3 class="title" style="min-height: 40px;"><a href="<?php echo $value['canonical'].HTSUFFIX ?>"><?php echo $value['title'] ?></a></h3>
                                                <div class="description lib-line-3">
                                                    <?php echo strip_tags(base64_decode($value['description'])) ?>
                                                </div>
                                            </div>
                                        </article>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </section>
                        </section>
                        <?php } ?>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>