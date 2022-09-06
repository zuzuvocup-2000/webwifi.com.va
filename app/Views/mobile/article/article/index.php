<?php
	helper(['mydatafrontend','mydata']);
	$baseController = new App\Controllers\FrontendController();
    $language = $baseController->currentLanguage();
    $footer = get_panel([
		'locate' => 'footer',
		'language' => $language
	]);
?>
<section class="va-articleCat-panel">
	<div class="uk-container uk-container-center">
		<ul class="uk-breadcrumb uk-clearfix mb30">
			<li class="breadcrumb-home"><a href=""> <i class="fa fa-home"></i> Trang chủ</a></li>
			<?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){
				foreach ($breadcrumb as $key => $value) {
			 ?>
				<li class=""><a href="<?php echo BASE_URL.check_isset($value['canonical']).HTSUFFIX ?>" ><span><?php echo check_isset($value['title']) ?></span></a></li>
			<?php }} ?>
			<li class="uk-active"><a href="<?php echo check_isset($object['canonical']); ?>"><?php echo check_isset($object['title']); ?></a></li>
		</ul>
		<div class="articleList">
			<div class="uk-grid uk-grid-medium uk-clearfix">
				<div class="uk-width-large-1-4 uk-visible-large">
					<?php echo view('frontend/homepage/common/aside') ?>
				</div>
				<div class="uk-width-large-3-4">
					<div class="article-panel">
						<section class="art-detail detail-content">
							<h1 class="art-title uk-text-bold mb15"><span style=""><?php echo check_isset($object['title']); ?></span></h1>
						</section>
						<div class="article-content"><?php echo check_isset($object['content']); ?></div>
						<?php if(isset($footer) && is_array($footer) && count($footer)){
							foreach ($footer as $keyPanel => $valPanel) {
						?>
						<section class="art-same mt30">
							<header class="panel-head uk-text-center mb20 panel-head-mobiel">
								<div class="heading-1"><span><?php echo check_isset($valPanel['title']); ?></span></div>
							</header>

								<section class="panel-body">
									<ul class="uk-grid uk-grid-medium uk-grid-width-1-1 uk-grid-width-medium-1-2 uk-grid-width-xlarge-1-4 list-article">
										<?php if(isset($valPanel['data']) && is_array($valPanel['data']) && count($valPanel['data'])){
											foreach ($valPanel['data'] as $key => $val) {
										?>
										<li class="mb20">
											<article class="article">
												<div class="thumb mb15">
													<a class="image img-mobile img-cover img-flash" href="<?php echo check_isset($val['canonical']); ?>" title="<?php echo check_isset($val['title']); ?>"><img src="<?php echo check_isset($val['avatar']); ?>" alt="<?php echo check_isset($val['title']); ?>"></a>
												</div>
												<div class="infor">
													<div class="title"><a href="<?php echo check_isset($val['canonical']); ?>" title="<?php echo check_isset($val['title']); ?>"><?php echo check_isset($val['title']); ?></a></div>
												</div>
											</article><!-- .article-->
										</li>
										<?php }} ?>
									</ul>
								</section>
						</section>
						<?php }} ?>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>
