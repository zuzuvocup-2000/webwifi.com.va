<?php
    helper('form');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $languageList = get_list_language(['currentLanguage' => $language]);
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản lý tài liệu</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>"><?php echo translate('cms_lang.post.post_home', $language) ?></a>
         </li>
         <li class="active"><strong>Quản lý tài liệu</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý tài liệu </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                         <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="delete-all" data-module="<?php echo $module; ?>"><?php echo translate('cms_lang.post.post_deleteall', $language) ?></a>
                            </li>
                            <li><a href="#" class="status" data-value="0" data-field="publish" data-module="<?php echo $module; ?>" title="Cập nhật trạng thái bài viết"><?php echo translate('cms_lang.post.post_deactive', $language) ?></a>
                            </li>
                            <li><a href="#" class="status" data-value="1" data-field="publish" data-module="<?php echo $module; ?>" data-title="Cập nhật trạng thái bài viết"><?php echo translate('cms_lang.post.post_active', $language) ?></a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="" method="">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between mb20">
                            <div class="perpage">
                                <div class="uk-flex uk-flex-middle mb10">
                                    <select name="perpage" class="form-control input-sm perpage filter mr10">
                                        <option value="20">20 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="30">30 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="40">40 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="50">50 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="60">60 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="70">70 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="80">80 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="90">90 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="100">100 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="toolbox">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    <div class="form-row cat-wrap">
									<?php
										$selected =20;
										 if(isset($_GET['catalogueid'])){
										 $selected = $_GET['catalogueid'];
										}
									?>
						                                        <?php echo form_dropdown('catalogueid', $dropdown, set_value('catalogueid', (isset($_GET['catalogueid'])) ? $_GET['catalogueid'] : ''), 'class="form-control m-b select2 mr10", onchange="this.form.submit()", style="width:220px;"');?>
                                    </div>
                                    <div class="uk-search uk-flex uk-flex-middle mr10 ml10">
                                        <div class="input-group">
                                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="<?php echo translate('cms_lang.post.post_placeholder', $language) ?>" class="form-control">
                                            <span class="input-group-btn">
                                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm"><?php echo translate('cms_lang.post.post_search', $language) ?>
                                            </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="uk-button">
                                        <a href="<?php echo base_url('backend/file/file/create') ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i>Thêm Tài Liệu</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th style="width: 35px;">
                                <input type="checkbox" id="checkbox-all">
                                <label for="check-all" class="labelCheckAll"></label>
                            </th>
                            <th >Tiêu đề</th>
                             <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                            <?php foreach($languageList as $key => $val){ ?>
                            <th class="text-center" style="width: 100px;">
                                <span class="icon-flag img-cover"><img src="<?php echo getthumb($val['image']); ?>" alt=""></span>
                            </th>
                            <?php }} ?>
                 
                            <th style="width:150px;"><?php echo translate('cms_lang.post.post_creator', $language) ?></th>
                            <th style="width:150px;" class="text-center"><?php echo translate('cms_lang.post.post_created_at', $language) ?></th>
                            <th class="text-center" style="width:88px;"><?php echo translate('cms_lang.post.post_status', $language) ?></th>
                            <th class="text-center" style="width:103px;"><?php echo translate('cms_lang.post.post_action', $language) ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($fileList) && is_array($fileList) && count($fileList)){ ?>
                            <?php foreach($fileList as $key => $val){ ?>

                            <?php
                                $image = getthumb($val['image'], true);
                                $catalogue = json_decode($val['catalogue'], TRUE);
                                $cat_list = [];
                                if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
                                    $cat_list = get_catalogue_object([
                                        'module' => $module,
                                        'catalogue' => $catalogue,
                                    ]);
                                }

                            ?>
                            <?php
                                $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
                            ?>

                            <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                    <div for="" class="label-checkboxitem"></div>
                                </td>
                                <td>
                                    <div class="uk-flex uk-flex-middle">
                                        <div class="image mr5">
                                            <span class="image-post img-scaledown"><img src="<?php echo $image; ?>" alt="<?php echo $val['file_title']; ?>" /></span>
                                        </div>
                                        <div class="main-info">
                                            <div class="title"><a class="maintitle" href="<?php echo $val['icon'] ?>" download title=""><?php echo $val['file_title']; ?> (<?php echo $val['viewed']; ?>)</a></div>
                                            <div class="catalogue" style="font-size:10px">
                                                <span style="color:#f00000;">Nhóm tài liệu: </span>
                                                <a class="" style="color:#333;" href="<?php echo site_url('backend/file/catalogue/update/'.$val['cat_id']); ?>" title=""><?php echo $val['cat_title'] ?></a>
                                                <?php if(isset($cat_list) && is_array($cat_list) && count($cat_list)){ foreach($cat_list as $keyCat => $valCat){ ?>
                                                    <a class="" style="color:#333;" href="<?php echo site_url('backend/file/file/index?catalogueid='.$valCat['id']); ?>" title=""><?php echo $valCat['title'] ?></a><?php echo ($keyCat + 1 < count($cat_list)) ? ',' : '' ?>
                                                <?php }} ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                                <?php foreach($languageList as $keyLanguage => $valLanguage){ ?>
                                <td class="text-center "><a class="text-small <?php echo ($val[$valLanguage['canonical'].'_detect'] > 0 ) ? 'text-success' : 'text-danger' ?> " href="<?php echo base_url('backend/translate/translate/translateObject/'.$val['id'].'/'.$module.'/'.$valLanguage['canonical'].'') ?>">
                                    <?php echo ($val[$valLanguage['canonical'].'_detect'] > 0 ) ? translate('cms_lang.post.post_translated', $language) : translate('cms_lang.post.post_not_translated', $language) ?>

                                </a></td>
                                <?php }} ?>
                        
                                <td class="text-primary"><?php echo $val['creator']; ?></td>
                                <td class="text-center text-primary"><?php echo gettime($val['created_at'],'Y-d-m') ?></td>
                                <td class="text-center td-status" data-field="publish" data-module="<?php echo $module; ?>" data-where="id"><?php echo $status; ?></td>
                                <td class="text-center">
                                    <a type="button" href="<?php echo base_url('backend/file/file/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a type="button" href="<?php echo base_url('backend/file/file/delete/'.$val['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php }}else{ ?>
                                <tr>
                                    <td colspan="100%"><span class="text-danger"><?php echo translate('cms_lang.post.empty', $language) ?></span></td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                    <div id="pagination">
                        <?php echo (isset($pagination)) ? $pagination : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
