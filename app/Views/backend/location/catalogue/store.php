<?php
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
?>
<form method="post" action="" class="form-horizontal box" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
			</div><!-- /.box-body -->
		</div>
		<div class="row">
			<div class="col-lg-8 clearfix">
				<div class="ibox mb20">
					<div class="ibox-title" style="padding: 9px 15px 0px;">
						<div class="uk-flex uk-flex-middle uk-flex-space-between">
							<h5><?php echo translate('cms_lang.location_catalogue.tourjet_info', $language) ?> <small class="text-danger"><?php echo translate('cms_lang.location_catalogue.tourcat_sub_info', $language) ?></small></h5>
							<div class="ibox-tools">
								<button type="submit" name="create" value="create" class="btn btn-primary block full-width m-b"><?php echo translate('cms_lang.location_catalogue.tourjet_save', $language) ?></button>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row mb15">
							<div class="col-lg-4">
								<div class="form-row">
									<label class="control-label text-left">
										<span><?php echo translate('cms_lang.location_catalogue.tourjet_create_title', $language) ?><b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('title', validate_input(set_value('title', (isset($location_catalogue['title'])) ? $location_catalogue['title'] : '')), 'class="form-control title" placeholder="" id="title" autocomplete="off"'); ?>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-row">
									<label class="control-label text-left">
										<span><?php echo translate('cms_lang.location_catalogue.tourjet_key_create', $language) ?> <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('keyword', validate_input(set_value('keyword', (isset($location_catalogue['keyword'])) ? $location_catalogue['keyword'] : '')), 'class="form-control keyword" placeholder="" id="keyword" autocomplete="off"'); ?>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-row">
									<label class="control-label text-left">
										<span><?php echo translate('cms_lang.location_catalogue.tourjet_create_attr', $language) ?> <b class="text-danger">(*)</b></span>
									</label>
									<?php 
										$attribute = [
											0 => '-- '.translate('cms_lang.location_catalogue.tourjet_create_select_0', $language).' --',
											'start' => translate('cms_lang.location_catalogue.tourjet_create_select_1', $language),
											'end' => translate('cms_lang.location_catalogue.tourjet_create_select_2', $language)
										];
									 ?>
									<?php echo form_dropdown('attribute', $attribute, set_value('attribute', (isset($location_catalogue['attribute'])) ? $location_catalogue['attribute'] : ''), ' class="form-control m-b select2 "');?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row form-description">
									<div class="uk-flex uk-flex-middle uk-flex-space-between">
										<label class="control-label text-left">
											<span><?php echo translate('cms_lang.location_catalogue.tourjet_short', $language) ?></span>
										</label>
										<a href="" title="" data-target="description" class="uploadMultiImage"><?php echo translate('cms_lang.location_catalogue.tourjet_upload', $language) ?></a>
									</div>
									<?php echo form_textarea('description', htmlspecialchars_decode(html_entity_decode(set_value('description', (isset($location_catalogue['description'])) ? $location_catalogue['description'] : ''))), 'class="form-control ck-editor" id="description" placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<button type="submit" name="create" value="create" class="btn btn-primary block m-b pull-right"><?php echo translate('cms_lang.location_catalogue.tourjet_save', $language) ?></button>
			</div>
			<div class="col-lg-4">
				<div class="ibox mb20">
					<div class="ibox-title">
						<h5><?php echo translate('cms_lang.location_catalogue.tourjet_display', $language) ?> </h5>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-row">
									<div class="text-warning mb15"><?php echo translate('cms_lang.location_catalogue.tourjet_display_des', $language) ?></div>
									<div class="block clearfix">
										<div class="i-checks mr30" style="width:100%;">
											<span style="color:#000;" class="uk-flex uk-flex-middle"> 
												<?php echo form_radio('publish', set_value('publish', 1), ((isset($_POST['publish']) && $_POST['publish'] == 1 || (isset($location_catalogue['publish']) && $location_catalogue['publish'] == 1)) ? true : (!isset($_POST['publish'])) ? true : false),'class=""  id="publish"  style="margin-top:0;margin-right:10px;" '); ?>
												<label for="publish" style="margin:0;cursor:pointer;"><?php echo translate('cms_lang.location_catalogue.tourjet_display_1', $language) ?></label>
											</span>
										</div>
									</div>
									<div class="block clearfix">
										<div class="i-checks" style="width:100%;">
											<span style="color:#000;" class="uk-flex uk-flex-middle"> 
												<?php echo form_radio('publish', set_value('publish', 0), ((isset($_POST['publish']) && $_POST['publish'] == 0 || (isset($location_catalogue['publish']) && $location_catalogue['publish'] == 0)) ? true : false),'class=""   id="no-publish" style="margin-top:0;margin-right:10px;" '); ?>
												
												<label for="no-publish" style="margin:0;cursor:pointer;"><?php echo translate('cms_lang.location_catalogue.tourjet_display_0', $language) ?></label>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

