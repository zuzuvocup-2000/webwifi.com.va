<?php
	helper(['mydatafrontend','mydata']);
	$baseController = new App\Controllers\FrontendController();


    $language = $baseController->currentLanguage();
	$slide_banner =  slide($language);
	$languageList = get_data([
		'select' => 'id, title, image, canonical',
		'table' => 'language',
		'where' => [
			'deleted_at' => 0,
			'publish' => 1
		],
		'order_by' => 'order desc, id desc'
	], TRUE);
 ?>

<!-- MOBILE HEADER -->
<header class="mobile-header uk-hidden-large">
	<div class="mobile-header-company">
		<?php echo $general['homepage_company'] ?>
	</div>
	<section class="upper">
		<div class="uk-flex uk-flex-middle uk-flex-space-between">
			<a class="moblie-menu-btn skin-1" href="#offcanvas" class="offcanvas" title="menu-mobile" data-uk-offcanvas="{target:'#offcanvas'}">
				<span>Menu</span>
			</a>
			<?php echo logo() ?>
			<div class="uk-flex uk-flex-middle">
				<div class="mobile-header-search mr10">
					<a href="" title="mobile-search-btn">
						<i class="fa fa-search" aria-hidden="true"></i>
					</a>
				</div>
				<div class="hd-cart">
					<a href="<?php echo BASE_URL.'gio-hang'.HTSUFFIX; ?>" title="<?php echo $general['homepage_company'].' cart' ?>" class="shopping_cart">
						<img src="public/frontend/resources/img/icon/icon-cart.png" alt="gio hang">
						<div class="number_cart"><?php echo $cart->totalItems(); ?></div>
					</a>
				</div>
			</div>
		</div>
	</section>
	<!-- .upper -->
	<section id="mobile-search" class="lower" style="display: block;">
		<h2 style="display: none">Mobile search</h2>
		<div class="mobile-search">
			<form  class="uk-form form">
				<input type="text" name="keyword" class="uk-width-1-1 input-text" placeholder="Nhập từ khóa tìm kiếm ...">
				<button type="submit" name="" value="" class="btn-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
			</form>
		</div>
	</section>
	<section class="slide-panel-mobile" <?php echo (isset($_SERVER['REDIRECT_URL']) && $_SERVER['REDIRECT_URL'] == '/gio-hang.html') ? 'style="display:none"' : '' ?>>
		<h2 style="display: none">SLIDE TOUR</h2>
		<?php if(isset($slide_banner)){
			echo $slide_banner;
		} ?>
	</section>
</header>
<!-- .mobile-header -->
