<div class="blog-post">
    <article class="post post-frame overlay-zoom">
        <figure class="post-media" style="background-color: #e9e9e9;">
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
            <div class="calender"><i class="fa fa-calendar mr15" aria-hidden="true"></i><?php echo date('d/m/Y', strtotime($value['created_at'])) ?></div>
            <p class="post-content limit-line-3"><?php echo strip_tags(base64_decode($value['description'])) ?></p>
        </div>
    </article>
</div>