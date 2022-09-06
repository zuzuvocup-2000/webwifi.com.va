<div class="global-breadcrumb bg-white">
    <div class="container">
        <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="ul clearfix">
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="/" itemprop="item" class="nopad-l">
                    <span itemprop="name" class="icons icon-home">Trang chủ</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>
            <?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){
                foreach ($breadcrumb as $value) {
             ?>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" itemprop="item" class="nopad-l">
                        <span itemprop="name"><?php echo $value['title'] ?></span>
                    </a>
                    <meta itemprop="position" content="2" />
                </li>
            <?php }} ?>
        </ol>
    </div>
</div>

<div class="article-page">
    <div class="container">
        <div class="row">
            <div class="col-8 article-detail-page">
                <p class="art-detail-title"><?php echo $object['title'] ?></p>

                <time class="art-detail-time js-art-time" data-time="<?php echo date('d/m/Y H:i:s', strtotime($object['created_at'])) ?>">
                    <?php echo date('d/m/Y H:i:s', strtotime($object['created_at'])) ?>
                </time>

                <div class="art-detail-content js-product-id">
                    <?php echo $object['description'] ?>
                    <?php echo $object['content'] ?>
                </div>

                <div class="art-detail-social">
                    <div class="fb-like" data-href="https://wifi.com.vn/khuyen-mai-mung-sinh-nhat-h2k-8-tuoi-ha-noi..html" data-width="" data-layout="button" data-action="like" data-size="small" data-share="true"></div>
                </div>
                <?php if(isset($articleRelate) && is_array($articleRelate) && count($articleRelate)){ ?>
                    <div class="art-detail-related-group">
                        <p class="art-box-title"><span>Tin liên quan</span></p>

                        <div class="art-related-holder">
                            <?php foreach ($articleRelate as $value) { ?>
                                <div class="art-item">
                                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="art-img">
                                        <img data-src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>" class="lazy w-auto h-auto" width="1" height="1" />
                                    </a>

                                    <div class="art-text">
                                        <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="art-title"><h3 class="inherit"><?php echo $value['title'] ?></h3></a>
                                        <time class="js-art-time" data-time="<?php echo date('d/m/Y H:i:s', strtotime($value['created_at'])) ?>">
                                            <?php echo date('d/m/Y H:i:s', strtotime($value['created_at'])) ?>
                                        </time>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="col-4 article-col-right">
                <?php echo view('frontend/homepage/common/aside') ?>
            </div>
        </div>
    </div>
</div>