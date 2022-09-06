<div class="page-wrapper">
	<!-- End Header -->
	<main class="main">
		<div class="page-content">
			<main class="main account">
				<nav class="breadcrumb-nav">
					<div class="container">
						<ul class="breadcrumb">
							<li><a href="/"><i class="d-icon-home"></i></a></li>
							<li>Hồ sơ</li>
						</ul>
					</div>
				</nav>
				<div class="page-content mt-4 mb-10 pb-6">
					<div class="container">
						<h2 class="title title-center mb-10">Tài khoản của tôi</h2>
						<div class="tab tab-vertical gutter-lg">
							<ul class="nav nav-tabs mb-4 col-lg-3 col-md-4" role="tablist">
								<li class="nav-item">
									<a href="thong-tin-chi-tiet.html">Tổng quan</a>
								</li>
								<li class="nav-item">
									<a class="" href="don-hang-cua-toi.html">Đơn hàng</a>
								</li>
								<li class="nav-item">
									<a class="active"  href="tai-khoan.html">Thông tin tài khoản</a>
								</li>
								<li class="nav-item">
									<a class=" button-logouts"  href="logout.html">Đăng xuất</a>
								</li>
							</ul>
							<div class="tab-content col-lg-9 col-md-8">
								<div class="tab-pane active" id="account">
									<form  method="post" class="form">
										<label>Họ tên *</label>
										<input type="text" class="form-control profile-name"  name="name" value="<?php echo $user['fullname'] ?>" required="">
										<p class="validate-message validate-profile__name">Tên không được để trống!</p>
										<label>Email *</label>
										<input type="email" class="form-control profile-email" value="<?php echo $user['email'] ?>" name="email" required="">
										<p class="validate-message validate-profile__email">Email không được để trống!</p>
										<p class="validate-message check-profile__email">Email không đúng định dạng!</p>
										<label>Số điện thoại *</label>
										<input type="text" class="form-control profile-phone" value="<?php echo $user['phone'] ?>" name="phone" required="">
										<p class="validate-message validate-profile__phone">Số điện thoại không được để trống!</p>
										<p class="validate-message check-profile__phone">Số điện thoại không đúng định dạng!</p>
										<label>Địa chỉ *</label>
										<input type="text" class="form-control profile-address" value="<?php echo $user['address'] ?>" name="address" required="">
										<p class="validate-message validate-profile__address">Địa chỉ không được để trống!</p>
										<fieldset>
											<legend>Đổi mật khẩu</legend>
											<label>Mật khẩu hiện tại (để trống không thay đổi)</label>
											<input type="password" class="form-control profile-current__password" name="current_password">
											<p class="validate-message validate-current__password">Mật khẩu hiện tại không được để trống!</p>
											<label>Mật khẩu mới (để trống không thay đổi)</label>
											<input type="password" class="form-control profile-new__password" name="new_password">
											<p class="validate-message validate-new__password">Mật khẩu mới không được để trống!</p>
											<label>Xác nhận mật khẩu mới</label>
											<input type="password" class="form-control profile-confirm__password" name="confirm_password">
											<p class="validate-message validate-confirm__password">Vui lòng xác nhận lại mật khẩu mới!</p>
											<p class="validate-message check-confirm__password">Mật khẩu mới không khớp!</p>
											<p class="validate-message count-confirm__password">Mật khẩu phải trên 6 kí tự!</p>
										</fieldset>
										<button type="submit" data-id="<?php echo $user['id'] ?>" class="btn btn-primary btn-save-info">Lưu thay đổi</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
	</main>
</div>