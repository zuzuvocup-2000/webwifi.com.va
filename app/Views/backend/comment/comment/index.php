<?php  
    helper('form');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $languageList = get_list_language(['currentLanguage' => $language]);
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản lý Comment</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>"><?php echo translate('cms_lang.post.post_home', $language) ?></a>
         </li>
         <li class="active"><strong>Quản lý Comment</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý Comment </h5>
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
                                        <a href="<?php echo base_url('backend/comment/comment/create') ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Thêm mới Comment</a>
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
                            <th style="width: 200px">Khách hàng</th>
                            <th class="text-center">Điện thoại</th>
                            <th >Email</th>
                            <th class="text-center" style="width: 80px">Module</th>
                            <th class="text-center" style="width: 70px">Chi tiết</th>
                            <th >Comment</th>
                            <th class="text-center" style="width: 100px">Đánh giá</th>
                            <th class="text-center">Hiển thị</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php if(isset($commentList) && is_array($commentList) && count($commentList)){ ?>
                            <?php foreach($commentList as $key => $val){ ?>
                            <?php  
                                $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
                            ?>

                            <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                    <div for="" class="label-checkboxitem"></div>
                                </td>
                                <td><?php echo $val['fullname'] ?></td>
                                <td class="text-center"><?php echo $val['phone'] ?></td>
                                <td ><?php echo $val['email'] ?></td>
                                <td class="text-center"><?php echo $val['module'] ?></td>
                                <td class="text-center">
                                    <a href="<?php echo $val['url'].HTSUFFIX ?>" target="_blank"><i class="fa fa-link" aria-hidden="true"></i></a>  
                                </td>
                                <td><?php echo $val['comment'] ?></td>
                                <td class="text-center rate-view">
                                    <?php 
                                        for ($i = 1; $i <= $val['rate'] ; $i++) { 
                                            echo '<i class="star-rating fa fa-star" aria-hidden="true"></i>';
                                        }
                                        for ($i = 1; $i <= 5 - $val['rate']; $i++) { 
                                            echo '<i class="star-rating fa fa-star-o" aria-hidden="true"></i>';
                                        }
                                    ?>
                                </td>
                                
                                <td class="text-center publishonoffswitch" data-field="publish" data-module="<?php echo $module; ?>" data-where="id">
                                    <div class="switch">
                                        <div class="onoffswitch">
                                            <input type="checkbox" class="onoffswitch-checkbox publish" data-id="<?php echo $val['id'] ?>" id="publish-<?php echo $val['id'] ?>" <?php echo ($val['publish'] == 1 ? 'checked' : '') ?>>
                                            <label class="onoffswitch-label" for="publish-<?php echo $val['id'] ?>">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a type="button" href="<?php echo base_url('backend/comment/comment/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a type="button" href="<?php echo base_url('backend/comment/comment/delete/'.$val['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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