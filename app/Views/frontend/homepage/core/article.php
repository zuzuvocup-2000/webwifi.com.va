<div class="blog-post">
    <article class="post post-frame overlay-zoom">
        <figure class="post-media" style="background-color: #e9e9e9;">
            <div class="va-thumb-1-1" style="padding-top: 70%;">
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
            <h4 class="post-title home-title__blog"><a href="<?php echo $value['canonical'].HTSUFFIX ?>"><?php echo $value['title'] ?></a></h4>
            <?php /*<p class="post-content"><?php echo strip_tags(base64_decode($value['description'])) ?></p>
            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="btn btn-primary btn-link btn-underline">Đọc thêm<i class="d-icon-arrow-right"></i></a>*/ ?>
        </div>
    </article>
</div>