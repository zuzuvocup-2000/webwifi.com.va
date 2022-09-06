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
            <div class="col-8 article-category-page">
                <?php if(isset($articleList) && is_array($articleList) && count($articleList)){
                    foreach ($articleList as $key => $value) {
                 ?>
                    <div class="art-item">
                        <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="art-img">
                            <img
                                data-src="<?php echo $value['image'] ?>"
                                alt="<?php echo $value['title'] ?>"
                                class="lazy w-auto h-auto"
                                width="1"
                                height="1"
                            />
                        </a>

                        <div class="art-text">
                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="art-title">
                                <h3 class="inherit"><?php echo $value['title'] ?></h3>
                            </a>
                            <time class="js-art-time" data-time="<?php echo date('d/m/Y H:i:s', strtotime($value['created_at'])) ?>">
                                <?php echo date('d/m/Y H:i:s', strtotime($value['created_at'])) ?>
                            </time>

                            <div class="art-summary"><?php echo strip_tags(base64_decode($value['description'])) ?></div>
                        </div>
                    </div>
                <?php }} ?>
                <div id="pagination">
                    <?php echo (isset($pagination)) ? $pagination : ''; ?>
                </div>
            </div>

            <div class="col-4 article-col-right">
                <?php echo view('frontend/homepage/common/aside') ?>
            </div>
        </div>
    </div>
</div>