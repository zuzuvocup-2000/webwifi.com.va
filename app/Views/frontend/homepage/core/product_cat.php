<div class="wrap-grid mb20">
    <div class="product-box h100">
        <div class="product-img">
            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="img-cover" title="<?php echo $value['title'] ?>">
                <?php echo render_img(['src' => $value['image']]) ?>
            </a>
        </div>
        <div class="product-content">
            <h4 class="product-tilte"><?php echo $value['title'] ?></h4>
            <div class="product-price uk-text-center">
                <label class="price"><?php echo (isset($value['price_promotion']) && $value['price_promotion'] != 0 ? number_format($value['price'], 0, ',', '.').'đ' : '') ?></label>
                <span class="price"><?php echo (isset($value['price_promotion']) && $value['price_promotion'] != 0 ? number_format($value['price_promotion'], 0, ',', '.').'đ' : (isset($value['price']) && $value['price'] != 0 ? number_format($value['price'], 0, ',', '.').'đ' : 'Liên hệ')) ?></span>
            </div>
            <button class="bt-product" data-uk-modal="{target:'#buy-product'}">Mua hàng</button>
        </div>
    </div>
</div>