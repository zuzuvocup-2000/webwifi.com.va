<div class="blog-post">
    <article class="post post-frame overlay-zoom">
        <figure class="post-media uk-position-relative va-border-white" style="background-color: #e9e9e9;">
            <div class="va-thumb-1-1 thumb-75">
                <a href="<?php echo $value['canonical'].HTSUFFIX ?>">
                    <img class="lazy" data-src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>" width="340" height="206" style="background-color: #919fbc;" />
                </a>
            </div>
            <?php /*<div class="post-calendar">
                <span class="post-day"><?php echo date('d', strtotime($value['created_at'])) ?></span>
                <span class="post-month">Tháng <?php echo date('m', strtotime($value['created_at'])) ?></span>
            </div>*/ ?>
        </figure>
        <div class="post-details home-title__detail">
            <h4 class="post-title home-title__blog post-title-news limit-line-2"><a href="<?php echo $value['canonical'].HTSUFFIX ?>"><?php echo $value['title'] ?></a></h4>
            <div class="customer-media uk-position-relative"><?php echo $value['customer'] ?></div>
            <div class="general-info-media">Diện tích: <strong><?php echo ($value['area'] == '') ? 'Đang cập nhật' : $value['area'] ?></strong></div>
            <div class="general-info-media">Phong cách: <strong><?php echo ($value['phongcach'] == '') ? 'Đang cập nhật' : $value['phongcach'] ?></strong></div>
        </div>
    </article>
</div>