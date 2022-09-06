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
			<div class="col-lg-12">
				<div class="ibox m0">
					<div class="ibox-content">
						<div class="row mb15">
							<div class="col-lg-12">
								<div class="tv-title">
									<h3><?php echo translate('cms_lang.contact_catalogue.contactcat_info', $language) ?></h3>
									<div><?php echo translate('cms_lang.contact_catalogue.contactcat_sub_info', $language) ?></div>
								</div>
								<div class="col-lg-6">
									<div class="form-row mb15">
										<label class="control-label text-left">
											<span><?php echo translate('cms_lang.contact_catalogue.contactcat_create_title', $language) ?> <b class="text-danger">(*)</b></span>
										</label>
										<input type="text" name="title" value="<?php echo (isset($contact_catalogue['title']) ? $contact_catalogue['title'] : '') ?>" class="form-control title" placeholder="<?php echo translate('cms_lang.contact_catalogue.contactcat_description', $language) ?>" id="title" autocomplete="off">
									</div>

									<div class="form-row">
										<label class="control-label text-left">
											<span>Từ khóa<b class="text-danger">(*)</b></span>
										</label>
										<input type="text" name="keyword" value="<?php echo (isset($contact_catalogue['keyword']) ? $contact_catalogue['keyword'] : '') ?>" class="form-control keyword" placeholder="Nhập vào từ khóa..." id="keyword" autocomplete="off">
										<input type="hidden" name="keyword_original" value="<?php echo (isset($contact_catalogue['keyword']) ? $contact_catalogue['keyword'] : '') ?>" class="form-control keyword_original" placeholder="Nhập vào từ khóa..." id="keyword_original" autocomplete="off">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-row">
										<label class="control-label text-left">
											<span><?php echo translate('cms_lang.contact_catalogue.contactcat_display_des', $language) ?></b></span>
										</label>
										<div class="ct-form-container clearfix">
											<div class="block clearfix">
												<div class="i-checks mr30" style="width:100%;">
													<span style="color:#000;" class="uk-flex uk-flex-middle">
													<?php $publish = (isset($contact_catalogue['publish']) ? "checked" : 'no-publish') ?> 
														<input type="radio" name="publish" value="1" checked="<?php echo $publish ?>" class="" id="publish" style="margin-top:0;margin-right:10px;">
														<label for="publish" style="margin:0;cursor:pointer;"><?php echo translate('cms_lang.contact_catalogue.contactcat_display', $language) ?></label>
													</span>
												</div>
											</div>
											<div class="block clearfix">
												<div class="i-checks" style="width:100%;">
													<span style="color:#000;" class="uk-flex uk-flex-middle"> 
														<input type="radio" name="publish" value="0" class="" id="<?php echo $publish ?>" style="margin-top:0;margin-right:10px;">
														
														<label for="no-publish" style="margin:0;cursor:pointer;"><?php echo translate('cms_lang.contact_catalogue.contactcat_off', $language) ?></label>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="toolbox action clearfix">
									<div class="uk-flex uk-flex-middle uk-button pull-right">
										<button class="btn btn-primary btn-sm ct-button" name="create" value="delete" type="submit"><?php echo translate('cms_lang.contact_catalogue.contactcat_save', $language) ?></button>
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