<section class="home mt50">
    <div class="first-panel ">
        <div class="container-1 uk-container-center">
            <div class="article-panel">
                <div class="wrap-article mb10">
                    <h2 class="article-title"><?php echo $object['title'] ?></h2>
                </div>
                <div class="info-article mb20">
                    <i class="fa fa-clock-o"></i> <?php echo date('H:i:s d-m-Y' , strtotime($object['created_at'])) ?>
                </div>
                <?php if($module == 'media'){ ?>
                    <div class="info-article-media mb10"><?php echo $object['iframe'] ?></div>
                <?php } ?>
                <div class="info-article-desc mb10"><?php echo $object['description'] ?></div>
                <div class="info-article-content"><?php echo $object['content'] ?></div>
            </div>
        </div>
    </div>
</section>