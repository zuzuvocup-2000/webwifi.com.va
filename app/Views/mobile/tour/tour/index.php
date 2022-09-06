<?php if(isset($object) && is_array($object) && count($object)){ ?>
<section class="address-tourdetail-panel">
			
	<div class="uk-container uk-container-center">
		<ul class="uk-breadcrumb uk-clearfix">
			<li><a href="">Trang chủ</a></li>
			<?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){
				foreach ($breadcrumb as $key => $value) {
			 ?>
				<li class=""><a href="<?php echo BASE_URL.check_isset($value['canonical']).HTSUFFIX ?>" style="color: #333"><span><?php echo check_isset($value['title']) ?></span></a></li>
			<?php }} ?>
			<li class="uk-active"><span><?php echo check_isset($object['title'])?></span></li>
		</ul>
	</div>
</section>
<?php  
	$owlInit = array(
		'items' =>  1,
		'margin' => 20,
		'loop' => true,
		'nav' => true,
		'dots' =>true,
	);
?>
<section class="tour-detail-panel">
	<div class="uk-container uk-container-center">
		<div class="tour-detail-title">
			<h1>
				<?php echo check_isset($object['title'])?>
			</h1>
		</div>
		<div class="title-action mb30">
			<div class="uk-flex uk-flex-middle uk-flex-wrap">
				<div class="btn-like mr5">
					<a href="" title="like"><i class="fa fa-thumbs-o-up mr5" aria-hidden="true"></i>Thích <span>0</span></a>
				</div>
				<div class="btn-share mr10">
					<a href="" title="share"><i class="fa mr5 fa-share-square-o" aria-hidden="true"></i>Chia sẻ</a>
				</div>
				<div class="rating-info">
					<div class="uk-flex uk-flex-middle">
						<div class="rating-star-info uk-flex uk-flex-middle">
							<span>
								Đánh giá: 
							</span>
							<div class="rate">
								<i class="fa fa-star color-star" aria-hidden="true"></i>
								<i class="fa fa-star color-star" aria-hidden="true"></i>
								<i class="fa fa-star color-star" aria-hidden="true"></i>
								<i class="fa fa-star-o color-star" aria-hidden="true"></i>
								<i class="fa fa-star-o color-star" aria-hidden="true"></i>
							</div>
						</div>
						<div class="rating-result">
							<span>3/5</span>trong <span>0</span> đánh giá
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="uk-grid uk-gird-medium uk-clearfix">
			<div class="uk-width-medium-1-1 uk-width-large-1-4">
				
			</div>
			<div class="uk-width-medium-1-1 uk-width-large-3-4">
				<div class="tour-detail-wrapp mb20">
					<div class="uk-grid uk-grid-medium uk-clearfix">
						<div class="uk-width-medium-1-1 uk-width-large-1-4">
							<aside class="aside-tour-detail-left">
								<ul class="tabs tab-aside uk-list">
									<li class="btn-tab-aside tab-link current" data-tab="tong-hop">
										Tổng hợp
									</li>
									<?php if(isset($sub_album)&& is_array($sub_album) && count($sub_album)){
										foreach ($sub_album as $key => $value) {
									 ?>
										<li class="btn-tab-aside va-btn-sub-album tab-link" data-tab="<?php echo check_isset(slug($value['title'][0])) ?>">
											<?php echo check_isset($value['title'][0]) ?>
										</li>
									<?php }} ?>
									<?php if(isset($object['video']) && $object['video'] != ''){ ?>
									<li class="btn-tab-aside tab-link" data-tab="video_tour"> 
										Video
									</li>
									<?php } ?>
								</ul>
							</aside>
						</div>

						<div class="uk-width-medium-1-1 uk-width-large-3-4">
							<div class="wrap-carousel">
								<ul class=" uk-list tabs-content tabs-content-aside">
									<li id="tong-hop" class="tab-content current">
										<div class="owl-slide">
											<div class="owl-carousel owl-theme" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>" data-disabled="0">
												<?php if(isset($object['album']) && is_array($object['album']) && count($object['album'])){
													foreach ($object['album'] as $key => $value) {
												 ?>
													<div class="wrap-img-tour-detail">
														<a href="" class="img-cover">
															<?php echo render_img(check_isset($value)); ?>
														</a>
													</div>
												<?php }} ?>
											</div>
										</div>
									</li>
									<?php if(isset($sub_album)&& is_array($sub_album) && count($sub_album)){
										foreach ($sub_album as $key => $value) {
									 ?>
									<li id="<?php echo check_isset(slug($value['title'][0])) ?>" class="tab-content">
										<div class="owl-slide">
											<div class="owl-carousel owl-theme" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>" data-disabled="0">
												<?php if(isset($value['album']) && is_array($value['album']) && count($value['album'])){
													foreach ($value['album'] as $keyAlbum => $valAlbum) {
												 ?>
													<div class="wrap-img-tour-detail">
														<a href="" class="img-cover">
															<?php echo render_img(check_isset($valAlbum)); ?>
														</a>
													</div>
												<?php }} ?>
											</div>
										</div>
									</li>
									
									<?php }} ?>
									<?php if(isset($object['video']) && $object['video'] != ''){ ?>
										<li id="video_tour" class="tab-content">
											<div class="wrap-video-tour-detail">
												<?php echo check_isset($object['video']) ?>
											</div>
										</li>
									<?php } ?>
								</ul>
							</div>
						</div>

					</div>
				</div>
				<div class="info-tour mb30">
					<div class="info-tour-title mb20">
						<h2>Thông tin tour:</h2>
					</div>
					<div class="info-tour-content">
						<div class="uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-2 uk-clearfix uk-grid-medium">
							<div class="wrap-info-tour">
								<div class="uk-flex">
									<div class="info-tour-text">
										<i class="fa fa-qrcode" aria-hidden="true"></i>Mã tour:
										<span>
											<?php echo check_isset($object['tourid'])?>
										</span>
									</div>
								</div>
							</div>
							<div class="wrap-info-tour">
								<div class="uk-flex">
									<div class="info-tour-text">
									<i class="fa fa-clock-o" aria-hidden="true"></i>Thời gian:

										<span>
										<?php echo check_isset($object['number_days'])?>
										</span>
									</div>
								</div>
							</div>
							<div class="wrap-info-tour">
								<div class="uk-flex">
									<div class="info-tour-text">
									<i class="fa fa-map-marker" aria-hidden="true"></i>Điểm khởi hành:
										<span>
										<?php echo check_isset($object['start'])?>
										</span>
									</div>
								</div>
							</div>
							<div class="wrap-info-tour">
								<div class="uk-flex">
									<div class="info-tour-text">
									<i class="fa fa-male" aria-hidden="true"></i>Phương tiện:
										<span>
										<?php echo check_isset(((isset($object['info']['vehicle']) ? $object['info']['vehicle'] : '')))?>
										</span>
									</div>
								</div>
							</div>
							<div class="wrap-info-tour">
								<div class="uk-flex">
									<div class="info-tour-text">
									<i class="fa fa-map-marker" aria-hidden="true"></i>Điểm đến:


										<span>
										<?php echo check_isset($object['end'])?>
										</span>
									</div>
								</div>
							</div>
							<div class="wrap-info-tour">
								<div class="uk-flex">
									<div class="info-tour-text">
									<i class="fa fa-user" aria-hidden="true"></i>Số chỗ trống:
										<span>
										<?php echo check_isset(((isset($object['info']['number']) ? $object['info']['number'] : '')))?>
										</span>
									</div>
								</div>
							</div>
							<div class="wrap-info-tour">
								<div class="uk-flex">
									<div class="info-tour-text">
									<i class="fa fa-calendar" aria-hidden="true"></i>Ngày khởi hành:

										<span>
										<?php echo check_isset($object['day_start'])?>
										</span>
									</div>
								</div>
							</div>
							<div class="wrap-info-tour">
								
								<div class="info-tour-text">
									<i class="fa fa-briefcase" aria-hidden="true"></i>Lịch trình:

									<span>
									<?php echo check_isset(((isset($object['info']['schedule']) ? $object['info']['schedule'] : '')))?>
									</span>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				<aside class="aside-tour-detail-right">
					<div class="wrap-aside">
						<div class="key-price ">Giá chỉ

							<div class="old <?php echo (isset($object['price_promotion']) && $object['price_promotion'] != 0) ? 'line-price' : '' ?>">
								<?php echo check_isset($object['price']) ?> đ
							</div>
							<div class="new" style="<?php echo (isset($object['price_promotion']) && $object['price_promotion'] != 0) ? '' : 'display: none;' ?>">
								<?php echo check_isset($object['price_promotion']) ?> đ
							</div>
						</div>
						<?php 
							$price_cart = ((isset($object['price_promotion']) && $object['price_promotion'] != 0) ? $object['price_promotion'] : $object['price'] );
							$price_cart = str_replace('.', '', $price_cart);
							$price_cart = (float)$price_cart;
							$avatar_cart = ((isset($object['album']) && count($object['album']) && is_array($object['album'])) ? $object['album'][0] : $general['homepage_logo']);
							$cart = [
								'title' => check_isset($object['title']),
								'price' => $price_cart,
								'avatar' => $avatar_cart,
								'code' => check_isset($object['tourid']),
								'day_start' => check_isset($object['day_start']),
								'url' => check_isset($object['canonical'])
							];
						 ?>
						<button class="btn-keep" data-array="<?php echo base64_encode(json_encode($cart)) ?>">
							giữ chỗ
						</button>
						<a href="#create-helpper" class="create-help btn-modal-general">
							Đăng kí tư vấn <span>Hotline: <?php echo check_isset($general['contact_phone']) ?></span>
						</a>
					</div>
					<div class="wrap-aside">
						<p class="tab-detail-text center mb20">
							<span>
							MỌI THẮC MẮC XIN VUI LÒNG LIÊN HỆ						
							</span>
						</p>
						<div class="info-contact">
							<i class="fa fa-phone-square" aria-hidden="true"></i>Hotline:
							<a href="" title=""><?php echo check_isset($general['contact_phone']) ?></a>
						</div>
						<div class="info-contact mb30">
							<i class="fa fa-envelope" aria-hidden="true"></i>Email:
							<a href="" title=""><?php echo check_isset($general['contact_email']) ?></a>
						</div>
						<p class="tab-detail-text center mb20">
							<span>
							HOẶC ĐỂ LẠI THÔNG TIN				
							</span>
						</p>
						<div class="name-input mb10	">
							Họ và tên: 
						</div>
						<div class="input-general mb20">
							<input type="text" class="input_name" placeholder="Nhập họ và tên bạn">
						</div>
						<div class="name-input mb10	">
							Email hoặc số điện thoại
						</div>
						<div class="input-general mb20">
							<input type="text" class="input_phone" placeholder="Nhập email hoặc số điện thoại">
						</div>
						<div class="btn-send">
							<button>
								GỬI
							</button>
						</div>
					</div>


					<!-- ===================================================== -->
					<div id="create-helpper" class="modal">
						<div class="modal-content-review  w100">
							<div class="modal-title center">
								ĐĂNG KÝ TƯ VẤN
							</div>
							<div class="modal-content-panel">
								<div class="wrap-modal">
									<p class="tab-detail-text mb20 center">
										<span>
										MỌI THẮC MẮC XIN VUI LÒNG LIÊN HỆ						
										</span>
									</p>
									<div class="info-contact">
										<i class="fa fa-phone-square" aria-hidden="true"></i>Hotline:
										<a href="" title="">19004518</a>
									</div>
									<div class="info-contact mb30">
										<i class="fa fa-envelope" aria-hidden="true"></i>Email:
										<a href="" title="">sales@hanoitourist.vn</a>
									</div>
									<p class="tab-detail-text center mb20 center">
										<span>
										HOẶC ĐỂ LẠI THÔNG TIN				
										</span>
									</p>
									<div class="name-input mb10	">
										Họ và tên: 
									</div>
									<div class="input-general mb20">
										<input type="text" class="input_name_modal" placeholder="Nhập họ và tên bạn">
									</div>
									<div class="name-input mb10	">
										Email hoặc số điện thoại
									</div>
									<div class="input-general mb20">
										<input type="text" class="input_phone_modal" placeholder="Nhập email hoặc số điện thoại">
									</div>
									<div class="btn-send-modal">
										<button>
											GỬI
										</button>
									</div>

								</div>
							</div>
							<div class="modal-close">
								<?php echo render_img('public/frontend/resources/img/icon/close.png','close') ?>
							</div>
						</div>
					</div>
				</aside>
				<div class="tab-detail-tour-panel mb30">
					<div class="uk-sticky-placeholder" >
						<div class="uk-panel "  >
							<ul class="uk-nav uk-nav-side tab-detail-tour uk-list" data-uk-scrollspy-nav="{closest:'li', smoothscroll:{offset:70}}">
							    <li><a href="#tab-0" style="text-transform: uppercase;">Giới thiệu chung</a></li>
							    <li><a href="#tab-1" style="text-transform: uppercase;">Chương trình chi tiết</a></li>
							    <?php if(isset($object['sub_title']) && is_array($object['sub_title']) && count($object['sub_title'])){ 
									$count = 1;
									foreach ($object['sub_title'] as $key => $value) {
									?>
								<li><a href="#detail-tab-<?php echo $count ?>" style="text-transform: uppercase;"><?php echo check_isset($value) ?></a></li>
								<?php $count++;}} ?>
							</ul>
						</div>
					</div>
					<div class="tab-content-detail-tour">
						<div id="tab-0" class="mb30">
							<div class="tab-detail-text uk-clearfix ">
								<div class="title-tab-detail mb30">
									<h4>Giới thiệu chung</h4>
								</div>
								<?php echo check_isset($object['description']) ?>
							</div>
						</div>
						<hr>
						<div id="tab-1" class="mt30">
							<div class="tab-detail-text uk-clearfix ">
								<div class="title-tab-detail mb30">
									<h4>Chương trình chi tiết</h4>
								</div>
								<?php echo check_isset($object['content']) ?>
							</div>
						</div>
						<?php if(isset($object['sub_content']) && is_array($object['sub_content']) && count($object['sub_content'])){ 
							$count = 1;
							foreach ($object['sub_content'] as $key => $value) {
							?>
							<hr>
							<div id="detail-tab-<?php echo $count ?>" class="mb30 mt30">
								<div class="tab-detail-text uk-clearfix ">
									<div class="title-tab-detail mb30">
										<h4><?php echo $object['sub_title'][$key] ?></h4>
									</div>
									<?php echo check_isset($value) ?>
								</div>
							</div>
						<?php $count++;}} ?>
					</div>
				</div>
				<section class="block-comment-panel pt50 pb50">
					<div class="uk-container uk-container-center">
						<div class="block-comments">
							<div class="info-customer">
								<div class="ibox mb20">
									<div class="ibox-header">
										<h5>Đánh giá của Khách Hàng</h5>
									</div>
									<div class="ibox-content" style="position:relative; padding: 20px;">
										<form action="" method="" class="form uk-form" id="form-front-comment" data-module="<?php echo $module ?>" data-canonical="<?php echo $object['canonical'] ?>">
											<div class="uk-flex uk-flex-middle uk-grid uk-grid-medium mb30">
												<div class="uk-width-large-1-1">
													<section id="comment-front">
														<div class="ibox">
															<div class="uk-grid uk-grid-large uk-clearfix uk-flex uk-flex-middle">
																<div class="uk-width-large-1-2">
																	<section class="comment-statistic">
																		<div class="wrap-star uk-flex uk-flex-column-reverse">
																			<?php 
																				if(!isset($star['calculator'])){
																					$star['calculator'] = [
																			            '1' => 0,
																			            '2' => 0,
																			            '3' => 0,
																			            '4' => 0,
																			            '5' => 0,
																			        ];
																				}
																			 ?>
																			 <?php if(isset($rate['calculator'])){
																			 	foreach ($rate['calculator'] as $key => $value) {
																			  ?>
																			<div class="uk-flex uk-flex-middle uk-flex-wrap mb5">
																				<div class="five-star mr20 text-left">
																					<span class="rating order-1" data-stars="<?php echo $key ?>"  style="display: inline-block;">
																						<?php 
																							for ($i=1; $i <= $key ; $i++) { 
																								echo '<i class="star-rating fa fa-star" aria-hidden="true"></i>';
																							}
																							for ($i=1; $i <= 5-$key ; $i++) { 
																								echo '<i class="star-rating fa fa-star-o" aria-hidden="true"></i>';
																							}
																						 ?>
																						
																					</span>
																				</div>
																				<div class="uk-flex uk-flex-middle">
																					<div class="uk-progress mr20">
																						<?php 
																							if($rate['sum'] != 0){
																								$width = $value/$rate['sum']*100 ;
																							}else{
																								$width = 0;
																							}
																						?>
																						<div class="uk-progress-bar" style="width: <?php echo $width ?>%"></div>
																					</div>
																					<div class="total-comment"><?php echo $value ?></div>
																				</div>
																			</div>
																			<?php }} ?>
																		</div>
																	</section>
																</div>
																<div class="uk-width-large-1-2">
																	<div class="uk-flex uk-flex-center">
																		<section class="wrap-total">
																			<div class="">
																				<div class="number-average">
																					<span class="big-number"><?php echo isset($rate['total']) ? $rate['total'] : 0 ?></span>/
																					<span class="small-number">5</span>
																				</div>
																				<div class="star-average">
																					<div class="text-left">
																						<span class="rating"  style="display: inline-block;">
																							<?php 
																								$number = 0;
																								if(isset($rate['total'])){
																									$number = $rate['total'];
																								}
																								for ($i=1; $i <= round($number) ; $i++) { 
																									echo '<i class="star-rating-big fa fa-star" aria-hidden="true"></i>';
																								}
																								for ($i=1; $i <= 5-round($number) ; $i++) { 
																									echo '<i class="star-rating-big fa fa-star-o" aria-hidden="true"></i>';
																								}
																							 ?>
																						</span>
																					</div>
																					<p><?php echo isset($rate['sum']) ? $rate['sum'] : 0 ?> đánh giá</p>
																				</div>
																			</div>
																		</section>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div> 
											<div class="uk-grid uk-grid-small uk-grid-width-large-1-2">
												<div class="form-row">
													<textarea name="comment_note" cols="40" rows="10" placeholder="Viết nhận xét" class="textarea cmt-content" autocomplete="off"></textarea>
												</div>
												<div class="comment-infomation">
													<div class="uk-grid uk-grid-small uk-grid-width-large-1-2 mb10">
														<div class="form-row">
															<input type="text" name="comment_name" value="" placeholder="Họ tên" class="input-text cmt-name" autocomplete="off">
														</div>
														<div class="form-row">
															<input type="text" name="comment_phone" value="" placeholder="Số Điện thoại" class="input-text cmt-phone" autocomplete="off">
														</div>
													</div>
													<div class="uk-grid uk-grid-small uk-grid-width-large-1-2 mb10">
														<div class="form-row">
															<input type="text" name="comment_email" value="" placeholder="Email" class="input-text cmt-email" autocomplete="off">
														</div>
														<div class="uk-flex uk-flex-middle">
															<div class="">
																<input type="number" style="display: none" class="data-rate" name="data-rate" value="5">
																<div class="rate">
																    <input type="radio" id="star5" name="rate" value="5" />
																    <label for="star5" title="text">5 stars</label>
																    <input type="radio" id="star4" name="rate" value="4" />
																    <label for="star4" title="text">4 stars</label>
																    <input type="radio" id="star3" name="rate" value="3" />
																    <label for="star3" title="text">3 stars</label>
																    <input type="radio" id="star2" name="rate" value="2" />
																    <label for="star2" title="text">2 stars</label>
																    <input type="radio" id="star1" name="rate" value="1" />
																    <label for="star1" title="text">1 star</label>
															  	</div>
															</div>
														</div>
														<div class="btn-cmt sent-cmt">
															<button type="submit"  class="btn btn-success comment-btn uk-width-1-1" >Gửi</button>
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="ibox">
								<div class="ibox-header">
									<h5>Danh sách đánh giá</h5>
								</div>
								<div class="ibox-content" style="position:relative;padding-right:10px;padding-left:10px;">
									<div class="block-comment in-active">
										<?php 
											$check = [];
											if(isset($_COOKIE[AUTH.'backend']) && $_COOKIE[AUTH.'backend'] != ''){
												$check = $rate['all_comment'];
											}else{
												$check = $rate['comment_publish_1'];
											}
										?>

										<?php if(isset($check) && is_array($check) && count($check)){ ?>
											<ul class="list-comment uk-list uk-clearfix">
												<?php foreach ($check as $key => $value) { ?>
												<?php if($key == 10)	break; ?>
													<li class="list-comment-item ajax_get_cmt">
														<div class="comment admin_select_hidden" data-user="<?php echo (isset($_COOKIE[AUTH.'backend']) ? base64_encode($_COOKIE[AUTH.'backend']) : '') ?>" data-value="<?php echo base64_encode(json_encode($value)) ?>">
															<div class="uk-flex uk-flex-space-between mb5">
																<div class="cmt-profile">
																	<div class="uk-flex">
																		<div class="_cmt-avatar"><img src="<?php echo ((isset($value['image']) && $value['image'] != '') ? $value['image'] : 'public/avatar.png') ?>" alt="" class="img-sm"></div>
																		<div class="_cmt-info">
																			<div class="uk-flex uk-flex-middle">
																				<div class="_cmt-name"><?php echo ((isset($value['fullname']) && $value['fullname'] != '') ? $value['fullname'] : 'Ẩn danh') ?></div>
																				<div class="label label-primary _cmt-tag">Khách hàng</div>
																			</div>
																			<?php $replace_phone = substr($value['phone'],0,7); ?>
																			<div class="_cmt-phone"><?php echo $replace_phone.'xxx' ?></div>
																		</div>
																	</div>
																</div>
																<?php if(isset($_COOKIE[AUTH.'backend']) && $_COOKIE[AUTH.'backend'] != ''){ ?>
																	<div class="switch uk-flex uk-flex-center publishonoffswitch" data-field="publish" data-module="comment" data-id="<?php echo $value['id'] ?>">
																		<div class="onoffswitch">
																			<input type="checkbox" id="publish-<?php echo $value['id'] ?>" class="onoffswitch-checkbox publish" <?php echo ($value['publish'] == 1 ? 'checked' : '') ?>>
																			<label class="onoffswitch-label" for="publish-<?php echo $value['id'] ?>">
																				<span class="onoffswitch-inner"></span>
																				<span class="onoffswitch-switch"></span>
																			</label>
																		</div>
																	</div>
																<?php } ?>
															</div>
															<div class="cmt-content">
																<?php echo $value['comment'] ?>
																<div class="cmt-gallery mt10">
																	<?php $album_cmt = json_decode($value['album']);  ?>
																	<ul class="list-gallery ">
																		<?php if(isset($album_cmt) && is_array($album_cmt) && count($album_cmt)){
																			foreach ($album_cmt as $keySub => $valueSub) {
																				?>
																		<li>
																			<?php echo render_img($valueSub,$valueSub) ?>
																		</li>
																	<?php }} ?>
																	</ul>
																</div>
																<div class="_cmt-reply">
																	<a href="" title="" class="btn-reply" data-comment="1" data-id="<?php echo $value['id'] ?>" data-module="<?php echo $module ?>">Trả lời</a> 
																	<span class="rating"  style="display: inline-block;">
																		<?php 
																			$number = 0;
																			if(isset($value['rate'])){
																				$number = $value['rate'];
																			}
																			for ($i=1; $i <= round($number) ; $i++) { 
																				echo '<i class="star-rating fa fa-star" aria-hidden="true"></i>';
																			}
																			for ($i=1; $i <= 5-round($number) ; $i++) { 
																				echo '<i class="star-rating fa fa-star-o" aria-hidden="true"></i>';
																			}
																		 ?>
																	</span>
																	<span class="dash">-</span>
																	<span class="cmt-time">
																		<i class="fa fa-clock-o"></i>
																		<time class="timeago" datetime="<?php echo check_isset($value['created_at']) ?>"></time>
																	</span>
																</div>
																<div class="show-reply">
																	<!-- đổ cấu trúc comment vào đây -->
																</div>
																<div class="wrap-list-reply">
																	<ul class="list-reply list-comment uk-list uk-clearfix" id="reply-to-<?php echo $value['id'] ?>">
																	</ul>
																</div>
															</div>
														</div>
													</li>
												<?php } ?>

											</ul>
											
										<?php } ?>

									</div>	
								</div>
							</div>
						</div>
						<div class="loadmore-cmt"><a href="#" title="btn-loadmore" class="btn-loadmore-cmt" >Xem thêm tất cả bình luận</a></div>
					</div>
				</section>
			</div>
			
		</div>
	</div>
</section>
<?php } ?>