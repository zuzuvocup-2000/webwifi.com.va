<?php
    $price = number_format($value['price_promotion'],0,',','.').' đ';
    if ($value['price_promotion'] == 0) $price = "Liên hệ";

    $marketPrice = "";
    $discount = "";
    if ($value['price'] > $value['price_promotion'] && $value['price_promotion'] > 0) {
        $marketPrice = number_format($value['price'],0,',','.').' đ';
        $percent = round((100 - ($value['price_promotion'] * 100) / $value['price']));
        $discount = "<span class='p-discount'> -" . $percent . "% </span>";
    }
?>
<div class="p-item">
    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="p-img">
        <img
            data-src="<?php echo $value['image'] ?>"
            alt="<?php echo $value['title'] ?>"
            class="lazy"
            src="<?php echo $general['homepage_logo'] ?>"
        />
        <span class="p-type-new">NEW</span>
    </a>

    <div class="p-text">
        <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="p-name"><h3><?php echo $value['title'] ?></h3></a>

        <div class="p-price-group">
            <span class="p-price">
                <?php echo $price ?>
            </span>

            <span class="p-old-price"><?php echo $marketPrice ?></span>
            <?php echo $discount ?>
        </div>
        <a href="javascript:void(0)" class="p-item-btn icon-cart" onclick="addProductToCart(<?php echo $value['id'] ?>, 1, '')"></a>
    </div>
</div>