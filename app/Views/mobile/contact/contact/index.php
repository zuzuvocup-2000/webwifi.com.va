
<section class="contact-body">
	<div class="uk-container-center uk-container">
		<section class="main-slide breadcrumb-rl">
			<div class="breadcrumb">
				<h1 class="main-title">Liên hệ</h1>
				<ul class="uk-breadcrumb">
					<li><a href="" title=""><i class="fa fa-home"></i> Trang chủ</a></li>
					
					<li><a href="" title="">Liên hệ</a></li>
				</ul>
			</div><!-- .breadcrumb -->
		</section>
		<section class="uk-panel contact contact-section">
			<section class="panel-body">
				<div class="contact-infomation mb30">
					<div class="note">Cám ơn quý khách đã ghé thăm website chúng tôi.</div>
					<h2 class="company">KIM LIEN TRAVEL</h2>
					<div class="address">
						<p><span style="font-size:20px;"><span style="color: rgb(153, 153, 153);">Liên hệ - Contacts </span></span></p>
						<table border="0" class="MsoTable15Grid1Light" height="540" style="border-collapse: collapse;" width="890">
							<thead>
								<tr>
									<td style="background:#f2f2f2; padding:.25in .25in .25in .25in; ">
										<?php echo check_isset($general['contact_us']) ?>
									</td>
									<td style="background:#00b0f0; width:10.1pt; padding:0in 0in 0in 0in; " >
									</td>
									<td style="background:#f7a23f; width:10.1pt; padding:0in 0in 0in 0in; " >
									</td>
									<td style="background:#0070c0; width:40.5pt; padding:0in 0in 0in 0in; " >
									</td>
								</tr>
							</thead>
						</table>
					</div>
					<div class="contact-map">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.4716657850877!2d105.79965911430784!3d21.01380539366595!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab5f0f938b49%3A0x166c6f1af608ba59!2sTrung+Y%C3%AAn+Plaza!5e0!3m2!1svi!2s!4v1523156183683" width="100%" height="330" frameborder="0" style="border:0" allowfullscreen="">
						</iframe>							
					</div>
				</div><!-- .contact-infomation -->
				<div class="contact-form">
					<div class="label">Mời bạn điền vào mẫu thư liên lạc và gửi đi cho chúng tôi. Các chuyên viên tư vấn của chúng tôi sẽ trả lời bạn trong thời gian sớm nhất.</div>
						<form action="" method="post" class="uk-form form form-contact">
							<div class="form-row">
								<input type="text" name="fullname" class="uk-width-1-1 input-text" placeholder="Họ &amp; tên *">
							</div>
							<div class="form-row">
								<input type="text" name="email" class="uk-width-1-1 input-text" placeholder="Email *">
							</div>
							<div class="form-row">
								<input type="text" name="phone" class="uk-width-1-1 input-text" placeholder="Phone *">
							</div>
							<div class="form-row">
								<input type="text" name="title" class="uk-width-1-1 input-text" placeholder="Tiêu đề thư *">
							</div>
							<div class="form-row">
								<textarea name="message" class="uk-width-1-1 form-textarea" placeholder="Nội dung *"></textarea>
							</div>
							<div class="form-row uk-text-right">
								<input type="submit" name="create" class="btn-submit" value="Gửi đi">
							</div>
						</form><!-- .form -->
					</div><!-- .contact-form -->
				</div><!-- .uk-grid -->
			</section><!-- .panel-body -->
		</section>
	</div>
</section>	

<?php
	$owlInit = array(
		'items' =>  3,
		'margin' => 30,
		'loop' => true,
		'nav' => false,
		'dots' => false,
		'autoplay' => false,
		'autoplayTimeout' => 5000,
		'responsiveClass' =>true,
		'responsive' => array(
			0 => array(
				'items' => 3,
				'nav' => false
			),
			500 => array(
				'items' => 5,
				'nav' => false
			),
			1024 => array(
				'items' => 8,
				'nav' => false
			),
		)
	);
?>

<section class="slide-company-panel p30">
	<div class="uk-container uk-container-center">
		<div class="owl-slide">
			<div class="owl-carousel owl-theme" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>" data-disabled="0">
				<?php if(isset($slide_company) && is_array($slide_company) && count($slide_company)){
					foreach ($slide_company['data'] as $key => $value) {
				 ?>
					<div class="slide-company">
						<div class="slide-company-body">
							<a href="<?php echo $value['url'] ?>" class="img-scaledown image">
								<?php echo render_img($value['image'],$value['title']); ?>
							</a>
						</div>
					</div>
				<?php }} ?>
			</div>
		</div>
	</div>
</section>

