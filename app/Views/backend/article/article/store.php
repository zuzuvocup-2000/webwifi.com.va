<?php
    helper('form', 'data');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $get_catalogue = check_type_canonical($language);
    if($get_catalogue['content'] == 'silo'){
    	$class = 'get_catalogue';
    }else{
    	$class = '';
    }
?>
<style>
	.sort-slide .show-image {
	    display: none;
	    position: absolute;
	    top: 50%;
	    transform: translateY(-50%);
	    text-align: center;
	    color: #fff;
	    width: 100%;
	    font-size: 15px;
	}

	.sort-slide .thumb:hover .show-image {
	    display: block;
	}
</style>
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
									<?php echo form_input('title', validate_input(set_value('title', (isset($article['title'])) ? $article['title'] : '')), 'class="form-control '.(($method == 'create') ? 'title' : '').'" placeholder="" id="title" autocomplete="off"'); ?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row form-description">
									<div class="uk-flex uk-flex-middle uk-flex-space-between">
										<label class="control-label text-left">
											<span><?php echo translate('cms_lang.post.post_description', $language) ?></span>
										</label>
										<a href="" title="" data-target="description" class="uploadMultiImage"><?php echo translate('cms_lang.post.post_upload', $language) ?></a>
									</div>
									<?php echo form_textarea('description', htmlspecialchars_decode(html_entity_decode(set_value('description', (isset($article['description'])) ? $article['description'] : ''))), 'class="form-control ck-editor" id="description" placeholder="" autocomplete="off"');?>

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
										<a href="" title="" data-target="content" class="uploadMultiImage"><?php echo translate('cms_lang.post.post_upload', $language) ?></a>
									</div>
									<?php echo form_textarea('content', htmlspecialchars_decode(html_entity_decode(set_value('content', (isset($article['content'])) ? $article['content'] : ''))), 'class="form-control ck-editor" id="content" placeholder="" autocomplete="off"');?>
								</div>
								<div class="uk-flex uk-flex-middle uk-flex-space-between">
									<label class="control-label text-left ">
										<span>Nội dung mở rộng</span>
									</label>
									<a href="" title="" class="add-attr" onclick="return false;">Thêm nội dung +</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ibox">
					<div class="row" id="sortable-view">
					    <div class="col-lg-12 ui-sortable attr-more">
					    	<?php if(isset($article['sub_title']) && is_array($article['sub_title']) && count($article['sub_title'])){ ?>
							<?php foreach ($article['sub_title'] as $key => $value) {?>
								<?php $id = slug($value) ?>
						        <div class="ibox desc-more" style="opacity: 1;">
						            <div class="ibox-title ui-sortable-handle ">
						            	<div class="uk-flex uk-flex-middle row">
							                <div class="col-lg-8">
												<input type="text" name="sub_content[title][]" class="form-control" value="<?php echo $value ?>" placeholder="Tiêu đề">
											</div>
											<div class="col-lg-4">
												<div class="uk-flex uk-flex-middle uk-flex-space-between">
													<a href="" title="" data-target="<?php echo $id ?>" class="uploadMultiImage">Upload hình ảnh</a>
									                <div class="ibox-tools">
									                    <a class="collapse-link ui-sortable">
									                        <i class="fa fa-chevron-up"></i>
									                    </a>
									                    <a class="close-link">
									                        <i class="fa fa-times"></i>
									                    </a>
									                </div>
												</div>
											</div>

						            	</div>
						            </div>
						            <div class="ibox-content" style="">
						            	<div class="row">
							                <div class="col-lg-12" >
							                	<textarea name="sub_content[description][]" class="form-control ck-editor" id="<?php echo $id ?>" placeholder="Mô tả"><?php echo $article['sub_content'][$key] ?></textarea>
											</div>
										</div>
						            </div>
						        </div>
					        <?php }} ?>
					    </div>
					</div>
				</div>

				<div class="ibox mb20 album">
					<div class="ibox-title">
						<div class="uk-flex uk-flex-middle uk-flex-space-between">
							<h5><?php echo translate('cms_lang.post.post_img', $language) ?> </h5>

							<div class="uk-flex uk-flex-middle uk-flex-space-between">
								<!-- <form class="js_upload_now" action="" method="post" enctype="multipart/form-data">
									<input data-result="" class="m-r " type="file" name="a" multiple>
									<input type="submit" name="abx" value="Add">
								</form> -->
								<div class="edit">
									<a onclick="BrowseServerAlbumArticle($(this));return false;" href="" title="" class="upload-picture"><?php echo translate('cms_lang.post.post_upload', $language) ?></a>
								</div>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<?php
							if(isset($_POST['album'])){
								$album = $_POST['album'];
							}else if(isset($article)){
								$album = json_decode($article['album'], TRUE);
							}

							if(isset($_POST['album_title'])){
								$album_title = $_POST['album_title'];
							}else if(isset($article)){
								$album_title = json_decode($article['album_title'], TRUE);
							}


						 ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="click-to-upload" <?php echo (isset($album))?'style="display:none"':'' ?>>
									<div class="icon">
										<a type="button" class="upload-picture" onclick="BrowseServerAlbumArticle($(this));return false;">
											<svg style="width:80px;height:80px;fill: #d3dbe2;margin-bottom: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><path d="M80 57.6l-4-18.7v-23.9c0-1.1-.9-2-2-2h-3.5l-1.1-5.4c-.3-1.1-1.4-1.8-2.4-1.6l-32.6 7h-27.4c-1.1 0-2 .9-2 2v4.3l-3.4.7c-1.1.2-1.8 1.3-1.5 2.4l5 23.4v20.2c0 1.1.9 2 2 2h2.7l.9 4.4c.2.9 1 1.6 2 1.6h.4l27.9-6h33c1.1 0 2-.9 2-2v-5.5l2.4-.5c1.1-.2 1.8-1.3 1.6-2.4zm-75-21.5l-3-14.1 3-.6v14.7zm62.4-28.1l1.1 5h-24.5l23.4-5zm-54.8 64l-.8-4h19.6l-18.8 4zm37.7-6h-43.3v-51h67v51h-23.7zm25.7-7.5v-9.9l2 9.4-2 .5zm-52-21.5c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5zm0-8c-1.7 0-3 1.3-3 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3zm-13-10v43h59v-43h-59zm57 2v24.1l-12.8-12.8c-3-3-7.9-3-11 0l-13.3 13.2-.1-.1c-1.1-1.1-2.5-1.7-4.1-1.7-1.5 0-3 .6-4.1 1.7l-9.6 9.8v-34.2h55zm-55 39v-2l11.1-11.2c1.4-1.4 3.9-1.4 5.3 0l9.7 9.7c-5.2 1.3-9 2.4-9.4 2.5l-3.7 1h-13zm55 0h-34.2c7.1-2 23.2-5.9 33-5.9l1.2-.1v6zm-1.3-7.9c-7.2 0-17.4 2-25.3 3.9l-9.1-9.1 13.3-13.3c2.2-2.2 5.9-2.2 8.1 0l14.3 14.3v4.1l-1.3.1z"></path></svg>
										</a>
									</div>
									<div class="small-text"><?php echo translate('cms_lang.post.post_img_content', $language) ?></div>
								</div>
								<div class="upload-list" <?php echo (isset($album))?'':'style="display:none"' ?> style="padding:5px;">
									<div class="row">
										<ul id="sortable" class="clearfix data-album sortui sort-slide">
											<?php if(isset($album) && is_array($album) && count($album)){ ?>
											<?php foreach($album as $key => $val){ ?>
												<li class="ui-state-default select_album_<?php echo $key ?>">
													<div class="thumb">
														<span class="image img-scaledown">
															<img src="<?php echo $val; ?>" alt="" /> 
															<input type="hidden" value="<?php echo $val; ?>" name="album[]" />
															<input type="hidden" value="<?php echo isset($album_title[$key]) ? $album_title[$key] : ''; ?>" class="value-data-banner" name="album_title[]" />
														</span>
														<div class="overlay"></div>
														<div class="delete-image"><i class="fa fa-trash" aria-hidden="true"></i></div>
														<div class="show-image" data-toggle="modal" data-target="#show_detail_image" data-class=".select_album_<?php echo $key ?>" ><i class="fa fa-search-plus" aria-hidden="true"></i></div>
													</div>
												</li>
											<?php }} ?>
										</ul>
									</div>
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
									$metaTitle = (isset($_POST['meta_title'])) ? $_POST['meta_title'] : ((isset($article['meta_title']) && $article['meta_title'] != '') ? $article['meta_title'] : translate('cms_lang.post.post_seo_validate_title', $language)) ;
									$googleLink = (isset($_POST['canonical'])) ? $_POST['canonical'] : ((isset($article['canonical']) && $article['canonical'] != '') ? BASE_URL.$article['canonical'].HTSUFFIX : BASE_URL.'duong-dan-website'.HTSUFFIX) ;
									$metaDescription = (isset($_POST['meta_description'])) ? $_POST['meta_description'] : ((isset($article['meta_description']) && $article['meta_description'] != '') ? $article['meta_description'] : translate('cms_lang.post.post_seo_validate_description', $language)) ;
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
										<?php echo form_input('meta_title', htmlspecialchars_decode(html_entity_decode(set_value('meta_title', (isset($article['meta_title'])) ? $article['meta_title'] : ''))), 'class="form-control meta-title" placeholder="" autocomplete="off"');?>
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
										<?php echo form_textarea('meta_description', set_value('meta_description', (isset($article['meta_description'])) ? $article['meta_description'] : ''), 'class="form-control meta-description" id="seoDescription" placeholder="" autocomplete="off"');?>
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
												<?php echo form_input('canonical', htmlspecialchars_decode(html_entity_decode(set_value('canonical', (isset($article['canonical'])) ? $article['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off" data-flag="0" ');?>
												<?php echo form_hidden('original_canonical', htmlspecialchars_decode(html_entity_decode(set_value('original_canonical', (isset($article['canonical'])) ? $article['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off"');?>

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
						<h5><?php echo translate('cms_lang.post.post_select_catalogue', $language) ?></h5>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-row mb10">
									<small class="text-danger"><?php echo translate('cms_lang.post.post_select_warning', $language) ?></small>
								</div>
								<div class="form-row">
									<?php echo form_dropdown('catalogueid', $dropdown, set_value('catalogueid', (isset($article['catalogueid'])) ? $article['catalogueid'] : ''), 'class="form-control m-b select2 '.($method == 'create' ? $class : '').'" data-module="'.$module.'"');?>
								</div>

								<script>
									var catalogue = '<?php echo (isset($_POST['catalogue'])) ? json_encode($_POST['catalogue']) : ((isset($article['catalogue']) && $article['catalogue'] != null) ? $article['catalogue'] : '');  ?>';
								</script>
								<div class="form-row mt20">
										<label class="control-label text-left">
											<span><?php echo translate('cms_lang.post.post_sub_cat', $language) ?></span>
										</label>

										<div class="form-row">
											<?php echo form_dropdown('catalogue[]', '', NULL, 'class="form-control selectMultiple" multiple="multiple" data-title="Nhập 2 kí tự để tìm kiếm..."  style="width: 100%;" data-join="'.$module.'_translate" data-module="'.$module.'_catalogue" data-select="title"'); ?>
										</div>
									</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ibox mb20 ">
					<div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
						<h5 class="choose-image" style="cursor: pointer;margin:0;">Template hiển thị Website</h5>
					</div>
					<div class="ibox-content">
						<div class="form-row">
							<div class="block clearfix">
								<div class="i-checks mr30" style="width:100%;">
									<span style="color:#000;" class="uk-flex uk-flex-middle">
										<?php echo form_radio('template', set_value('template', 'frontend/article/article/index'), ((isset($_POST['template']) && $_POST['template'] == 'frontend/article/article/index' || (isset($article['template']) && $article['template'] == 'frontend/article/article/index')) ? true : (!isset($_POST['template']) ? true : false)),'class=""  id="normal"  style="margin-top:0;margin-right:10px;" '); ?>
										<label for="normal" style="margin:0;cursor:pointer;">Giao diện mặc định</label>
									</span>
								</div>
							</div>
							<div class="block clearfix">
								<div class="i-checks" style="width:100%;">
									<span style="color:#000;" class="uk-flex uk-flex-middle">
										<?php echo form_radio('template', set_value('template', 'frontend/article/article/chuongtrinh'), ((isset($_POST['template']) && $_POST['template'] == 'frontend/article/article/chuongtrinh' || (isset($article['template']) && $article['template'] == 'frontend/article/article/chuongtrinh')) ? true : false),'class=""   id="learn" style="margin-top:0;margin-right:10px;" '); ?>

										<label for="learn" style="margin:0;cursor:pointer;">Giao diện Giới thiệu</label>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ibox mb20 hidden">
					<div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
						<h5 >Thông tin Tuyển dụng</h5>
					</div>
					<div class="ibox-content">
						<div class="form-row mb10">
							<label>Số lượng</label>
							<?php echo form_input('info[sl]', set_value('info[sl]', (isset($article['info']['sl']) ? $article['info']['sl'] : '')), 'class="form-control "  placeholder="" autocomplete="off" ');?>
						</div>
						<div class="form-row mb10">
							<label>Địa điểm</label>
							<?php echo form_input('info[address]', set_value('info[address]', (isset($article['info']['address']) ? $article['info']['address'] : '')), 'class="form-control "  placeholder="" autocomplete="off" ');?>
						</div>
						<div class="form-row mb10">
							<label>Hạn nộp</label>
							<?php echo form_input('info[time]', set_value('info[time]', (isset($article['info']['time']) ? $article['info']['time'] : '')), 'class="form-control "  placeholder="" autocomplete="off" ');?>
						</div>
					</div>
				</div>
				<div class="ibox mb20">
					<div class="ibox-title">
						<h5 class="choose-image" style="cursor: pointer;"><?php echo translate('cms_lang.post.post_avatar', $language) ?> </h5>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-row">
									<div class="avatar" style="cursor: pointer;"><img src="<?php echo (isset($_POST['image'])) ? $_POST['image'] : ((isset($article['image']) && $article['image'] != '') ? $article['image'] : 'public/not-found.png') ?>" class="img-thumbnail" alt=""></div>
									<?php echo form_input('image', htmlspecialchars_decode(html_entity_decode(set_value('image', (isset($article['image'])) ? $article['image'] : ''))), 'class="form-control " placeholder="Đường dẫn của ảnh"  id="imageTxt"  autocomplete="off" style="display:none;" ');?>
								</div>
							</div>
						</div>
					</div>
				</div>
                <div class="ibox mb20">
                    <div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
						<h5 class="choose-image" style="cursor: pointer;margin:0;">Video Iframe</h5>
					</div>
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row form-description">
                                    <?php echo form_textarea('video', htmlspecialchars_decode(html_entity_decode(set_value('video', (isset($article['video'])) ? $article['video'] : ''))), 'class="form-control"  placeholder="" autocomplete="off"');?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox mb20">
                    <div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
						<h5 class="choose-image" style="cursor: pointer;margin:0;">Sản phẩm liên kết</h5>
					</div>
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row form-description">
                                    <?php echo form_input('productid', htmlspecialchars_decode(html_entity_decode(set_value('productid', (isset($article['productid'])) ? $article['productid'] : ''))), 'class="form-control tagsinput"  placeholder="" autocomplete="off"');?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

				<div class="ibox mb20">
					<div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
						<h5 class="choose-image" style="cursor: pointer;margin:0;">Router</h5>
					</div>
					<div class="ibox-content">
						<div class="form-row">
							<div class="text-danger">Lưu ý: Chỉ dành cho lập trình viên</div>
							<?php echo form_input('router', set_value('router', (isset($article['router']) && $article['router'] != '') ? $article['router'] : '\App\Controllers\Frontend\Article\Article::index'), 'class="form-control router-display"  placeholder="" autocomplete="off" data-flag="0" ');?>
						</div>
					</div>
				</div>
				<div class="ibox mb20">
					<div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
						<h5 class="choose-image" style="cursor: pointer;margin:0;">Icon hiển thị </h5>
						<a href="" title="" data-target="image" class="uploadIcon">Upload hình ảnh</a>
					</div>
					<div class="ibox-content">
						<div class="form-row">
							<small class="text-danger">Chọn icon hoặc ảnh để hiển thị ra website</small>
							<?php echo form_input('icon', htmlspecialchars_decode(set_value('icon', (isset($article['icon'])) ? $article['icon'] : '')), 'class="form-control icon-display" placeholder="" autocomplete="off" data-flag="0" ');?>
						</div>
					</div>
				</div>
				<div class="ibox mb20">
					<div class="ibox-title">
						<h5>Chọn TAGS cho Bài viết </h5>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-row">
									<?php echo form_input('tags', validate_input(set_value('tags', (isset($tags)) ? $tags : '')), 'class="form-control tags tagsinput" placeholder="" id="tags" autocomplete="off"'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				

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
												<?php echo form_radio('publish', set_value('publish', 1), ((isset($_POST['publish']) && $_POST['publish'] == 1 || (isset($article['publish']) && $article['publish'] == 1)) ? true : (!isset($_POST['publish']) ? true : false)),'class=""  id="publish"  style="margin-top:0;margin-right:10px;" '); ?>
												<label for="publish" style="margin:0;cursor:pointer;"><?php echo translate('cms_lang.post.post_display_1', $language) ?></label>
											</span>
										</div>
									</div>
									<div class="block clearfix">
										<div class="i-checks" style="width:100%;">
											<span style="color:#000;" class="uk-flex uk-flex-middle">
												<?php echo form_radio('publish', set_value('publish', 0), ((isset($_POST['publish']) && $_POST['publish'] == 0 || (isset($article['publish']) && $article['publish'] == 0)) ? true : false),'class=""   id="no-publish" style="margin-top:0;margin-right:10px;" '); ?>

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
<div id="show_detail_image" class="modal fade va-general modal-banner" >
      <div class="modal-dialog modal-xl">
           <div class="modal-content">
                <div class="modal-header ">
                	<div class="uk-flex uk-flex-middle uk-flex-space-between">
	                    <h4 class="modal-title">Chi tiết ảnh</h4>
	                    <button type="button" class="close " data-dismiss="modal">&times;</button>
                	</div>
                </div>
                <div class="modal-body">
                	<form action="" class="form-horizontal-banner">
	                	<div class="form-group form-item-va uk-clearfix">
				            <label class="col-xs-4 control-label control-title-modal"  for="attachment-details-two-column-title">Đường dẫn ảnh</label>
				            <div class="col-xs-8"> <input type="text" id="attachment-details-two-column-title" placeholder="Đường dẫn ảnh..." name="title" class="form-control"> </div>
				        </div>
				        <div class="btn-question uk-clearfix mt20">
				        	<button class="btn btn-primary pull-right" type="submit">Lưu</button>
				        </div>
                	</form>
                </div>
           </div>
      </div>
 </div>
<script>
	
	$(document).on('click','.show-image', function(){
		let _this = $(this)
		get_data_image(_this)
		return false;
	});

	function get_data_image(_this){
		let data = _this.parents('.ui-state-default').find('.value-data-banner').val()
		console.log(data)
		let _class = _this.attr('data-class')
		
		$('.icon-change-image').removeAttr('disabled')
		if($(_class).is(':first-child') == true){
			$('.icon-change-image.left').attr('disabled', 'disabled')
		}
		if($(_class).is(':last-child') == true){
			$('.icon-change-image.right').attr('disabled', 'disabled')
		}
		$('.form-horizontal-banner').attr('data-target' , _class)
		$('.form-horizontal-banner')[0].reset();

		$('#attachment-details-two-column-title').val(data)
	}

	$(document).on('submit','.form-horizontal-banner', function(){
		let _this = $(this);
		let title = _this.find('#attachment-details-two-column-title').val()
		let _class = _this.attr('data-target')
		$(_class).find('.value-data-banner').val(title)
		toastr.success('Khởi tạo dữ liệu ảnh thành công','Thành công!');
		$('#show_detail_image').modal('hide');
		
		return false;
	})
</script>