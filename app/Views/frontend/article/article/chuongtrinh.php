<main class="clearfix mt50" style="margin-top: 90px;">
	<div id="ctl00_divCenter " class="middle-fullwidth ">
		<div class='center-menu clearfix mrb30 Module Module-142 '>
			<div class='ModuleContent'>
				<nav class="text-xs-center">
					<a class="transition active" href="<?php echo $object['canonical'].HTSUFFIX ?>"><?php echo $object['title'] ?></a>
					<?php if(isset($articleRelate) && is_array($articleRelate) && count($articleRelate)){
						foreach ($articleRelate as $key => $value) {
					?>
					<a class="transition" href="<?php echo $value['canonical'].HTSUFFIX ?>"><?php echo $value['title'] ?></a>
					<?php }} ?>
				</nav>
			</div>
		</div>
		<div class='clearfix Module Module-88'>
			<div class='ModuleContent'>
				<div id="ctl00_mainContent_ctl01_ctl00_pnlInnerWrap">
					<section class="live-news mrb30">
						<div class="container">
							<div class="single-item">
								<?php if(isset($object['album']) && is_array($object['album']) && count($object['album'])){
									foreach ($object['album'] as $value) {
								?>
								<div class="item">
									<img src="<?php echo $value ?>" alt="">
								</div>
								<?php }} ?>
							</div>
							<div class="clearfix content">
								<?php echo $object['description'] ?>
								<?php echo $object['content'] ?>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</main>