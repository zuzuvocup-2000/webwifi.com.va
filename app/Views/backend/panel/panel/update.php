<?php  
    helper('form');
    helper('nestedset');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $AutoloadModel = new App\Models\AutoloadModel();
    $languageList = get_full_language(['currentLanguage' => $language]);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div>
                <h2><?php echo translate('cms_lang.panel.update_panel', $language) ?></h2>
                <ol class="breadcrumb mb20">
                    <li>
                        <a href=""><?php echo translate('cms_lang.panel.home_panel', $language) ?></a>
                    </li>
                    <li class="active"><strong><?php echo translate('cms_lang.panel.update_panel', $language) ?></strong></li>
                </ol>
                <div class="uk-flex uk-flex-middle" >
                    <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                        <?php foreach($languageList as $key => $val){ ?>
                            <a href="<?php echo base_url('backend/panel/panel/update/'.$id.'/'.$val['canonical'].'') ?>" class="mr10" title="<?php echo $val['canonical'] ?>">
                                <span class="icon-flag img-cover"><img src="<?php echo getthumb($val['image']); ?>" alt=""></span>
                            </a>
                    <?php }} ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo view('backend/panel/panel/store') ?>



