
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
			<div class="lable-language">Tiếng Việt</div>
			<div class=" ibox-content tv  ">
						<div class="row ">
							<div class="col-lg-12">
								<div class="upload-list" <?php echo (isset($object))?'':'style="display:none"' ?> style="padding:5px;">
									<div class="row"> 
										<ul id="" class="clearfix sortui">
											<?php if(isset($object) && is_array($object) && count($object)){ ?>
											<?php foreach($object as $key => $val){ ?>
												<script type="text/javascript">
													var k = <?php echo $key+1 ?>;
												</script>
											 <li class="tv-block ui-state-default translate pd-20">
												<div class="tv-slide-container">
													<div class="col-lg-5">
														<div class="thumb tv">
															<span class="image img-cover tv">
																<img src="<?php echo isset($object[$key]['image'])? $object[$key]['image']: '' ?>" alt="" /> 
																<input type="hidden" value="<?php echo isset($object[$key]['image'])? $object[$key]['image']: '' ?>" name="object[<?php echo $key ?>][image]" />
															</span>
														</div>
													</div>
													<div class="col-lg-7">
														<div class="tabs-container tv">
															<div class="tab-content">
																<div  class="tab-0 tab-pane active">
																		<div class="row mb5 ">
																			<label>URL</label>
																			<input  placeholder="URL..." type="text"  class="form-control m-b" name="data[<?php echo $key ?>][url]" value="<?php echo isset($object[$key]['url'])? $object[$key]['url']: '' ?>" disabled >
																		</div>
																		<div class="row ">
																			<?php  $title= isset($object[$key]['title'])? $object[$key]['title']: '' ?>
																			<label>Tiêu đề</label>
																			<textarea disabled  placeholder="Tên Slide..."  class="form-control m-b"  name="data[<?php echo $key ?>][title]"><?php echo $title  ?></textarea>
																		</div>
																
																		<div class="row mb5">
																			<div class="form-row ">
																				<label>Mô tả</label>
																				<input disabled  placeholder="Mô tả..." type="text"  class="form-control m-b" name="data[<?php echo $key ?>][description]" value="<?php echo isset($object[$key]['description'])? $object[$key]['description']: ''; ?>">
																			</div>
																		</div>
																		<div class="row mb18 ">
																			<div class="form-row ">
																				<?php $content = isset($object[$key]['content'])? $object[$key]['content']: '' ?>
																				<label>Nội dung</label>
																				<textarea disabled  placeholder="Nội dung..."  class="form-control m-b"   name="data[<?php echo $key ?>][content]"><?php echo $content?></textarea>
																			</div>
																			
																		</div>
																	
																</div>
															</div>

														</div>
													</div>
												</div>
											</li>
        
											<?php }}   ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
		</div>
		<form method="post" action="" class="form-horizontal box">
			<div class="col-lg-6 clearfix">
				<?php 
					$text = '';
					if ($language == 'en'){
						$text = 'Tiếng Anh';
					}else{
						if ($language == 'jp')
							$text = 'Tiếng Nhật';
					}

				 ?>
				<div class="lable-language"> <?php echo $text ?></div>
				<div class="ibox-content tv">
						<?php
							
							$dataTrans = [];
							if(isset($_POST['dataTrans'])){
								$dataTrans = $_POST['dataTrans'];
							}else if(isset($slide_translate)){
								$dataTrans = $value;
							}
							
						 ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="upload-list" <?php echo (isset($object))?'':'style="display:none"' ?> style="padding:5px;">
									<div class="row "> 
										<ul id="" class="clearfix sortui">
											<?php if(isset($object) && is_array($object) && count($object)){ ?>
											<?php foreach($object as $key => $val){ ?>
												<li class="tv-block ui-state-default pd-20">
													<div class="tv-slide-container clearfix">
														<div class="col-lg-12">
															<div class="tabs-container tv">
																<div class="tab-content">
																			<div class="row mb5">
																				<label>URL</label>
																				<input  placeholder="Tên Slide..." type="text"  class="form-control m-b" name="dataTrans[<?php echo $key ?>][url]" value="<?php echo isset($value[$key]['url'])? $value[$key]['url']: '' ?>" >
																			</div>
																			<div class="row ">
																				<?php  $url=  isset($value[$key]['title'])? $value[$key]['title']: '' ?>
																				<label>Tiêu đề</label>
																				<textarea  placeholder="Title..."  class="form-control m-b"  name="dataTrans[<?php echo $key ?>][title]"><?php echo $url  ?></textarea>
																			</div>
																		
																	
																	
																			<div class="row mb5">
																				<div class="form-row">
																					<label>Mô tả</label>
																					<input  placeholder="Mô tả..." type="text"  class="form-control m-b" name="dataTrans[<?php echo $key ?>][description]" value="<?php echo isset($value[$key]['description'])? $value[$key]['description']: '' ?>">

																				</div>
																			</div>
																			<div class="row mb18">
																				<div class="form-row">
																					<?php $content =  isset($value[$key]['content'])? $value[$key]['content']: '' ?>
																					<label>Nội dung</label>
																					<textarea  placeholder="Nội dung..."  class="form-control m-b"   name="dataTrans[<?php echo $key ?>][content]"><?php echo $content?></textarea>
																				</div>
																				
																			
																	</div>
																</div>
															</div>
														</div>
													</div>
												</li>
        
											<?php }}   ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>

				
				<button type="submit" name="create" value="create" class="btn btn-primary block m-b pull-right">Lưu</button>
			</div>
		</form>

			
	</div>
</div>
