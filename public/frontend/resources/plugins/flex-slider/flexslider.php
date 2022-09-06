<?php 
	$list_image = json_decode(base64_decode($productDetail['image_json']));
?>

<div class="prd-gallerys">
	<div id="slider" class="flexslider">
		<ul class="slides">
			<?php if(isset($list_image) && is_array($list_image) && count($list_image)){ ?>
			<?php foreach($list_image as $key => $val) { ?>
			<li>
				<div class="thumb">
					<a class="image img-scaledown" href="<?php echo $val; ?>" title="Ảnh chi tiết dự án" data-uk-lightbox="{group:'prdGallerys'}"><img src="<?php echo $val; ?>" alt="<?php echo $val; ?>" /></a>
				</div>
			</li>
			<?php }} ?>
		</ul>
	</div>
	<div id="carousel" class="flexslider">
		<ul class="slides">
			<?php if(isset($list_image) && is_array($list_image) && count($list_image)){ ?>
			<?php foreach($list_image as $key => $val) { ?>
			<li>
				<div class="thumb">
					<span class="image img-scaledown"><img src="<?php echo $val;?>" alt="<?php echo $val;?>" /></span>
				</div>
			</li>
			<?php }} ?>
		</ul>
	</div>
	<!-- Không có slide ảnh
	<div class="cover"><a class="image img-cover" href="" title=""></a></div>
	-->
</div> <!-- end of product-gallery -->


<style>
	
	.prd-gallerys {
		position: relative;
		margin: 0 0 30px 0;
	}
	.prd-gallerys .flexslider {margin: 0;}
	.prd-gallerys .flexslider img {height: 100%;}
	.prd-gallerys .flex-direction-nav a {
		width: 45px;
		height: 45px;
		background-color: rgba(255, 255, 255, 1);
		background-position: center;
		background-repeat: no-repeat;
		-webkit-border-radius: 50%;
		-moz-border-radius: 50%;
		-ms-border-radius: 50%;
		-o-border-radius: 50%;
		border-radius: 50%;
	}
	.prd-gallerys .flex-direction-nav .flex-prev {background-image: url(img/btn-prev.png);}
	.prd-gallerys .flex-direction-nav .flex-next {background-image: url(img/btn-next.png);}
	.prd-gallerys .flex-direction-nav a:before {
		display: none;
		visibility: hidden;
	}
	.prd-gallerys #slider .image{
		height: 380px;
	}
	
	.prd-gallerys #carousel .slides li + li {margin-left:6px;}
	.prd-gallerys #carousel {
		max-width: 600px;
		position: relative;
		margin: -33px auto 0 auto;
	}
	.prd-gallerys #carousel .image {
		height: 65px;
		border: 1px solid #fff;
		cursor: pointer;
	}
	.prd-gallerys #carousel .slides .flex-active-slide .image {
		border-color: #d63240;
	}
</style>