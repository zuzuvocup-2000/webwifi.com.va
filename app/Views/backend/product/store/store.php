<form method="post" action="" class="form-horizontal box" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
			</div><!-- /.box-body -->
		</div>
		<div class="row">
			<div class="col-lg-5">
				<div class="panel-head">
					<h2 class="panel-title">Thông tin chung</h2>
					<div class="panel-description">
						Một số thông tin cơ bản của Cửa hàng.
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
										<span>Mã cửa hàng<b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('storeid', set_value('storeid', (isset($store['storeid'])) ? $store['storeid'] : $storeid), 'class="form-control va-uppercase" readonly placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Tên cửa hàng <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('title', set_value('title', (isset($store['title'])) ? $store['title'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Email <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('email', set_value('email', (isset($store['email'])) ? $store['email'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
									<?php echo form_hidden('email_original', set_value('email_original', (isset($store['email'])) ? $store['email'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-6 ">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Hình ảnh</span>
									</label>
									<?php echo form_input('image', set_value('image', (isset($store['image'])) ? $store['image'] : ''), 'class="form-control" placeholder="" autocomplete="off" onclick="BrowseServer(this)"');?>
									<img src="" class="abc" alt="">
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
						Các thông tin liên hệ chính với Cửa hàng này.
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
									<?php echo form_input('address', set_value('address', (isset($store['address'])) ? $store['address'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Số điện thoại</span>
									</label>
									<?php echo form_input('phone', set_value('phone', (isset($store['phone'])) ? $store['phone'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						
						<div class="row mb15">
							<div class="col-lg-6">

								<script>
									var cityid = '<?php echo (isset($_POST['cityid'])) ? $_POST['cityid'] : ((isset($store['cityid'])) ? $store['cityid'] : ''); ?>';
									var districtid = '<?php echo (isset($_POST['districtid'])) ? $_POST['districtid'] : ((isset($store['districtid'])) ? $store['districtid'] : ''); ?>'
									var wardid = '<?php echo (isset($_POST['wardid'])) ? $_POST['wardid'] : ((isset($store['wardid'])) ? $store['wardid'] : ''); ?>'
								</script>
								<div class="form-row">
									<label class="control-label text-left">
										<span>Tỉnh/Thành Phố</span>
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
									<?php echo form_dropdown('cityid', $city, set_value('cityid', (isset($store['cityid'])) ? $store['cityid'] : 0), 'class="form-control m-b city"  id="city"');?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Quận/Huyện</span>
									</label>
									<select name="districtid" id="district" class="form-control m-b location">
										<option value="0">[Chọn Quận/Huyện]</option>
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
										<option value="0">Chọn Phường/Xã</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Ghi chú</span>
									</label>
									<?php echo form_input('description', set_value('description', (isset($store['description'])) ? $store['description'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="toolbox action clearfix">
							<div class="uk-flex uk-flex-middle uk-button pull-right">
								<button class="btn btn-primary btn-sm" name="create" value="create" type="submit">Lưu lại</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</form>