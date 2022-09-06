<?php $company = get_slide(['keyword' => 'ban-quan-tri' , 'language' => $language, ]); ?>
<?php
$panel = get_panel([
'locate' => 'intro',
'language' => $this->data['language']
]);
$panel_web = [];
foreach ($panel as $key => $value) {
$panel_web[$value['keyword']] = $value;
}
?>
<div class="introduce-page lazyloading_box">
	<div class="uk-grid uk-grid-collapse">
		<div class="uk-width-large-1-4">
			<div class="introduce-item" style="background-image: url(<?php echo $detailCatalogue['image'] ?>); background-size: cover; background-position: center center;">
				<div class="introduce-content">
					<div class="introduce-title"><?php echo $detailCatalogue['title'] ?></div>
					<div class="introduce-description"><?php echo base64_decode($detailCatalogue['description']) ?></div>
				</div>
				<div class="introduce-view-more">
					<a class="introduce-icon" href="#intro" data-uk-modal title=""><i class="fa fa-chevron-down"></i><i class="fa fa-plus"></i></a>
					<a href="#intro" data-uk-modal title="" class="introduce-text-link">Xem chi tiết</a>
				</div>
			</div>
		</div>
		<div id="intro" class="uk-modal">
			<div class="uk-modal-dialog" style="background-image: url(<?php echo $detailCatalogue['image'] ?>); background-size: cover; background-position: center center;">
				<a class="uk-modal-close uk-close"></a>
				<div class="uk-container uk-container-center">
					<div class="content-intro-modal">
						<?php echo base64_decode($detailCatalogue['content']) ?>
					</div>
				</div>
			</div>
		</div>
		<!--  =========================================================================================================== -->
		<?php if(isset($panel_web['history']['data']) && is_array($panel_web['history']['data']) && count($panel_web['history']['data'])){ ?>
		<?php
			$history = $panel_web['history']['data'][0];
			$history['sub_title'] = json_decode(base64_decode($history['sub_title']),true);
			$history['sub_content'] = json_decode(base64_decode($history['sub_content']),true);
		?>
		<div class="uk-width-large-1-4">
			<div class="introduce-item" style="background-image: url(<?php echo $history['image'] ?>); background-size: cover; background-position: center center;">
				<div class="introduce-content">
					<div class="introduce-title">Lịch sử phát triển</div>
					<?php if(isset($history['sub_title']) && is_array($history['sub_title']) && count($history['sub_title'])){
						foreach ($history['sub_title'] as $key => $value) {
					?>
					<div  class="introduce-description uk-flex uk-flex-middle"><span class="counter-up mr10" data-count="<?php echo $value ?>">0</span> <?php echo isset($history['sub_content'][$key]) ? $history['sub_content'][$key] : '' ?></div>
					<?php }} ?>
				</div>
				<div class="introduce-view-more">
					<a class="introduce-icon" href="#history" data-uk-modal title=""><i class="fa fa-chevron-down"></i><i class="fa fa-plus"></i></a>
					<a href="#history" data-uk-modal title="" class="introduce-text-link">Xem chi tiết</a>
				</div>
			</div>
		</div>
		<div id="history" class="uk-modal">
			<div class="uk-modal-dialog" style="background-image: url(<?php echo $history['image'] ?>); background-size: cover; background-position: center center;">
				<a class="uk-modal-close uk-close"></a>
				<div class="uk-container uk-container-center">
					<div class="time-line">
						<?php if(isset($panel_web['timeline']['data']) && is_array($panel_web['timeline']['data']) && count($panel_web['timeline']['data'])){ ?>
						<?php
									$timeline = $panel_web['timeline']['data'][0];
									$timeline['sub_title'] = json_decode(base64_decode($timeline['sub_title']),true);
									$timeline['sub_content'] = json_decode(base64_decode($timeline['sub_content']),true);
						?>
						<?php if(isset($timeline['sub_title']) && is_array($timeline['sub_title']) && count($timeline['sub_title'])){
						foreach ($timeline['sub_title'] as $key => $value) {
						?>
						<?php if($key % 2 == 0){ ?>
						<div class="uk-grid uk-grid-collapse uk-clearfix first-timeline">
							<div class="uk-width-large-1-2">
								<time class="scrollable-content-about-us ">
								<p><?php echo $value ?></p>
								</time>
								<div class="history-wrapper"><?php echo isset($timeline['sub_content'][$key]) ? strip_tags($timeline['sub_content'][$key]) : '' ?></div>
							</div>
							<div class="uk-width-large-1-2">
							</div>
						</div>
						<?php }else{ ?>
						<div class="uk-grid uk-grid-collapse uk-clearfix ">
							<div class="uk-width-large-1-2">
							</div>
							<div class="uk-width-large-1-2">
								<time class="scrollable-content-about-us">
								<p><?php echo $value ?></p>
								</time>
								<div class="history-wrapper"><?php echo isset($timeline['sub_content'][$key]) ? strip_tags($timeline['sub_content'][$key] ) : '' ?></div>
							</div>
						</div>
						<?php }}} ?>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<!--  =========================================================================================================== -->
		<?php if(isset($panel_web['ceo-intro']['data']) && is_array($panel_web['ceo-intro']['data']) && count($panel_web['ceo-intro']['data'])){ ?>
		<?php $ceo_intro = $panel_web['ceo-intro']['data'][0]; ?>
		<div class="uk-width-large-1-4">
			<div class="introduce-item" style="background-image: url(<?php echo $ceo_intro['image'] ?>); background-size: cover; background-position: center center;">
				<div class="introduce-content">
					<div class="introduce-title"><?php echo $ceo_intro['title'] ?></div>
					<div class="introduce-description"><?php echo base64_decode($ceo_intro['description']) ?></div>
				</div>
				<div class="introduce-view-more">
					<a class="introduce-icon" href="#ceo" data-uk-modal title=""><i class="fa fa-chevron-down"></i><i class="fa fa-plus"></i></a>
					<a href="#ceo" data-uk-modal title="" class="introduce-text-link">Xem chi tiết</a>
				</div>
			</div>
		</div>
		<div id="ceo" class="uk-modal">
			<div class="uk-modal-dialog" style="background-image: url(<?php echo $ceo_intro['image'] ?>); background-size: cover; background-position: center center;">
				<a class="uk-modal-close uk-close"></a>
				<div class="uk-container uk-container-center">
					<div class="content-intro-modal">
						<?php echo base64_decode($ceo_intro['content']) ?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<!--  =========================================================================================================== -->
		<?php if(isset($company) && is_array($company) && count($company)){ ?>
		<div class="uk-width-large-1-4">
			<div class="introduce-item" style="background-image: url(<?php echo $company[0]['image'] ?>); background-size: cover; background-position: center center;">
				<div class="introduce-content">
					<div class="introduce-title"><?php echo $company[0]['cat_title'] ?></div>
					<div class="introduce-description"><?php echo $company[0]['cat_description'] ?></div>
				</div>
				<div class="introduce-view-more">
					<a class="introduce-icon" href="<?php echo site_url('ban-quan-tri') ?>" title=""><i class="fa fa-chevron-down"></i><i class="fa fa-plus"></i></a>
					<a href="<?php echo site_url('ban-quan-tri') ?>" title="" class="introduce-text-link">Xem chi tiết</a>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<script>
	$(".counter-up").each(function () {
		var $this = $(this),
			countTo = $this.attr("data-count");
		$({
			countNum: $this.text()
		}).animate({
				countNum: countTo
			},
			{
				duration: 8000,
				easing: "linear",
				step: function () {
					$this.text(Math.floor(this.countNum));
				},
				complete: function () {
					$this.text(this.countNum);
					//alert('finished');
				}
			}
		);
	});
</script>