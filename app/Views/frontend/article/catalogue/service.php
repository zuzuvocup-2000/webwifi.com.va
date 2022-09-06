<section class="service-panel">
    <div class="uk-grid uk-grid-collapse uk-visible-large">
        <?php if(isset($child) && is_array($child) && count($child)){ 
            foreach ($child as $key => $value) {
        ?>
        <?php if($key %2 == 0){ ?>
            <div class="uk-width-large-1-2 va-hover-zoom">
                <div class="service-wrap-1 service-wrap-first">
                    <div class="over-lay">
                        <div class="img img-cover">
                            <img src="<?php echo $value['image'] ?>">
                        </div>
                        <div class="service-title">
                            <?php echo $value['title'] ?>
                            <div class="service-more">
                                <i class="d-icon-angle-down"></i>
                            </div>
                        </div>
                        
                    </div>
                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="service-content">
                        <div class="content-top">
                            <div class="service-title">
                                <?php echo $value['title'] ?>
                            </div>
                            <div class="description">
                                <?php echo base64_decode($value['description']) ?>
                            </div>
                        </div>
                        <div class="content-bottom">
                            <div class="img img-cover">
                                <img src="<?php echo $value['image'] ?>">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        <?php }else{ ?>
            <div class="uk-width-large-1-2 va-hover-zoom">
                <div class="service-wrap-1 right">
                    <div class="over-lay">
                        <div class="img img-cover">
                            <img src="<?php echo $value['image'] ?>">
                        </div>
                        <div class="service-title">
                            <?php echo $value['title'] ?>
                            <div class="service-more">
                                <i class="d-icon-angle-down"></i>
                            </div>
                        </div>
                        
                    </div>
                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="service-content">
                        <div class="content-top">
                            <div class="service-title">
                                <?php echo $value['title'] ?>
                            </div>
                            <div class="description">
                                <?php echo base64_decode($value['description']) ?>
                            </div>
                        </div>
                        <div class="content-bottom">
                            <div class="img img-cover">
                                <img src="<?php echo $value['image'] ?>">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        <?php }}} ?>
    </div>
    <div class="uk-hidden-large">
        <?php if(isset($child) && is_array($child) && count($child)){ 
            foreach ($child as $key => $value) {
        ?>
            <div class="wrap-service-mobile">
                <div class="img-service-mobile">
                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="img img-cover">
                        <img src="<?php echo $value['image'] ?>" alt="">
                    </a>
                </div>
                <div class="content-service-mobile">
                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="">
                        <?php echo $value['title'] ?>
                    </a>
                    <div class="desc-service-mobile">
                        <?php echo base64_decode($value['description']) ?>
                    </div>
                </div>
            </div>
        <?php }} ?>
    </div>
</section>
