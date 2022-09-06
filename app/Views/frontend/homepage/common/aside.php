<?php
    $model = new App\Models\AutoloadModel();
    $article_love = $model->_get_where([
        'select' => 'tb2.title, tb1.image, tb2.canonical, tb2.description, tb1.created_at',
        'where' => [
            'tb1.deleted_at' => 0,
            'tb1.publish' => 1,
            'tb1.hot' => 1,
        ],
        'table' => 'article as tb1',
        'join' => [
            [
                'article_translate as tb2','tb2.module = "article" AND tb2.objectid = tb1.id AND tb2.language = \''.$language.'\'', 'inner'
            ]
        ],
        'limit' => 5,
        'group_by' => 'tb1.id',
        'order_by' => 'tb1.created_at desc'
    ], true);

    $article_news = $model->_get_where([
        'select' => 'tb2.title, tb1.image, tb2.canonical, tb2.description, tb1.created_at',
        'where' => [
            'tb1.deleted_at' => 0,
            'tb1.publish' => 1,
        ],
        'table' => 'article as tb1',
        'join' => [
            [
                'article_translate as tb2','tb2.module = "article" AND tb2.objectid = tb1.id AND tb2.language = \''.$language.'\'', 'inner'
            ]
        ],
        'limit' => 5,
        'group_by' => 'tb1.id',
        'order_by' => 'tb1.created_at desc'
    ], true);
?>
<?php if(isset($article_news) && is_array($article_news) && count($article_news)){ ?>
<div class="art-new-group">
    <p class="art-box-title">Tin mới nhất</p>

    <div>
        <?php foreach ($article_news as $value) { ?>
            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="item">
                <span class="number"></span>
                <span class="title"><?php echo $value['title'] ?></span>
            </a>
        <?php } ?>
    </div>
</div>
<?php } ?>
<?php if(isset($article_love) && is_array($article_love) && count($article_love)){ ?>
<div class="art-top-group">
    <p class="art-box-title">BÀI VIẾT nổi bật</p>

    <div>
        <?php foreach ($article_love as $key => $value) { ?>
            <?php if($key ==0){ ?>
            <div class="big-item">
                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="item-img">
                    <img data-src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>" class="lazy w-auto h-auto" width="1" height="1" />
                </a>

                <div class="item-text">
                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="item-title"><?php echo $value['title'] ?></a>
                    <time class="js-art-time" data-time="<?php echo date('d/m/Y H:i:s', strtotime($value['created_at'])) ?>">
                        <?php echo date('d/m/Y H:i:s', strtotime($value['created_at'])) ?>
                    </time>
                    <div class="item-summary"><?php echo strip_tags(base64_decode($value['description'])) ?></div>
                </div>
            </div>
        <?php }else{ ?>
            <div class="art-item">
                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="art-img">
                    <img data-src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>" class="lazy w-auto h-auto" width="1" height="1" />
                </a>

                <div class="art-text">
                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="art-title"><?php echo $value['title'] ?></a>
                    <time class="js-art-time" data-time="<?php echo date('d/m/Y H:i:s', strtotime($value['created_at'])) ?>">
                        <?php echo date('d/m/Y H:i:s', strtotime($value['created_at'])) ?>
                    </time>
                </div>
            </div>
        <?php }} ?>
    </div>
</div>
<?php } ?>
