<?php
$baseController = new App\Controllers\BaseController();
$language = $baseController->currentLanguage();
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2><?php echo translate('cms_lang.contact.contact_title', $language) ?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin'); ?>"><?php echo translate('cms_lang.contact.contact_home', $language) ?></a>
			</li>
			<li class="active"><strong><?php echo translate('cms_lang.contact.contact_title', $language) ?></strong></li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo translate('cms_lang.contact.contact_title', $language) ?></h5>
				</div>
				<div class="ibox-content">
					<form action="" class="form-search mb20" method="">
						<div class="uk-flex uk-flex-middle uk-flex-space-between mb20">
							<div class="uk-flex uk-flex-middle mr20">
								<div class="perpage mr10">
									<div class="uk-flex uk-flex-middle ">
										<select name="perpage" class="form-control input-sm perpage filter mr10">
											<option value="20">20 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
											<option value="30">30 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
											<option value="40">40 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
											<option value="50">50 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
											<option value="60">60 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
											<option value="70">70 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
											<option value="80">80 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
											<option value="90">90 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
											<option value="100">100 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
										</select>
									</div>
								</div>
								<div class="search-time">
									<div class="form-row ">
										<input class="form-control active" type="text" name="daterange" autocomplete="off" value="<?php echo (isset($_GET['daterange']) && $_GET['daterange'] != '' ? $_GET['daterange'] : '') ?>" placeholder="Chọn thời gian">
									</div>
								</div>
							</div>
							<div class="toolbox">
								<div class="uk-flex uk-flex-middle ">
									<div class="">
										<div class="form-row ">
											<?php echo form_dropdown('type', $type['type'], set_value('type', (isset($_GET['type'])) ? $_GET['type'] : '0'), 'class="form-control input-sm  filter mr10 select2"  ');?>
										</div>
									</div>
									<div class="uk-search uk-flex uk-flex-middle mr10 ml10">
										<div class="input-group">
											<input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="<?php echo translate('cms_lang.post.post_placeholder', $language) ?>" class="form-control" style="width: 500px;">
											<span class="input-group-btn">
												<button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm"><?php echo translate('cms_lang.post.post_search', $language) ?>
												</button>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
					<table class="table table-striped table-bordered table-hover dataTables-example">
						<thead>
							<tr>
								<th style="width: 30px" class="text-center">
									<input type="checkbox" id="checkbox-all">
									<label for="check-all" class="labelCheckAll"></label>
								</th>
								<th class="text-center" style="width:100px">Mã Liên hệ</th>
								<th style="width:250px"><?php echo translate('cms_lang.contact.contact_info', $language) ?></th>
								<th class="text-center" style="width: 300px;">Nội dung gửi</th>
								<th class="text-center" style="width: 300px;">Nội dung phản hồi</th>
								<th class="text-center" style="width:80px"><?php echo translate('cms_lang.contact.contact_action', $language) ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($contactList) && is_array($contactList) && count($contactList)){ ?>
							<?php foreach($contactList as $key => $val){ ?>
							<tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
								<td class="text-center">
									<input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
									<div for="" class="label-checkboxitem"></div>
								</td>
								<td class="text-center"><a type="button" href="<?php echo base_url('backend/contact/contact/reply/'.$val['id']) ?>" class="btn open-window btn-success"><?php echo $val['contactid'] ?></a></td>
								<td class="information">
									<div class="customer-name uk-flex uk-flex-middle uk-flex-space-between">
										<div class="user-name"><?php echo $val['fullname']; ?></div>
									</div>
									<div class="customer-detail">
										<?php if(isset($val['phone']) && $val['phone'] != ''){ ?>
											Phone: <?php echo $val['phone']; ?>
											<br>
										<?php } ?>
										<?php if(isset($val['email']) && $val['email'] != ''){ ?>
											Email: <?php echo $val['email']; ?>
											<br>
										<?php } ?>
										<?php if(isset($val['address']) && $val['address'] != ''){ ?>
											Địa chỉ: <?php echo $val['address']; ?>
											<br>
										<?php } ?>
										<?php if(isset($val['type']) && $val['type'] != ''){ ?>
											Loại liên hệ: <?php echo $type['type'][$val['type']]; ?>
											<br>
										<?php } ?>
										<?php echo translate('cms_lang.contact.contact_created_at', $language) ?>: <?php echo date('d/m/Y g:i a' , strtotime($val['created_at'])); ?>
									</div>
								</td>
								<td>
									Tiêu đề: <?php echo $val['title']; ?>
									<br>
									Thể loại: <?php echo $val['theloai']; ?>
									<?php echo isset($val['content']) && $val['content'] != '' ? '<br>Nội dung: '.$val['content'] : ''; ?>
								</td>
								<td>
									<?php echo isset($val['admin']) && $val['admin'] != '' ? 'Người phản hồi: '.$val['admin'] : ''; ?>
									<?php echo isset($val['reply']) && $val['reply'] != '' ? '<br>Nội dung: '.$val['reply'] : ''; ?>
								</td>
								<td class="text-center">
									<a type="button" href="<?php echo base_url('backend/contact/contact/reply/'.$val['id']) ?>" class="btn open-window btn-success"><i class="fa fa-edit"></i></a>
									<button class="btn btn-danger btn-sm delete1" id="<?php echo $val['id'] ?>" name="delete" value="delete" type="submit"><i class="fa fa-trash"></i></button>
								</td>
								<?php }}else{ ?>
								<tr>
									<td colspan="100%"><span class="text-danger"><?php echo translate('cms_lang.contact.empty', $language) ?></span></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<div id="pagination">
							<?php echo (isset($pagination)) ? $pagination : ''; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>