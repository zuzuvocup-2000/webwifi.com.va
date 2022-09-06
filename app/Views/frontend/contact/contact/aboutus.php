<?php $logo_slide = get_slide(['keyword' => 'logo', 'language' => $language]); ?>
<section class="n-about-us-panel">
    <div class="n-breadcum-top" style="background-image: url('<?php echo $detailCatalogue['image'] ?>'); ">
        <div class="uk-container uk-container-center">
            <div class="n-breadcum-content">
                <header class="header">
                    <h2 class="n-main-title">
                        <?php echo $detailCatalogue['title'] ?>
                    </h2>
                    <h4 class="n-secondary-title">
                       <?php echo strip_tags(base64_decode($detailCatalogue['description'])) ?>
                    </h4>
                </header>
                <ul class="uk-breadcrumb uk-flex uk-flex-center">
                    <li>
                        <a href="" title="home">Home</a>
                    </li>
                    <li >
                        <a href="<?php echo $detailCatalogue['canonical'].HTSUFFIX ?>" title="<?php echo $detailCatalogue['title'] ?>"><?php echo $detailCatalogue['title'] ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="n-intro-panel mb50 lazyloading_box" >
        <div class="uk-container uk-container-center">
            <?php if(isset($articleList) && is_array($articleList) && count($articleList)){
                foreach ($articleList as $key => $value) {
            ?>
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-2-3">
                        <div class="left-side">
                            <header class="n-intro-header">
                                <h2 class="heading">
                                    <?php echo $value['title'] ?>
                                </h2>
                            </header>
                            <div class="n-intro-description mb30">
                                <?php echo base64_decode($value['description']) ?>
                            </div>

                            <div class="n-intro-more">
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="hvr-sweep-to-right">
                                    <?php echo $general['homepage_company'] ?> Sustainability
                                    <ion-icon name="arrow-forward"></ion-icon>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-1-3">
                        <div class="right-side">
                            <?php 
                                $owlInit = [
                                    'items' => 1,
                                    'margin' => 20,
                                    'nav' => false,
                                    'dots' =>true,
                                    'responsive' => array(
                                        0 => array(
                                            'items' => 1,
                                            'nav' => false,
                                            'dots' =>true,
                                        ),
                                        768 => array(
                                            'items' => 1,
                                            'nav' => false,
                                            'dots' =>true,
                                        ),
                                        960 => array(
                                            'items' => 1,
                                            'nav' => false,
                                            'dots' =>true,
                                        ),
                                    )
                                ];
                                $icon = ['<i class="fa fa-line-chart" aria-hidden="true"></i>','<i class="fa fa-handshake-o" aria-hidden="true"></i>'];
                            ?>
                            <div class="owl-slide">
                                <div class="panel-body" >
                                    <div class="owl-carousel" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>">
                                        <?php 
                                            $value['sub_title'] = json_decode(base64_decode($value['sub_title']),true);
                                            $value['sub_content'] = json_decode(base64_decode($value['sub_content']),true);
                                        ?>
                                        <?php if(isset($value['sub_title']) && is_array($value['sub_title']) && count($value['sub_title'])){
                                            $dem = 0;
                                            foreach ($value['sub_title'] as $keyChild => $valueChild) {
                                        ?>
                                            <div class="n-intro-item">
                                                <div class="n-intro-title uk-flex uk-flex-middle mb20">
                                                    <div class="n-intro-icon">
                                                        <?php echo $icon[$dem] ?>
                                                    </div>
                                                    <h3 class="heading-2">
                                                        <?php echo $valueChild ?>
                                                    </h3>
                                                </div>

                                                <div class="item-description">
                                                    <?php echo (isset($value['sub_content'][$keyChild]) ? $value['sub_content'][$keyChild] : '') ?>
                                                </div>
                                            </div>
                                        <?php 
                                        if($dem == 1){
                                            $dem = 0;
                                        }else{
                                            $dem++;
                                        }}} ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }} ?>
        </div>
    </div>
    <?php $detailCatalogue['album'] = json_decode($detailCatalogue['album'], true) ?>
    <div class="uk-slidenav-position lazyloading_box" data-uk-slideshow>
        <ul class="uk-slideshow slide-aboutus">
            <?php if(isset($detailCatalogue['album']) && is_array($detailCatalogue['album']) && count($detailCatalogue['album'])){
                foreach ($detailCatalogue['album'] as $key => $value) {
             ?>
                <li>
                    <div class="img img-cover">
                        <img src="<?php echo $value ?>" alt="<?php echo $value ?>">
                    </div>
                </li>
            <?php }} ?>
        </ul>
        <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </a>
    </div>
    <?php if(isset($panel['company']['data']) && is_array($panel['company']['data']) && count($panel['company']['data'])){ ?>
        <div class="m-about-us lazyloading_box">
            <div class="m-about-us-head">
                <div class="uk-container uk-container-center">
                    <div class="m-aboutus-head">
                        <h2 class="m-aboutuss-title"> <?php echo $panel['company']['title'] ?> </h2>
                        <p class="m-aboutuss-text"> <?php echo $panel['company']['description'] ?></p>
                        <span class="heading-underline2 solid"> <span></span> </span>    
                    </div>
                </div>
            </div>
            <div class="m-aboutus-body">
                <div class="uk-container uk-container-center">
                    <div class="uk-grid uk-grid-large">
                        <div class="uk-width-large-1-3"></div>
                        <div class="uk-width-large-2-3">
                            <ul class="nav-color2 uk-flex uk-clearfix uk-list" data-uk-switcher="{connect:'#my-id3'}">
                                <?php if(isset($panel['company']['data'][0]['post']) && is_array($panel['company']['data'][0]['post']) && count($panel['company']['data'][0]['post'])){
                                    foreach ($panel['company']['data'][0]['post'] as $key => $value) {
                                ?>
                                    <li><a href=""><?php echo $value['title'] ?></a></li>
                                <?php }} ?>
                                <?php foreach ($panel['company']['data'] as $key => $value) {
                                    if($key == 0) continue;
                                ?>
                                    <li><a href=""><?php echo $value['title'] ?></a></li>
                                <?php } ?>
                            </ul>
                            <ul id="my-id3" class="uk-switcher">
                                <?php if(isset($panel['company']['data'][0]['post']) && is_array($panel['company']['data'][0]['post']) && count($panel['company']['data'][0]['post'])){
                                    foreach ($panel['company']['data'][0]['post'] as $key => $value) {
                                        $value['sub_title'] = json_decode(base64_decode($value['sub_title']),true);
                                        $value['sub_content'] = json_decode(base64_decode($value['sub_content']),true);
                                        $value['description'] = base64_decode($value['description']);
                                        // prE($panel['company']['data'][0]['post']);
                                ?>
                                    <?php if($value['canonical'] == 'why-choose-us'){ ?>
                                        <li>
                                            <div class="m-aboutus-content">
                                                <p class="mb20"><?php echo $value['description'] ?></p>
                                                <div class="uk-grid uk-grid-medium uk-clearfix">
                                                    <?php if(isset($value['sub_title']) && is_array($value['sub_title']) && count($value['sub_title'])){ 
                                                        foreach ($value['sub_title'] as $keyTitle => $valueTitle) {
                                                    ?>
                                                        <div class="uk-width-large-1-2 mb15">
                                                            <div class="m-aboutus-item uk-flex uk-flex-middle">
                                                                <div class="m-aboutus-icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 432.4 432.4" style="enable-background:new 0 0 432.4 432.4;" xml:space="preserve"> <g> <g> <g> <path d="M216.529,93.2c-61.2,0-111.2,50-111.2,111.2c0,32,14,62.8,37.6,83.6c17.6,17.6,16,55.2,15.6,55.6     c0,2,0.4,3.6,2,5.2c1.2,1.2,3.2,2,4.8,2h102c2,0,3.6-0.8,4.8-2c1.2-1.2,2-3.2,2-5.2c0-0.4-2-38,15.6-55.6     c0.4-0.4,0.8-0.8,1.2-1.2c23.2-21.2,36.8-51.2,36.8-82.4C327.729,143.2,277.729,93.2,216.529,93.2z M280.529,277.6     c-0.4,0.4-1.2,1.2-1.2,1.6c-15.6,16.8-18.4,44.4-18.8,57.6h-88.4c-0.4-13.2-3.2-42-20-59.2c-21.2-18.4-33.6-45.2-33.6-73.6     c0-54,43.6-97.6,97.6-97.6s97.6,43.6,97.6,97.6C313.729,232.4,301.729,259.2,280.529,277.6z"></path> <path d="M216.129,121.6c-3.6,0-6.8,3.2-6.8,6.8c0,3.6,3.2,6.8,6.8,6.8c40.4,0,72.8,32.8,72.8,72.8     c0,3.6,3.2,6.8,6.8,6.8c3.6,0,6.8-3.2,6.8-6.8C302.929,160.4,264.129,121.6,216.129,121.6z"></path> <path d="M260.529,358.4h-88.8c-9.2,0-16.8,7.6-16.8,16.8s7.6,16.8,16.8,16.8h88.4     c9.6-0.4,17.2-7.6,17.2-16.8C277.329,366,269.729,358.4,260.529,358.4z M260.529,378h-88.8c-1.6,0-3.2-1.2-3.2-3.2     s1.2-3.2,3.2-3.2h88.4c1.6,0,3.2,1.2,3.2,3.2S262.129,378,260.529,378z"></path> <path d="M247.329,398.8h-62.4c-9.2,0-16.8,7.6-16.8,16.8s7.6,16.8,16.8,16.8h62.4     c9.2,0,16.8-7.6,16.8-16.8C264.129,406,256.529,398.8,247.329,398.8z M247.329,418.4h-62.4c-1.6,0-3.2-1.2-3.2-3.2     s1.2-3.2,3.2-3.2h62.4c1.6,0,3.2,1.2,3.2,3.2S248.929,418.4,247.329,418.4z"></path> <path d="M216.129,60c4,0,6.8-3.2,6.8-6.8V6.8c0-3.6-3.2-6.8-6.8-6.8c-3.6,0-6.8,3.2-6.8,6.8v46.4     C209.329,56.8,212.529,60,216.129,60z"></path> <path d="M329.329,34.4c-3.2-2.4-7.2-1.2-9.2,1.6l-25.6,38.4c-2.4,3.2-1.6,7.6,1.6,9.6     c1.2,0.8,2.4,1.2,3.6,1.2c2.4,0,4.4-1.2,5.6-3.2l25.6-38.4C333.329,40.8,332.529,36.4,329.329,34.4z"></path> <path d="M134.929,83.6c1.2,0,2.4-0.4,3.6-1.2c3.2-2,4-6.4,2-9.6l-24.8-38.8c-2-3.2-6.4-4-9.6-2     s-4,6.4-2,9.6l24.8,38.8C130.529,82.8,132.529,83.6,134.929,83.6z"></path> <path d="M86.529,126l-40.4-22c-3.2-1.6-7.6-0.4-9.2,2.8c-2,3.2-0.8,7.6,2.8,9.2l40.4,22     c1.2,0.4,2,0.8,3.2,0.8c2.4,0,4.8-1.2,6-3.6C90.929,132,89.729,127.6,86.529,126z"></path> <path d="M395.729,106.8c-1.6-3.2-6-4.4-9.2-2.8l-40.8,22c-3.2,1.6-4.4,6-2.8,9.2c1.2,2.4,3.6,3.6,6,3.6     c1.2,0,2.4-0.4,3.2-0.8l40.8-22C396.129,114.4,397.329,110,395.729,106.8z"></path> </g> </g> </g> </svg>
                                                                </div>
                                                                <div class="m-aboutus-text">
                                                                    <h3 class="m-ab-title"><?php echo $valueTitle ?></h3>
                                                                    <?php echo (isset($value['sub_content'][$keyTitle]) ? $value['sub_content'][$keyTitle] : '') ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }} ?>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <?php if($value['canonical'] == 'history'){ ?>
                                        <li>
                                            <div class="m-aboutus-content">
                                                <?php echo $value['description'] ?>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <?php if($value['canonical'] == 'own-grown'){ ?>
                                        <li>
                                            <div class="m-aboutus-content">
                                                <div class="m-aboutus-item-2">
                                                    <div class="m-ab-description">
                                                        <p><?php echo $value['description'] ?></p>
                                                    </div>
                                                    <div class="m-ab-img-2">
                                                        <img src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                <?php }} ?>
                                <?php foreach ($panel['company']['data'] as $key => $value) {
                                    if($key == 0) continue;
                                ?>
                                    <li>
                                        <div class="m-aboutus-content">
                                            <div class="uk-grid uk-grid-medium uk-clearfix">
                                                <?php if(isset($value['post']) && is_array($value['post']) && count($value['post'])){
                                                    foreach ($value['post'] as $keyChild => $valueChild) { ?>
                                                    <div class="uk-width-large-1-2">
                                                        <div class="m-aboutus-item-2">
                                                            <div class="m-aboutus-img img-cover">
                                                                <img src="<?php echo $valueChild['image'] ?>" alt="<?php echo $valueChild['title'] ?>">
                                                            </div>
                                                            <div class="m-ab-title2">
                                                                <h3 class="m-ab-title-2"><i class="fa fa-square" aria-hidden="true"></i> <?php echo $valueChild['title'] ?></h3>
                                                            </div>
                                                            <div class="m-ab-content-2">
                                                                <?php echo base64_decode($valueChild['description']) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }} ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <script>
        function animateNumber(finalNumber, duration = 5000, startNumber = 0, callback) {
        let currentNumber = startNumber;
        const interval = window.setInterval(updateNumber, 50);
        function updateNumber() {
            if (currentNumber >= finalNumber) {
                clearInterval(interval);
            } else {
                let inc = Math.ceil(finalNumber / (duration / 17));
                if (currentNumber + inc > finalNumber) {
                    currentNumber = finalNumber;
                    clearInterval(interval);
                } else {
                    currentNumber += inc;
                }
                callback(currentNumber);
            }
        }
        }
        document.addEventListener("DOMContentLoaded", function () {
        animateNumber(<?php echo $general['parameter_year'] ?>, 3000, 0, function (number) {
            const formattedNumber = number.toLocaleString();
            document.getElementById("num1").innerText = formattedNumber;
        });

        animateNumber(<?php echo $general['parameter_customer'] ?>, 1000, 0, function (number) {
            const formattedNumber = number.toLocaleString();
            document.getElementById("num2").innerText = formattedNumber;
        });
        animateNumber(<?php echo $general['parameter_distributor'] ?>, 1000, 0, function (number) {
            const formattedNumber = number.toLocaleString();
            document.getElementById("num3").innerText = formattedNumber;
        });
        animateNumber(<?php echo $general['parameter_factory'] ?>, 3000, 0, function (number) {
            const formattedNumber = number.toLocaleString();
            document.getElementById("num4").innerText = formattedNumber;
        });
        });
    </script>
    <?php $title_parameter = explode('|', $general['another_title']) ?>
    <div class="m-js-countdown lazyloading_box">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-width-large">
                <div class="uk-width-large-1-4 uk-width-medium-1-2 uk-width-small-1-1 mb20">
                    <div class="m-js-countdown-item">
                        <div id='num1' class="numbers-item-number"></div>
                        <div class="numbers-item-title"><?php echo (isset($title_parameter[0]) ? $title_parameter[0] : '-') ?></div>
                    </div>
                </div>
                <div class="uk-width-large-1-4 uk-width-medium-1-2 uk-width-small-1-1 mb20">
                    <div class="m-js-countdown-item">
                        <div class="uk-flex uk-flex-middle m-content-center">
                            <div id='num2' class="numbers-item-number"></div>
                            <span class="m-more">+</span>
                        </div>
                        <div class="numbers-item-title"><?php echo (isset($title_parameter[1]) ? $title_parameter[1] : '-') ?></div>
                    </div>
                </div>
                <div class="uk-width-large-1-4 uk-width-medium-1-2 uk-width-small-1-1 mb20">
                    <div class="m-js-countdown-item">
                        <div id='num3' class="numbers-item-number"></div>
                        <div class="numbers-item-title"><?php echo (isset($title_parameter[2]) ? $title_parameter[2] : '-') ?></div>
                    </div>
                </div>
                <div class="uk-width-large-1-4 uk-width-medium-1-2 uk-width-small-1-1 mb20">
                    <div class="m-js-countdown-item">
                        <div id='num4' class="numbers-item-number"></div>
                        <div class="numbers-item-title"><?php echo (isset($title_parameter[3]) ? $title_parameter[3] : '-') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($panel['our-teams']['data']) && is_array($panel['our-teams']['data']) && count($panel['our-teams']['data'])){ ?>
        <div class="m-ourteam lazyloading_box">
            <div class="uk-container uk-container-center">
                <div class="m-ourteam-content uk-flex uk-flex-middle uk-flex-space-between">
                    <div class="m-aboutus-head">
                        <h2 class="m-aboutuss-title"> <?php echo $panel['our-teams']['title'] ?> </h2>
                        <p class="m-aboutuss-text"><?php echo $panel['our-teams']['description'] ?></p>
                        <span class="heading-underline2 solid"> <span></span> </span>  
                    </div>
                    <div class="m-button-ourteam hvr-bounce-to-right m-black"><a class="m-text" href="" title="">JOIN OUR TEAM</a></div>
                </div>
                <div class="m-ourteam-body">
                    <?php
                        $owlInit = [
                            'items' => 3,
                            'nav' => false,
                            'loop' => true,
                            'autoplay' => false,
                            'autoplayTimeout' => 3000,
                        ];
                    ?> 
                    <div class="owl-slide">
                        <div class="category category-doctor" >
                            <div class="owl-carousel" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>">
                                <?php foreach ($panel['our-teams']['data'] as $key => $value) { ?>
                                    <div>
                                        <div class="our-item">
                                            <div class="ours-item-image">
                                                <img class=" img-scaledown" src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>">
                                            </div>
                                            <div class="our-content">
                                                <div class="out-meta">
                                                    <div class="ours-item-name">  <a  class="m-text" href="" title="<?php echo $value['title'] ?>" onclick="return false"><?php echo $value['title'] ?></a>  </div>
                                                    <div class="ours-item-position"><?php echo base64_decode($value['description']) ?></div>
                                                </div>
                                                <div class="ours-item-description"><?php echo base64_decode($value['content']) ?></div>
                                                <div class="ours-item-social uk-flex">
                                                    <a href="" title="social"><i class="fa fa-facebook"></i></a>
                                                    <a href="" title="social"><i class="fa fa-twitter"></i></a>
                                                    <a href="" title="social"><i class="fa fa-skype"></i></a>
                                                    <a href="" title="social"><i class="fa fa-instagram"></i></a>
                                                    <a href="" title="social"><i class="fa fa-envelope"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php $about_us = get_slide(['keyword' => 'about-us', 'language' => $language]); ?>
    <div class="n-contact lazyloading_box">
        <div class="uk-grid uk-grid-collapse" data-uk-grid-match>
            <div class="uk-width-large-1-2">
                <div class="left-side">
                    <div class="img-cover">
                        <?php echo isset($about_us[0]['image']) ? render_img(['src' => $about_us[0]['image']]) : '' ?>
                    </div>
                </div>
            </div>
            <div class="uk-width-large-1-2">
                <div class="right-side">
                    <div class="cms-heading layout2 heading mb40">
                        <h2 class="custom-heading">
                            <span><?php echo isset($about_us[0]['title']) ?  $about_us[0]['title'] : '' ?></span>
                        </h2>
                        <div class="custom-description">
                            <?php echo isset($about_us[0]['description']) ?  $about_us[0]['description'] : '' ?>
                        </div> 
                        <span class="heading-underline solid">
                            <span></span> 
                        </span>
                    </div>
                    <div class="panel-body">
                        <form class="about-contact-form" method="post" action="">
                            <div class="form-row">
                                <div class="uk-grid uk-grid-medium">
                                    <div class="uk-width-large-1-2">
                                        <input type="text" name="" placeholder="YOUR NAME*" class="input-text">
                                    </div>
                                    <div class="uk-width-large-1-2">
                                        <input type="text" name="" placeholder="EMAIL*" class="input-text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="uk-grid uk-grid-medium">
                                    <div class="uk-width-large-1-2">
                                        <input type="text" name="" placeholder="YOUR PHONE" class="input-text">
                                    </div>
                                    <div class="uk-width-large-1-2">
                                        <select id="cars">
                                            <option value="volvo">Inquiry 1</option>
                                            <option value="saab">Inquiry 2</option>
                                            <option value="vw">Inquiry 3</option>
                                            <option value="audi" selected>YOUR INQUIRY ABOUT</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <textarea name="message" class="uk-width-1-1 form-textarea" placeholder="YOUR MESSAGE*"></textarea>
                            </div>
                            <div class="form-row">
                                <div class="n-intro-more mb30">
                                    <a href="" title="" class="hvr-sweep-to-right">
                                        SUBMIT QUOTE
                                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="form-row">
                                <input type="checkbox" name="" id="agree">
                                <label for="agree">
                                    Agree to our terms and conditions.
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($panel['testimonials']['data']) && is_array($panel['testimonials']['data']) && count($panel['testimonials']['data'])){ ?>
        <?php 
            $owlInit = array(
                'lazyload' => true,
                'nav' => false,
                'dots' => true,
                'loop' => true,
                'autoplay' => true,
                'margin' => 15,
                'autoplayTimeout' => 3000,
                'responsive' => array(
                    0 => array(
                        'items' => 1,
                    ),
                    375 => array(
                        'items' => 1,
                    ),
                    768 => array(
                        'items' => 2,
                    ),
                )
            );
        ?>
        <div class="m-testimonials lazyloading_box">
            <div class="uk-container uk-container-center">
                <div class="m-testimonials-head">
                    <h2 class="m-testimonials-title"><?php echo $panel['testimonials']['title'] ?></h2>
                    <p class="m-testimonials-description"><?php echo $panel['testimonials']['description'] ?></p>
                    <span class="heading-underline solid"> <span></span> </span>
                </div>
                <div class="m-testimonials-body">
                    <div class="owl-slide">
                        <div class="category category-doctor" >
                            <div class="owl-carousel" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>">
                                <?php foreach ($panel['testimonials']['data'] as $key => $value) { ?>
                                    <div>
                                        <div class="review-item">
                                            <div class="review-item-text"><?php echo base64_decode($value['content']) ?></div>
                                            <div class="review-item-quote">
                                                <i class="fa fa-quote-right" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="review-info uk-flex uk-flex-middle">
                                            <div class="review-img">
                                                <img class="img-scaledown" src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>">
                                            </div>
                                            <div class="reviewer">
                                                <h5 class="m-name-text"><?php echo $value['title'] ?>
                                                    <div class="m-rating">
                                                        <i class="fa fa-star "></i>
                                                        <i class="fa fa-star "></i>
                                                        <i class="fa fa-star "></i>
                                                        <i class="fa fa-star "></i>
                                                        <i class="fa fa-star "></i>
                                                    </div>
                                                </h5>
                                                <div class="m-address-text"><p><?php echo base64_decode($value['description']) ?></p></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>      
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if(isset($logo_slide) && is_array($logo_slide) && count($logo_slide)){ ?>
        <div class="m-partner lazyloading_box">
            <?php
                $owlInit = [
                    'items' => 4,
                    'nav' => false,
                    'loop' => true, 
                    'autoplay' => true,
                    'autoplayTimeout' => 3000,
                ];
            ?>
            <div class="uk-container uk-container-center">
                <div class="owl-slide">
                    <div class="category category-doctor" >
                        <div class="owl-carousel" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>">
                            <?php foreach ($logo_slide as $key => $value) { ?>
                                <div>
                                    <div class="m-partner-item">
                                        <a class="img-cover" href="" onclick="return false;" title="<?php echo $value['image'] ?>"><img src="<?php echo $value['image'] ?>" alt="<?php echo $value['image'] ?>"></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</section>