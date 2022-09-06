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
            <section class="art-detail">
                <section class="panel-body mb50">
                    <h1 class="main-title"><?php echo $object['title'] ?></h1>
                    <div class="description">
                        <?php echo $object['description'] ?>
                    </div>
                    <article class="article detail-content">
                        <?php echo $object['content'] ?>
                    </article>
                </section>
                <?php if(isset($articleRelate) && is_array($articleRelate) && count($articleRelate)){ ?>
                    <div class="panel-view-more">
                        <div class="view-more">Xem thêm:</div>
                        <ul class="list-article-relate">
                            <?php foreach ($articleRelate as $value) { ?>
                                <li>
                                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </section>
        </div>
    </div>
</section>
