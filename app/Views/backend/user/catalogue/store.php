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
									<div class="form-row">
										<label class="control-label text-left">
											<span>Tiêu đề Nhóm <b class="text-danger">(*)</b></span>
										</label>
										<?php echo form_input('title', set_value('title', (isset($user_catalogue['title'])) ? $user_catalogue['title'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
									</div>
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							
							<?php
								$dir = 'app/Controllers/Backend';
								$permission = (isset($_POST['permission'])) ? $_POST['permission'] : '';
								if($permission == ''){
									if(isset($user_catalogue) && is_array($user_catalogue) && count($user_catalogue)){
										$permission = json_decode($user_catalogue['permission'], TRUE);
									}
								}

							?>
							<?php if(file_exists($dir.'/permission.xml') ==  true) { ?>
							<?php
								$xml = simplexml_load_file($dir.'/permission.xml') or die('Error: Cannot create object '.$dir.'/permission.xml');
								$xml = json_decode(json_encode((array)$xml), TRUE);
							?>
							<?php if(isset($xml['permissions']) && is_array($xml['permissions']) && count($xml['permissions'])){ ?>
							<?php foreach($xml['permissions'] as $keyXml => $valPermission){
							?>
							<div class="form-group">
								<label style="margin-bottom:0;" class="col-md-2 text-left">
									<span><?php echo $valPermission['title']; ?></span>
								</label>
								<?php if(isset($valPermission['item']) && is_array($valPermission['item']) && count($valPermission['item'])){ ?>
								<div class="col-md-10">
									<div class="userGroupContainer clearfix">
										<?php foreach($valPermission['item'] as $keyItem => $valItem){ ?>
										<div class="i-checks">
											<label class="uk-flex uk-flex-middle">
												<input style="margin-top:0;margin-right:10px" name="permission[]" <?php echo (($permission != '')  && in_array($valItem['param'], $permission)) ? 'checked' : '' ?> type="checkbox" value="<?php echo $valItem['param']; ?>">
												<span><?php echo $valItem['description']; ?></span>
											</label>
										</div>
										<?php } ?>
									</div>
								</div>
								<?php } ?>
							</div>
							<?php }}} ?>
							<div class="toolbox action clearfix">
								<div class="uk-flex uk-flex-middle uk-button pull-right">
									<button class="btn btn-primary btn-sm" name="create" value="delete" type="submit">Lưu Lại</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</form>