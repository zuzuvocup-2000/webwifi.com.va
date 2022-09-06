// Validate và gửi form đăng ký để nhận mã OTP

$('.login-form').validate({
    rules: {
		phone: {
			required: true,
			minlength: 10
		},
		password: {
			required: true,
			minlength: 6
		}
	},
	messages: {
		phone: {
			required: "Xin vui lòng nhập số điện thoại",
			minlength: "Số điện thoại phải lớn hơn hoặc bằng 10 ký tự"
		},
		password: {
			required: "Xin vui lòng nhập mật khẩu",
			minlength: "Mật khẩu phải lớn hơn 6 ký tự"
		}
	},
	errorPlacement: function(error, element){
        if ( element.is(":radio") ){
            error.appendTo( element.parents('.form-group') );
        }else{
            error.insertAfter( element );
        }
 	},
 	submitHandler: function(form) {
        let form_URL = 'ajax/frontend/auth/login';
        let data = {
        	phone: $('.login-form').find('input[name="phone"]').val(),
        	password: $('.login-form').find('input[name="password"]').val(),
        }
        $('.hd-login').attr('disabled', 'disabled');
        $('.hd-login').addClass('disabled')
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: {form:data},
            url: form_URL,
            success:function(data){
            	$('.hd-login').removeAttr('disabled')
       	 		$('.hd-login').removeClass('disabled')
                if(data.response.code == 10){
                    toastr.success(data.response.message, 'Thành công!');
                    window.location.reload()
                }else{
                    toastr.error(data.response.message,'Có lỗi xảy ra!');
                }
            }
        });
    }
});

// Validate và gửi form đăng ký để nhận mã OTP

$('.register-form').validate({
    rules: {
		phone: {
			required: true,
			minlength: 10
		},
		password: {
			required: true,
			minlength: 6
		},
		password_confirm: {
			required: true,
			minlength: 6,
			equalTo: ".password-register"
		},
		email: {
			required: true,
			email: true
		},
	},
	messages: {
		phone: {
			required: "Xin vui lòng nhập số điện thoại",
			minlength: "Số điện thoại phải lớn hơn hoặc bằng 10 ký tự"
		},
		email: {
			required: "Xin vui lòng nhập Email",
			email: "Định dạng Email không hợp lệ"
		},
		password: {
			required: "Xin vui lòng nhập mật khẩu",
			minlength: "Mật khẩu phải lớn hơn 6 ký tự"
		},
		password_confirm: {
			required: "Xin vui lòng nhập lại mật khẩu",
			minlength: "Mật khẩu nhập lại phải lớn hơn 6 ký tự",
			equalTo: "Mật khẩu nhập lại không khớp"
		},
	},
	errorPlacement: function(error, element){
        if ( element.is(":radio") ){
            error.appendTo( element.parents('.form-group') );
        }else{
            error.insertAfter( element );
        }
 	},
 	submitHandler: function(form) {
        let form_URL = 'ajax/frontend/auth/send_otp_signup';
        let data = {
        	phone: $('.register-form').find('input[name="phone"]').val(),
        	email: $('.register-form').find('input[name="email"]').val(),
        	password: $('.register-form').find('input[name="password"]').val(),
        }
        $('.hd-register').attr('disabled', 'disabled');
        $('.hd-register').addClass('disabled')
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: {form:data},
            url: form_URL,
            success:function(data){
            	$('.hd-register').removeAttr('disabled')
       	 		$('.hd-register').removeClass('disabled')
                if(data.response.code == 10){
                    $('.register').removeClass('block')
                    $('.register-form')[0].reset();
                    $('.verify').addClass('block')
                    $('.verify-form').attr('data-id', data.response.id)
                    $('.verify-form').addClass('otp-register')
                    toastr.success(data.response.message, 'Thành công!');
                }else{
                    toastr.error(data.response.message,'Có lỗi xảy ra!');
                }
            }
        });
    }
});

// Validate nhập mã OTP quên mật khẩu và đăng ký

$('.verify-form').validate({
    rules: {
		otp: {
			required: true,
		}
	},
	messages: {
		otp: {
			required: "Xin vui lòng nhập mã OTP",
		},
	},
	errorPlacement: function(error, element){
        if ( element.is(":radio") ){
            error.appendTo( element.parents('.form-group') );
        }else{
            error.insertAfter( element );
        }
 	},
 	submitHandler: function(form) {
        $('.hd-verify').attr('disabled', 'disabled');
        $('.hd-verify').addClass('disabled')
        if($('.verify-form').hasClass('otp-register')){
        	let form_URL = 'ajax/frontend/auth/signup';
	        $.ajax({
	            type: 'post',
	            dataType: 'json',
	            data: {id: $('.otp-register').attr('data-id'), otp: $('.otp-register input[name="otp"]').val()},
	            url: form_URL,
	            success:function(data){
	            	$('.hd-verify').removeAttr('disabled')
	       	 		$('.hd-verify').removeClass('disabled')
	                if(data.response.code == 10){
	                	$('.verify-form')[0].reset();
	                    $('.back-to-form').trigger('click')
	                    toastr.success(data.response.message, 'Thành công!');
	                }else{
	                    toastr.error(data.response.message,'Có lỗi xảy ra!');
	                }
	            }
	        });
        }else if($('.verify-form').hasClass('otp-forgot')){
        	let form_URL = 'ajax/frontend/auth/get_new_password';
	        $.ajax({
	            type: 'post',
	            dataType: 'json',
	            data: {id: $('.otp-forgot').attr('data-id'), otp: $('.otp-forgot input[name="otp"]').val()},
	            url: form_URL,
	            success:function(data){
	            	$('.hd-verify').removeAttr('disabled')
	       	 		$('.hd-verify').removeClass('disabled')
	                if(data.response.code == 10){
	                	$('.verify-form')[0].reset();
	                    $('.back-to-form').trigger('click')
	                    toastr.success(data.response.message, 'Thành công!');
	                }else{
	                    toastr.error(data.response.message,'Có lỗi xảy ra!');
	                }
	            }
	        });
        }
    }
});

// Validate quên mật khẩu để nhận mã OTP

$('.forgot-form').validate({
    rules: {
		email: {
			required: true,
			email: true
		},
	},
	messages: {
		email: {
			required: "Xin vui lòng nhập Email",
			email: "Định dạng Email không hợp lệ"
		},
	},
	errorPlacement: function(error, element){
        if ( element.is(":radio") ){
            error.appendTo( element.parents('.form-group') );
        }else{
            error.insertAfter( element );
        }
 	},
 	submitHandler: function(form) {
        let form_URL = 'ajax/frontend/auth/send_otp_forgot';
        $('.hd-forgot').attr('disabled', 'disabled');
        $('.hd-forgot').addClass('disabled')
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: { email: $('.forgot-form input[name="email"]').val()},
            url: form_URL,
            success:function(data){
            	$('.hd-forgot').removeAttr('disabled')
       	 		$('.hd-forgot').removeClass('disabled')
                if(data.response.code == 10){
                	$('.forgot-form')[0].reset();
                    $('.forgot').removeClass('block')
                    $('.verify').addClass('block')
                    $('.verify-form').attr('data-id', data.response.id)
                    $('.verify-form').addClass('otp-forgot')
                    toastr.success(data.response.message, 'Thành công!');
                }else{
                    toastr.error(data.response.message,'Có lỗi xảy ra!');
                }
            }
        });
    }
});

function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    } else {
        return true;
    }
}
