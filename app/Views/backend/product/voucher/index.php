<?php  
    helper('form');
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản Lý Voucher</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Home</a>
         </li>
         <li class="active"><strong>Quản lý Voucher</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý Voucher </h5>
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
                                    <div class="uk-search uk-flex uk-flex-middle mr10">
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
                                    <div class="uk-button">
                                        <a href="<?php echo base_url('backend/product/voucher/create') ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Thêm Voucher mới</a>
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
                            <th class="text-center" style="width: 200px;">Mã Voucher</th>
                            <th >Tiêu đề</th>
                            <th class="text-center" style="width: 100px;">Giá giảm</th>
                            <th class="text-center" style="width: 100px;">Số lượng</th>
                            <th class="text-center" style="width: 120px;">Đã sử dụng</th>
                            <th class="text-center" style="width:88px;">Tình trạng</th>
                            <th class="text-center" style="width:103px;">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                            <script>
                                var _module = '<?php echo $module ?>';
                            </script>
                            <?php if(isset($voucherList) && is_array($voucherList) && count($voucherList)){ ?>
                            <?php foreach($voucherList as $key => $val){ ?>
                            <?php  
                                $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';

                            ?>
                            
                            <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                    <div for="" class="label-checkboxitem"></div>
                                </td>
                                <td class="text-danger text-center" ><?php echo $val['voucherid']; ?></td>
                                <td  class="text-success" ><?php echo $val['title']; ?></td>
                                <td class="text-center update_price td-status" >
                                    <div class="view_price text-success">
                                        <?php echo ($val['price'] != '' || $val['price'] == 0) ? number_format(check_isset($val['price']),0,',','.') : 0 ?>
                                    </div>
                                    <input type="text" autocomplete="off" name="price" value="<?php echo ($val['price'] != '' || $val['price'] == 0) ? $val['price'] : '0' ?>" data-id="<?php echo $val['id'] ?>" data-field="price" class="int index_update_price form-control" style="text-align: right;display:none; padding: 6px 3px;">
                                </td>
                                <td class="text-center update_price td-status" >
                                    <div class="view_price text-success">
                                        <?php echo ($val['max'] != '' || $val['max'] == 0) ? check_isset($val['max']) : 0 ?>
                                    </div>
                                    <input type="text" autocomplete="off" name="price" value="<?php echo ($val['max'] != '' || $val['max'] == 0) ? $val['max'] : '0' ?>" data-id="<?php echo $val['id'] ?>" data-field="max" class=" index_update_price form-control" style="text-align: right;display:none; padding: 6px 3px;">
                                </td>
                                <td class="text-primary text-center"><?php echo $val['count_bill'] ?></td>
                                <td class="text-center td-status" data-field="publish" data-module="<?php echo $module; ?>" data-where="id"><?php echo $status; ?></td>
                                <td class="text-center">
                                    <a type="button" href="<?php echo base_url('backend/product/voucher/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a type="button" href="<?php echo base_url('backend/product/voucher/delete/'.$val['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
 