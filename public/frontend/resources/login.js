$(document).ready(function(){
    // $("body").lazyScrollLoading({
    //     lazyItemSelector: ".w_content , .lazyloading",
    //     onLazyItemVisible: function(e, $lazyItems, $visibleLazyItems) {
    //         $visibleLazyItems.each(function() {
    //             $(this).addClass("show");
    //         });
    //     }
    // });
	$(".toggle-password").click(function() {
	  	$(this).toggleClass("fa-eye fa-eye-slash");
	  	var input = $($(this).attr("toggle"));
	  	if (input.attr("type") == "password") {
	    	input.attr("type", "text");
	  	} else {
		    input.attr("type", "password");
	  	}
	});

    $(".btn-submit-form-user").click(function() {
        let _this= $(this);
        let form = $('#form-user').serializeArray()
        let form_URL = 'ajax/frontend/auth/update_info_member';

       $.post(form_URL, {
            form: form
        },
        function(data){
            if(data.trim() == 'no_email'){
                toastr.error('Email không tồn tại trong hệ thống!','Xin vui lòng thử lại!');
            }else if(data.trim() == 'error'){
                toastr.error('Có lỗi xảy ra!','Xin vui lòng thử lại!');
            }else{
                toastr.success('Cập nhật hồ sơ cá nhân thành công!','Thành công!');
                window.location.reload()
            }
        }); 
       return false;
    });

	if($('.select2').length){
		$('.select2').select2();
	}
	
    $('#signup-email').blur(function() {
        var email = $('#signup-email').val();
        if (IsEmail(email) == false) {
            $(this).addClass('input-warning');
    		toastr.error('Định dạng Email không hợp lệ!','Xin vui lòng thử lại!');
        } else {
            $(this).removeClass('input-warning');
        }
    });
    $('#confirm-password').blur(function() {
        console.log(1);
        if ($('#password-field').val() !== $('#confirm-password').val()) {
            $(this).addClass('input-warning');
    		toastr.error('Mật khẩu bạn nhập không đúng!','Xin vui lòng thử lại!');
        } else {
            $(this).removeClass('input-warning');
        }
    }); 
    $('#password-field').blur(function() {
        if ($('#password-field').val().length < 6) {
            $(this).addClass('input-warning');
    		toastr.error('Mật khẩu phải ít nhất 6 kí tự!','Xin vui lòng thử lại!');
        } else {
            $(this).removeClass('input-warning');
        }
    });
    $('#contact-number').blur(function() {
        if ($('#contact-number').val().length != 10) {
            $(this).addClass('input-warning');
    		toastr.error('Số điện thoại không hợp lệ!','Xin vui lòng thử lại!');
        } else {
            $(this).removeClass('input-warning');
        }
    });

    $('.btn-otp-email').on('click', function(){
    	let fullname = $('input[name=fullname]').val();
    	let email = $('input[name=email]').val();
    	let form_URL = 'ajax/frontend/auth/send_otp_signup';
    	if(fullname == ''){
    		toastr.error('Vui lòng điền Họ và tên!','Xin vui lòng thử lại!');
    	}else if(email == ''){
    		toastr.error('Vui lòng điền Email!','Xin vui lòng thử lại!');
    	}else{
			begin();
    		$.post(form_URL, {
				fullname: fullname,  email: email
			},
			function(data){
				if(data== 0){
    				toastr.error('Có lỗi xảy xa!','Xin vui lòng thử lại!');
				}else if(data== 2){
    				toastr.error('Email đã tồn tại trong hệ thống!','Xin vui lòng thử lại!');
				}else{
					toastr.success('Mã OTP đã được gửi vào email của bạn!','Thành công!');
				}
			});	
    	}
    	return false;
    })

    $('.btn-submit-change-password').on('click', function(){
        let form = $('#form-password').serializeArray();
        let error = false;

        for (var i = 0; i < form.length; i++) {
            if(form[i].value == ''){
                toastr.warning('Vui lòng điền đầy đủ thông tin các trường!','Xin vui lòng thử lại!'); 
                error = true; 
                break;
            }
        }

        $('#form-password .input-warning').each(function(){
            toastr.warning('Mật khẩu mới không hợp lệ hoặc không tương thích!','Xin vui lòng thử lại!'); 
            error = true; 
        })

        if(error == false){
            let form_URL = 'ajax/frontend/auth/change_password';
            $.post(form_URL, {
                form: form
            },
            function(data){
                if(data.trim() == 'error_confirm'){
                    toastr.error('Mật khẩu và Mật khẩu xác nhận không giống nhau!','Xin vui lòng thử lại!');
                }else if(data.trim() == 'error_email'){
                    toastr.error('Có lỗi xảy ra!','Xin vui lòng thử lại!');
                }else if(data.trim() == 'error_password'){
                    toastr.error('Mật khẩu không chính xác!','Xin vui lòng thử lại!');
                }else{
                    toastr.success('Bạn đã đổi mật khẩu thành công!','Thành công!');
                    window.location.reload();
                }
            }); 
        }
        
        return false;
    })
    $('.btn-get-otp-forgot').on('click', function(){
        let _this  = $(this)
        let email = $('input[name=email]').val();
        let form_URL = 'ajax/frontend/auth/send_otp_forgot';
        if(IsEmail(email) == false){
            toastr.error('Định dạng Email không hợp lệ!','Xin vui lòng thử lại!');
        }else{
            $.post(form_URL, {
                email: email
            },
            function(data){
                if(data.trim() == 'no_email'){
                    toastr.error('Email không tồn tại trong hệ thống!','Xin vui lòng thử lại!');
                }else if(data.trim() == 'error'){
                    toastr.error('Có lỗi xảy ra!','Xin vui lòng thử lại!');
                }else{
                    toastr.success('Mã OTP đã được gửi tới Email của bạn!','Thành công!');
                    $('.email-check-otp-forgot').removeClass('hidden')
                    $('.send-back-otp').removeClass('hidden')
                    $('.btn-get-otp-forgot').addClass('hidden')
                    $('.btn-submit-forgot').removeClass('hidden')
                    $('.send-back-otp').removeClass('hidden')
                }
            }); 
        }
        return false;
    }) 
    $('.btn-submit-forgot').on('click', function(){
        let email = $('input[name=email]').val();
        let otp = $('input[name=otp]').val();
        let form_URL = 'ajax/frontend/auth/get_new_password';
        if(IsEmail(email) == false){
            toastr.error('Định dạng Email không hợp lệ!','Xin vui lòng thử lại!');
        }else if(otp == '' || otp.length != 6){
            toastr.error('Mã OTP không chính xác hoặc đã hết thời gian sử dụng!','Xin vui lòng thử lại!');
        }else{
            $.post(form_URL, {
                email: email, otp : otp
            },
            function(data){
                if(data.trim() == 'error'){
                    toastr.error('Có lỗi xảy ra!','Xin vui lòng thử lại!');
                }else if(data.trim() == 'error_otp'){
                    toastr.error('Mã OTP không chính xác hoặc đã hết thời gian sử dụng!','Xin vui lòng thử lại!');
                }else{
                    toastr.success('Mật khẩu mới đã được gửi vào Email của bạn!','Thành công!');
                    window.location.href = BASE_URL+'login.html';
                }
            }); 
        }
        return false;
    })
    $('.send-back-otp').on('click', function(){
        let _this  = $(this)
        let email = $('input[name=email]').val();
        $('.email-check-otp-forgot').addClass('hidden')
        _this.addClass('hidden')
        $('.btn-get-otp-forgot').removeClass('hidden')
        $('.btn-submit-forgot').addClass('hidden')
        return false;
    })

    $('.signup-form .button-login button').on('click', function(){
    	let valForm = $('.signup-form').serializeArray();
    	let count = 0;
    	let form_URL = 'ajax/frontend/auth/signup';
    	for (var i = 0; i < valForm.length; i++) {
    		if(valForm[i].value == ''){
    			count++;
    		}
    		if(valForm[i].name == 'password'){
    			if(valForm[i].value.length < 6){
    				count++;
    			}
    		}
    	}
    	if(count != 0){
			toastr.warning('Xin vui lòng điền đầy đủ thông tin các trường!','Có lỗi xảy ra!');
    	}else{
    		$.post(form_URL, {
				data: valForm
			},
			function(data){
				let json = JSON.parse(data)
					console.log(json);
				if(json == 'otp'){
    				toastr.error('Mã OTP không chính xác hoặc đã hết thời gian sử dụng!');
				}else if(json == 'email_exist'){
    				toastr.error('Email đã tồn tại trong hệ thống!');
				}else{
					toastr.success('Bạn đã đăng ký thành công!','Thành công!');
					window.location.href = BASE_URL+'login.html';
				}
			});	
    	}
    	return false;
    })

    $('.login-form .button-login button').on('click', function(){
    	let email = $('input[name=email]').val()
    	let password = $('input[name=password]').val()
    	let form_URL = 'ajax/frontend/auth/login';
    	if(email == '' || password == ''){
			toastr.warning('Xin vui lòng điền đầy đủ thông tin các trường!','Có lỗi xảy ra!');
    	}else{
    		$.post(form_URL, {
				email: email,password: password
			},
			function(data){
				console.log(data);
				if(data.trim() == '0'){
    				toastr.error('Tài khoản hoặc mật khẩu không đúng!','Xin vui lòng thử lại!');
				}else if(data.trim() == '1'){
    				toastr.error('Tài khoản của bạn đang bị khóa!','Xin vui lòng thử lại!');
				}else if(data.trim() == 'error'){
    				toastr.error('Có lỗi xảy ra!','Xin vui lòng thử lại!');
    				$.removeCookie('HTVIETNAM_member', { path: '/' });
				}else{
    				toastr.success('Đăng nhập thành công!','Thành công!');
    				window.location.href = BASE_URL;
				}
			});	
    	}
    	return false;
    })



	function begin() {
	    timing = 60;
	    $('.60s-countdown').removeClass('display-none')
	    $('.send-otp-text').addClass('display-none')
	    $('.60s-countdown').html(timing);
	    $('.btn-otp-email').addClass('isDisabled');
	    myTimer = setInterval(function() {
	      --timing;
	      $('.60s-countdown').html(timing);
	      if (timing === 0) {
	        clearInterval(myTimer);
	        $('.60s-countdown').addClass('display-none')
	    	$('.send-otp-text').removeClass('display-none')
	    	$('.btn-otp-email').removeClass('isDisabled');
	      }
	    }, 1000);

	 }

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        }
    }

})