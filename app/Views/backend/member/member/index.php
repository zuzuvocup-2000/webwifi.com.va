<?php  
    helper('form');
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản Lý Khách hàng</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Home</a>
         </li>
         <li class="active"><strong>Quản lý Khách hàng</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý Khách hàng </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-member">
                            <li><a href="#" class="delete-all">Xóa tất cả</a>
                            </li>
                            <li><a href="#" class="status" data-value="0" data-field="publish" data-module="member" title="Cập nhật trạng thái người dùng">Deactive Khách hàng</a>
                            </li> 
                            <li><a href="#" class="status" data-value="1" data-field="publish" data-module="member" data-title="Cập nhật trạng thái người dùng">Active Khách hàng</a>
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
                                    <?php 
                                        $memberCatalogue = get_data(['select' => 'id, title','table' => 'member_catalogue','where' => ['deleted_at' => 0],'order_by' => 'title asc']);
                                        $memberCatalogue = convert_array([
                                            'data' => $memberCatalogue,
                                            'field' => 'id',
                                            'value' => 'title',
                                            'text' => 'Nhóm Khách hàng',
                                        ]);
                                    ?>
                                    <?php echo form_dropdown('catalogueid', $memberCatalogue, set_value('catalogueid', (isset($_GET['catalogueid'])) ? $_GET['catalogueid'] : 0), 'class="form-control mr10"');?>
                                    <?php   
                                         $gender = [
                                            -1 => 'Giới Tính',
                                            0 => 'Nữ',
                                            1 => 'Nam',
                                         ];
                                        echo form_dropdown('gender', $gender, set_value('gender', (isset($_GET['gender'])) ? $_GET['gender'] : -1),'class="form-control mr10 input-sm perpage filter" style="width:115px"'); 
                                    ?>
                                    <div class="uk-search uk-flex uk-flex-middle mr10">
                                        <div class="input-group">
                                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="Nhập Từ khóa bạn muốn tìm kiếm..." class="form-control"> 
                                            <span class="input-group-btn"> 
                                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">Tìm Kiếm
                                            </button> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="uk-button">
                                        <a href="<?php echo base_url('backend/member/member/create') ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Thêm Khách hàng mới</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="checkbox-all">
                                <label for="check-all" class="labelCheckAll"></label>
                            </th>
                            <th>Họ Tên</th>
                            <th>Email</th>
                            <th class="text-center">Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th style="width: 80px;" class="text-center">Giới tính</th>
                            <th class="text-center">Tình trạng</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($memberList) && is_array($memberList) && count($memberList)){ ?>
                            <?php foreach($memberList as $key => $val){ ?>
                            <?php  
                                $gender = ($val['gender'] == 1) ? 'Nam' : 'Nữ';
                                $fullname = ($val['fullname'] != '') ? $val['fullname'] : '-';
                                $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
                            ?>
                            <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                    <div for="" class="label-checkboxitem"></div>
                                </td>
                                <td><?php echo $fullname ?></td>
                                <td class="text-navy"><?php echo $val['email'] ?></td>
                                <td class="text-center"><?php echo $val['phone'] ?></td>
                                <td><?php echo $val['address'] ?></td>
                                <td  class="text-center"><?php echo $gender; ?></td>
                                <td class="text-center td-status" data-field="publish" data-module="<?php echo $module; ?>"><?php echo $status; ?></td>
                                <td class="text-center">
                                    <a type="button" href="<?php echo base_url('backend/member/member/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a type="button" href="<?php echo base_url('backend/member/member/delete/'.$val['id']) ?>" class="btn btn-info"><i class="fa fa-trash"></i></a>
                                    <a type="button" href="" class="btn btn-danger btn-reset-pass"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                    <a type="button" href="" data-toggle="modal" data-target="#open_discount" data-module="<?php echo $module; ?>" class="btn btn-warning btn-open-discount"><i class="fa fa-gift" aria-hidden="true"></i></a>
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

<div id="open_discount" class="modal fade va-general">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="uk-flex uk-flex-space-between uk-flex-middle" >
                    <h4 class="modal-title">Danh sách mã khuyến mãi</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover dataTables-example table-discount">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 30px;">STT</th>
                            <th>Tiêu đề</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Loại</th>
                            <th class="text-center">Giảm</th>
                            <th class="text-center">Tình trạng</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>