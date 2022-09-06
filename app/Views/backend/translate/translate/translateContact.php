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
													<span>Tên NHóm Hiển Thị <b class="text-danger">(*)</b></span>
												</label>
												<input type="text" name="" value="<?php echo $object['title'] ?>" class="form-control title" placeholder="Nhập vào tên nhóm liên hệ..." id="title" autocomplete="off" disabled>
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
														<span>Tên NHóm Hiển Thị <b class="text-danger">(*)</b></span>
													</label>
													<input type="text" name="title" value="<?php echo isset($dataTrans['title']) ? $dataTrans['title'] : '' ?>" class="form-control title" placeholder="Nhập vào tên nhóm liên hệ..." id="title" autocomplete="off" >
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
