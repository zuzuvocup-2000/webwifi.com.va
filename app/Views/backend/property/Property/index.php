<?php  
    helper('form');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $languageList = get_list_language(['currentLanguage' => $language]);
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản Lý Bài Viết</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Home</a>
         </li>
         <li class="active"><strong>Quản lý Bài Viết</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý Bài Viết </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                         <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="delete-all" data-module="<?php echo $module; ?>">Xóa tất cả</a>
                            </li>
                            <li><a href="#" class="status" data-value="0" data-field="publish" data-module="<?php echo $module; ?>" title="Cập nhật trạng thái bài viết">Deactive Bài viết</a>
                            </li> 
                            <li><a href="#" class="status" data-value="1" data-field="publish" data-module="<?php echo $module; ?>" data-title="Cập nhật trạng thái bài viết">Active Bài viết</a>
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
                                        <option value="20">20 bản ghi</option>
                                        <option value="30">30 bản ghi</option>
                                        <option value="40">40 bản ghi</option>
                                        <option value="50">50 bản ghi</option>
                                        <option value="60">60 bản ghi</option>
                                        <option value="70">70 bản ghi</option>
                                        <option value="80">80 bản ghi</option>
                                        <option value="90">90 bản ghi</option>
                                        <option value="100">100 bản ghi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="toolbox">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    <div class="form-row cat-wrap">
                                        <?php
                                            $propertyCatalogue = convert_array([
                                                'data' => $propertyCatalogue,
                                                'field' => 'id',
                                                'value' => 'title',
                                                'text' => 'Nhóm Thuộc tính',
                                            ]);
                                        ?>
                                        <?php echo form_dropdown('parentid', $propertyCatalogue, set_value('parentid', (isset($_GET['parentid'])) ? $_GET['parentid'] : ''), 'class="form-control m-b select2 mr10" style="width:220px;"');?>
                                    </div>
                                    <div class="uk-search uk-flex uk-flex-middle mr10 ml10">
                                        <div class="input-group">
                                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="Nhập Từ khóa bạn muốn tìm kiếm..." class="form-control"> 
                                            <span class="input-group-btn"> 
                                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">Tìm Kiếm
                                            </button> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="uk-button">
                                        <a href="<?php echo base_url('backend/property/property/create') ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Thêm Thuộc Tính Mới</a>
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
                                <th >Giá trị</th>
                                 <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                                <?php foreach($languageList as $key => $val){ ?>
                                <th class="text-center" style="width: 100px;">
                                    <span class="icon-flag img-cover"><img src="<?php echo getthumb($val['image']); ?>" alt=""></span>
                                </th>
                                <?php }} ?>
                                <th style="width:150px;">Người tạo</th>
                                <th style="width:150px;" class="text-center">Ngày tạo</th>
                                <th class="text-center" style="width:103px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($propertyList) && is_array($propertyList) && count($propertyList)){ ?>
                            <?php foreach($propertyList as $key => $val){ ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                        <div for="" class="label-checkboxitem"></div>
                                    </td>
                                    <td class="text-center">
                                        <div><?php echo $val['title']; ?></div> 
                                    </td>
                                    <td class="text-center">
                                        <div><?php echo $val['value']; ?></div> 
                                    </td>
                                    <?php if(isset($languageList) && is_array($languageList) && count($languageList)){?>

                                    <?php foreach($languageList as $keyLanguage => $valLanguage){ ?>
                                        <td class="text-center "><a class="text-small <?php echo ($val[$valLanguage['canonical'].'_detect'] > 0 ) ? 'text-success' : 'text-danger' ?> " href="<?php echo base_url('backend/translate/translate/translateProperty/'.$val['id'].'/'.$module.'/'.$valLanguage['canonical'].'') ?>">
                                    <?php echo ($val[$valLanguage['canonical'].'_detect'] > 0 ) ? 'Đã Dịch' : 'Chưa Dịch' ?>

                                        </a></td>
                                         
                                    <?php }} ?>
                                    <td>
                                        <div><?php echo $val['creator']; ?></div> 
                                    </td>
                                    <td>
                                        <div><?php echo $val['created_at']; ?></div> 
                                    </td>
                                    
                            
                                    <td class="text-center">
                                        <a type="button" href="<?php echo base_url('backend/property/property/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                        <!-- link controller -->
                                       <a type="button" href="<?php echo base_url('backend/property/property/delete/'.$val['id']) ?>" id = "<?php echo $val['id']; ?>" class="deleteProperty btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>

                            <?php }} ?>

                        
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