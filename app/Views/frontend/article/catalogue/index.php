<section class="bg-banner-top-new uk-position-relative bg-general" style="background-image: url(<?php echo $detailCatalogue['image'] ?>);">
    <div class="wrap-breadcum">
        <h2 class="heading-2 heading-cat-title">
            <?php echo $detailCatalogue['title'] ?>
        </h2>
        <ul class="uk-breadcrumb">
            <li>
                <a href="#" title=" Trang chủ"><i class="fa fa-home"></i> Trang chủ</a>
            </li>
            <?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){
                foreach ($breadcrumb as $value) {
             ?>
                <li class=""><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a></li>
            <?php }} ?>
        </ul>
    </div>
</section>
<section id="body">
    <div id="article-page" class="page-body">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-large-3-4">
                    <section class="artcatalogue">
                        <section class="panel-body">
                            <ul class="uk-list list-article">
                                <?php   if(isset($articleList) && is_array($articleList) && count($articleList)){
                                foreach (   $articleList as $value) {
                                ?>
                                <li>
                                    <article class="article uk-clearfix">
                                        <div class="thumb img-flash">
                                            <a
                                                class="image img-cover"
                                                href="<?php echo $value['canonical'].HTSUFFIX ?>"
                                                title="<?php    echo $value['title'] ?>"
                                                >
                                                <img src="<?php echo $value['image'] ?>" alt="<?php   echo $value['title'] ?>" />
                                            </a>
                                        </div>
                                        <div class="info">
                                            <h2 class="title">
                                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php  echo $value['title'] ?>">
                                                    <?php   echo $value['title'] ?>
                                                </a>
                                            </h2>
                                            <div class="meta"><i class="fa fa-clock-o"></i> <?php echo date('d/m/Y', strtotime($value['created_at'])) ?></div>
                                            <div class="description lib-line-2 mb20">
                                                <?php   echo strip_tags(base64_decode( $value['description'])) ?>
                                            </div>
                                            <div class="btn-view-more-art">
                                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="uk-flex uk-flex-middle">Đọc tiếp <i class="fa fa-long-arrow-right ml10" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </article>
                                </li>
                                <?php   }} ?>
                            </ul>
                        </section>
                        <footer class="panel-foot">
                            <div id="pagination">
                                <?php echo (isset($pagination)) ? $pagination : ''; ?>
                            </div>
                        </footer>
                    </section>
                </div>
                <div class="uk-width-large-1-4 ">
                    <?php echo view('frontend/homepage/common/aside') ?>
                </div>
            </div>
        </div>
    </div>
</section>