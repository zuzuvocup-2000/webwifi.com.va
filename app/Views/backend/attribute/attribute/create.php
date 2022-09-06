<?php
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2><?php echo translate('cms_lang.attribute.attribute_create', $language) ?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin'); ?>"><?php echo translate('cms_lang.attribute.attribute_home', $language) ?></a>
			</li>
			<li class="active"><strong><?php echo translate('cms_lang.attribute.attribute_create', $language) ?></strong></li>
		</ol>
	</div>
</div>
<?php echo view('backend/attribute/attribute/store') ?>