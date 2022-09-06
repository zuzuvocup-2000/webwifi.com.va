<?php
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
?>
<style>
.sort-slide .ui-state-default:first-child,
	.sortui .ui-state-default {
    	width: calc(33.33% - 2px) !important;
	}
</style>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="box-body">
			<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : ''; ?>
		</div>
	</div>
	<script type="text/javascript">
		var k = 0;
	</script>
	<div class="row">
		<div class="col-lg-6 clearfix">
			<div class="ibox mb20">
				<div class="ibox-title" style="padding: 9px 15px 0px;">
					<div class="uk-flex uk-flex-middle uk-flex-space-between">
						<h5><?php echo translate('cms_lang.slide.information3', $language) ?> <small class="text-danger"><?php echo translate('cms_lang.slide.Note5', $language) ?></small></h5>
					</div>
				</div>
				<div class="ibox-content">
					<div class="row">
						<div class="col-lg-6 mb15">
							<div class="form-row">
								<label class="control-label text-left">
									<span><?php echo translate('cms_lang.slide.SlideGruopName', $language) ?><b class="text-danger">(*)</b></span>
								</label>
								<?php  echo form_input('title_catalogue', validate_input(set_value('title_catalogue', (isset($slide_catalogue['title'])) ? $slide_catalogue['title'] : '')), 'class="form-control title" readonly placeholder="" autocomplete="off"'); ?>
							</div>
						</div>
						<div class="col-lg-6 mb15">
							<div class="form-row">
								<label class="control-label text-left">
									<span><?php echo translate('cms_lang.slide.Keyword3', $language) ?><b class="text-danger">(*)</b></span>
								</label>
								<?php echo form_input('keyword_catalogue', validate_input(set_value('keyword_catalogue', (isset($slide_catalogue['keyword'])) ? $slide_catalogue['keyword'] : '')), 'class="form-control" readonly placeholder="" autocomplete="off"'); ?>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-row form-description">
								<div class="uk-flex uk-flex-middle uk-flex-space-between">
									<label class="control-label text-left">
										<span><?php echo translate('cms_lang.post_catalogue.postcat_description', $language) ?></span>
									</label>
								</div>
								<?php echo form_textarea('description_catalogue', htmlspecialchars_decode(html_entity_decode(set_value('description_catalogue', (isset($slide_catalogue['description'])) ? $slide_catalogue['description'] : ''))), 'class="form-control"  placeholder="" readonly autocomplete="off"');?>

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="ibox mb20 album">
				<div class="ibox-title">
					<div class="uk-flex uk-flex-middle uk-flex-space-between">
						<h5><?php echo translate('cms_lang.slide.ImageSlide', $language) ?> </h5>
					</div>
				</div>
				<div class="ibox-content">
					<?php
						$data = [];
						if(isset($_POST['album']) && is_array($_POST['album']) && count($_POST['album'])){
							foreach ($_POST['album'] as $key => $value) {
								$data[] = [
									'image' => $value,
								];
							}
						}else if(isset($slide)){
							$data = $slide;
						}
					 ?>
					<div class="row">
						<div class="col-lg-12">
							<div class="click-to-upload" <?php echo (isset($data) && is_array($data) && count($data))?'style="display:none"':'' ?>>
								<div class="icon">
									<a type="button" class="upload-picture" onclick="SelectBanner($(this));return false;">
										<svg style="width:80px;height:80px;fill: #d3dbe2;margin-bottom: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><path d="M80 57.6l-4-18.7v-23.9c0-1.1-.9-2-2-2h-3.5l-1.1-5.4c-.3-1.1-1.4-1.8-2.4-1.6l-32.6 7h-27.4c-1.1 0-2 .9-2 2v4.3l-3.4.7c-1.1.2-1.8 1.3-1.5 2.4l5 23.4v20.2c0 1.1.9 2 2 2h2.7l.9 4.4c.2.9 1 1.6 2 1.6h.4l27.9-6h33c1.1 0 2-.9 2-2v-5.5l2.4-.5c1.1-.2 1.8-1.3 1.6-2.4zm-75-21.5l-3-14.1 3-.6v14.7zm62.4-28.1l1.1 5h-24.5l23.4-5zm-54.8 64l-.8-4h19.6l-18.8 4zm37.7-6h-43.3v-51h67v51h-23.7zm25.7-7.5v-9.9l2 9.4-2 .5zm-52-21.5c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5zm0-8c-1.7 0-3 1.3-3 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3zm-13-10v43h59v-43h-59zm57 2v24.1l-12.8-12.8c-3-3-7.9-3-11 0l-13.3 13.2-.1-.1c-1.1-1.1-2.5-1.7-4.1-1.7-1.5 0-3 .6-4.1 1.7l-9.6 9.8v-34.2h55zm-55 39v-2l11.1-11.2c1.4-1.4 3.9-1.4 5.3 0l9.7 9.7c-5.2 1.3-9 2.4-9.4 2.5l-3.7 1h-13zm55 0h-34.2c7.1-2 23.2-5.9 33-5.9l1.2-.1v6zm-1.3-7.9c-7.2 0-17.4 2-25.3 3.9l-9.1-9.1 13.3-13.3c2.2-2.2 5.9-2.2 8.1 0l14.3 14.3v4.1l-1.3.1z"></path></svg>
									</a>
								</div>
								<div class="small-text"><?php echo translate('cms_lang.slide.post_img_content', $language) ?></div>
							</div>
							<?php $count = 0; ?>
							<script type="text/javascript">
								var count = <?php echo $count ?>;
							</script>
							<div class="upload-list" <?php echo (isset($data) && is_array($data) && count($data))?'':'style="display:none"' ?> style="padding:5px;">
								<div class="row"> 
									<ul  class="tv clearfix data-album sortui sort-slide">
										<?php 
										if(isset($data) && is_array($data) && count($data)){ 
											$_data['data'] = $data;
										?>
                                            <?php echo view('backend/dashboard/common/slideblock', $_data); ?>
                                      	<?php }  ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<form method="post" action="" class="form-horizontal box" >
			<div class="col-lg-6 clearfix">

				<div class="ibox mb20">
					<div class="ibox-title" style="padding: 9px 15px 0px;">
						<div class="uk-flex uk-flex-middle uk-flex-space-between">
							<h5><?php echo translate('cms_lang.slide.information3', $language) ?> <small class="text-danger"><?php echo translate('cms_lang.slide.Note5', $language) ?></small></h5>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12 mb15">
								<div class="form-row">
									<label class="control-label text-left">
										<span><?php echo translate('cms_lang.slide.SlideGruopName', $language) ?><b class="text-danger">(*)</b></span>
									</label>
									<?php  echo form_input('title_catalogue', validate_input(set_value('title_catalogue', (isset($slide_catalogue_translate['title'])) ? $slide_catalogue_translate['title'] : '')), 'class="form-control title" placeholder="" autocomplete="off"'); ?>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-row form-description">
									<div class="uk-flex uk-flex-middle uk-flex-space-between">
										<label class="control-label text-left">
											<span><?php echo translate('cms_lang.post_catalogue.postcat_description', $language) ?></span>
										</label>
									</div>
									<?php echo form_textarea('description_catalogue', htmlspecialchars_decode(html_entity_decode(set_value('description_catalogue', (isset($slide_catalogue_translate['description'])) ? $slide_catalogue_translate['description'] : ''))), 'class="form-control"  placeholder="" autocomplete="off"');?>

								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ibox mb20 album">
					<div class="ibox-title">
						<div class="uk-flex uk-flex-middle uk-flex-space-between">
							<h5><?php echo translate('cms_lang.slide.ImageSlide', $language) ?> </h5>
							<div class="uk-flex uk-flex-middle uk-flex-space-between">
								<div class="edit">
									<a onclick="SelectBanner($(this));return false;" href="" title="" class="upload-picture tv-button"><?php echo translate('cms_lang.slide.NewSlide1', $language) ?></a>
								</div>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<?php
							$data = [];
							if(isset($_POST['album']) && is_array($_POST['album']) && count($_POST['album'])){
								foreach ($_POST['album'] as $key => $value) {
									$data[] = [
										'image' => $value,
									];
								}
							}else if(isset($slide_translate)){
								$data = $slide_translate;
							}
						 ?>
						<div class="row">
							<div class="col-lg-12">
								<div class="click-to-upload"  <?php echo (isset($data) && is_array($data) && count($data))?'style="display:none"':'' ?>>
									<div class="icon">
										<a type="button" class="upload-picture" onclick="SelectBanner($(this));return false;">
											<svg style="width:80px;height:80px;fill: #d3dbe2;margin-bottom: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><path d="M80 57.6l-4-18.7v-23.9c0-1.1-.9-2-2-2h-3.5l-1.1-5.4c-.3-1.1-1.4-1.8-2.4-1.6l-32.6 7h-27.4c-1.1 0-2 .9-2 2v4.3l-3.4.7c-1.1.2-1.8 1.3-1.5 2.4l5 23.4v20.2c0 1.1.9 2 2 2h2.7l.9 4.4c.2.9 1 1.6 2 1.6h.4l27.9-6h33c1.1 0 2-.9 2-2v-5.5l2.4-.5c1.1-.2 1.8-1.3 1.6-2.4zm-75-21.5l-3-14.1 3-.6v14.7zm62.4-28.1l1.1 5h-24.5l23.4-5zm-54.8 64l-.8-4h19.6l-18.8 4zm37.7-6h-43.3v-51h67v51h-23.7zm25.7-7.5v-9.9l2 9.4-2 .5zm-52-21.5c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5zm0-8c-1.7 0-3 1.3-3 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3zm-13-10v43h59v-43h-59zm57 2v24.1l-12.8-12.8c-3-3-7.9-3-11 0l-13.3 13.2-.1-.1c-1.1-1.1-2.5-1.7-4.1-1.7-1.5 0-3 .6-4.1 1.7l-9.6 9.8v-34.2h55zm-55 39v-2l11.1-11.2c1.4-1.4 3.9-1.4 5.3 0l9.7 9.7c-5.2 1.3-9 2.4-9.4 2.5l-3.7 1h-13zm55 0h-34.2c7.1-2 23.2-5.9 33-5.9l1.2-.1v6zm-1.3-7.9c-7.2 0-17.4 2-25.3 3.9l-9.1-9.1 13.3-13.3c2.2-2.2 5.9-2.2 8.1 0l14.3 14.3v4.1l-1.3.1z"></path></svg>
										</a>
									</div>
									<div class="small-text"><?php echo translate('cms_lang.slide.post_img_content', $language) ?></div>
								</div>
								<?php $count = 0; ?>
								<script type="text/javascript">
									var count = <?php echo $count ?>;
								</script>
								<div class="upload-list" <?php echo (isset($data) && is_array($data) && count($data))?'':'style="display:none"' ?> style="padding:5px;">
									<div class="row"> 
										<ul id="sortable" class="tv clearfix data-album sortui sort-slide">
											<?php 
											if(isset($data) && is_array($data) && count($data)){ 
												$_data['data'] = $data;

											?>
                                                <?php echo view('backend/dashboard/common/slideblock', $_data); ?>
                                          	<?php }  ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<button type="submit" name="create" value="create" class=" btn btn-primary block m-b pull-right"><?php echo translate('cms_lang.slide.Save1', $language) ?></button>
			</div>
		</form>
	</div>
</div>

<div id="show_detail_image" class="modal fade va-general modal-banner" data-backdrop="static" data-keyboard="false">  
      <div class="modal-dialog modal-xl">  
           <div class="modal-content">  
                <div class="modal-header p0 pl20">
                    <div class="uk-flex uk-flex-space-between uk-flex-middle" >
                        <h4 class="modal-title">Chi tiết ảnh</h4>  
                        <div class="wrap-btn">
                        	<div class="uk-flex uk-flex-middle">
		                        <button class="left icon-banner-modal icon-change-image"><i class="fa fa-angle-left" aria-hidden="true"></i></button>  
		                        <button class="right icon-banner-modal icon-change-image"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
		                        <button type="button" class="close icon-banner-modal" data-dismiss="modal">&times;</button>  
                        	</div>
                        </div>
                    </div>  
                </div>  
                <div class="modal-body p0 ">  
                    <div class="uk-grid uk-grid-medium uk-clearfix">
                    	<div class="uk-width-large-1-2">
                    		<div class="thumbnail-image ">
                    			<div class="va-thumb-1-1">
                    				<div class="image img-scaledown">
										<img class="details-image" src=""  alt="demo">
                    				</div>
                    			</div>
							</div>
                    	</div>
                    	<div class="uk-width-large-1-2">
                    		<div class="attachment-info">
								<div class="details">
									<div class="uploaded"><strong>Đã tải lên vào lúc:</strong> <span class="file_general_detail file_time"></span></div>
									<div class="filename"><strong>Tên tập tin:</strong> <span class="file_general_detail file_name"></span></div>
									<div class="filename"><strong>Đường dẫn:</strong> <span class="file_general_detail file_path"></span></div>
									<div class="file-type"><strong>Loại tập tin:</strong> <span class="file_general_detail file_type"></span></div>
									<div class="file-size"><strong>Dung lượng tệp:</strong> <span class="file_general_detail file_size"></span> KB</div>
									<div class="dimensions"><strong>Kích thước</strong> <span class="file_general_detail file_height"></span> dài và rộng <span class="file_general_detail file_width"></span> pixel</div>							
								</div>
								<div class="settings">
									<div class="text-danger mb10">Bạn phải ấn lưu trước khi chuyển ảnh, nếu không bạn sẽ nhập lại từ đầu :D</div>
									<form class="form-horizontal-banner form-horizontal">
								        <div class="form-group form-item-va">
								            <label class="col-xs-4 control-label" for="attachment-details-two-column-alt-text" class="name">Văn bản thay thế</label>
								            <div class="col-xs-8"> 
								            	<input type="text" id="attachment-details-two-column-alt-text" name="alt" placeholder="Văn bản thay thế" class="form-control">
								            </div>
								        </div>
								        <div class="form-group form-item-va">
								            <label class="col-xs-4 control-label"  for="attachment-details-two-column-title">Tiêu đề</label>
								            <div class="col-xs-8"> <input type="text" id="attachment-details-two-column-title" placeholder="Tiêu đề..." name="title" class="form-control"> </div>
								        </div>
								        <div class="form-group form-item-va">
								            <label class="col-xs-4 control-label"  for="attachment-details-two-column-canonical">Đường dẫn</label>
								            <div class="col-xs-8"> <input type="text" id="attachment-details-two-column-canonical" placeholder="Đường dẫn..." name="canonical" class="form-control"> </div>
								        </div>
								        <div class="form-group form-item-va">
								            <label class="col-xs-4 control-label" for="attachment-details-two-column-description">Mô tả</label>
								            <div class="col-xs-8"> <textarea id="attachment-details-two-column-description" placeholder="Mô tả..." name="description" class="form-control"></textarea> </div>
								        </div>
								        <div class="form-group form-item-va">
								            <label class="col-xs-4 control-label" for="attachment-details-two-column-caption">Nội dung</label>
								            <div class="col-xs-8"> <textarea id="attachment-details-two-column-caption" placeholder="Nội dung" name="content" class="form-control"></textarea> </div>
								        </div>
								        <div class="btn-question"> 
								        	<button class="btn btn-primary" type="submit">Lưu</button>
								        </div>
								    </form>
								</div>
							</div>
                    	</div>
                    </div>	
                </div>   
           </div>  
      </div>  
 </div> 


