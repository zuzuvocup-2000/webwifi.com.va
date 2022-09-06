<?php  
    helper('form');
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản Lý Cửa hàng</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Home</a>
         </li>
         <li class="active"><strong>Quản lý Cửa hàng</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý Cửa hàng </h5>
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
                                    <div class="uk-search uk-flex uk-flex-middle mr10 toolbox">
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
                                    <div class="uk-button mr10">
                                        <button type="button" name="general_system" id="general_system" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning m0">Thiết lập cấu hình chung</button>
                                    </div>
                                    <div class="uk-button">
                                        <a href="<?php echo base_url('backend/product/store/create') ?>" class="btn btn-danger btn-sm h32"><i class="fa fa-plus"></i> Thêm Cửa hàng mới</a>
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
                            <th class="text-center" style="width: 100px;">Mã cửa hàng</th>
                            <th >Tên của hàng</th>
                            <th >Địa chỉ</th>
                            <th class="text-center" style="width: 120px;">Điện thoại</th>
                            <th class="text-center" style="width:88px;">Tình trạng</th>
                            <th class="text-center" style="width:103px;">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                            <script>
                                var _module = '<?php echo $module ?>';
                            </script>
                            <?php if(isset($storeList) && is_array($storeList) && count($storeList)){ ?>
                            <?php foreach($storeList as $key => $val){ ?>
                            <?php 
                                $address = $val['address'].((isset($val['ward'])) ? ', ' : '').$val['ward'].((isset($val['district'])) ? ', ' : '').$val['district'].((isset($val['city'])) ? ', ' : '').$val['city'];
                            ?>
                            <?php  
                                $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';

                            ?>
                            
                            <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                    <div for="" class="label-checkboxitem"></div>
                                </td>
                                <td class="text-navy text-center va-uppercase" style="color: blue;width: 130px;"><?php echo $val['storeid']; ?></td>
                                <td class="text-danger" style="color: blue;width: 200px;"><?php echo $val['title']; ?></td>
                                <td class="text-primary" style="color:blue;"><?php echo $address; ?></td>
                                <td class="text-primary text-center"><?php echo $val['phone']; ?></td>

                                <td class="text-center td-status" data-field="publish" data-module="<?php echo $module; ?>" data-where="id"><?php echo $status; ?></td>
                                <td class="text-center">
                                    <a type="button" href="<?php echo base_url('backend/product/store/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a type="button" href="<?php echo base_url('backend/product/store/delete/'.$val['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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