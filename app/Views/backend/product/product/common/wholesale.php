<div class="ibox mb20 block-wholesale">
	<div class="ibox-title uk-flex uk-flex-middle uk-flex-space-between">
		<h5>Giá bán buôn</h5>
		<div class="ibox-tools">
			<button class="btn btn_wholesale btn-success block full-width m-b">Thêm giá mới</button>
		</div>
	</div>
	<div class="ibox-content wholesale_more ">
		<?php 
			if(isset($wholesale_list) && is_array($wholesale_list) && count($wholesale_list)){ 
			$count = 1;
		?>
			<?php foreach ($wholesale_list as $key => $value) { ?>
				<div class="wholesale_desc mb15">
					<div class="uk-flex uk-flex-middle uk-flex-space-between">
						<div class="va-flex-row">
							<div class="form-row">
								<label class="control-label text-left">
									<span>Số lượng từ</span>
								</label>
								<input type="number" name="wholesale[number_start][]" value="<?php echo $value['number_start'] ?>" class="form-control number_start" placeholder=""  autocomplete="off" id="numberstart_<?php echo $count ?>">
							</div>
						</div>
						<div class="va-flex-row">
							<label class="control-label ">
								<span>Đến</span>
							</label>
							<input type="number" name="wholesale[number_end][]" value="<?php echo $value['number_end'] ?>" class="form-control number_end" placeholder=""  autocomplete="off" id="numberend_<?php echo $count ?>">
						</div>
						<div class="va-flex-row">
							<label class="control-label ">
								<span>Giá mới</span>
							</label>
							<input type="text" name="wholesale[wholesale_price][]" value="<?php echo $value['price_wholesale'] ?>" class="form-control wholesale_price int" placeholder=""  autocomplete="off" id="wholesale_<?php echo $count ?>">
						</div>
						<div class="va-flex-row">
							<label class="control-label " style="display: none">
								<span>Xóa</span>
							</label>
							<a type="button" class="btn btn-default wholesale_del" ><i class="fa fa-trash"></i></a>
						</div>
					</div>
				</div>
		<?php $count++; }} ?>
	</div>
</div>