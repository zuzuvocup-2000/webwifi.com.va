<?php
     $owlInit = array(
         'margin' => 8,
         'lazyload' => true,
         'nav' => true,
         'autoplay' => true,
         'smartSpeed' => 1000,
         'autoplayTimeout' => 3000,
         'dots' => false,
         'loop' => true,
         'responsive' => array(
             0 => array(
                 'items' => 1.5,
             ),
             600 => array(
                 'items' => 2.5,
             ),
             1000 => array(
                 'items' => 5.5,
             ),
         )
     );
    ?>
    <?php $slide = get_slide(['keyword' => 'partner', 'output' => 'array']); ?>
    <div class="partner">
        <div class="uk-container uk-container-center">
            <div class="owl-slide ">
                <div class="owl-carousel" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>">
                    <?php foreach($slide['data'] as $key => $val){ ?>
                    <div class="slide-item">
                        <a href="<?php echo $val['url'] ?>" class="image img-scaledown"><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>"></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
