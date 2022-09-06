<?php  
    helper('form');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $languageList = get_list_language(['currentLanguage' => $language]);
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản Lý Thông tin</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Home</a>
         </li>
         <li class="active"><strong>Quản lý Thông tin</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý Thông tin </h5>
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
                            <li><a href="#" class="status" data-value="0" data-field="publish" data-module="<?php echo $module; ?>" title="Cập nhật trạng thái Thông tin">Deactive Thông tin</a>
                            </li> 
                            <li><a href="#" class="status" data-value="1" data-field="publish" data-module="<?php echo $module; ?>" data-title="Cập nhật trạng thái Thông tin">Active Thông tin</a>
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
                                <div class="uk-flex uk-flex-middle ">
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
                                    <div class="form-row cat-wrap">
                                        <?php echo form_dropdown('catalogueid', $dropdown, set_value('catalogueid', (isset($_GET['catalogueid'])) ? $_GET['catalogueid'] : ''), 'class="form-control m-b select2 mr10" style="width:220px;"');?>
                                    </div>
                                    <div class="uk-search uk-flex uk-flex-middle mr10 ml10">
                                        <div class="input-group">
                                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="Nhập Từ khóa bạn muốn tìm kiếm..." class="form-control va-search"> 
                                            <span class="input-group-btn"> 
                                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">Tìm Kiếm
                                            </button> 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="toolbox">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    <div class="uk-button mr20">
                                        <a href="<?php echo base_url('backend/product/brand/catalogue/index') ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> QL Nhóm Thông tin</a>
                                    </div>
                                    <div class="uk-button">
                                        <a href="<?php echo base_url('backend/product/brand/brand/create') ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Thêm Thông tin Mới</a>
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
                            <th class="text-center" style="width: 100px;">Logo</th>
                            <th >Tên Thông tin</th>
                             <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                            <?php foreach($languageList as $key => $val){ ?>
                            <th class="text-center" style="width: 100px;">
                                <span class="icon-flag img-cover"><img src="<?php echo getthumb($val['image']); ?>" alt=""></span>
                            </th>
                            <?php }} ?>
                            <th class="text-center" style="width: 67px;">Vị trí</th>
                            <th class="text-center" style="width:88px;">Tình trạng</th>
                            <th class="text-center" style="width:103px;">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php if(isset($brandList) && is_array($brandList) && count($brandList)){ ?>
                            <?php foreach($brandList as $key => $val){ ?>

                            <?php  
                                $image = ( isset($val['image']) && $val['image'] != '' ? getthumb($val['image'], true) : 'public/not-found.png');
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
                                    <div class="image mr5">
                                        <span class="image-post img-cover"><img src="<?php echo $image; ?>" alt="<?php echo $val['brand_title']; ?>" /></span>
                                    </div>
                                </td>
                                <td> 
                                    <div class="uk-flex uk-flex-middle">
                                        <div class="main-info">
                                            <div class="title"><a class="maintitle" href="<?php echo site_url('backend/product/brand/brand/update/'.$val['id']); ?>" title=""><?php echo $val['brand_title']; ?></a></div>
                                            <div class="catalogue" style="font-size:10px">
                                                <span style="color:#f00000;">Nhóm hiển thị: </span>
                                                <a class="" style="color:#333;" href="<?php echo site_url('backend/product/brand/catalogue/update/'.$val['cat_id']); ?>" title=""><?php echo $val['cat_title'] ?><?php echo ((isset($cat_list) ? ',' : '')) ?></a> 
                                                <?php if(isset($cat_list) && is_array($cat_list) && count($cat_list)){ foreach($cat_list as $keyCat => $valCat){ ?>
                                                    <a class="" style="color:#333;" href="<?php echo site_url('backend/product/brand/catalogue/update/'.$valCat['id']); ?>" title=""><?php echo $valCat['title'] ?></a><?php echo ($keyCat + 1 < count($cat_list)) ? ',' : '' ?> 
                                                <?php }} ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                                <?php foreach($languageList as $keyLanguage => $valLanguage){ ?>
                                <td class="text-center "><a class="text-small <?php echo ($val[$valLanguage['canonical'].'_detect'] > 0 ) ? 'text-success' : 'text-danger' ?> " href="<?php echo base_url('backend/translate/translate/translateObject/'.$val['id'].'/'.$module.'/'.$valLanguage['canonical'].'') ?>">
                                    <?php echo ($val[$valLanguage['canonical'].'_detect'] > 0 ) ? 'Đã Dịch' : 'Chưa Dịch' ?>

                                </a></td>
                                <?php }} ?>
                                <td class="text-center text-primary">
                                    <?php echo form_input('order['.$val['id'].']', $val['order'], 'data-module="'.$module.'" data-id="'.$val['id'].'"  class="form-control sort-order" placeholder="Vị trí" style="width:50px;text-align:right;"');?>

                                </td>
                                <td class="text-center td-status" data-field="publish" data-module="<?php echo $module; ?>" data-where="id"><?php echo $status; ?></td>
                                <td class="text-center">
                                    <a type="button" href="<?php echo base_url('backend/product/brand/brand/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a type="button" href="<?php echo base_url('backend/product/brand/brand/delete/'.$val['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php }}else{ ?>
                                <tr>
                                    <td colspan="100%"><span class="text-danger">Không có dữ liệu phù hợp...</span></td>
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