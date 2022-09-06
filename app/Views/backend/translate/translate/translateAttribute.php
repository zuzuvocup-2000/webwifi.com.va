<?php  
    helper('form');
    $baseController = new App\Controllers\BaseController();
    $currentLanguage = $baseController->currentLanguage();
    $languageList = get_list_language(['currentLanguage' => $language]);
 	$currentText = (($currentLanguage == 'vi') ? $flag[1]['image']: (($currentLanguage == 'en') ? $flag[1]['image'] : ($currentLanguage == 'jp') ? $flag[2]['image'] : ''));
	 $text = (($language == 'vi') ? $flag[1]['image']: (($language == 'en') ? $flag[0]['image'] : (($language == 'jp') ? $flag[2]['image'] : '')));

?>

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Bản Dịch</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin'); ?>">Home</a>
			</li>
			
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
		
	<div class="row">
		<div class="col-lg-6  clearfix">
			
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
											<div class="text-center tv2">
												<span class="icon-flag img-cover tv"><img src="<?php echo getthumb($currentText); ?>" alt=""></span>
											</div>
											
											<div class="form-row">
												<label class="control-label text-left">
													<span>Tên Thuộc tính <b class="text-danger">(*)</b></span>
												</label>
												<input type="text" name="" value="<?php echo $object['title'] ?>" class="form-control title" placeholder="Nhập vào tên nhóm liên hệ..." id="title" autocomplete="off" disabled>
											</div>
											
									</div>
								</div>
								<div class="row mb15">
									<div class="col-lg-12">
											
											
											<div class="form-row">
												<label class="control-label text-left">
													<span>Mô tả <b class="text-danger">(*)</b></span>
												</label>
												<input type="text" name="" value="<?php echo $object['description'] ?>" class="form-control description" placeholder="Nhập vào tên giá trị..." id="description" autocomplete="off" disabled>
											</div>
											
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<?php  
											
											$googleLink = ((isset($object['canonical']) && $object['canonical'] != '') ? BASE_URL.$object['canonical'].HTSUFFIX : BASE_URL.'duong-dan-website'.HTSUFFIX) ;
											
										?>
										<div class="google">
											<div class="g-link1"><?php echo $googleLink ?></div>
												
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		
			</div>
		</div>
		<form method="post" action="" class="form-horizontal box">
			<div class="col-lg-6 clearfix">
				
				
				<div class="col-lg-12">
						<div class="ibox m0">
							<div class="ibox-content mt20">
								<div class="row mb15">
									<div class="col-lg-12">
										<div class="col-lg-12">
												<div class="text-center tv2">
													<span class="icon-flag img-cover tv"><img src="<?php echo getthumb($text); ?>" alt=""></span>
												</div>
												
												<div class="form-row">
													<label class="control-label text-left">
														<span>Tên thuộc tính <b class="text-danger">(*)</b></span>
													</label>
													<input type="text" name="title" value="<?php echo isset($dataTrans['title']) ? $dataTrans['title'] : '' ?>" class="form-control title" placeholder="Nhập vào tên thuộc tính ..." id="title" autocomplete="off" >
												</div>
											
											
										</div>
									</div>
								</div>
								<div class="row mb15">
									<div class="col-lg-12">
										<div class="col-lg-12">
											<div class="form-row">
												<label class="control-label text-left">
													<span>Mô tả <b class="text-danger">(*)</b></span>
												</label>
												<input type="text" name="description" value="<?php echo $dataTrans['description'] ?>" class="form-control description" placeholder="Nhập vào tên giá trị..." id="description" autocomplete="off" >
											</div>
										</div>
											
									</div>
								</div>
										<div class="ibox-title">
											<div class="uk-flex uk-flex-middle uk-flex-space-between">
												
												
												<div class="uk-flex uk-flex-middle uk-flex-space-between">
													<div class="edit">
														<a href="#" class="edit-seo">Chỉnh sửa đường dẫn</a>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<?php  
													
													$googleLink = (isset($_POST['canonical'])) ? $_POST['canonical'] : ((isset($article['canonical']) && $article['canonical'] != '') ? BASE_URL.$article['canonical'].HTSUFFIX : BASE_URL.'duong-dan-website'.HTSUFFIX) ;
													
												?>
												<div class="google">
													<div class="g-link"><?php echo $googleLink ?></div>
													
												</div>
											</div>
										</div>
										
										<div class="seo-group hidden">
										
										
											<div class="row mb15">
												<div class="col-lg-12">
													<div class="form-row">
														<div class="uk-flex uk-flex-middle uk-flex-space-between">
															<label class="control-label ">
																<span>Đường dẫn <b class="text-danger">(*)</b></span>
															</label>
														</div>
														<div class="outer">
															<div class="uk-flex uk-flex-middle">
																<div class="base-url"><?php echo base_url(); ?></div>
																<?php echo form_input('canonical', htmlspecialchars_decode(html_entity_decode(set_value('canonical', (isset($article['canonical'])) ? $article['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off" data-flag="0" ');?>
																<?php echo form_hidden('original_canonical', htmlspecialchars_decode(html_entity_decode(set_value('canonical', (isset($article['canonical'])) ? $article['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off"');?>

															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									
							</div>
						</div>
				</div>

				
				<button type="submit" name="create" value="create" class="btn btn-primary block m-b pull-right mr10">Lưu</button>
			</div>
		</form>

			
	</div>
</div>
