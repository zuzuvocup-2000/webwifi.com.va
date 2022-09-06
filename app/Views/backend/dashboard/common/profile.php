
<div class="row">
    <div class="col-lg-12">
        <div class="row wrapper pl30 border-bottom white-bg page-heading animated fadeInRight">
            <div class="col-lg-10">
                <h2>Cập nhật thành viên</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    
                    <li class="active">
                        <strong>Cập nhật thành viên</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <form method="post" action="" class="form-horizontal box">
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="box-body">
                        <?php echo (!empty($validate['old-password']) &&isset($validate['old-password'])) ? '<div class="alert alert-danger">'.$validate['old-password'].'</div>': '' ?>
                        <?php echo (!empty($validate['fullname']) &&isset($validate['fullname'])) ? '<div class="alert alert-danger">'.$validate['fullname'].'</div>': '' ?>
                        <?php echo (!empty($validate['catalogueid']) &&isset($validate['catalogueid'])) ? '<div class="alert alert-danger">'.$validate['catalogueid'].'</div>': '' ?>
                        <?php echo (!empty($validate['password']) &&isset($validate['password'])) ? '<div class="alert alert-danger">'.$validate['password'].'</div>': '' ?>
                        <?php echo (!empty($validate['re_password']) &&isset($validate['re_password'])) ? '<div class="alert alert-danger">'.$validate['re_password'].'</div>': '' ?>

                    </div><!-- /.box-body -->
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="panel-head">
                            <h2 class="panel-title">Thông tin chung</h2>
                            <div class="panel-description">
                                Một số thông tin cơ bản của người sử dụng.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="ibox m0">
                            <div class="ibox-content">
                                <div class="row">
                                    
                                    <div class="col-lg-6">
                                        <div class="form-row mb15">
                                            <label class="control-label text-left">
                                                <span>Email <b class="text-danger">(*)</b></span>
                                            </label>
                                            <input type="text" name="email" readonly value="<?php echo set_value('email', $user['email']) ?>" class="form-control " placeholder="" autocomplete="off">
                                            <input type="hidden" name="email_original" value="<?php echo set_value('email_original', $user['email']) ?>" class="form-control " placeholder="" autocomplete="off">
                                        </div>
                                        <div class="form-row mb15">
                                            <label class="control-label text-left">
                                                <span>Họ tên <b class="text-danger">(*)</b></span>
                                            </label>
                                            <input value="<?php echo set_value('fullname',$user['fullname']) ?>" type="text" name="fullname" value="" class="form-control " placeholder="" autocomplete="off">
                                        </div>
                                        <div class="form-row mb15">
                                            <label class="control-label text-left">
                                                <span>Ngày sinh <b class="text-danger"></b></span>
                                            </label>
                                            <input value="<?php echo set_value('birthday',$user['birthday']) ?>" type="text" name="birthday" value="" class="form-control datetimepicker hasDatepicker" placeholder="" autocomplete="off" id="dp1596117018054">
                                        </div>
                                        <div class="form-row mb15">
                                            <label class="control-label text-left">
                                                <span>Giới tính </span>
                                            </label>
                                            <?php $gender = [
                                                -1 => 'Chọn giới tính',
                                                0 =>'Nữ',
                                                1 =>'Nam'
                                            ]; ?>
                                            <?php  echo form_dropdown('gender', $gender, set_value('gender',$user['gender']), 'class="form-control input-sm perpage filter" style="width:100%;height:32px"') ; 
                                            ?>
                                        </div>
                                        <div class="form-row mb15">
                                            <label class="control-label text-left">
                                                <span>Nhóm Thành viên <b class="text-danger">(*)</b></span>
                                            </label>
                                            <?php 
                                                $userCatalogue = get_data(['select' => 'id,title', 'table'=> 'user_catalogue', 'where' => ['deleted_at' => 0], 'order_by' => 'title asc']);
                                                $userCatalogue = convert_array([
                                                    'data' => $userCatalogue,
                                                    'field' => 'id',
                                                    'value' => 'title',
                                                    'text' => 'Nhóm thành viên'
                                                ]);
                                             ?>
                                            <?php echo form_dropdown('catalogueid', $userCatalogue, set_value('catalogueid',(isset($user['catalogueid'])) ? $user['catalogueid'] : ''), 'class="form-control m-b city"'); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <label class="control-label text-left " style="width: 100%;">
                                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                    <h5 class="choose-image" style="cursor: pointer;font-size: 14px">Ảnh đại diện <span style="font-size: 12px" class="text-danger">(Click vào đây để đổi avatar)</span></h5>
                                                </div>
                                            </label>
                                            <div class="avatar local_result img-cover"  style="cursor: pointer;">
                                                <img src="<?php echo ($user['image'] != '') ? $user['image'] : 'public/backend/img/not-found.png'; ?>" class="img-thumbnail" alt="">
                                            </div>
                                            <input type="text" name="image" value="<?php echo isset($user['image']) ? $user['image'] : ''; ?>" class="form-control " placeholder="Đường dẫn của ảnh" id="imageTxt" autocomplete="off" style="display:none;">
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                <div class="row mb15">
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="panel-head">
                            <h2 class="panel-title">Địa chỉ</h2>
                            <div class="panel-description">
                                Các thông tin liên hệ chính với người sử dụng này.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="ibox m0">
                            <div class="ibox-content">
                                <div class="row mb15">
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <label class="control-label text-left">
                                                <span>Địa chỉ</span>
                                            </label>
                                            <input value="<?php echo set_value('address',$user['address']) ?>" type="text" name="address" value="" class="form-control " placeholder="" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <label class="control-label text-left">
                                                <span>Số điện thoại</span>
                                            </label>
                                            <input value="<?php echo set_value('phone',$user['phone']) ?>" type="text" name="phone" value="" class="form-control " placeholder="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb15">
                                    <div class="col-lg-6">
                                        <script>
                                            var cityid = '<?php echo (isset($_POST['cityid'])? $_POST['cityid'] : ((isset($user['cityid'])) ? $user['cityid'] : '')); ?>';
                                            var districtid = '<?php echo (isset($_POST['districtid'])? $_POST['districtid'] : ((isset($user['districtid'])) ? $user['districtid'] : '')); ?>';
                                            var wardid = '<?php echo (isset($_POST['wardid'])? $_POST['wardid'] : ((isset($user['wardid'])) ? $user['wardid'] : '')); ?>';
                                        </script>
                                        <div class="form-row">
                                            <label class="control-label text-left">
                                                <span>Tỉnh/Thành Phố</span>
                                            </label>
                                            <?php $city = get_data(['select' => 'provinceid,name', 'table'=> 'vn_province',  'order_by' => 'order desc, name asc']);
                                                $city = convert_array([
                                                    'data' => $city,
                                                    'field' => 'provinceid',
                                                    'value' => 'name',
                                                    'text' => 'thành phố '
                                                ]);
                                             ?>
                                            <?php echo form_dropdown('cityid', $city, set_value('cityid',(isset($user['cityid'])) ? $user['cityid'] : 0), 'class="form-control m-b city" id="city"'); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <label class="control-label text-left">
                                                <span>Quận/Huyện</span>
                                            </label>
                                            <select name="districtid" id="district" class="form-control m-b location">
                                                <option value="0">-- Chọn Quận/Huyện --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb15">
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <label class="control-label text-left">
                                                <span>Phường xã</span>
                                            </label>
                                            <select name="wardid" id="ward" class="form-control m-b location">
                                                <option value="0">-- Chọn Phường/Xã --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <label class="control-label text-left">
                                                <span>Ghi chú</span>
                                            </label>
                                            <input type="text" name="description" value="" class="form-control " placeholder="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="toolbox action clearfix">
                                    <div class="uk-flex uk-flex-middle uk-button pull-right">
                                        <button class="btn btn-primary btn-sm" name="update" value="update" type="submit">Cập nhật </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
        <form method="post" action="" class="form-horizontal box mb15">
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="panel-head">
                            <h2 class="panel-title">Đổi mật khẩu</h2>
                            <div class="panel-description">
                                Điền đầy đủ thông tin để thay đổi mật khẩu của bạn
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="ibox m0">
                            <div class="ibox-content">
                                <div class="row mb15">
                                    <div class="col-lg-6">
                                        <div class="form-row mb10">
                                            <label class="control-label text-left">
                                                <span>Mật khẩu cũ <b class="text-danger">(*)</b><b class="text-danger" style="font-weight:400;"></b></span>
                                            </label>
                                            <input type="password" name="old-password" value="" class="form-control" placeholder="" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-row mb10">
                                            <label class="control-label text-left">
                                                <span>Mật khẩu mới <b class="text-danger" style="font-weight:400;"></b></span>
                                            </label>
                                            <input type="password" name="password" value="" class="form-control" placeholder="" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-row mb10">
                                            <label class="control-label text-left">
                                                <span>Nhập lại mật khẩu mới <b class="text-danger">(*)</b></span>
                                            </label>
                                            <input type="password" name="re_password" value="" class="form-control" placeholder="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="toolbox action clearfix">
                                    <div class="uk-flex uk-flex-middle uk-button pull-right">
                                        <button class="btn btn-primary btn-sm" name="reset" value="password" type="submit">Reset mật khẩu</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php echo view('backend/dashboard/common/footer') ?>

</div>