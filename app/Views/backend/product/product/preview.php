
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-12">
      <h2>Chi tiết Sản phẩm: <span class="font-bold m-b-xs"><?php echo $object['title'] ?></span></h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Trang chủ</a>
         </li>
         <li class="active"><strong>Chi tiết Sản phẩm</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox product-detail">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="product-images">
                            	<?php if(isset($object['album']) && is_array($object['album']) && count($object['album'])){
                            		foreach ($object['album'] as $key => $value) { ?>
	                                <div>
	                                    <div class="image-imitation">
	                                    	<div  class="img-cover">
	                                        	<img src="<?php echo $value ?>" alt="<?php echo $object['title'] ?>">
	                                    	</div>
	                                    </div>
	                                </div>
	                            <?php }} ?>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h2 class="font-bold m-b-xs">
                                <?php echo $object['title'] ?>
                            </h2>
                            <small>Many desktop publishing packages and web page editors now.</small>
                            <div class="m-t-md">
                                <div class="wrap-price mb10">
									<span class="new" style="<?php echo (isset($object['price_promotion']) && $object['price_promotion'] != 0) ? '' : 'display: none;' ?>">
	                                    <?php echo check_isset($object['price_promotion']) ?> đ
	                                </span>
	                                <span class="old <?php echo (isset($object['price_promotion']) && $object['price_promotion'] != 0) ? 'line-price' : '' ?>"><?php echo check_isset($object['price']) ?> đ</span>
	                            </div>
                            </div>
                            <hr>
                            <h4>Mô tả</h4>
                            <div class="small text-muted">
                                <?php echo $object['description'] ?>
                            </div>
                            <hr>
                            <div>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-cart-plus"></i> Add to cart</button>
                                    <button class="btn btn-white btn-sm"><i class="fa fa-star"></i> Add to wishlist </button>
                                    <button class="btn btn-white btn-sm"><i class="fa fa-envelope"></i> Contact with author </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

