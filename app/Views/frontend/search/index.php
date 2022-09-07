<div class="global-breadcrumb">
    <div class="container">
        <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="ul clearfix">
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="/" itemprop="item" class="nopad-l">
                    <span itemprop="name" class="icons icon-home">Trang chủ</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a href="<?php echo $canonical ?>" itemprop="item" class="nopad-l">
                    <span itemprop="name">Tìm kiếm</span>
                </a>
                <meta itemprop="position" content="2" />
            </li>
        </ol>
    </div>
</div>

<div class="container">
    <div class="product-category-page">
        <div class="category-name-group">
            <h1 class="current-name d-inline-block"><?php echo $detailCatalogue['title'] ?></h1>
            <span>(<?php echo $count_product ?> sản phẩm)</span>
        </div>

        <div class="product-banner-group">
            <div class="owl-carousel owl-theme custom-nav hover-img" id="js-product-banner">
                <img border="0" src="/media/banner/23_Jund532a7fe608e92c479d5eed9875e06b9.png" width="644" height="231" alt="" />

                <img border="0" src="/media/banner/23_Jun062a20f9eb1e3bea84e81e3378416121.png" width="644" height="230" alt="" />
            </div>
        </div>

        <div class="d-flex">
            <div class="product-right-group" style="width: 100%;">
                <div class="product-sort-group">
                    <div class="item-left">
                        <b>Sắp xếp theo</b>

                        <a href="<?php echo $canonical ?>?order_by=tb1.created_at desc"> Mới nhất </a>

                        <a href="<?php echo $canonical ?>?order_by=tb1.price asc"> Giá tăng dần </a>

                        <a href="<?php echo $canonical ?>?order_by=tb1.price desc"> Giá giảm dần </a>

                        <a href="<?php echo $canonical ?>?order_by=tb1.viewed desc"> Lượt xem </a>

                        <a href="<?php echo $canonical ?>?order_by=tb2.title asc"> Tên A->Z </a>
                    </div>
                </div>

                <div class="p-container" id="js-product-list">
                    <?php if(isset($productList) && is_array($productList) && count($productList)){
                        foreach ($productList as $key => $value) {
                     ?>
                        <?php echo view('frontend/homepage/core/product', ['value' => $value]) ?>
                    <?php }} ?>
                </div>

                <div class="button-show-product text-center">
                    <div id="pagination">
                        <?php echo (isset($pagination)) ? $pagination : ''; ?>
                    </div>
                </div>

                <div class="product-static-html js-static-container">
                    <div class="overflow-hidden js-static-content">
                        <?php echo base64_decode($detailCatalogue['description']) ?>
                        <?php echo base64_decode($detailCatalogue['content']) ?>
                    </div>

                    <div class="text-center btn-html-content">
                        <a href="javascript:void(0)" class="js-showmore-button">Xem thêm <i class="fas fa-angle-double-down"></i></a>
                        <a href="javascript:void(0)" class="js-showless-button">Thu gọn <i class="fas fa-angle-double-up"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>