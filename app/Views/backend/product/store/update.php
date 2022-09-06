<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Cập nhật Cửa hàng</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin'); ?>">Home</a>
			</li>
		</ol>
	</div>
</div>
<?php echo view('backend/product/store/store',  ['method' => $method]) ?>
