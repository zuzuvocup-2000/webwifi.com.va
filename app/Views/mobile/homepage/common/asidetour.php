<?php
	helper(['mydatafrontend','mydata']);
	$baseController = new App\Controllers\FrontendController();
    $language = $baseController->currentLanguage();
    $location = location($language,'end');
    $attr = attribute($language);
    $price = explode_price($general['another_price']);
?>
<div class="aside-tour-mobile mb30">
	<div class="aside-search mb30">
		<form action="" method="" class="uk-form va-form">
			<input type="text" name="keyword" id="keyword" class="uk-width-1-1 input-text" placeholder="Tìm kiếm">
			<button type="submit" name="" class="va-btn-submit"><i class="fa fa-search"></i></button>
		</form>
		<div class="searchResult"></div>
	</div>
	<div class="mobile-aside-view-more" id="section">
		<div class="moretext mb30">
			<div class="aside-list-mobile uk-flex">
				<div class="aside-mobile-title">
					<h3>Khu vực</h3>
				</div>
				<ul class="uk-list">
					<?php if(isset($location) && is_array($location) && count($location)){
		                foreach ($location as $key => $value) {
		             ?>
		                <li>
		                    <label class="check-aside check-area uk-flex uk-flex-middle mb10" data-select="<?php echo check_isset($value['keyword']) ?>" >
				                <input type="checkbox" name="area[]"  value="<?php echo check_isset($value['id']) ?>">
				                <?php echo check_isset($value['title']) ?>
				            </label>
		                </li>
		            <?php }} ?>
				</ul>
			</div>
			
			<div class="aside-list-mobile uk-flex">
				<div class="aside-mobile-title">
					<h3>Khoảng giá</h3>
				</div>
				<ul class="uk-list">
					<?php if(isset($price) && is_array($price) && count($price)){
						foreach ($price as $key => $value) {
					 ?>
			            <li>
			                <label class="check-aside check-price uk-flex uk-flex-middle mb10">
				                <input type="checkbox" data-start="<?php echo check_isset($value['start']) ?>" data-end="<?php echo check_isset($value['end']) ?>" name="price[]" class="about-price" value="<?php echo check_isset($value['value']) ?>">
				                <?php 
				                	if(check_isset($value['start']) == 'min'){
				                		echo 'Dưới '.convertPrice($value['end']);
				                	}else if(check_isset($value['end']) == 'max'){
				                		echo 'Trên '.convertPrice($value['start']);
				                	}else{
				                		echo 'Từ '.convertPrice($value['start']).' - '.convertPrice($value['end']);
				                	}
				                ?>
				            </label>
			            </li>
		        	<?php }} ?>
				</ul>
			</div>
			
			<?php if(isset($attr) && is_array($attr) && count($attr)){ 
				foreach ($attr as $key => $value) {
			?>
				<div class="aside-list-mobile uk-flex">
					<div class="aside-mobile-title">
						<h3><?php echo check_isset($value['title']) ?></h3>
					</div>
					<ul class="uk-list">
						<?php if(isset($value['child']) && is_array($value['child']) && count($value['child'])){
			                foreach ($value['child'] as $keyChild => $valChild) {
			             ?>
			                <li>
			                    <label class="check-aside filter-attr uk-flex uk-flex-middle mb10">
					                <input type="checkbox" name="<?php echo check_isset($value['canonical']) ?>"  value="<?php echo check_isset($valChild['id']) ?>">
					                <?php echo check_isset($valChild['title']) ?>
					            </label>
			                </li>
			            <?php }} ?>
					</ul>
				</div>
				
			<?php }} ?>
			
		</div>
		<div class="wrap-moreless-button uk-text-center">
  			<a class="moreless-button" href="#">Tìm kiếm nâng cao</a>
		</div>
	</div>
</div>

