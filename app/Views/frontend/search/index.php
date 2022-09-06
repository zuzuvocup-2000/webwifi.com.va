<section id="body">
    <div id="prdcatalogue-page" class="page-body pt50 pb50">
        <div class="uk-container uk-container-center">
            <div class="uk-grid">
                <div class="uk-width-large-1-4 uk-visible-large">
                    <?php echo view('frontend/homepage/common/aside') ?>
                </div>
                <div class="uk-width-large-3-4">
                    <div class="medical-section-panel mb30">
                        <div class="medical-section-body">
                            <div class="uk-grid uk-grid-small">
                                <?php if(isset($productList) && is_array($productList) && count($productList)){
                                    foreach ($productList as $value) {
                                ?>
                                    <div class="uk-width-large-1-4 uk-width-1-2 mb10">
                                        <div class="medical-item product">
                                            <div class="item-pic">
                                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="img img-cover product-media">
                                                    <img src="<?php echo $value['image'] ?>">
                                                </a>
                                                <div class="item-function">
                                                    <div class="uk-flex uk-flex-middle">
                                                        <div class="icon icon-img-action mr10">
                                                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>">
                                                                <img src="public/eye.png" alt="" class="p10">
                                                            </a>
                                                        </div>
                                                        <div class="icon icon-img-action mr10">
                                                            <a class="buy_now" data-id="<?php echo $value['id'] ?>" data-sku="SKU_<?php echo $value['id'] ?>">
                                                                <img src="public/cart.png" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="icon icon-img-action" >
                                                            <a  data-id="<?php echo $value['id'] ?>" class="btn-wishlist">
                                                                <i class="d-icon-heart"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-text">
                                                <div class="product-title product-name mb5">
                                                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="limit-line-3 ">
                                                        <?php echo $value['title'] ?> <?php echo (!empty($value['model']) ? ' - Model: '.$value['model'] : '') ?> <?php echo (!empty($value['bar_code']) ? ' - Hãng: '.$value['bar_code'] : '') ?><?php echo (!empty($value['made_in']) ? ' - '.$value['made_in'] : '') ?>
                                                    </a>
                                                </div>
                                                <div class="product-star mb5">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                                <div class="product-contact mb10 product-price">
                                                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>">
                                                        <div class="prd-price uk-clearfix">
                                                            <span class="price-old uk-display-block "><?php echo empty($value['price_promotion']) ? '' : number_format(check_isset($value['price']),0,',','.').' VNĐ' ?></span>
                                                            <span class="price-new new-price"><?php echo (empty($value['price'] ) ? 'Liên hệ' : (!empty($value['price_promotion']) ? number_format(check_isset($value['price_promotion']),0,',','.').' VNĐ' : number_format(check_isset($value['price']),0,',','.').' VNĐ')) ?></span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }} ?>
                            </div>
                            <div id="pagination">
                                <?php echo (isset($pagination)) ? $pagination : ''; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>