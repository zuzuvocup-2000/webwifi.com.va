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
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Upload file: <?php echo $article['title'] ?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin'); ?>"><?php echo translate('cms_lang.post.post_home', $language) ?></a>
			</li>
			<li class="active"><strong>Upload file: <?php echo $article['title'] ?></strong></li>
		</ol>
	</div>
</div>
<form method="post" action="" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
				</div><!-- /.box-body -->
			</div>
			<div class="row uk-flex-center uk-flex">
				<div class="col-lg-10 clearfix">
					<div class="ibox mb20">
						<div class="ibox-title" style="padding: 9px 15px 0px;">
							<div class="uk-flex uk-flex-middle uk-flex-space-between">
								<h5>Nội dung <span class="text-danger">Lưu ý: Nếu bạn ấn lưu, bài viết của bạn sẽ được hiển thị dưới dạng list File hoặc Download</span></h5>
								<div class="uk-flex uk-flex-middle">
									<button type="submit" name="create" value="create" class="btn btn-primary block full-width m0"><?php echo translate('cms_lang.post.post_save', $language) ?></button>
								</div>
							</div>
						</div>
						<div class="ibox-content">
							<div class="row mb15">
								<div class="col-lg-12">
									<div class="form-row mb15">
										<label class="control-label text-left">
											<span><?php echo translate('cms_lang.post.post_create_title', $language) ?> <b class="text-danger">(*)</b></span>
										</label>
										<?php echo form_input('title', validate_input(set_value('title', (isset($article['title'])) ? $article['title'] : '')), 'class="form-control '.(($method == 'create') ? 'title' : '').'" readonly placeholder="" id="title" autocomplete="off"'); ?>
									</div>
									<div class="form-row">
										<label class="control-label uk-flex uk-flex-middle uk-flex-space-between">
											<span>Thông tin chi tiết</span>
											<span>
												<button class="btn btn-success block btn-add-file-article m0">Thêm File</button>
												
											</span>
										</label>
										<table class="table table-striped table-bordered table-hover dataTables-example">
											<thead>
												<tr>
													<th style="width: 35px;">
					                                    <input type="checkbox" id="checkbox-all">
					                                    <label for="check-all" class="labelCheckAll"></label>
					                                </th>
													<th >Tiêu đề</th>
													<th class="text-center" >Đường dẫn File</th>
													<th class="text-center" style="width: 80px;">Sắp xếp</th>
													<th class="text-center" style="width:103px;">Thao tác</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
					                                    <input type="checkbox" name="checkbox[]" value="<?php echo $article['id']; ?>" class="checkbox-item">
					                                    <div for="" class="label-checkboxitem"></div>
					                                </td>
													<td class="text-center text-primary">
					                                    <?php echo form_input('title[]', $article['title'], 'data-module="'.$module.'"   class="form-control " placeholder="Tiêu đề..." style="width:100%;text-align:left;"');?>
					                                </td>
					                                <td class="text-center text-primary">
					                                    <?php echo form_input('canonical[]', $article['canonical'], 'data-module="'.$module.'"   class="form-control " placeholder="Đường dẫn File" style="width:100%;text-align:left;"');?>
					                                </td>
					                                <td class="text-center text-primary">
					                                    <?php echo form_input('order[]', $article['order'], 'data-module="'.$module.'"   class="form-control int" placeholder="Vị trí" style="width:100%;text-align:left;"');?>
					                                </td>
					                                <td class="text-center">
					                                    <a type="button" href="" class="btn btn-danger btn-delete-file-article"><i class="fa fa-trash"></i></a>
					                                </td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>