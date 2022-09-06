<aside class="aside-2" data-uk-sticky="{boundary: true, top:10}">
	<?php if($detailCatalogue['id'] == 4){ ?>
		<?php
			$model = new App\Models\AutoloadModel();
			$category = $model->_get_where([
				'select' => 'tb1.id, tb2.title, tb1.parentid, tb2.canonical, tb1.icon, tb1.image',
				'table' => 'product_catalogue as tb1',
				'join' => [
					['product_translate as tb2','tb1.id = tb2.objectid','inner']
				],
				'where' => [
					'tb1.publish' => 1,
					'tb2.module' => 'product_catalogue',
				]
			], TRUE);
			$category = recursive($category);
		 ?>
		 <div class="wrap-category-article aside-news" >
		 	<div class="heading">Tin liên quan</div>
		 	<ul class="uk-list wrap-category-article-list">
		 		<?php if(isset($category) && is_array($category) && count($category)){
		 			foreach ($category as $key => $value) {  ?>
			 		<li>
			 			<a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a>
			 		</li>
			 	<?php }} ?>
		 	</ul>
		 </div>
	<?php }else{ ?>
	<?php if(isset($articleNew) && is_array($articleNew) && count($articleNew)){  ?>
	<div class="aside-news mt10">
		<div class="heading">Tin mới nhất</div>
		<div class="panel-body">
			<?php foreach($articleNew as $key => $val){ ?>
			<article class="post-3 uk-clearfix">
				<a href="<?php echo write_url($val['canonical']); ?>" class="image img-cover">
					<?php echo render_img(['src' => $val['image'],'alt' => $val['title']]) ?>
				</a>
				<div class="title limit-line-2"><a href="<?php echo $val['canonical'] ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></div>
			</article>
			<?php } ?>
		</div>
	</div>
	<?php }} ?>
	<?php if(isset($module) && $module == 'article'){ ?>
	<?php if(isset($articleRelate) && is_array($articleRelate) && count($articleRelate)){ ?>
	<div class="aside-related aside-news mt10">
		<div class="heading">Tin liên quan</div>
		<div class="panel-body">
			<ul class="uk-list uk-clearfix">
				<?php foreach($articleRelate as $key => $val){ ?>
				<li><a href="<?php echo write_url($val['canonical']); ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<?php } ?>
	<div class="aside-video aside-news mt10">
		<div class="heading">Video</div>
		<div class="panel-body">
			<?php foreach($video as $key => $val){ ?>
			<article class="post-3 uk-clearfix">
				<a href="<?php echo write_url($val['canonical']); ?>" class="image img-cover">
					<?php echo render_img(['src' => $val['image'],'alt' => $val['title']]) ?>
				</a>
				<div class="title limit-line-2"><a href="<?php echo $val['canonical'] ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></div>
			</article>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
	<?php  if(isset($connect_product) && is_array($connect_product) && count($connect_product)){ ?>
	<div class="aside-product aside-news mt10">
		<div class="heading">Sản phẩm liên quan</div>
		<div class="panel-body">
			<?php foreach($connect_product as $key => $val){ ?>
			<?php
				$title = $val['title'];
				$canonical = write_url($val['canonical']);
				$percent = percent($val['price'],  $val['price_promotion']);
				$image = $val['image'];
				$price_show = ($val['price_promotion'] > 0) ? number_format($val['price_promotion'],'0',',','.').'đ' : number_format($val['price'], 0, ',', '.').'đ';
				if($price_show == 0){
					$price_show = 'Liên Hệ';
				}
			?>
			<div class="product-3 uk-clearfix">
				<a href="<?php echo $canonical ?>" class="image img-scaledown">
					<?php echo render_img(['src' => $image,'alt' => $title]) ?>
				</a>
				<div class="info">
					<div class="title limit-line-2"><a href="<?php echo $canonical; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></div>
					<div class="uk-flex uk-flex-middle">
						<div class="fs-price"><?php echo $price_show ?></div>
						<?php if($val['price_promotion'] > 0){ ?>
						<div class="s-price"><?php echo number_format($val['price'], 0, ',','.') ?>đ</div>
						<?php } ?>
					</div>
					<div class="buynow"><a href="<?php echo $canonical; ?>" title="<?php echo $title; ?>"><img src="public/frontend/resources/img/btnMua-s.png" alt="Buy Now"></a></div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
</aside>
