<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Xóa thành viên: <?php echo $user['fullname'] ?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin'); ?>">Home</a>
			</li>
			<li class="active"><strong>Xóa thành viên</strong></li>
		</ol>
	</div>
</div>
<form method="post" action="" class="form-horizontal box" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-lg-5">
				<div class="panel-head">
					<h2 class="panel-title">Thông tin chung</h2>
					<div class="panel-description">
						Một số thông tin cơ bản của người sử dụng.
						<div><span class="text-danger">Khi xóa thành viên, thì thành viên này sẽ không thể truy cập và mất toàn bộ thông tin. Hãy chắc chắn bạn muốn thực hiện chức năng này!</span></div>
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
										<span>Email <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('email', set_value('email', $user['email']), 'class="form-control" disabled placeholder="" autocomplete="off"');?>
									<?php echo form_hidden('id', set_value('id', $user['id']), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Họ tên <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('fullname', set_value('fullname', $user['fullname']), 'class="form-control " placeholder="" autocomplete="off" disabled');?>
								</div>
							</div>
						</div>
						<div class="row mb15">	
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Nhóm Thành viên <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_dropdown('catalogueid', [], set_value('catalogueid'), 'class="form-control m-b city" disabled');?>
								</div>
							</div>
							
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Giới tính</span>
									</label>
									 <?php   
                                         $gender = [
                                            -1 => 'Giới Tính',
                                            0 => 'Nữ',
                                            1 => 'Nam',
                                         ];
                                        echo form_dropdown('gender', $gender, set_value('gender', $user['gender']),'class="form-control mr20 input-sm perpage filter" style="width:100%" disabled'); 
                                    ?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Ngày sinh <b class="text-danger"></b></span>
									</label>
									<?php echo form_input('birthday', set_value('birthday', $user['birthday']), 'class="form-control datetimepicker" placeholder="" autocomplete="off" disabled');?>
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
									<?php echo form_input('address', set_value('address', $user['address']), 'class="form-control " placeholder="" autocomplete="off" disabled');?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Số điện thoại</span>
									</label>
									<?php echo form_input('phone', set_value('phone', $user['phone']), 'class="form-control " placeholder="" autocomplete="off" disabled');?>
								</div>
							</div>
						</div>
						
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Tỉnh/Thành Phố</span>
									</label>
									
									<?php echo form_dropdown('cityid', [], '', 'class="form-control m-b city"  id="city" disabled');?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Quận/Huyện</span>
									</label>
									<select name="districtid" id="district" class="form-control m-b location" disabled>
										<option value="0">Chọn Quận/Huyện</option>
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
									<select name="wardid" disabled id="ward" class="form-control m-b location">
										<option value="0">Chọn Phường/Xã</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Ghi chú</span>
									</label>
									<?php echo form_input('description', set_value('description'), 'class="form-control " placeholder="" autocomplete="off" disabled');?>
								</div>
							</div>
						</div>
						<div class="toolbox action clearfix">
							<div class="uk-flex uk-flex-middle uk-button pull-right">
								<button class="btn btn-danger btn-sm" name="delete" value="delete" type="submit">Xóa Thành viên</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</form>