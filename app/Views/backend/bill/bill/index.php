<?php
    helper('form');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $languageList = get_list_language(['currentLanguage' => $language]);
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản lý Đơn hàng</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>"><?php echo translate('cms_lang.post.post_home', $language) ?></a>
         </li>
         <li class="active"><strong>Quản lý Đơn hàng</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý Đơn hàng </h5>
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
                    <form action="" class="form-search mb20" method="">
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
                                    <?php 
                                        $status_bill =[
                                            'root' => '[Tình trạng]',
                                            '0' => 'Chờ giao hàng',
                                            '1' => 'Thành công'
                                        ];
                                    ?>
                                    <?php echo form_dropdown('status', $status_bill, set_value('status', (isset($_GET['status'])) ? $_GET['status'] : 'root'), 'class="form-control input-sm  filter mr10"  ');?>
                                    <div class="uk-search uk-flex uk-flex-middle mr10 ml10">
                                        <div class="input-group">
                                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="<?php echo translate('cms_lang.post.post_placeholder', $language) ?>" class="form-control" style="width: 500px;">
                                            <span class="input-group-btn">
                                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm"><?php echo translate('cms_lang.post.post_search', $language) ?>
                                            </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-flex box-bill-advanced" style="display: none">
                            <div class="uk-width-1-4 mb20 mr30">
                                 <div class="form-row ">
                                    <label>Thời gian</label>
                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                        <input class="form-control active" type="text" name="daterange" value="<?php echo (isset($_GET['daterange']) && $_GET['daterange'] != '' ? $_GET['daterange'] : '') ?>" placeholder="Chọn thời gian">
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
                            <th style="width: 100px;">Mã Đơn</th>
                            <th style="width: 250px">Thông tin khách hàng</th>
                            <th style="width: 360px">Thông tin liên lạc</th>
                            <th style="width: 180px">Thông tin thanh toán</th>
                            <th class="text-center" >Trạng thái</th>
                            <th class="text-center" >Tình trạng</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($billList) && is_array($billList) && count($billList)){ ?>
                            <?php foreach($billList as $key => $value){ ?>
                            <?php
                                $status = ($value['status'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
                            ?>

                            <tr id="post-<?php echo $value['id']; ?>" data-id="<?php echo $value['id']; ?>">
                                <td class="text-center" style="color:blue">
                                    <a type="button" href="<?php echo base_url('backend/bill/bill/detail/'.$value['id']) ?>" class="btn btn-success open-window"><?php echo $value['bill_id'] ?></a>
                                </td>
                                <td style="color:blue">
                                    <div class="mb5"> <span>Họ Tên: <?php echo $value['fullname'] ?></span></div>
                                    <div class="mb5"><span>Số Phone: <?php echo $value['phone'] ?></span></div>
                                </td>
                                <td style="color:blue">
                                    <div class="mb5"> <span>Địa chỉ: <?php echo $value['address'] ?></span></div>

                                </td>
                                <?php
                                    $method = '';
                                    if($value['method'] == 'home'){
                                        $method = 'Tại nhà';
                                    }else if($value['method'] == 'store'){
                                        $method = 'Tại cửa hàng';
                                    }else if($value['method'] == 'bank'){
                                        $method = 'Chuyển khoản';
                                    }else if($value['method'] == 'apota'){
                                        $method = 'Apota Pay';
                                    }
                                ?>
                                <td style="color:blue">
                                    <div class="mb5"><span class="text">Số lượng </span>: <span class="text-danger"><?php echo $value['quantity'] ?> sản phẩm</span></div>
                                    <div class="mb5"><span class="text">Tổng tiền </span>: <span class="text-danger"><?php echo ($value['total'] != '' || $value['total'] == 0) ? number_format(check_isset($value['total']),0,',','.').' vnđ' : 'Liên hệ' ?></span></div>
                                </td>
                                <td class="bill-onoffswitch" data-field="status" data-module="<?php echo $module; ?>" data-where="id">
                                    <div class="switch">
                                        <div class="onoffswitch" style="margin: auto">
                                            <input type="checkbox" class="onoffswitch-checkbox status" data-id="<?php echo $value['id'] ?>" id="status-<?php echo $value['id'] ?>" <?php echo ($value['status'] == 1 ? 'checked' : '') ?>>
                                            <label class="onoffswitch-label" for="status-<?php echo $value['id'] ?>">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <?php
                                    $status =  ($value['status'] == 0) ? '<span class="text-small btn btn-danger">Chờ giao hàng</span>' : '<span class="text-small btn btn-primary">Thành công</span>';
                                 ?>
                                <td class="text-center text-status-bill" >
                                    <?php echo $status ?>
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
