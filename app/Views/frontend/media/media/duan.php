<div class="page-wrapper">
    <!-- End Header -->
    <main class="main">
        <div class="page-content">
            <main class="main">
                <nav class="breadcrumb-nav mt-0 mt-lg-3">
                    <div class="container">
                        <ul class="breadcrumb">
                            <li><a href="/"><i class="d-icon-home"></i></a></li>
                            <?php foreach($breadcrumb as $key => $val){ ?>
                            <li><a href="<?php echo $val['canonical'].HTSUFFIX ?>" class="<?php echo $detailCatalogue['canonical'] == $val['canonical'] ? 'active' : '' ?>"><?php echo $val['title'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </nav>
                <div class="page-content with-sidebar">
                    <div class="container">
                        <?php if(isset($panel['intro-top']['data']) && is_array($panel['intro-top']['data']) && count($panel['intro-top']['data'])){
                        $intro = $panel['intro-top']['data'][0];
                        if(isset($intro['sub_title']) && $intro['sub_title'] != ''){
                        $sub_title = json_decode(base64_decode($intro['sub_title']));
                        $sub_content = json_decode(base64_decode($intro['sub_content']));
                        if(isset($sub_title) && is_array($sub_title) && count($sub_title)){
                        ?>
                        <section class="intro-top-media mt30 ">
                            <div class="title uk-text-uppercase uk-flex-center"><?php echo $panel['intro-top']['title'] ?></div>
                            <div class="uk-grid uk-grid-width-1-1 uk-grid-medium uk-grid-width-medium-1-2 uk-grid-width-large-1-3">
                                <?php
                                foreach ($sub_title as $key => $value) {
                                ?>
                                <div class="wrap-grid">
                                    <div class="title-intro-media"><?php echo $value ?></div>
                                    <div class="content-intro-media">
                                        <?php echo $sub_content[$key] ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </section>
                        <?php }}} ?>
                        <?php if(isset($articleRelate) && is_array($articleRelate) && count($articleRelate)){
                        ?>
                        <section class="design-panel pt50 pb50">
                            <div class="uk-container uk-container-center">
                                <div class="title uk-text-uppercase uk-flex-center">Một số dự án thiết kế tiêu biểu</div>
                                <div class="wrap-body-design">
                                    <div class="uk-grid uk-grid-medium uk-grid-width-1-1 uk-grid-width-medium-1-2 uk-grid-width-large-1-3 uk-clearfix">
                                        <?php
                                        foreach ($articleRelate as $keyChild => $valueChild) {
                                        $data['value'] = $valueChild;
                                        echo view('frontend/homepage/core/duan', $data);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php } ?>
                        <article class="post-single">
                            <div class="post-details">
                                <h1 class="post-title"><?php echo $object['title'] ?></h1>
                                <ul class="mb30">
                                    <li class="general-info-media">Khách hàng: <strong><?php echo ($object['customer'] == '') ? 'Đang cập nhật' : $object['customer'] ?></strong></li>
                                    <li class="general-info-media">Diện tích: <strong><?php echo ($object['area'] == '') ? 'Đang cập nhật' : $object['area'] ?></strong></li>
                                    <li class="general-info-media">Phong cách: <strong><?php echo ($object['phongcach'] == '') ? 'Đang cập nhật' : $object['phongcach'] ?></strong></li>
                                    <li class="general-info-media ">Đơn vị thực hiện: <strong><?php echo ($object['brand'] == '') ? 'Đang cập nhật' : $object['brand'] ?></strong></li>
                                </ul>
                                <div class="post-body mb-7 css-content">
                                    <?php echo $object['description'] ?>
                                    <?php echo $object['content'] ?>
                                </div>
                            </div>
                        </article>
                        <?php if(isset($object['sub_title']) && is_array($object['sub_title']) && count($object['sub_title'])){
                        foreach ($object['sub_title'] as $key => $value) {
                        ?>
                        <section class="intro-top-media mt30 ">
                            <div class="title uk-text-uppercase uk-flex-center"><?php echo $value ?></div>
                            <div class="content-intro-media">
                                <?php echo $object['sub_content'][$key] ?>
                            </div>
                        </section>
                        <?php }} ?>
                        <?php if(isset($panel['question']['data']) && is_array($panel['question']['data']) && count($panel['question']['data'])){
                            $question = $panel['question']['data'][0];
                            if(isset($question['sub_title']) && $question['sub_title'] != ''){
                            $sub_title = json_decode(base64_decode($question['sub_title']));
                            $sub_content = json_decode(base64_decode($question['sub_content']));
                            if(isset($sub_title) && is_array($sub_title) && count($sub_title)){
                        ?>
                        <section class="question-panel">
                            <header class="main-header">
                                <h2 class="heading">
                                <?php echo $panel['question']['title'] ?>
                                </h2>
                            </header>
                            <section class="question-body">
                                <div class="uk-container uk-container-center">
                                    <div class="question-content">
                                        <div class="uk-accordion" data-uk-accordion>
                                            <?php
                                            foreach ($sub_title as $key => $value) {
                                            ?>
                                            <h3 class="uk-accordion-title">
                                            <?php echo $value ?>
                                            </h3>
                                            <div class="uk-accordion-content">
                                                <?php echo $sub_content[$key] ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </section>
                        <?php }}} ?>
                        <?php if(isset($panel['quy-trinh']['data']) && is_array($panel['quy-trinh']['data']) && count($panel['quy-trinh']['data'])){
                            $quy_trinh = $panel['quy-trinh']['data'][0];
                            if(isset($quy_trinh['sub_title']) && $quy_trinh['sub_title'] != ''){
                            $sub_title = json_decode(base64_decode($quy_trinh['sub_title']));
                            $sub_content = json_decode(base64_decode($quy_trinh['sub_content']));
                            if(isset($sub_title) && is_array($sub_title) && count($sub_title)){
                        ?>
                            <section class="step-panel mt50">
                                <div class="uk-container uk-container-center">
                                    <header class="main-header mb40">
                                        <h2 class="heading mb40">
                                            <?php echo $panel['quy-trinh']['title'] ?>
                                        </h2>
                                        <div class="description uk-width-large-3-4 m-a">
                                            <?php echo $panel['quy-trinh']['description'] ?>
                                        </div>
                                    </header>
                                    <section class="step-body">
                                        <div class="uk-grid uk-grid-collapse uk-grid-match">
                                            <div class="uk-width-large-1-2">
                                                <div class="step-pic">
                                                    <div class="img img-cover">
                                                        <?php echo render_img(['src' =>$panel['quy-trinh']['image']]) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-large-1-2">
                                                <div class="step-content">
                                                    <div class="uk-accordion" data-uk-accordion>
                                                        <?php
                                                        foreach ($sub_title as $key => $value) {
                                                        ?>
                                                        <h3 class="uk-accordion-title">
                                                        <?php echo $value ?>
                                                        </h3>
                                                        <div class="uk-accordion-content">
                                                            <?php echo $sub_content[$key] ?>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </section>
                        <?php }}} ?>
                    </div>
                </div>
            </main>
        </div>
    </main>
</div>