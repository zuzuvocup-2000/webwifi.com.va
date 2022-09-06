<div class="ibox mb20 block-general-product">
	<div class="ibox-title uk-flex uk-flex-middle uk-flex-space-between">
		<h5>Thông tin Chung</h5>
		<div class="ibox-tools">
			<button type="submit" name="create" value="create" class="btn btn-primary block full-width m-b">Lưu</button>
		</div>
	</div>
	<div class="ibox-content">
		<div class="row">
			<div class="col-lg-6">
				<div class="form-row">
					<label class="control-label text-left">
						<span>Giá Sản phẩm <b class="text-danger">(*)</b></span>
					</label>
					<?php echo form_input('price', validate_input(set_value('price', (isset($product['price'])) ? $product['price'] : '')), 'class="form-control price int" placeholder="" id="price" autocomplete="off"'); ?>
				</div>
			</div>
			<div class="col-lg-6 m-b">
				<label class="control-label ">
					<span>Giá khuyến mại</span>
				</label>
				<?php echo form_input('promotion_price', set_value('promotion_price', (isset($product['price_promotion'])) ? $product['price_promotion'] : ''), 'class="form-control price int" placeholder="" id="promotion_price" autocomplete="off"'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 mb15">
				<label class="control-label ">
					<span>BarCode</span>
				</label>
				<?php echo form_input('bar_code', set_value('bar_code', (isset($product['bar_code'])) ? $product['bar_code'] : ''), 'class="form-control" placeholder="VD:UPC,ISBN" id="bar_code" autocomplete="off"'); ?>
			</div>
			<div class="col-lg-4 mb15">
				<label class="control-label ">
					<span>Model</span>
				</label>
				<?php echo form_input('model', set_value('model', (isset($product['model'])) ? $product['model'] : ''), 'class="form-control" placeholder="UA50NU7400KXXV" id="model" autocomplete="off"'); ?>
			</div>
			<div class="col-lg-4 mb15">
				<label class="control-label ">
					<span>Xuất xứ</span>
				</label>
				<?php echo form_input('made_in', set_value('made_in', (isset($product['made_in'])) ? $product['made_in'] : ''), 'class="form-control" placeholder="Việt Nam" id="made_in" autocomplete="off"'); ?>
			</div>
			<div class="col-lg-6 mb15 ">
				<label class="control-label ">
					<span class="label-title">Mã sản phẩm <b class="text-danger">(*)</b></span>
				</label>
				<script>
					var productid = '<?php echo isset($product['productid']) ? $product['productid'] : $productid ?>'
				</script>
				<div class="dd-item">
					<?php echo form_input('productid', set_value('productid', (isset($product['productid'])) ? $product['productid'] : $productid), 'class="form-control va-uppercase productid" readonly placeholder="" autocomplete="off"');?>
					<input type="text" name="productid_original" class="form-control va-uppercase productid_original" value="<?php echo (isset($product['productid_original'])) ? $product['productid_original'] : ((isset($product['productid']) ? $product['productid'] : '')) ?>" style="display: none;">
					
					<input type="checkbox" id="toogle_readonly" name="toogle_readonly">
				</div>
			</div>
			<div class="col-lg-6 mb15">
				<div class="uk-flex-space-between uk-flex-middle uk-flex">
					<label class="control-label ">
						<span>Thương hiệu</span>
					</label>
					<button type="button" name="add_brand" id="add_brand" data-toggle="modal" data-target="#product_add_brand" class="btn">Tạo thương hiệu mới</button>
					
				</div>
				<?php echo form_dropdown('brandid', $export_brand, set_value('brandid', (isset($product['brandid'])) ? $product['brandid'] : ''), 'class="form-control m-b brand_select select2"');?>
			</div>
		</div>
	</div>
</div>