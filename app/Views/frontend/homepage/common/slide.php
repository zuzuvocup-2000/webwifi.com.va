<?php $slide = get_slide(['keyword' => 'main-slide' , 'language' => $language ]); ?>
<?php if(isset($slide) && is_array($slide) && count($slide)){ ?>
<section class="main-slide">
    <!-- <div class="uk-container uk-container-center uk-container-1"> -->
        <div class="uk-slidenav-position slide-show" data-uk-slideshow="{autoplay: true, autoplayInterval: 7500, animation: 'random-fx'}">
            <ul class="uk-slideshow">
                <?php foreach($slide as $key => $val) { ?>

                    <?php
                        $title = $val['title'];
                        $href = $val['canonical'];
                        $image = $val['image'];
                        $description = cutnchar(strip_tags($val['description']), 250);
                    ?>
                <li>
                    <div class="slide-content">
                        <div class="image img-cover"><img src="<?php echo $image; ?>" alt="<?php echo $image; ?>" /></div>
                        <div class="overlay-slide uk-vertical-align">
                            <div class="uk-vertical-align-middle">
                                <h2 class="heading-slide"><span class="line-3 animated slideInDown target"><?php echo $title; ?></span></h2>
                                <div class="description animated slideInUp target"><?php echo $description; ?></div>
                            </div>
                            <!-- container -->
                        </div>
                    </div>
                </li>
                <?php } ?>
            </ul>
            <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
            <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
            <ul class="uk-dotnav uk-dotnav-contrast uk-position-bottom uk-flex-center">
            <?php for($i = 0; $i<count($slide); $i++){ ?>
                <li data-uk-slideshow-item="<?php echo $i; ?>"><a href=""></a></li>
            <?php } ?>
            </ul>
        </div>
    <!-- </div> -->
</section><!-- .main-slide -->
<?php } ?>

<style>
    .hide{
        opacity: 0 !important;
    }
</style>


<script>
    
    var target = $('.target');

    var target_title = $('.uk-slideshow .overlay-slide .heading-1>*');
    var target_description = $('.uk-slideshow .overlay-slide .description');
    var target_btn = $('.uk-slideshow .overlay-slide .submit');
    var animate_1 = 'slideInDown';
    var animate_2 = 'slideInUp';
    var animate_3 = 'slideInUp';

    UIkit.on('beforeshow.uk.slideshow', function(){
        target.addClass('hide');
        target_title.removeClass(animate_1);
        target_description.removeClass(animate_2);
        target_btn.removeClass(animate_3);
    });

    UIkit.on('show.uk.slideshow', function(){
        target.removeClass('hide');
        target_title.addClass(animate_1);
        target_description.addClass(animate_2);
        target_btn.addClass(animate_3);
    });

</script>