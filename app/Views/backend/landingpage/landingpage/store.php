<?php
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
?>
<link href="public/backend/css/plugins/codemirror/codemirror.css" rel="stylesheet">
<link href="public/backend/css/plugins/codemirror/ambiance.css" rel="stylesheet">
<form method="post" action="" >
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
							<h5><?php echo translate('cms_lang.post.post_info', $language) ?> <small class="text-danger"><?php echo translate('cms_lang.post.post_sub_info', $language) ?></small></h5>
							<div class="ibox-tools">
								<button type="submit" name="create" value="create" class="btn btn-primary block full-width m-b"><?php echo translate('cms_lang.post.post_save', $language) ?></button>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row">
									<label class="control-label text-left">
										<span><?php echo translate('cms_lang.post.post_create_title', $language) ?> <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('title', validate_input(set_value('title', (isset($landingpage['title'])) ? $landingpage['title'] : '')), 'class="form-control '.(($method == 'create') ? 'title' : '').'" placeholder="" id="title" autocomplete="off"'); ?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row">
									<div class="uk-flex uk-flex-middle uk-flex-space-between">
										<label class="control-label text-left">
											<span><?php echo translate('cms_lang.post.post_content', $language) ?></span>
										</label>
									</div>
									<?php echo form_textarea('content', htmlspecialchars_decode(html_entity_decode(set_value('content', (isset($landingpage['content'])) ? $landingpage['content'] : ''))), 'class="form-control code1" id="code1" placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ibox ibox-seo mb20">
					<div class="ibox-title">
						<div class="uk-flex uk-flex-middle uk-flex-space-between">
							<h5><?php echo translate('cms_lang.post.post_seo', $language) ?></h5>

							<div class="uk-flex uk-flex-middle uk-flex-space-between">
								<div class="edit">
									<a href="#" class="edit-seo"><?php echo translate('cms_lang.post.post_seo_edit', $language) ?></a>
								</div>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<?php
									$metaTitle = (isset($_POST['meta_title'])) ? $_POST['meta_title'] : ((isset($landingpage['meta_title']) && $landingpage['meta_title'] != '') ? $landingpage['meta_title'] : translate('cms_lang.post.post_seo_validate_title', $language)) ;
									$googleLink = (isset($_POST['canonical'])) ? $_POST['canonical'] : ((isset($landingpage['canonical']) && $landingpage['canonical'] != '') ? BASE_URL.$landingpage['canonical'].HTSUFFIX : BASE_URL.'duong-dan-website'.HTSUFFIX) ;
									$metaDescription = (isset($_POST['meta_description'])) ? $_POST['meta_description'] : ((isset($landingpage['meta_description']) && $landingpage['meta_description'] != '') ? $landingpage['meta_description'] : translate('cms_lang.post.post_seo_validate_description', $language)) ;
								?>
								<div class="google">
									<div class="g-title"><?php echo $metaTitle; ?></div>
									<div class="g-link"><?php echo $googleLink ?></div>
									<div class="g-description" id="metaDescription">
										<?php echo $metaDescription; ?>

									</div>
								</div>
							</div>
						</div>

						<div class="seo-group hidden">
							<hr>
							<div class="row mb15">
								<div class="col-lg-12">
									<div class="form-row">
										<div class="uk-flex uk-flex-middle uk-flex-space-between">
											<label class="control-label ">
												<span><?php echo translate('cms_lang.post.post_seo_title', $language) ?></span>
											</label>
											<span style="color:#9fafba;"><span id="titleCount">0</span> <?php echo translate('cms_lang.post.post_seo_number_title', $language) ?></span>
										</div>
										<?php echo form_input('meta_title', htmlspecialchars_decode(html_entity_decode(set_value('meta_title', (isset($landingpage['meta_title'])) ? $landingpage['meta_title'] : ''))), 'class="form-control meta-title" placeholder="" autocomplete="off"');?>
									</div>
								</div>
							</div>
							<div class="row mb15">
								<div class="col-lg-12">
									<div class="form-row">
										<div class="uk-flex uk-flex-middle uk-flex-space-between">
											<label class="control-label ">
												<span><?php echo translate('cms_lang.post.post_seo_description', $language) ?></span>
											</label>
											<span style="color:#9fafba;"><span id="descriptionCount">0</span> <?php echo translate('cms_lang.post.post_seo_number_description', $language) ?></span>
										</div>
										<?php echo form_textarea('meta_description', set_value('meta_description', (isset($landingpage['meta_description'])) ? $landingpage['meta_description'] : ''), 'class="form-control meta-description" id="seoDescription" placeholder="" autocomplete="off"');?>
									</div>
								</div>
							</div>
							<div class="row mb15">
								<div class="col-lg-12">
									<div class="form-row">
										<div class="uk-flex uk-flex-middle uk-flex-space-between">
											<label class="control-label ">
												<span><?php echo translate('cms_lang.post.post_seo_canonical', $language) ?><b class="text-danger">(*)</b></span>
											</label>
										</div>
										<div class="outer">
											<div class="uk-flex uk-flex-middle">
												<div class="base-url"><?php echo base_url(); ?></div>
												<?php echo form_input('canonical', htmlspecialchars_decode(html_entity_decode(set_value('canonical', (isset($landingpage['canonical'])) ? $landingpage['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off" data-flag="0" ');?>
												<?php echo form_hidden('original_canonical', htmlspecialchars_decode(html_entity_decode(set_value('original_canonical', (isset($landingpage['canonical'])) ? $landingpage['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off"');?>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>
				<button type="submit" name="create" value="create" class="btn btn-primary block m-b pull-right"><?php echo translate('cms_lang.post.post_save', $language) ?></button>

			</div>
			<div class="col-lg-4">
				<div class="ibox mb20">
					<div class="ibox-title">
						<h5><?php echo translate('cms_lang.post.post_display', $language) ?></h5>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-row">
									<div class="text-warning mb15"><?php echo translate('cms_lang.post.post_display_des', $language) ?></div>
									<div class="block clearfix">
										<div class="i-checks mr30" style="width:100%;">
											<span style="color:#000;" class="uk-flex uk-flex-middle">
												<?php echo form_radio('publish', set_value('publish', 1), ((isset($_POST['publish']) && $_POST['publish'] == 1 || (isset($landingpage['publish']) && $landingpage['publish'] == 1)) ? true : (!isset($_POST['publish'])) ? true : false),'class=""  id="publish"  style="margin-top:0;margin-right:10px;" '); ?>
												<label for="publish" style="margin:0;cursor:pointer;"><?php echo translate('cms_lang.post.post_display_1', $language) ?></label>
											</span>
										</div>
									</div>
									<div class="block clearfix">
										<div class="i-checks" style="width:100%;">
											<span style="color:#000;" class="uk-flex uk-flex-middle">
												<?php echo form_radio('publish', set_value('publish', 0), ((isset($_POST['publish']) && $_POST['publish'] == 0 || (isset($landingpage['publish']) && $landingpage['publish'] == 0)) ? true : false),'class=""   id="no-publish" style="margin-top:0;margin-right:10px;" '); ?>

												<label for="no-publish" style="margin:0;cursor:pointer;"><?php echo translate('cms_lang.post.post_display_0', $language) ?></label>
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
<script src="public/backend/js/plugins/codemirror/codemirror.js"></script>
<script src="public/backend/js/plugins/codemirror/mode/javascript/javascript.js"></script>

 <script>
     $(document).ready(function(){

         var editor_one = CodeMirror.fromTextArea(document.getElementById("code1"), {
             lineNumbers: true,
             matchBrackets: true,
             styleActiveLine: true,
             theme:"ambiance"
         });
    });
</script>