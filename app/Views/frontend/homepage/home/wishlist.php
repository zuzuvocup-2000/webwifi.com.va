<div class="page-content">
	<main class="main">
		<nav class="breadcrumb-nav">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="/"><i class="d-icon-home"></i></a></li>
					<li>Danh sách yêu thích</li>
				</ul>
			</div>
		</nav>
		<div class="page-content pt-10 pb-10 mb-2">
			<div class="container">
				<table class="shop-table wishlist-table mt-2 mb-4">
					<thead>
						<tr>
							<th class="product-name"><span>Sản phẩm</span></th>
							<th></th>
							<th class="product-name"><span>Giá</span></th>
							<th class="product-add-to-cart"></th>
							<th class="product-remove"></th>
						</tr>
					</thead>
					<tbody class="wishlist-items-wrapper">
						<?php if(isset($productList) && is_array($productList) && count($productList)){
							foreach ($productList as $key => $value) {
						?>
							<tr id="table-product__<?php echo $value['id'] ?>" class="product">
								<td class="product-thumbnail">
									<a href="<?php echo $value['canonical'].HTSUFFIX ?>">
										<figure>
											<img src="<?php echo $value['image'] ?>" width="100" height="100"
											alt="<?php echo $value['title'] ?>">
										</figure>
									</a>
								</td>
								<td class="product-name">
									<a href="<?php echo $value['canonical'].HTSUFFIX ?>"><?php echo $value['title'] ?></a>
								</td>
								<td class="product-price">
						            <span class="price"><?php echo (isset($value['price_promotion']) && $value['price_promotion'] != 0 ? number_format($value['price_promotion'], 0, ',', '.').'đ' : (isset($value['price']) && $value['price'] != 0 ? number_format($value['price'], 0, ',', '.').'đ' : 'Liên hệ')) ?></span>
						            <label class="price"><?php echo (isset($value['price_promotion']) && $value['price_promotion'] != 0 ? number_format($value['price'], 0, ',', '.').'đ' : '') ?></label>
								</td>
								<td class="product-add-to-cart">
									<a data-id="<?php echo $value['id'] ?>" data-sku="SKU_<?php echo $value['id'] ?>" class="buy_now btn-product btn-primary"><span>Thêm vào giỏ hàng</span></a>
								</td>
								<td class="product-remove">
									<div>
										<a data-id="<?php echo $value['id'] ?>" data-remove="table-product__<?php echo $value['id'] ?>" class="remove-wishlist remove" title="Xóa"><i class="d-icon-times"></i></a>
									</div>
								</td>
							</tr>
						<?php }} ?>
					</tbody>
				</table>
			</div>
		</div>
	</main>
</div>
