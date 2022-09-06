<div class="swiper-slide">
    <article class="post-style-home post-style-5">
        <div class="post-container">
            <div class="post-meta-thumb">
                <a href="<?php echo $valuePost['canonical'].HTSUFFIX ?>">
                    <img width="390" height="290" src="<?php echo $valuePost['image'] ?>" class="attachment-size390 size-size390 wp-post-image" alt="" loading="lazy"  />
                </a>
            </div>
            <div class="post-content-container">
                <p class="b-post-item-tilte-h2">
                    <a href="<?php echo $valuePost['canonical'].HTSUFFIX ?>" class="b-post-item-tilte-a" tabindex="0"><?php echo $valuePost['title'] ?>
                    </a>
                </p>
                <!--  <div class="post-category">
                    <a class="post-category-item" href="https://kientruc2.webdaitin.info/category/thiet-ke-kien-truc/thiet-ke-biet-thu/biet-thu-hien-dai/">Biệt thự hiện đại
                    </a> /
                    <a class="post-category-item" href="https://kientruc2.webdaitin.info/category/thiet-ke-kien-truc/thiet-ke-biet-thu/biet-thu-mai-thai/">Biệt thự mái Thái
                    </a> /
                </div> -->
                <div class="entry-excerpt">
                    <div class="thong-tin-hs-v1">
                        <p>
                            <i class="fa fa-user"></i> Chủ đầu tư : <?php echo isset($valuePost['bar_code']) ? $valuePost['bar_code'] : '' ?>
                        </p>
                        <p>
                            <i class="fa fa-diadiem" aria-hidden="true"></i> Địa chỉ : <?php echo isset($valuePost['info']['address']) ? $valuePost['info']['address'] :'' ?>
                        </p>
                        <p>
                            <i class="fa fa-mattien"></i> Mặt tiền : <?php echo isset($valuePost['length']) ?$valuePost['length'] :'' ?>
                        </p>
                        <p>
                            <i class="fa fa-dienthicxaydung" aria-hidden="true"></i> Diện tích xây dựng : <?php echo isset($valuePost['width']) ?$valuePost['width'] :'' ?>
                        </p>
                        <p>
                            <i class="fa fa-sotang"></i> Số tầng : <?php echo isset($valuePost['info']['tang']) ?$valuePost['info']['tang'] :'' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>