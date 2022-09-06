<?php
    helper('form');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $languageList = get_list_language(['currentLanguage' => $language]);
?>
<script>
    var attribute_cat = '';
</script>
<script>
    var _module = '<?php echo $module ?>';
</script>

<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản Lý Sản Phẩm</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Home</a>
         </li>
         <li class="active"><strong>Quản lý Sản Phẩm</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title uk-flex uk-flex-middle uk-flex-space-between">
                    <div class="uk-flex uk-flex-middle">
                        <h5 class="mb0 ">Quản lý Sản Phẩm </h5>
                        <div class="uk-button ml20">
                            <a href="<?php echo base_url('backend/product/catalogue/index') ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> QL Nhóm Sản phẩm</a>
                        </div>
                    </div>
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
                            <li><a href="#" class="clone-all" data-toggle="modal" data-target="#clone_modal" data-module="<?php echo $module; ?>">Sao chép</a>
                            <li><a href="#" class="status" data-value="0" data-field="publish" data-module="<?php echo $module; ?>" title="Cập nhật trạng thái Sản Phẩm">Deactive Sản Phẩm</a>
                            </li>
                            <li><a href="#" class="status" data-value="1" data-field="publish" data-module="<?php echo $module; ?>" data-title="Cập nhật trạng thái Sản Phẩm">Active Sản Phẩm</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="" class="form-search mb20" method="">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between mb20">
                            <div class="perpage">
                                <div class="uk-flex uk-flex-middle ">
                                    <select name="perpage" class="form-control input-sm perpage filter mr10" style="width:120px">
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
                                        <?php echo form_dropdown('catalogueid', $dropdown, set_value('catalogueid', (isset($_GET['catalogueid'])) ? $_GET['catalogueid'] : ''), 'class="form-control m-b select2 mr10" style="width:150px;"');?>
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
                                </div>

                            </div>
                            <div class="toolbox">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    <div class="uk-button mr10">
                                        <button type="button" name="general_system" id="general_system" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning m0">Thiết lập cấu hình chung</button>
                                    </div>
                                    <div class="uk-button">
                                        <a href="<?php echo base_url('backend/product/product/create') ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Thêm Sản Phẩm Mới</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-flex box-advanced" style="display: none">
                            <div class="uk-width-1-4 mb20 mr30">
                                 <div class="form-row ">
                                    <label>Khoảng giá</label>
                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                        <?php echo form_input('priceFrom', set_value('priceFrom',(isset($_GET['priceFrom']))? $_GET['priceFrom'] : ''), 'class="form-control input uk-width-1-2 int mr10"  placeholder="Giá từ..." autocomplete="off"');?>
                                        <span>-</span>
                                        <?php echo form_input('priceTo', set_value('date_end',(isset($_GET['priceTo']))? $_GET['priceTo'] : ''), 'class="form-control input uk-width-1-2 int ml10"  placeholder="Đến" autocomplete="off"');?>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-4 mb20">
                                 <div class="form-row ">
                                    <label>Thuộc tính</label>
                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                        <?php
                                            $attr = convert_array([
                                                'data' => $attribute_list,
                                                'field' => 'id',
                                                'value' => 'title',
                                                'text' => 'thuộc tính',
                                            ]);
                                        ?>
                                        <?php echo form_dropdown('attr', $attr, set_value('attr', (isset($_GET['attr'])) ? $_GET['attr'] : 'root'), 'class="form-control input-sm  select2 mr10"  ');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-flex uk-flex-middle">
                            <a href="" title ="Advanced" class="form-advanced lta-btn">Tìm kiếm nâng cao</a>
                        </div>
                    </form>

                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th style="width: 35px;">
                                <input type="checkbox" id="checkbox-all">
                                <label for="check-all" class="labelCheckAll"></label>
                            </th>
                            <th >ID</th>
                            <th >Tiêu đề sản phẩm</th>
                            <th class="text-center" >Demo</th>
                            <th  class="text-center" style="width: 100px;">Giá gốc</th>
                            <th  class="text-center" style="width: 130px;">Giá khuyến mại</th>
                            <th class="text-center" style="width: 67px;">Vị trí</th>
                            <th class="text-center" style="width: 67px;">Hot</th>
                             <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                            <?php foreach($languageList as $key => $val){ ?>
                            <th class="text-center" style="width: 100px;">
                                <span class="icon-flag img-cover"><img src="<?php echo getthumb($val['image']); ?>" alt=""></span>
                            </th>
                            <?php }} ?>
                            <th class="text-center" style="width:88px;">Tình trạng</th>
                            <th class="text-center" style="width:140px;">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php if(isset($productList) && is_array($productList) && count($productList)){ ?>
                            <?php foreach($productList as $key => $val){ ?>

                            <?php
                                $image = get_first_img($val['album']);
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
                                <td><?php echo $val['id'] ?></td>
                                <td>
                                    <div class="uk-flex uk-flex-middle">
                                        <div class="image mr5">
                                            <span class="image-post img-cover"><img src="<?php echo ((isset($image) ? $image : 'public/not-found.png')); ?>" alt="<?php echo $val['product_title']; ?>" /></span>
                                        </div>
                                        <div class="main-info">
                                            <div class="title">
                                                <a class="maintitle" href="<?php echo site_url('backend/product/product/update/'.$val['id']); ?>" title=""><?php echo $val['product_title']; ?></a>
                                            </div>
                                            <div class="catalogue" style="font-size:10px">
                                                <span style="color:#f00000;">Nhóm hiển thị: </span>
                                                <a class="" style="color:#333;" href="<?php echo site_url('backend/product/product/index?catalogueid='.$val['cat_id']); ?>" title=""><?php echo $val['cat_title'] ?></a>
                                                <?php if(isset($cat_list) && is_array($cat_list) && count($cat_list)){ foreach($cat_list as $keyCat => $valCat){ ?>
                                                    , <a class="" style="color:#333;" href="<?php echo site_url('backend/product/product/index?catalogueid='.$valCat['id']); ?>" title=""><?php echo $valCat['title'] ?></a><?php echo ($keyCat + 1 < count($cat_list)) ? ',' : '' ?>
                                                <?php }} ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="<?php echo site_url('backend/product/product/preview/'.$val['id']); ?>" class=" open-window" >(<i class="fa fa-eye"></i>)</a>
                                </td>
                                <td class="text-center update_price td-status" >
                                    <div class="view_price text-success">
                                        <?php echo (!empty($val['price'])) ? number_format(check_isset($val['price']),0,',','.') : 'Liên hệ' ?>
                                    </div>
                                    <input type="text" name="price" value="<?php echo ($val['price'] != '' || $val['price'] == 0) ? $val['price'] : '0' ?>" data-id="<?php echo $val['objectid'] ?>" data-field="price" class="int index_update_price form-control" style="text-align: right;display:none; padding: 6px 3px;">
                                </td>
                                <td class="text-center update_price text-primary">
                                    <div class="view_price text-success">
                                        <?php echo (($val['price_promotion'] != '' || $val['price_promotion'] != 0) ? number_format(check_isset($val['price_promotion']),0,',','.') : '0') ?>
                                    </div>
                                    <input type="text" name="price_promotion" value="<?php echo (($val['price_promotion'] != '' || $val['price_promotion'] != 0) ? $val['price_promotion'] : '0') ?>" data-id="<?php echo $val['objectid'] ?>" data-field="price_promotion" class="int index_update_price form-control" style="text-align: right;display:none; padding: 6px 3px;">
                                </td>
                                <td class="text-center text-primary">
                                    <?php echo form_input('order['.$val['id'].']', $val['order'], 'data-module="'.$module.'" data-id="'.$val['id'].'"  class="form-control sort-order" placeholder="Vị trí" style="width:50px;text-align:right;"');?>

                                </td>
                                <td class="text-center publishonoffswitch" data-field="hot" data-module="<?php echo $module; ?>" data-where="id">
                                    <div class="switch">
                                        <div class="onoffswitch">
                                            <input type="checkbox" class="onoffswitch-checkbox hot" data-id="<?php echo $val['id'] ?>" id="hot-<?php echo $val['id'] ?>" <?php echo ($val['hot'] == 1 ? 'checked' : '') ?>>
                                            <label class="onoffswitch-label" for="hot-<?php echo $val['id'] ?>">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                                <?php foreach($languageList as $keyLanguage => $valLanguage){ ?>
                                <td class="text-center "><a class="text-small <?php echo ($val[$valLanguage['canonical'].'_detect'] > 0 ) ? 'text-success' : 'text-danger' ?> " href="<?php echo base_url('backend/translate/product/product/index/'.$val['id'].'/'.$valLanguage['canonical'].'') ?>">
                                    <?php echo ($val[$valLanguage['canonical'].'_detect'] > 0 ) ? 'Đã Dịch' : 'Chưa Dịch' ?>
                                </a></td>
                                <?php }} ?>
                                
                                <td class="text-center td-status" data-field="publish" data-module="<?php echo $module; ?>" data-where="id"><?php echo $status; ?></td>
                                <td class="text-center">
                                    <a type="button" data-toggle="modal" data-target="#add_combo" href="" class="btn btn-success add-combo-modal" data-id="<?php echo $val['id'] ?>" data-title="<?php echo $val['product_title'] ?>" data-module="<?php echo $module ?>"><i class="fa fa-ticket" aria-hidden="true"></i></a>
                                    <a type="button" href="<?php echo base_url('backend/product/product/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a type="button" href="<?php echo base_url('backend/product/product/delete/'.$val['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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

<?php if(isset($code) && is_array($code) && count($code)){ ?>
<div id="add_data_Modal" class="modal fade va-general">
      <div class="modal-dialog">
           <div class="modal-content">
                <div class="modal-header">
                    <div class="uk-flex uk-flex-space-between uk-flex-middle" >
                        <h4 class="modal-title">Tạo cấu hình chung cho mã Cửa hàng</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="post" id="insert_general" class="uk-clearfix" data-max-0="<?php echo ((isset($code['num0']) ? $code['num0'] : '')) ?>">
                        <div class="uk-grid uk-grid-width-large-1-2 uk-clearfix">
                            <div class="va-input-general">
                                <label>Tiền tố</label>
                                <input type="text" name="suffix" id="suffix" value="<?php echo ((isset($code['suffix']) ? $code['suffix'] : '')) ?>" placeholder="VD: VA-..." class="form-control va-uppercase" />
                            </div>
                            <div class="va-input-general">
                                <label>Hậu tố</label>
                                <input type="text" name="prefix" id="prefix" value="<?php echo ((isset($code['prefix']) ? $code['prefix'] : '')) ?>" placeholder="VD: ...-STORE" class="form-control va-uppercase" />
                            </div>
                        </div>
                        <br>
                        <div class="va-input-general">
                            <label class="mb10">Kết quả</label>
                            <div class="uk-flex uk-flex-middle">
                                <span class="render_suffix text-danger va-uppercase"><?php echo ((isset($code['suffix']) ? $code['suffix'] : '')) ?></span>
                                <span>-</span>
                                <span class="render_num0 text-danger"></span>
                                <span>-</span>
                                <span class="render_prefix text-danger va-uppercase"><?php echo ((isset($code['prefix']) ? $code['prefix'] : '')) ?></span>
                            </div>
                        </div>
                        <br>
                        <input type="submit" name="insert" id="insert" value="Lưu thay đổi" class="btn btn-success  float-right" />
                    </form>
                </div>
           </div>
      </div>
 </div>
<?php }else{ ?>
<div id="add_data_Modal" class="modal fade va-general">
      <div class="modal-dialog">
           <div class="modal-content">
                <div class="modal-header">
                    <div class="uk-flex uk-flex-space-between uk-flex-middle" >
                        <h4 class="modal-title">Tạo cấu hình chung cho mã Cửa hàng</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="post" id="insert_general" class="uk-clearfix" data-max-0="3">
                        <div class="uk-grid uk-grid-width-large-1-2 uk-clearfix">
                            <div class="va-input-general">
                                <label>Tiền tố</label>
                                <input type="text" name="suffix" id="suffix" placeholder="VD: VA-..." class="form-control" />
                            </div>
                            <div class="va-input-general">
                                <label>Hậu tố</label>
                                <input type="text" name="prefix" id="prefix" placeholder="VD: ...-STORE" class="form-control" />
                            </div>
                        </div>
                        <br>
                        <div class="va-input-general">
                            <label class="mb10">Kết quả</label>
                            <div class="uk-flex uk-flex-middle">
                                <span class="render_suffix text-danger va-uppercase">VA</span>
                                <span class=" text-danger va-uppercase">-</span>
                                <span class="render_num0 text-danger va-uppercase"></span>
                                <span class=" text-danger va-uppercase">-</span>
                                <span class="render_prefix text-danger va-uppercase">STR</span>
                            </div>
                        </div>
                        <br>
                        <input type="submit" name="insert" id="insert" value="Lưu thay đổi" class="btn btn-success  float-right" />
                    </form>
                </div>
           </div>
      </div>
 </div>
<?php } ?>
<div id="clone_modal" class="modal fade va-general">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">
                    <div class="uk-flex uk-flex-space-between uk-flex-middle" >
                        <h4 class="modal-title">Nhập số lượng cần Sao chép</h4>  
                        <button type="button" class="close" data-dismiss="modal">&times;</button>  
                    </div>  
                </div>  
                <div class="modal-body">  
                    <form method="post" id="clone_general" class="uk-clearfix" data-max-0="3">  
                        <div class="va-input-general mb15">
                            <label>Số lượng</label>  
                            <input type="text" name="quantity" id="quantity" class="form-control" />  
                        </div>
                        <input type="submit"  value="Sao chép" data-module="<?php echo $module ?>" class="btn btn-success clone-btn float-right" />  
                    </form>  
                </div>   
           </div>  
      </div>  
 </div> 

 <div id="add_combo" class="modal fade va-general">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">
                    <div class="uk-flex uk-flex-space-between uk-flex-middle" >
                        <h4 class="modal-title">Tạo combo cho Sản phẩm (Tổng số: <span class="count-combo">5</span> Combo) </h4>  
                        <button type="button" class="close" data-dismiss="modal">&times;</button>  
                    </div>  
                </div>  
                <div class="modal-body">  
                    <div class="add-new-combo-box">
                        <form method="post" class="uk-clearfix form-add-combo" data-module="<?php echo $module ?>" >  
                            <div class="va-input-general mb15">
                                <div class="uk-grid uk-grid-medium uk-grid-width-1-2 uk-clearfix">
                                    <div class="form-row mb10">
                                        <label class="control-label text-left">
                                            <span>Sản phẩm</span>
                                        </label>
                                        <div class="form-row">
                                            <?php echo form_dropdown('objectid', '', NULL, 'class="form-control select_combo_multiple select_current_product" multiple="multiple" data-title="Nhập 2 kí tự để tìm kiếm..."  style="width: 100%;" data-join="'.$module.'_translate" data-module="'.$module.'" data-select="title"'); ?>
                                        </div>
                                    </div>
                                    <div class="form-row mb10">
                                        <label class="control-label text-left">
                                            <span>Thời gian</span>
                                        </label>
                                        <div class="form-row">
                                            <input type="text" name="time_end" autocomplete="off" value="" class="form-control datetimepicker">
                                        </div>
                                    </div>
                                    <div class="form-row mb10">
                                        <label class="control-label text-left">
                                            <span>Loại combo</span>
                                        </label>
                                        <div class="form-row">
                                            <select name="type" class="select2 form-control select-combo-type">
                                                <option value="normal" selected="selected">Combo giảm theo giá tiền</option>
                                                <option value="percent">Combo giảm theo phần trăm</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb10">
                                        <label class="control-label text-left">
                                            <span>Giá trị </span><span class="text-danger">(VD: 1, 2, 1.1, 1.2,...)</span>
                                        </label>
                                        <div class="form-row">
                                            <input type="text" name="value" class=" form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="submit"  value="Tạo combo" class="btn btn-success float-right" />  
                        </form> 
                    </div>
                    <h2>Danh sách Combo</h2>
                    <hr>
                    <div class="wrap-combo-list">
                        
                    </div>
                </div>   
           </div>  
      </div>  
 </div> 
 