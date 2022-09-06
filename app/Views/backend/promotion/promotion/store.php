<form method="post" action="" class="form-horizontal box" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
			</div><!-- /.box-body -->
		</div>
		<div class="row uk-flex-center uk-flex">
			<div class="col-lg-8">
				<div class="ibox m0">
					<div class="ibox-content">
						<div class="row mb15">
							<div class="col-lg-12 mb15">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Tiêu đề <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('title', set_value('title', (isset($promotion['title'])) ? $promotion['title'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-6 mb15">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Loại khuyến mại </span>
									</label>
									<?php
										$type = [
											// 'price' => 'VNĐ',
											'percent' => '%',
										]
									?>
									<?php echo form_dropdown('type', $type, set_value('type', (isset($promotion['type'])) ? $promotion['type'] : ''), 'class="form-control m-b select2 " ');?>
								</div>
							</div>
							<div class="col-lg-6 mb15">
								<div class="form-row relative">
									<label class="control-label text-left">
										<span>Giảm </span>
									</label>
									<?php echo form_input('discount_value', validate_input(set_value('discount_value', (isset($promotion['discount_value'])) ? $promotion['discount_value'] : '')), 'class="form-control int" placeholder="" autocomplete="off"'); ?>
									<div style="font-size:13px;width: 60px;border: 1px solid #c4cdd5;position: absolute;bottom: 0;right: 0;background: #eee;" class="btn btn-white extend">%</div>
								</div>
							</div>
							<div class="col-lg-6 mb15">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Thời gian</span>
									</label>
									<?php echo form_input('daterange', validate_input(set_value('daterange', (isset($promotion['daterange'])) ? $promotion['daterange'] : '')), ' placeholder="Chọn thời gian" class="form-control " placeholder="" autocomplete="off"'); ?>
								</div>
							</div>
							<div class="col-lg-6 mb15">
								<div class="dd-item">
									<label class="control-label text-left">
										<span>Số lượng tối đa </span>
									</label>
									<?php echo form_input('max', set_value('max', (isset($promotion['max'])) ? $promotion['max'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-12 mb15 ">
								<label class="control-label ">
									<span class="label-title">Mã khuyến mãi <b class="text-danger">(*)</b></span>
								</label>
								<div class="uk-flex uk-flex-middle">
									<script>
										var promotionid = '<?php echo isset($promotion['promotionid']) ? $promotion['promotionid'] : (isset($_POST['promotionid']) ? $_POST['promotionid'] : '') ?>'
									</script>
									<div class="dd-item w100 mr20 data-promotion">
										<?php echo form_input('promotionid', set_value('promotionid', (isset($promotion['promotionid'])) ? $promotion['promotionid'] : ''), 'class="form-control  promotionid" readonly placeholder="" autocomplete="off"');?>
										<input type="text" name="promotionid_original" class="form-control  promotionid_original" value="<?php echo (isset($promotion['promotionid_original'])) ? $promotion['promotionid_original'] : ((isset($promotion['promotionid']) ? $promotion['promotionid'] : '')) ?>" style="display: none;">
										<input type="checkbox" id="toogle_readonly" name="toogle_readonly">
									</div>
									<button class="btn btn-warning btn-sm create-random-promotion" >Random</button>
								</div>
							</div>
							<?php 
							if($method == 'update'){ 
								?>
								<div class="col-lg-12 ">
									<div class="dd-item">
										<label class="control-label text-left">
											<span>Khuyến mãi đã sử dụng</span>
										</label>
										<?php echo form_input('count_bill', set_value('count_bill', (isset($promotion['count_bill'])) ? $promotion['count_bill'] : ''), 'class="form-control " placeholder="" disabled autocomplete="off"');?>
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
			<div class="col-lg-4">
				<div class="ibox mb20">
					<div class="ibox-title">
						<h5 class="choose-image" style="cursor: pointer;">Banner ảnh </h5>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-row">
									<div class="avatar" style="cursor: pointer;"><img src="<?php echo (isset($_POST['image'])) ? $_POST['image'] : ((isset($promotion['image']) && $promotion['image'] != '') ? $promotion['image'] : 'public/not-found.png') ?>" class="img-thumbnail" alt=""></div>
									<?php echo form_input('image', htmlspecialchars_decode(html_entity_decode(set_value('image', (isset($promotion['image'])) ? $promotion['image'] : ''))), 'class="form-control " placeholder="Đường dẫn của ảnh"  id="imageTxt"  autocomplete="off" style="display:none;" ');?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>