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
						Một số thông tin cơ bản của Voucher.
					</div>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="ibox m0">
					<div class="ibox-content">
						<div class="row mb15">
							<div class="col-lg-6 mb15">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Tiêu đề <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('title', set_value('title', (isset($voucher['title'])) ? $voucher['title'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-6 mb15">
								<div class="dd-item">
									<label class="control-label text-left">
										<span>Số lượng tối đa <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('max', set_value('max', (isset($voucher['max'])) ? $voucher['max'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
							
							<div class="col-lg-12 mb15 ">
								<label class="control-label ">
									<span class="label-title">Mã Voucher <b class="text-danger">(*)</b></span>
								</label>
								<div class="uk-flex uk-flex-middle">
									<script>
										var voucherid = '<?php echo isset($voucher['voucherid']) ? $voucher['voucherid'] : (isset($_POST['voucherid']) ? $_POST['voucherid'] : '') ?>'
									</script>
									<div class="dd-item w100 mr20 data-voucher">
										<?php echo form_input('voucherid', set_value('voucherid', (isset($voucher['voucherid'])) ? $voucher['voucherid'] : ''), 'class="form-control  voucherid" readonly placeholder="" autocomplete="off"');?>
										<input type="text" name="voucherid_original" class="form-control  voucherid_original" value="<?php echo (isset($voucher['voucherid_original'])) ? $voucher['voucherid_original'] : ((isset($voucher['voucherid']) ? $voucher['voucherid'] : '')) ?>" style="display: none;">
										<input type="checkbox" id="toogle_readonly" name="toogle_readonly">
									</div>
									<button class="btn btn-warning btn-sm create-random-voucher" >Tạo Voucher</button>
								</div>
								
							</div>
							<div class="col-lg-12 mb15">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Số tiền giảm <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('price', validate_input(set_value('price', (isset($voucher['price'])) ? $voucher['price'] : '')), 'class="form-control price int" placeholder="" id="price" autocomplete="off"'); ?>
								</div>
							</div>
							<?php 
							if($method == 'update'){ 
								?>
								<div class="col-lg-12 ">
									<div class="dd-item">
										<label class="control-label text-left">
											<span>Voucher đã sử dụng</span>
										</label>
										<?php echo form_input('count_bill', set_value('count_bill', (isset($voucher['count_bill'])) ? $voucher['count_bill'] : ''), 'class="form-control " placeholder="" disabled autocomplete="off"');?>
									</div>
								</div>
							<?php
							 } 
							 ?>
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