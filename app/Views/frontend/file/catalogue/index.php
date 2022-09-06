<style>
    .title-big-va{
        margin: 0;
        font-size: 18px;
        line-height: 1.4;
        font-family: 'Quicksans';
        font-weight: 700;
    }
    .stt-va{
        margin-right: 10px;
    }
    .stt-va,
    .content-title .description{
        font-size: 14px;
        color: #000;
        font-weight: 700;
        font-family: 'Quicksans';
        line-height: 1.5;
    }
</style>
<section class="home mt50">
    <div class="first-panel ">
        <div class="container-1 uk-container-center">
            <div class="alert-panel ">
                <div class="alert-body ">
                    <div class="panel-body" style="padding: 30px 30px 10px 30px;">
                        <a href="<?php echo $detailCatalogue['canonical'].HTSUFFIX ?>" title="<?php echo $detailCatalogue['title'] ?>" class="heading-title-va mb20 uk-display-block">
                            <h2 class="title-big-va"><?php echo $detailCatalogue['title'] ?></h2>
                        </a>
                        <hr>
                        <?php 
                            if(isset($fileList) && is_array($fileList) && count($fileList)){
                                $count = 1;
                            foreach ($fileList as $key => $value) { 
                        ?>
                            <div class="article article-download">
                                <div class="box">
                                   
                                    <div class="heading-content mb15 uk-flex uk-flex-middle uk-flex-space-between">
                                        <div class="content-left  uk-flex uk-flex-middle pl20">
                                            <div class="stt-va"><?php echo $count ?>.</div>
                                            <div class="content-title">
                                                <p class="description"><?php echo $value['title'] ?></p>
                                                <p class="description-content limit-line-1"><?php echo $value['description'] ?></p>
                                            </div>
                                        </div>
                                        <div class="content-right">
                                            <div class="dowload">
                                                <a href="<?php echo $value['icon'] ?>" title="<?php echo $value['title'] ?>" class="uk-text-nowrap" download >Tải về <i class="fa fa-download"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        <?php $count++;}} ?>
                        <?php 
                            if(isset($allfile) && is_array($allfile) && count($allfile)){
                            foreach ($allfile as $key => $value) { 
                        ?>
                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="heading-title-va mb10 uk-display-block">
                                <h2 class="title-big-va"><?php echo $value['title'] ?></h2>
                            </a>
                        <?php }} ?>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>