<?php
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Thông tin chi tiết đơn hàng</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin'); ?>"><?php echo translate('cms_lang.post.post_home', $language) ?></a>
			</li>
			<li class="active"><strong>Thông tin chi tiết đơn hàng</strong></li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="va-block">
		<div class="uk-grid uk-grid-small uk-clearfix">
	        <div class="uk-width-1-3">
	        	<div class="customer-panel">
		        	<h3 class="text-uppercase">Thông tin chi tiết Khách hàng</h3>
		        	<div class="customer-detail">
		        		<div class="mb5"><span class="text">Họ Tên </span>: <span><?php echo $bill['fullname'] ?></span></div>
	                    <div class="mb5"><span class="text">Số điện thoại</span> : <span><?php echo $bill['phone'] ?></span></div>
	                    <div class="mb5"><span class="text">Email</span> : <span><?php echo $bill['email'] ?></span></div>
	                    <div class="mb5"><span class="text">Địa chỉ</span> : <span><?php echo $bill['address'].(isset($bill['district']) ? ' - '.$bill['district'] : '').(isset($bill['city']) ? ' - '.$bill['city'] : '') ?></span></div>
	                    <div class="mb5"><span class="text">Lời nhắc</span> : <span><?php echo $bill['messages'] ?></span></div>
		        	</div>
		        	<a href="" class="bill-note">Tạo ghi chú</a>
		        	<form action="" class="uk-hidden submit-note-bill">
		        		<label>Ghi chú</label>
		        		<div class="textarea-bill">
			        		<textarea class="">
			        			
			        		</textarea>
		        		</div>
		        	</form>
	        	</div>
	        </div>
	        <?php 
                $method = '';
                if($bill['method'] == 'home'){
                    $method = 'Tại nhà';
                }else if($bill['method'] == 'store'){
                    $method = 'Tại cửa hàng';
                }else if($bill['method'] == 'bank'){
                    $method = 'Chuyển khoản';
                }else if($bill['method'] == 'apota'){
                    $method = 'Apota Pay';
                }
            ?>
	        <div class="uk-width-2-3">
	        	<div class="bill-panel ">
	        		<h3 class="text-uppercase">Thông tin chi tiết Đơn hàng</h3>
	        		<div class="bill-detail-general mb20">
	        			<div class="mb5"><span class="text">Số lượng </span>: <span><?php echo $bill['quantity'] ?></span></div>
	        			<div class="mb5"><span class="text">Tổng tiền </span>: <span><?php echo ($bill['total'] != '' || $bill['total'] == 0) ? number_format(check_isset($bill['total']),0,',','.') : 'Liên hệ' ?></span></div>
                        <div class="mb5"><span class="text">Kiểu thanh toán </span>: <span class="int"><?php echo $method ?></span></div>
                        <div class="mb5"><span class="text">Thời gian tạo đơn: </span>: <span class="int"><?php echo date('F j, Y, g:i a',strtotime($bill['created_at'])) ?></span></div>
	        		</div>
	        		<h3 class="text-uppercase mb20">Chi tiết Sản phẩm <span class="text-danger text-normal">*Lưu ý: Khi thay đổi dữ kiện hệ thống sẽ tự động cập nhật!</span></h3>
	        		<ul class="bill-detail-product">
	        			<?php if(isset($billDetail) && is_array($billDetail) && count($billDetail)){
	        				foreach ($billDetail as $key => $value) {
        				?>
		        			<li class="uk-flex mb20">
		        				<div class="uk-width-1-6">
		        					<div class="wrap-img-product img-cover">
		        						<img src="<?php echo $value['image'] ?>" alt="<?php echo $value['name'] ?>">
		        					</div>
		        				</div>
		        				<div class="uk-width-5-6 ml20">
		        					<div class="mb5"><h4 class="text-bold product-title-detail"><?php echo $value['name'] ?></h4></div>
	        						<div class="mb5"><span class="text">Mã đơn hàng </span>: <span><?php echo $value['productid'] ?></span></div>
	        						<div class="mb5"><span class="text">Giá </span>: <span><?php echo ($value['price'] != '' || $value['price'] == 0) ? number_format(check_isset($value['price']),0,',','.') : 'Liên hệ' ?></span></div>
	        						<div class="mb5"><span class="text">Số lượng </span>: <span><?php echo $value['quantity'] ?></span></div>
	        						<div class="mb5"><span class="text">Tổng tiền </span>: <span><?php echo ($value['subtotal'] != '' || $value['subtotal'] == 0) ? number_format(check_isset($value['subtotal']),0,',','.') : 'Liên hệ' ?></span></div>
		        					
		        				</div>
		        			</li>
		        		<?php }} ?>
	        		</ul>
	        	</div>
	        </div>
		</div>
    </div>
</div>