<?php  
    helper('form');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $languageList = get_list_language(['currentLanguage' => $language]);
    // pre($locationList);
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản lý phí vận chuyển </h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>"><?php echo translate('cms_lang.location.tourfor_home', $language) ?></a>
         </li>
         <li class="active"><strong>Quản lý phí vận chuyển </strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 class="mb0">Cấu hình phí vận chuyển</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <?php 
                    $dropdown = [
                        '' => 'Chọn loại cấu hình',
                        'normal' => 'Tự cấu hình phí vận chuyển',
                        'auto' => 'Tích hợp với bên thứ 3',
                    ]
                 ?>
                <div class="ibox-content">
                    <p class="text-danger">Cấu hình phí vẫn chuyển sẽ giúp bạn kiểm soát giá phí vận chuyển tốt hơn. Xin vui lòng chọn loại cấu hình mà mình đang sử dụng!</p>
                    <?php echo form_dropdown('system', $dropdown, set_value('system', (isset($type['value'])) ? $type['value'] : ''), 'class="form-control m-b select2 select_system_price" ');?>
                </div>
            </div>
        </div>
        <div class="<?php echo (isset($type['value']) && $type['value'] == 'normal') ? '' : 'hidden' ?> col-lg-12 system-general system-normal">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 class="mb0">Cấu hình phí vận chuyển  </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <script>
                    var cityid = '<?php echo (isset($_POST['cityid'])) ? $_POST['cityid'] : ((isset($user['cityid'])) ? $user['cityid'] : ''); ?>';
                    var districtid = '<?php echo (isset($_POST['districtid'])) ? $_POST['districtid'] : ((isset($user['districtid'])) ? $user['districtid'] : ''); ?>'
                    var wardid = '<?php echo (isset($_POST['wardid'])) ? $_POST['wardid'] : ((isset($user['wardid'])) ? $user['wardid'] : ''); ?>'
                </script>
                <div class="ibox-content">
                    <div class="row mb15">
                        <div class="col-lg-4">
                            <div class="form-row">
                                <label class="control-label text-left">
                                    <span>Tỉnh/ Thành phố <b class="text-danger">(*)</b></span>
                                </label>
                                <?php 
                                    $city = get_data(['select' => 'provinceid, name','table' => 'vn_province','order_by' => 'order desc, name asc']);
                                    $city = convert_array([
                                        'data' => $city,
                                        'field' => 'provinceid',
                                        'value' => 'name',
                                        'text' => 'Thành Phố',
                                    ]);
                                ?>
                                <?php echo form_dropdown('cityid', $city, '', 'class="form-control m-b city select-city"  id="city"');?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-row">
                                <label class="control-label text-left">
                                    <span>Quận/Huyện</span>
                                </label>
                                <select name="districtid" id="district" class="form-control m-b location select-district">
                                    <option value="0">[Chọn Quận/Huyện]</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-row">
                                <label class="control-label text-left">
                                    <span>Giá vận chuyển</span>
                                </label>
                                <input type="text" class="form-control input-price int" name="price">
                            </div>
                        </div>
                    </div>       
                    <div class="toolbox action clearfix">
                        <div class="uk-flex uk-flex-middle uk-button pull-right">
                            <button class="btn btn-primary btn-save-normal btn-sm">Lưu lại</button>
                        </div>
                    </div> 
                    <hr>
                    <form action="" method="">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between mb20">
                            <div class="perpage">
                                <div class="uk-flex uk-flex-middle mb10">
                                    <select name="perpage" class="form-control input-sm perpage filter mr10">
                                        <option value="20">20 <?php echo translate('cms_lang.location.tourfor_record', $language) ?></option>
                                        <option value="30">30 <?php echo translate('cms_lang.location.tourfor_record', $language) ?></option>
                                        <option value="40">40 <?php echo translate('cms_lang.location.tourfor_record', $language) ?></option>
                                        <option value="50">50 <?php echo translate('cms_lang.location.tourfor_record', $language) ?></option>
                                        <option value="60">60 <?php echo translate('cms_lang.location.tourfor_record', $language) ?></option>
                                        <option value="70">70 <?php echo translate('cms_lang.location.tourfor_record', $language) ?></option>
                                        <option value="80">80 <?php echo translate('cms_lang.location.tourfor_record', $language) ?></option>
                                        <option value="90">90 <?php echo translate('cms_lang.location.tourfor_record', $language) ?></option>
                                        <option value="100">100 <?php echo translate('cms_lang.location.tourfor_record', $language) ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="toolbox">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    <div class="uk-search uk-flex uk-flex-middle mr10 ml10">
                                        <div class="input-group">
                                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="<?php echo translate('cms_lang.location.tourfor_placeholder', $language) ?>" class="form-control"> 
                                            <span class="input-group-btn"> 
                                                <button type="submit" name="search" value="search" class="btn btn-success mb0 btn-sm"><?php echo translate('cms_lang.location.tourfor_search', $language) ?>
                                            </button> 
                                            </span>
                                        </div>
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
                            <th>Tỉnh/Thành phố</th>
                            <th>Quận/Huyện</th>
                            <th style="width:150px;" class="text-center">Giá</th>
                            <th class="text-center" style="width:103px;">
                                <?php echo translate('cms_lang.location.tourfor_manipulation', $language) ?>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="list-price-ship">

                            <?php if(isset($priceList) && is_array($priceList) && count($priceList)){ ?>
                            <?php foreach($priceList as $key => $val){ ?>

                            <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                    <div for="" class="label-checkboxitem"></div>
                                </td>
                                <td> 
                                    <?php echo $val['city']; ?>
                                </td>
                                 <td> 
                                    <?php echo $val['district']; ?>
                                </td>
                                <td class="text-center update_price td-status" >
                                    <div class="view_price text-success">
                                        <?php echo (!empty($val['price'])) ? number_format(check_isset($val['price']),0,',','.') : '0' ?>
                                    </div>
                                    <input type="text" name="price" value="<?php echo ($val['price'] != '' || $val['price'] == 0) ? $val['price'] : '0' ?>" data-id="<?php echo $val['id'] ?>" data-field="price" class="int index_update_price form-control" style="text-align: right;display:none; padding: 6px 3px;">
                                </td>
                                <td class="text-center">
                                    <a type="button" data-id="<?php echo $val['id']; ?>" class="btn btn-danger delete_price_ship"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php }}else{ ?>
                                <tr>
                                    <td colspan="100%"><span class="text-danger"><?php echo translate('cms_lang.location.empty', $language) ?></span></td>
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
        <div class="<?php echo (isset($type['value']) && $type['value'] == 'auto') ? '' : 'hidden' ?> col-lg-12 system-general system-auto">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 class="mb0">Cấu hình tích hợp với bên thứ 3</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row mb15">
                        <div class="col-lg-6">
                            <div class="form-row">
                                <label class="control-label text-left">
                                    <span>API key <b class="text-danger">(*)</b></span>
                                </label>
                                <?php echo form_input('apikey', set_value('apikey', (isset($price['apikey'])) ? $price['apikey'] : ''), 'class="form-control apikey" placeholder="" autocomplete="off"');?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-row">
                                <label class="control-label text-left">
                                    <span>Secret key <b class="text-danger">(*)</b></span>
                                </label>
                                <?php echo form_input('secretkey', set_value('secretkey', (isset($price['secretkey'])) ? $price['secretkey'] : ''), 'class="form-control secretkey" placeholder="" autocomplete="off"');?>
                            </div>
                        </div>
                    </div>       
                    <div class="toolbox action clearfix">
                        <div class="uk-flex uk-flex-middle uk-button pull-right">
                            <button class="btn btn-primary btn-save-auto btn-sm">Lưu lại</button>
                        </div>
                    </div>             
                </div>
            </div>
        </div>  
    </div>
</div>
<div id="location_translate" class="modal fade va-general">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">
                    <div class="uk-flex uk-flex-space-between uk-flex-middle" >
                        <h4 class="modal-title">Tạo bản dịch cho vị trí</h4>  
                        <button type="button" class="close" data-dismiss="modal">&times;</button>  
                    </div>  
                </div>  
                <div class="modal-body">  
                    <form method="post" id="va_translate" class="uk-clearfix" >  
                        <div class="uk-grid uk-grid-width-large-1-2 uk-clearfix">
                            <div class="va-input-general">
                                <label><?php echo translate('cms_lang.location.location_translate_old', $language) ?></label>  
                                <input type="text" disabled="" name="title_first" id="title_first" value="" placeholder="" class="form-control " />  
                            </div>
                            <div class="va-input-general">
                                <label><?php echo translate('cms_lang.location.location_translate_new', $language) ?></label>  
                                <input type="text" name="title_translate" id="title_translate" value="" placeholder="" class="form-control " />  
                            </div>
                        </div>
                        <br>
                        <input type="submit" name="insert" id="insert" value="<?php echo translate('cms_lang.location.tourfor_save', $language) ?>" class="btn btn-success  float-right" />  
                    </form>  
                </div>   
           </div>  
      </div>  
 </div> 