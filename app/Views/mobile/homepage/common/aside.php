<?php
	helper(['mydatafrontend','mydata']);
	$baseController = new App\Controllers\FrontendController();
    $language = $baseController->currentLanguage();
    $panel = get_panel([
		'locate' => 'sidebar',
		'language' => $language
	]);
	$slide = get_slide([
        'keyword' => 'aside',
        'language' => $language,
        'output' => 'array'
    ]);
?>

<aside class="va-aside">
	<?php if(isset($panel) && is_array($panel) && count($panel)){ 
		foreach ($panel as $keyPanel => $valPanel) {
	?>
		<div class="aside-news aside-panel">
			<div class="aside-head">
				<div class="aside-heading">
					<?php echo check_isset($valPanel['title']) ?>
				</div>
			</div>
			<div class="aside-body">
				<ul class="uk-list uk-clearfix list-news">
					<?php if(isset($valPanel['data']) && is_array($valPanel['data']) && count($valPanel['data'])){ 
						foreach ($valPanel['data'] as $key => $val) {
					?>
						<li>
							<article class="article">
								<div class="thumb">
									<a href="<?php echo check_isset($val['canonical']) ?>" title="<?php echo check_isset($val['title']) ?>" class="image img-cover"><img src="<?php echo check_isset($val['avatar']) ?>" alt="<?php echo check_isset($val['title']) ?>"></a>
								</div>
								<div class="info">
									<h3 class="title"><a href="<?php echo check_isset($val['canonical']) ?>" title="<?php echo check_isset($val['title']) ?>" class=""><?php echo check_isset($val['title']) ?></a></h3>
									<div class="va-readmore">
										<a href="<?php echo check_isset($val['canonical']) ?>" title="<?php echo check_isset($val['title']) ?>">Chi tiết</a>
									</div>
								</div>
							</article>
						</li>
					<?php }} ?>
				</ul>
			</div>
		</div>
	<?php }} ?>
</aside>