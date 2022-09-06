<?php if(isset($cat_aside) && is_array($cat_aside) && count($cat_aside)){ ?>
<div class="filter-item filter-cat">
    <p class="title text-uppercase">Danh mục <?php echo $detailCatalogue['title'] ?></p>

    <div class="cat-holder">
        <?php foreach ($cat_aside as $value) { ?>
            <a href="<?php echo $value['canonical'].HTSUFFIX ?>"> <h2><?php echo $value['title'] ?></h2></a>
        <?php } ?>
    </div>
</div>
<?php } ?>