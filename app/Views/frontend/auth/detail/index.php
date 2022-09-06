<link href="public/frontend/resources/auth/auth.css" rel="stylesheet" />
<script src="public/frontend/resources/uikit/js/components/sticky.min.js"></script>
<div class="main-content">
    <div class="user-profile">
        <div class="container">
            <div class="row">
                <div class="col-md-3 hidden-xs hidden-sm sidebar sidebar-left" >
                    <div class="wrapper" data-uk-sticky="{top: 60, boundary: '#footer'}">
                        <div class="title clearfix">
                            Xin Chào, <?php echo $user['fullname'] ?>
                        </div>
                        <ul class="list-menu">
                            <li data-id="user-info">
                                <a>Thông tin cá nhân</a>
                            </li>
                            <li data-id="user-application">
                                <a>Khuyến mãi</a>
                            </li>
                            <li data-id="user-password">
                                <a>Mật khẩu</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 col-xs-12 content-right">
                    <div class="item-user" id="user-info">
                        <div class="title">
                            Thông tin cá nhân
                            <span class="icon-edit btn-update-user-profile">Chỉnh sửa</span>
                        </div>
                        <div class="content">
                            <div class="show-content">
                                <div class="user-avatar clearfix">
                                    <div class="avatar" style="background-image: url(public/ic_noavt.png);"></div>
                                </div>
                                <table class="table-user-profile">
                                    <tr>
                                        <td>
                                            <span class="icon"><img src="public/display_name.png" /></span>
                                            <span class="i-title">Tên hiển thị:</span>
                                        </td>
                                        <td><?php echo $user['fullname'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="icon"><img src="public/profile.png" /></span>
                                            <span class="i-title">Email:</span>
                                        </td>
                                        <td><?php echo (isset($user['email']) && !empty($user['email'])) ? $user['email'] : 'Chưa cập nhật' ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="icon"><img src="public/phone.png" /></span>
                                            <span class="i-title">Số điện thoại:</span>
                                        </td>
                                        <td><?php echo (isset($user['phone']) && !empty($user['phone'])) ? $user['phone'] : 'Chưa cập nhật' ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="icon"><img src="public/gender.png" /></span>
                                            <span class="i-title">Giới tính:</span>
                                        </td>
                                        <td>
                                            <?php echo (isset($user['gender']) && $user['gender'] == 1) ? 'Nam' : 'Nữ' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="icon"><img src="public/birthday.png" /></span>
                                            <span class="i-title">Ngày sinh:</span>
                                        </td>
                                        <td>
                                            <?php echo (isset($user['birthday']) && !empty($user['birthday'])) ? date('d/m/Y', strtotime($user['birthday'])) : 'Chưa cập nhật' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="icon"><img src="public/address.png" /></span>
                                            <span class="i-title">Địa chỉ:</span>
                                        </td>
                                        <td>
                                            <?php echo (isset($user['address']) && !empty($user['address'])) ? $user['address'] : 'Chưa cập nhật' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="icon"><img src="public/user_facebook.png" /></span>
                                            <span class="i-title">Facebook:</span>
                                        </td>
                                        <a href=""></a>
                                        <td><?php echo (isset($user['facebook_link']) && !empty($user['facebook_link'])) ? '<a href="'.$user['facebook_link'].'" title="Facebook Link" target="_blank">'.$user['facebook_link'].'</a>' : 'Chưa cập nhật' ?></td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span class="icon"><img src="public/user_instagram.png" /></span>
                                            <span class="i-title">Instagram:</span>
                                        </td>
                                        <td><?php echo (isset($user['instagram_link']) && !empty($user['instagram_link'])) ? '<a href="'.$user['instagram_link'].'" title="Instagram Link" target="_blank">'.$user['instagram_link'].'</a>' : 'Chưa cập nhật' ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="edit-content hidden">
                                <form id="form-update-profile" action="cap-nhat-tai-khoan"  method="post">
                                    <div class="user-avatar clearfix">
                                        <div class="avatar" style="background-image: url(public/ic_noavt.png);"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">

                                            <div class="form-group">
                                                <div>Tên của bạn:</div>
                                                <input type="text" class="form-control" name="fullname" placeholder="Họ và tên" value="<?php echo $user['fullname'] ?>" required />
                                            </div>
                                            <div class="form-group">
                                                <div>Email: </div>
                                                <input type="text" class="form-control" name="email" placeholder="Email" <?php echo empty($user['email']) ? '' : 'readonly' ?> value="<?php echo $user['email'] ?>" />
                                            </div>

                                            <div class="form-group">
                                                <div>Số điện thoại</div>
                                                <input type="text" class="form-control" name="phone" placeholder="Số điện thoại" <?php echo empty($user['phone']) ? '' : 'readonly' ?> value="<?php echo $user['phone'] ?>" required />
                                            </div>
                                            <div class="form-group">
                                                <div>Địa chỉ Facebook</div>
                                                <input type="text" class="form-control" name="facebook_link" placeholder="https://facebook.com/user" value="<?php echo $user['facebook_link'] ?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                        	<div class="form-group">
                                                <div>Giới tính</div>
                                                <select class="form-control" name="gender">
                                                    <option value="1" <?php echo $user['gender'] == 1 ? 'selected' : '' ?>>Nam</option>
                                                    <option value="0" <?php echo $user['gender'] == 0 ? 'selected' : '' ?>>Nữ</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <div>Ngày sinh</div>
                                                <input type="date" class="form-control" name="birthday" value="<?php echo $user['birthday'] ?>" />
                                            </div>
                                            <div class="form-group">
                                                <div>Địa chỉ</div>
                                                <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="<?php echo $user['address'] ?>" required />
                                            </div>
                                            <div class="form-group">
                                                <div>Địa chỉ Instagram</div>
                                                <input type="text" class="form-control" name="instagram_link" placeholder="https://instagram.com/user" value="<?php echo $user['instagram_link'] ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="update" class="btn btn-danger btn-submit-update-profile">Cập nhật</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="item-user" id="user-application">
                        <div class="title">Khuyến mãi</div>
                        <div class="content clearfix">
                            <?php if(isset($promotion) && is_array($promotion) && count($promotion)){ ?>
                                <div class="row">
                                    <?php foreach ($promotion as $value) { ?>
                                        <div class="col-sm-4 col-xs-6 mb20">
                                            <div class="item-application" style="height: 100%">
                                                <p class="wrap-img va-thumb-1-1">
                                                    <span class="img-cover">
                                                        <img src="<?php echo $value['image'] ?>" alt="strava" />
                                                    </span>
                                                </p>
                                                <div class="uk-text-center">
                                                    <?php echo $value['title'] ?>
                                                </div>
                                                <div class="tutorial ">Code: <span class="text-info"><?php echo $value['promotionid'] ?></span></div>
                                                <div class="uk-flex uk-flex-middle uk-flex-center">
                                                    Tình trạng: <?php echo ($value['used'] == 1) ? '<span class="text-success ml10">Đã sử dụng</span>' : '<span class="text-danger ml10">Chưa sử dụng</span>' ?>
                                                </div>
                                                <?php if($value['used'] == 1){ ?>
                                                    <div class="used_at uk-text-center">
                                                        <?php echo date('d/m/Y H:i:s', strtotime($value['used_at'])) ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php }else{ ?>
                                <div class="show-content">
                                    <p style="margin-bottom: 0;">Bạn chưa có mã khuyến mãi nào</p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="item-user" id="user-password">
                        <div class="title">Mật khẩu</div>
                        <div class="content">
                            <div class="edit-content">
                                <form id="form-update-password" action="cap-nhat-mat-khau"  method="post">
                                    <div class="form-group">
                                        <div>Mật khẩu cũ:</div>
                                        <input type="password" class="form-control" name="old_password" placeholder="******" minlength="6" required />
                                    </div>
                                    <div class="form-group">
                                        <div>Mật khẩu mới:</div>
                                        <input type="password" class="form-control" name="new_password" placeholder="******" minlength="6" required />
                                    </div>
                                    <div class="form-group">
                                        <div>Nhập lại mật khẩu:</div>
                                        <input type="password" class="form-control" name="re_password" placeholder="******" minlength="6" required />
                                    </div>
                                    <button class="btn btn-danger" type="submit">Cập nhật</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
	$(window).scroll(function() {
      	var scrollTop = $(window).scrollTop();
      	var elementOffset = $('.content-right').offset().top;
    });
	var click_menu = false;

	$(".sidebar-left").on("click", "li", function () {
	    click_menu = true;
	    var id = $(this).data("id");
	    $(".sidebar-left").find("li.active").removeClass("active");
	    $(this).addClass("active");
	    $("html, body").animate(
	        {
	            scrollTop: $("#" + id).offset().top - 60,
	        },
	        500
	    );
	    setTimeout(function () {
	        click_menu = false;
	    }, 500);
	});

	setTimeout(function () {
	    var hash = location.hash;
	    if (hash && hash.indexOf("#edit-") === 0) {
	        click_menu = true;
	        var tab_id = hash.replace("#edit-", "", hash);
	        $(".sidebar-left")
	            .find('li[data-id="' + tab_id + '"]')
	            .click();
	    }
	}, 1000);

	$(document).on("scroll", function (e) {
	    try {
	        if (!click_menu) {
	            var scrollPos = $(document).scrollTop();
	            $(".sidebar-left li").each(function () {
	                var id = $(this).data("id");
	                var element = $("#" + id);
	                var currLink = $(this);
	                if (element.position().top <= scrollPos && element.position().top + element.height() > scrollPos) {
	                    currLink.addClass("active");
	                } else {
	                    currLink.removeClass("active");
	                }
	            });
	        }
	    } catch (err) {}
	});

	$(".item-user .icon-edit").click(function () {
	    var item = $(this).closest(".item-user");
	    if ($(this).hasClass("edit")) {
	        if ($(this).hasClass("btn-update-user-profile")) {
	            $(".btn-submit-update-profile").click();
	        } else if ($(this).hasClass("btn-update-account")) {
	            $(".btn-submit-update-account").click();
	        } else if ($(this).hasClass("btn-update-accessories")) updateUserAccessories();
	    } else {
	        $(this).addClass("edit");
	        item.find(".show-content").addClass("hidden");
	        item.find(".edit-content").removeClass("hidden");
	        $(this).text("Lưu lại");
	    }
	});

</script>