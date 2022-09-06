<?php
helper('form');
helper('nestedset');
$baseController = new App\Controllers\BaseController();
$language = $baseController->currentLanguage();
$AutoloadModel = new App\Models\AutoloadModel();
$languageList = get_list_language(['currentLanguage' => $language]);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div>
                <h2><?php echo translate('cms_lang.panel.ManageDisplay', $language) ?></h2>
                <ol class="breadcrumb mb20">
                    <li>
                        <a href=""><?php echo translate('cms_lang.panel.home_panel', $language) ?></a>
                    </li>
                    <li class="active"><strong><?php echo translate('cms_lang.panel.ManageDisplay', $language) ?></strong></li>
                </ol>
            </div>
            <div class="uk-button">
                <a href="<?php echo base_url('backend/panel/panel/create'.'/'.$languageSelect.'') ?>" class="btn btn-success "><i class="fa fa-plus"></i> <?php echo translate('cms_lang.panel.AddaNewlook', $language) ?></a>
            </div>
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
                <div class="col-lg-12">
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th style="width:40px;" class="text-center">STT</th>
                                    <th style="width:80px;" class="text-center"><?php echo translate('cms_lang.panel.Keyword4', $language) ?></th>
                                    <th><?php echo translate('cms_lang.panel.Title3', $language) ?></th>
                                    <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                                    <?php foreach($languageList as $key => $val){ ?>
                                    <th class="text-center" style="width: 100px;">
                                        <span class="icon-flag img-cover"><img src="<?php echo getthumb($val['image']); ?>" alt=""></span>
                                    </th>
                                    <?php }} ?>
                                    <th class="text-center"><?php echo translate('cms_lang.panel.Location1', $language) ?></th>
                                    <th style="width:100px;" class="text-center"><?php echo translate('cms_lang.panel.Manipulation2', $language) ?></th>
                                </tr>
                            </thead>
                            <tbody id="ajax-content">
                                <?php if(isset($panel) && is_array($panel) && count($panel)){
                                    $count = 1;
                                foreach ($panel as $key => $value) {
                                if(isset($locate[$value['locate']]) && $locate[$value['locate']] != ''){
                                $location = $locate[$value['locate']];
                                }
                                ?>
                                <tr class="gradeX" id="<?php echo $value['keyword'] ?>">
                                    <td class="text-center"><?php echo $count ?></td>
                                    <td class="text-center"><?php echo $value['keyword'] ?></td>
                                    <td><a class="" href="<?php echo base_url('backend/panel/panel/update/'.$value['id']) ?>" title=""><?php echo $value['title'] ?></a></td>
                                    <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                                    <?php foreach($languageList as $keyLanguage => $valLanguage){ ?>
                                    <td class="text-center "><a class="text-small <?php echo ($value[$valLanguage['canonical'].'_detect'] > 0 ) ? 'text-success' : 'text-danger' ?> " href="<?php echo base_url('backend/panel/panel/translate/'.$value['id'].'/'.$valLanguage['canonical'].'') ?>">
                                        <?php echo ($value[$valLanguage['canonical'].'_detect'] > 0 ) ? translate('cms_lang.post.post_translated', $language) : translate('cms_lang.post.post_not_translated', $language) ?>
                                    </a></td>
                                    <?php }} ?>
                                    <td class="text-center"><?php echo $location ?></td>
                                    <td class="text-center" >
                                        <a type="button" href="<?php echo base_url('backend/panel/panel/update/'.$value['id'].'/'.$languageSelect.'') ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                        <a type="button" href="<?php echo base_url('backend/panel/panel/delete/'.$value['id']).'/'.$languageSelect.'' ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php $count++;}} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>