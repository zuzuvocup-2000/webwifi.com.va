<?php
    helper('form');
    helper('mydata');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $AutoloadModel = new App\Models\AutoloadModel();
    $languageList = get_full_language(['currentLanguage' => $language]);
?>
<script type="text/javascript">
    var type_canonical = "<?php echo $general['website_canonical']; ?>";
</script>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo translate('cms_lang.menu.AddMenu', $language) ?></h2>
        <ol class="breadcrumb mb20">
            <li>
                <a href=""><?php echo translate('cms_lang.menu.home_menu', $language) ?></a>
            </li>
            <li class="active"><strong><?php echo translate('cms_lang.menu.AddMenu', $language) ?></strong></li>
        </ol>
        <div class="uk-flex uk-flex-middle" >
            <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                <?php foreach($languageList as $key => $val){ ?>
                    <a href="<?php echo isset($id) ? base_url('backend/menu/menu/create/'.$id.'/'.$val['canonical'].'') : base_url('backend/menu/menu/createmenu/'.$val['canonical'].'') ?>" class="mr10" title="<?php echo $val['canonical'] ?>">
                        <span class="icon-flag img-cover"><img src="<?php echo getthumb($val['image']); ?>" alt=""></span>
                    </a>
            <?php }} ?>
        </div>
    </div>
</div>
<form method="post" action="" class="form-horizontal box pb20">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="box-body">
                <?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
            </div><!-- /.box-body -->
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <h2 class="panel-title"><?php echo translate('cms_lang.menu.MenuPosition', $language) ?></h2>
                    <div class="panel-description">
                        <p>+ <?php echo translate('cms_lang.menu.Note13', $language) ?></p>
                        <p>+ <?php echo translate('cms_lang.menu.Note14', $language) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox m0" >
                    <div class="ibox-content" >
                        <div class="row mb15" >
                            <div class="col-lg-12" >
                                <div class="form-row" >
                                    <label class="control-label text-left w100">
                                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                            <span><?php echo translate('cms_lang.menu.Menu', $language) ?> <b class="text-danger">(*)</b></span>
                                            <button type="button" name="add_menu" id="add_menu" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning"><?php echo translate('cms_lang.menu.CADP', $language) ?></button>
                                        </div>
                                    </label>
                                    <select name="parentid" class="form-control m-b select2 " aria-hidden="true">
                                        <option value="0">-- <?php echo translate('cms_lang.menu.menu_select', $language) ?> --</option>
                                        <?php if(isset($menuCatalogue) && is_array($menuCatalogue) && count($menuCatalogue)){ ?>
                                            <?php foreach ($menuCatalogue as $key => $value){ ?>
                                            <option value="<?php echo $value['id'] ?>" <?php echo ((isset($_POST['parentid']) || (isset($id) ? ( $value['id'] == $id) : '')) ? 'selected' : '') ?>><?php echo $value['title'] ?></option>
                                        <?php }} ?>
                                    </select>
                                </div>
                                <?php if(isset($parent_menu) && is_array($parent_menu) && count($parent_menu)){ ?>
                                    <div class="form-row mt20" >
                                        <label class="control-label text-left w100">
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Chọn kiểu menu <b class="text-danger">(*)</b></span>
                                            </div>
                                        </label>
                                        <select name="type" class="form-control m-b select2 " aria-hidden="true">
                                            <option value="" <?php echo isset($parent_menu['type']) && $parent_menu['type'] == '' ? 'selected' : '' ?>>Menu dropdown mặc định</option>
                                            <!-- <option value="mega_image" <?php echo isset($parent_menu['type']) && $parent_menu['type'] == 'mega_image' ? 'selected' : '' ?>>Menu mega kèm hình ảnh</option> -->
                                            <option value="mega_list" <?php echo isset($parent_menu['type']) && $parent_menu['type'] == 'mega_list' ? 'selected' : '' ?>>Menu mega danh sách</option>
                                        </select>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-4">
                <div class="ibox-content va-content" style="">
                    <div class="panel-body va-panel-body">
                        <div class="panel-group" id="accordion">
                            <?php
                                if(isset($object) && is_array($object) && count($object)){
                                    foreach ($object as $key => $value) {
                                        if($value == []) continue;
                                        $object_menu = object_menu($value[0]['module'],$value[0]['translate'], $languageABC);
                            ?>
                                <div class="panel panel-default va-general" data-id="#<?php echo $value[0]['module'] ?>">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $value[0]['module'] ?>_collapse" aria-expanded="true" class="collapsed va-collapse panel-heading va-panel-heading">
                                        <?php echo $value[0]['name'] ?>
                                        <i class="fa fa-caret-up va-arrow" aria-hidden="true"></i>
                                    </a>
                                    <div id="<?php echo $value[0]['module'] ?>_collapse" class="panel-collapse collapse" aria-expanded="true" style="">
                                        <div class="panel-body va-panel-body" id="<?php echo $value[0]['module'] ?>">
                                            <ul class="tabs">
                                                <li class="tab-link current" data-tab="<?php echo $value[0]['module'].'_new' ?>"><?php echo translate('cms_lang.menu.menu_new', $language) ?></li>
                                                <li class="tab-link" data-tab="<?php echo $value[0]['module'].'_search' ?>"><?php echo translate('cms_lang.menu.menu_search', $language) ?></li>
                                            </ul>
                                            <ul class="tabs-content">
                                                <li id="<?php echo $value[0]['module'].'_new' ?>" class="tab-content current">
                                                    <div class="va-checkbox-all" data-class=".list_<?php echo $value[0]['module'] ?>">
                                                        <div class="list_<?php echo $value[0]['module'] ?>">
                                                            <?php
                                                            if(isset($object_menu) && is_array($object_menu) && count($object_menu)){ ?>
                                                                <?php foreach ($object_menu as $key => $val) { ?>
                                                                <div class="uk-flex mb5 va_select_all">
                                                                    <input type="checkbox" data-title="<?php echo $val['title'] ?>" name="check[check_select]" data-catid="<?php echo $val['catalogueid'] ?>" data-id="<?php echo $val['objectid'] ?>" data-module="<?php echo $val['module'] ?>" data-language="<?php echo $languageABC ?>" id="<?php echo $val['canonical'] ?>" value="<?php echo $val['canonical'] ?>" >
                                                                    <label for="<?php echo $val['canonical'] ?>" class="ml15 va-checkbox va-label"><?php echo $val['title'] ?></label>
                                                                </div>
                                                            <?php }} ?>
                                                            <div class="uk-flex uk-flex-middle mb10">
                                                                <input type="checkbox" name="<?php echo $value[0]['module'] ?>_all" id="<?php echo $value[0]['module'] ?>_all" class="<?php echo $value[0]['module'] ?>_all va_check_id" value="all">
                                                                <label for="<?php echo $value[0]['module'] ?>_all" class="ml15"><?php echo translate('cms_lang.menu.menu_selectall', $language) ?></label>
                                                            </div>
                                                            <a href="" class="btn btn-default va-search va_select_checkbox right block m-b" name="add_menu_item"><?php echo translate('cms_lang.menu.menu_add', $language) ?></a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li id="<?php echo $value[0]['module'].'_search' ?>" class="tab-content">
                                                    <input type="text" placeholder="<?php echo translate('cms_lang.menu.tourjet_placeholder', $language) ?>" class="typeahead_2 mb20 search_general form-control" data-search="<?php echo $value[0]['module']?>" data-translate="<?php echo $value[0]['translate']?> " data-language="<?php echo $languageABC; ?>">
                                                    <div class="va-list-general">
                                                    </div>
                                                    <a href="" class="btn btn-default va-search va_select_checkbox right block m-b" name="add_menu_item"><?php echo translate('cms_lang.menu.menu_add', $language) ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            <?php }} ?>

                            <div class="panel panel-default">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" class="collapsed va-collapse panel-heading va-panel-heading">
                                    <?php echo translate('cms_lang.menu.Menu_link', $language) ?>
                                    <i class="fa fa-caret-up va-arrow" aria-hidden="true"></i>
                                </a>
                                <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body va-panel-body">
                                        <h2 class="panel-title"><?php echo translate('cms_lang.menu.menu_create', $language) ?></h2>
                                        <div class="panel-description">
                                            <p>+ <?php echo translate('cms_lang.menu.menu_des', $language) ?></p>
                                            <p><small class="text-danger">* <?php echo translate('cms_lang.menu.menu_des_2', $language) ?></small></p>
                                            <p><small class="text-danger">* <?php echo translate('cms_lang.menu.menu_des_3', $language) ?></small></p>
                                            <p><small class="text-danger">* <?php echo translate('cms_lang.menu.menu_des_4', $language) ?></small></p>
                                            <a style="color:#000;border-color:#c4cdd5;display:inline-block !important;" href="" title="" class="btn btn-default add-menu m-b m-r right"><?php echo translate('cms_lang.menu.add_link', $language) ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox m0">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-row">
                                    <label style="margin:0;"><?php echo translate('cms_lang.menu.Title4', $language) ?></label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-row">
                                    <label style="margin:0;"><?php echo translate('cms_lang.menu.Path', $language) ?></label>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-row">
                                    <label style="margin:0;"><?php echo translate('cms_lang.menu.Order', $language) ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed" style="margin:10px 0;"></div>
                        <div class="menu-list">
                            <?php if(isset($menuList) && is_array($menuList) && count($menuList)){ ?>
                                <?php foreach ($menuList as $key => $value) { ?>
                               <div class="row mb15">
                                   <div class="col-lg-4">
                                       <div class="form-row">
                                           <input type="hidden" placeholder="" value="<?php echo $value['id'] ?>" name="menu[id][]" class="form-control input_menu_title" >
                                           <input type="text" placeholder="" value="<?php echo $value['title'] ?>" name="menu[title][]" class="form-control input_menu_title" >
                                       </div>
                                   </div>
                                   <div class="col-lg-4">
                                       <div class="form-row">
                                           <input type="text" placeholder="" value="<?php echo $value['canonical'] ?>" name="menu[link][]" class="form-control input_menu_canonical" >
                                       </div>
                                   </div>
                                   <div class="col-lg-2">
                                       <div class="form-row">
                                           <input type="text" value="<?php echo $value['order'] ?>" style="text-align:right;" name="menu[order][]" class="form-control" >
                                       </div>
                                   </div>
                                   <div class="col-lg-2">
                                       <div class="form-row" style="text-align:right;margin-top:10px;">
                                           <a class=" <?php echo ((isset($value['id']) && $value['id'] != '') ? 'btn_ajax_del' : 'delete-menu') ?> image img-scaledown" data-id="<?php echo check_isset($value['id']) ?>" data-node="0" style="height:12px;"><img src="/public/backend/img/close.png" /></a>
                                       </div>
                                   </div>
                               </div>
                            <?php }}else{ ?>
                                <div class="menu-notification" style="text-align:center;"><h4 style="font-weight:500;font-size:16px;color:#000"><?php echo translate('cms_lang.menu.menu_empty', $language) ?></h4><?php echo translate('cms_lang.menu.menu_des_empty', $language) ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="toolbox action clearfix">
            <div class="uk-flex uk-flex-middle uk-button pull-right">
                <button class="btn btn-primary btn-sm" name="create" value="create" type="submit"><?php echo translate('cms_lang.menu.save', $language) ?></button>
            </div>
        </div>
    </div>
</form>


<div id="add_data_Modal" class="modal fade">
      <div class="modal-dialog">
           <div class="modal-content">
                <div class="modal-header">
                    <div class="uk-flex uk-flex-space-between uk-flex-middle" >
                       <h4 class="modal-title"><?php echo translate('cms_lang.menu.modal', $language) ?></h4>
                       <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                </div>
                <div class="modal-body">
                     <form method="post" id="insert_form">
                          <label><?php echo translate('cms_lang.menu.modal_title', $language) ?></label>
                          <input type="text" name="title_menu" id="title_menu" class="form-control" />
                          <br />
                          <label><?php echo translate('cms_lang.menu.modal_value', $language) ?></label>
                          <input type="text" name="value_menu" id="value_menu" class="form-control" />
                          <br />
                          <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success " />
                     </form>
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
           </div>
      </div>
 </div>
