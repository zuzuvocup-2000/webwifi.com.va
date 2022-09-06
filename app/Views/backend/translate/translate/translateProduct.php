<script>
	var attribute_cat = '';
</script>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Bản Dịch</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin'); ?>">Home</a>
			</li>
			<li class="active"><strong>Dịch Sản phẩm</strong></li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="box-body">
			<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
		</div><!-- /.box-body -->
	</div>
	<div class="row">
		<div class="col-lg-6 clearfix">
			<div class="ibox mb20">
				<div class="ibox-title" style="padding: 9px 15px 0px;">
					<div class="uk-flex uk-flex-middle uk-flex-space-between">
						<h5>Thông tin cơ bản</h5>
						
					</div>
				</div>
				<div class="ibox-content">
					<div class="row mb15">
						<div class="col-lg-12 mb15">
							<div class="form-row">
								<label class="control-label text-left">
									<span>Tiêu đề danh mục <b class="text-danger">(*)</b></span>
								</label>
								<?php echo form_input('title', validate_input(set_value('title', (isset($object['title'])) ? $object['title'] : '')), 'class="form-control title" placeholder="" autocomplete="off"'); ?>
							</div>
						</div>
						<div class="col-lg-12">
							<label class="control-label ">
								<span>Xuất xứ</span>
							</label>
							<?php echo form_input('made_in', set_value('made_in', (isset($object['made_in'])) ? $object['made_in'] : ''), 'class="form-control" placeholder="Việt Nam" autocomplete="off"'); ?>
						</div>
					</div>
					<div class="row mb15">
						<div class="col-lg-12">
							<div class="form-row form-description">
								<div class="uk-flex uk-flex-middle uk-flex-space-between">
									<label class="control-label text-left">
										<span>Mô tả ngắn</span>
									</label>
									<a href="" title="" data-target="description" class="uploadMultiImage">Upload hình ảnh</a>
								</div>
								<?php echo form_textarea('description', htmlspecialchars_decode(html_entity_decode(set_value('description', (isset($object['description'])) ? base64_decode($object['description']) : ''))), 'class="form-control ck-editor" id="description" placeholder="" autocomplete="off"');?>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-row">
								<div class="uk-flex uk-flex-middle uk-flex-space-between">
									<label class="control-label text-left">
										<span>Nội dung</span>
									</label>
								</div>
								<?php echo form_textarea('content', htmlspecialchars_decode(html_entity_decode(set_value('content', (isset($object['content'])) ? base64_decode($object['content']) : ''))), 'class="form-control ck-editor" id="content" placeholder="" autocomplete="off"');?>
							</div>
						</div>
					</div>
					<div class="row">
						<?php if(isset($object['sub_title']) && is_array($object['sub_title']) && count($object['sub_title'])){ ?>
						<?php foreach ($object['sub_title'] as $key => $value) {?>
							<?php $id = slug($value) ?>
							<div class="col-lg-12 m-b desc-more">
								<div class="row m-b">
									<div class="col-lg-8">
										<input type="text" name="sub_content[title][]" class="form-control" value="<?php echo $value ?>" placeholder="Tiêu đề">
									</div>
									<div class="col-lg-4">
										<a href="" title="" data-target="<?php echo $id ?>" class="uploadMultiImage pull-right">Upload hình ảnh</a>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12" >
										<textarea  name="sub_content[description][]" class="form-control ck-editor" id="<?php echo $id ?>" placeholder="Mô tả"><?php echo $object['sub_content'][$key] ?></textarea>
									</div>
								</div>
							</div>
						<?php }} ?>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6 clearfix">
			<form method="post" action="" class="form-horizontal box" >
				<div class="ibox mb20">
					<div class="ibox-title" style="padding: 9px 15px 0px;">
						<div class="uk-flex uk-flex-middle uk-flex-space-between">
							<h5>Thông tin cơ bản <small class="text-danger">Điền đầy đủ các thông tin được mô tả dưới đây</small></h5>
							<div class="ibox-tools">
								<button type="submit" name="create" value="create" class="btn btn-primary block full-width m-b">Lưu</button>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row mb15">
							<div class="col-lg-12 mb15">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Tiêu đề danh mục <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('title', validate_input(set_value('title', (isset($translate['title'])) ? $translate['title'] : '')), 'class="form-control title" placeholder="" id="title" autocomplete="off"'); ?>
								</div>
							</div>
							<div class="col-lg-12">
								<label class="control-label ">
									<span>Xuất xứ</span>
								</label>
								<?php echo form_input('made_in', set_value('made_in', (isset($translate['made_in'])) ? $translate['made_in'] : ''), 'class="form-control" placeholder="Việt Nam" id="made_in" autocomplete="off"'); ?>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row form-description">
									<div class="uk-flex uk-flex-middle uk-flex-space-between">
										<label class="control-label text-left">
											<span>Mô tả ngắn</span>
										</label>
										<a href="" title="" data-target="description_translate" class="uploadMultiImage">Upload hình ảnh</a>
									</div>
									<?php echo form_textarea('description', htmlspecialchars_decode(html_entity_decode(set_value('description', (isset($translate['description'])) ? base64_decode($translate['description']) : ''))), 'class="form-control ck-editor" id="description_translate" placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-12 mb15">
								<div class="form-row">
									<div class="uk-flex uk-flex-middle uk-flex-space-between">
										<label class="control-label text-left">
											<span>Nội dung</span>
										</label>
										<a href="" title="" data-target="content_translate" class="uploadMultiImage">Upload hình ảnh</a>
									</div>
									<?php echo form_textarea('content', htmlspecialchars_decode(html_entity_decode(set_value('content', (isset($translate['content'])) ? base64_decode($translate['content']) : ''))), 'class="form-control ck-editor" id="content_translate" placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-12">	
								<div class="uk-flex uk-flex-middle uk-flex-space-between">
									<label class="control-label text-left ">
										<span>Nội dung mở rộng</span>
									</label>
									<a href="" title="" class="add-attr" onclick="return false;">Thêm nội dung +</a>
								</div>
							</div>
						</div>
						<div class="row attr-more">
							<?php if(isset($translate['sub_title']) && is_array($translate['sub_title']) && count($translate['sub_title'])){ ?>
							<?php foreach ($translate['sub_title'] as $key => $value) {?>
								<?php $id = slug($value) ?>
								<div class="col-lg-12 m-b desc-more">
									<div class="row m-b">
										<div class="col-lg-8">
											<input type="text" name="sub_content[title][]" class="form-control" value="<?php echo $value ?>" placeholder="Tiêu đề">
										</div>
										<div class="col-lg-4">
											<div class="uk-flex uk-flex-middle uk-flex-space-between">
												<a href="" title="" data-target="<?php echo $id ?>" class="uploadMultiImage">Upload hình ảnh</a>
												<button class="btn btn-danger delete-attr" type="button"><i class="fa fa-trash"></i></button>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12" >
											<textarea name="sub_content[description][]" class="form-control ck-editor" id="<?php echo $id ?>" placeholder="Mô tả"><?php echo $translate['sub_content'][$key] ?></textarea>
										</div>
									</div>
								</div>
							<?php }} ?>
						</div>
					</div>
				</div>

				<div class="ibox ibox-seo mb20">
					<div class="ibox-title">
						<div class="uk-flex uk-flex-middle uk-flex-space-between">
							<h5>Tối ưu SEO <small class="text-danger">Thiết lập các thẻ mô tả giúp khách hàng dễ dàng tìm thấy bạn.</small></h5>
							
							<div class="uk-flex uk-flex-middle uk-flex-space-between">
								<div class="edit">
									<a href="#" class="edit-seo">Chỉnh sửa SEO</a>
								</div>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<?php  
									$metaTitle = (isset($_POST['meta_title'])) ? $_POST['meta_title'] : ((isset($translate['meta_title']) && $translate['meta_title'] != '') ? $translate['meta_title'] : 'Bạn chưa nhập tiêu đề SEO cho bài viết') ;
									$googleLink = (isset($_POST['canonical'])) ? $_POST['canonical'] : ((isset($translate['canonical']) && $translate['canonical'] != '') ? BASE_URL.$translate['canonical'].HTSUFFIX : BASE_URL.'duong-dan-website'.HTSUFFIX) ;
									$metaDescription = (isset($_POST['meta_description'])) ? $_POST['meta_description'] : ((isset($translate['meta_description']) && $translate['meta_description'] != '') ? $translate['meta_description'] : 'Bạn Chưa nhập mô tả SEO cho bài viết') ;
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
												<span>Tiêu đề SEO</span>
											</label>
											<span style="color:#9fafba;"><span id="titleCount">0</span> trên 70 ký tự</span>
										</div>
										<?php echo form_input('meta_title', htmlspecialchars_decode(html_entity_decode(set_value('meta_title', (isset($translate['meta_title'])) ? $translate['meta_title'] : ''))), 'class="form-control meta-title" placeholder="" autocomplete="off"');?>
									</div>
								</div>
							</div>
							<div class="row mb15">
								<div class="col-lg-12">
									<div class="form-row">
										<div class="uk-flex uk-flex-middle uk-flex-space-between">
											<label class="control-label ">
												<span>Mô tả SEO</span>
											</label>
											<span style="color:#9fafba;"><span id="descriptionCount">0</span> trên 320 ký tự</span>
										</div>
										<?php echo form_textarea('meta_description', set_value('meta_description', (isset($translate['meta_description'])) ? $translate['meta_description'] : ''), 'class="form-control meta-description" id="seoDescription" placeholder="" autocomplete="off"');?>
									</div>
								</div>
							</div>
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
												<?php echo form_input('canonical', htmlspecialchars_decode(html_entity_decode(set_value('canonical', (isset($translate['canonical'])) ? $translate['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off" data-flag="0" ');?>
												<?php echo form_hidden('original_canonical', htmlspecialchars_decode(html_entity_decode(set_value('canonical', (isset($translate['canonical'])) ? $translate['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off"');?>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					
					</div>
					
				</div>
				<button type="submit" name="create" value="create" class="btn btn-primary block m-b pull-right">Lưu</button>
			</form>
		</div>
		
	</div>
</div>

