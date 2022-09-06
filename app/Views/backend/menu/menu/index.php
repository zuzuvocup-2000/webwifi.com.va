<?php  
    helper('form');
    helper('nestedset');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $AutoloadModel = new App\Models\AutoloadModel();
    $languageList = get_full_language(['currentLanguage' => $language]);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo translate('cms_lang.menu.ListMenu', $language) ?></h2>
        <ol class="breadcrumb mb20">
            <li>
                <a href="http://ipanel.thegioiweb.org/admin.html"><?php echo translate('cms_lang.menu.home_menu', $language) ?></a>
            </li>
            <li class="active"><strong><?php echo translate('cms_lang.menu.ListMenu', $language) ?></strong></li>
        </ol>
        <div class="uk-flex uk-flex-middle" >
            <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                <?php foreach($languageList as $key => $val){ ?>
                    <a href="<?php echo base_url('backend/menu/menu/index/'.$id.'/'.$val['canonical'].'') ?>" class="mr10" title="<?php echo $val['canonical'] ?>">
                        <span class="icon-flag img-cover"><img src="<?php echo getthumb($val['image']); ?>" alt=""></span>
                    </a>
            <?php }} ?>
        </div>
    </div>
</div>
<form method="post" action="" class="form-horizontal box">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="box-body">
        </div><!-- /.box-body -->
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <h2 class="panel-title"><?php echo translate('cms_lang.menu.ListMenu', $language) ?></h2>
                    <div class="panel-description">
                        <p>+ <?php echo translate('cms_lang.menu.Note10', $language) ?></p>
                        <p>+ <?php echo translate('cms_lang.menu.Note11', $language) ?></p>
                        <p>
                            + <?php echo translate('cms_lang.menu.Note12', $language) ?>
                        </p>
                        <a style="color:#000;border-color:#c4cdd5;display:inline-block !important;" href="<?php echo base_url('backend/menu/menu/create/'.$id.'/'.$languageSelect.'') ?>" title="" class="btn btn-default va-btn-default block m-b"><?php echo translate('cms_lang.menu.AddMenu', $language) ?></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <?php 
                    if(isset($menuCatalogue) && is_array($menuCatalogue) && count($menuCatalogue)){
                        foreach ($menuCatalogue as $keyCatalogue => $valCatalogue) {
                ?>
                    <div class="ibox">
                        <div class="ibox-title" style="padding: 9px 15px 9px;">
                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                <h5><?php echo $valCatalogue['title'] ?></h5>
                                <a style="color:#000;border-color:#c4cdd5;display:inline-block !important;" href="<?php echo base_url('backend/menu/menu/create/'.$id.'/'.$languageSelect.'') ?>" title="" class="btn btn-default va-btn-default block m-b"><?php echo translate('cms_lang.menu.UpdateMenu', $language) ?></a>
                            </div>
                        </div>
                        <script>
                            var language_nested = '<?php echo $languageSelect ?>';
                        </script>
                        <div class="ibox-content">
                             <div class="dd nestable2" id="" data-catalogueid="<?php echo $valCatalogue['id'] ?>">
                                <?php 

                                    $menuList = menu_recursive($menuList);
                                    if(isset($menuList) && is_array($menuList) && count($menuList)){
                                ?>
                                <ol class="dd-list">
                                    <?php 
                                    echo render_menu_recursive($menuList, $id, $languageSelect); ?>
                                    <?php }else{ ?>
                                        <p class="text-danger m0"><?php echo translate('cms_lang.menu.empty', $language) ?></p>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div>
                <?php }} ?>
            </div>
        </div>
    </div>
</form>

