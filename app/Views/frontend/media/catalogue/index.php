<section id="body">
    <div id="article-page" class="page-body">
        <div class="breadcrumb">
            <div class="uk-container uk-container-center">
                <ul class="uk-breadcrumb">
                    <li>
                        <a href="#" title=" Trang chủ"><i class="fa fa-home"></i> Trang chủ</a>
                    </li>
                    <?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){
                    foreach ($breadcrumb as $value) {
                    ?>
                    <li class=""><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a></li>
                    <?php }} ?>
                </ul>
            </div>
        </div>
        <!-- .breadcrumb -->
        <div class="uk-container uk-container-center">
            <section class="design-catalogues">
                <section class="panel-body">
                    <ul class="uk-grid uk-grid-medium uk-grid-width-large-1-4 list-article" data-uk-grid>
                        <?php   if(isset($articleList) && is_array($articleList) && count($articleList)){
                        foreach (   $articleList as $value) {
                        ?>
                        <li>
                            <article class="article uk-clearfix">
                                <div class="thumb">
                                    <a class="image img-cover" href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>">
                                        <img src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>" />
                                    </a>
                                </div>
                                <div class="infor">
                                    <h3 class="title"><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a></h3>
                                    <div class="meta uk-clearfix">
                                        <span class="datetime"><?php echo date('d/m/Y', strtotime($value['created_at'])) ?></span>
                                    </div>
                                    <div class="description">
                                        <?php   echo base64_decode( $value['description']) ?>
                                    </div>
                                </div>
                            </article>
                            <!-- .article -->
                        </li>
                        <?php }} ?>
                    </ul>
                </section>
                <footer class="panel-foot">
                    <div id="pagination" class="pagination mb30">
                        <?php echo (isset($pagination)) ? $pagination : ''; ?>
                    </div>
                </footer>
            </section>
        </div>
    </div>
</section>