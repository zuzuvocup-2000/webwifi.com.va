<?php

    // Login Google

    require_once 'vendor/autoload.php';
    $google_client = new Google_Client();
    $google_client->setClientId(GOOGLE_CLIENT_ID);
    $google_client->setClientSecret(GOOGLE_SECRET_ID);
    $google_client->setRedirectUri(BASE_URL.'login-gmail');
    $google_client->addScope('email');
    $google_client->addScope('profile');
    $url = $google_client->createAuthUrl();

?>
<div id="login-modal" class="uk-modal">
    <div class="uk-modal-dialog">
        <a href="" class="uk-modal-close uk-close"></a>
        <div class="back-to-form hide"><svg class="tiktok-1i5fgpz-StyledChevronLeftOffset eg439om1" width="1em" height="1em" viewBox="0 0 48 48" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.58579 22.5858L20.8787 6.29289C21.2692 5.90237 21.9024 5.90237 22.2929 6.29289L23.7071 7.70711C24.0976 8.09763 24.0976 8.7308 23.7071 9.12132L8.82843 24L23.7071 38.8787C24.0976 39.2692 24.0976 39.9024 23.7071 40.2929L22.2929 41.7071C21.9024 42.0976 21.2692 42.0976 20.8787 41.7071L4.58579 25.4142C3.80474 24.6332 3.80474 23.3668 4.58579 22.5858Z"></path></svg></div>
        <div class="login-main">
            <div class="login">
                <h1 class="heading-1"><span>Đăng nhập</span></h1>
                <div id="login-phone" class="loginfor"><a href="" title=""><i class="fa fa-mobile" aria-hidden="true"></i> Số điện thoại</a></div>
                <div id="login-apple" class="loginfor"><a href="" onclick="toastr.warning('Chức năng đang được nâng cấp!');return false;" title=""><i class="fa fa-apple" aria-hidden="true"></i> Apple</a></div>
                <div id="login-facebook" class="loginfor">
                    <a href="" onclick="fblogin()" target="_blank" title=""><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a>
                </div>
                <div id="login-google" class="loginfor"><a href="<?php echo $url ?>" target="_blank" title=""><i class="fa fa-google" aria-hidden="true"></i> Gmail</a></div>
                <form action="" novalidate="novalidate" class="login-form">
                    <div class="wrap-input mb10">
                        <label>Số điện thoại</label>
                        <input autocomplete="on" type="text" required name="phone" value="" class="form-input">
                    </div>
                    <div class="wrap-input mb10">
                        <label>Password</label>
                        <input autocomplete="on" type="password" required name="password" value="" class="form-input">
                    </div>
                    <a href="" class="login-forgot-pass uk-display-inline-block mb10">Quên mật khẩu?</a>
                    <div  class="btn-login" ><button class="hd-login" type="submit">Đăng nhập</button></div>
                </form>
            </div>
            <div class="register">
                <h1 class="heading-1"><span>Đăng ký</span></h1>
                <form action="" novalidate="novalidate" class="register-form">
                    <div class="wrap-input mb10">
                        <label>Số điện thoại</label>
                        <input autocomplete="on" type="text" required name="phone" value="" class="form-input">
                    </div>
                    <div class="wrap-input mb10">
                        <label>Email</label>
                        <input autocomplete="on" type="text" required name="email" value="" class="form-input">
                    </div>
                    <div class="wrap-input mb10">
                        <label>Nhập mật khẩu</label>
                        <input autocomplete="on" type="password" required name="password" value="" class="form-input password-register">
                    </div>
                    <div class="wrap-input mb20">
                        <label>Nhập lại mật khẩu</label>
                        <input autocomplete="on" type="password" required name="password_confirm" value="" class="form-input">
                    </div>
                    <div  class="btn-login" ><button class="hd-register" type="submit">Xác nhận</button></div>
                </form>
            </div>
            <div class="forgot">
                <h1 class="heading-1"><span>Quên mật khẩu</span></h1>
                <form action="" novalidate="novalidate" class="forgot-form">
                    <div class="wrap-input mb10">
                        <label>Email</label>
                        <input autocomplete="on" type="text" required name="email" value="" class="form-input">
                    </div>
                    <div class="btn-login" ><button class="hd-forgot" type="submit">Xác nhận</button></div>
                </form>
            </div>
            <div class="verify">
                <h1 class="heading-1"><span>Xác nhận mã OTP</span></h1>
                <form action="" novalidate="novalidate" class="verify-form">
                    <div class="wrap-input mb10">
                        <label>Nhập mã gồm 6 số</label>
                        <input autocomplete="on" type="number" required name="otp" value="" class="form-input">
                    </div>
                    <div class="btn-login" ><button class="hd-verify" type="submit">Xác nhận</button></div>
                </form>
            </div>
        </div>
        <div class="login-foot">
            <div class="btn-register"><span>Bạn không có tài khoản ?</span> <a href="" title="">Đăng ký</a></div>
            <!-- <div class="btn-forgot"><a  href="" title="">Quên mật khẩu ?</a></div> -->
            <div class="btn-login2"><span>Bạn đã có tài khoản?</span><a  href="" title="">Đăng nhập</a></div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $('#login-phone').on('click', function(){
            reset_display(' .verify, .register, .btn-login2, .btn-register, .login, .forgot, .login-form, .loginfor, .back-to-form')
            $('.login-form').addClass('block')
            $('.loginfor').addClass('hide')
            return false;
        });
        $('.login-forgot-pass').on('click', function(){
            reset_display(' .verify, .register, .btn-login2, .btn-register, .login, .forgot, .login-form, .loginfor, .back-to-form')
            $('.forgot').addClass('block')
            $('.login').addClass('hide')
            return false;
        });
        $('.btn-login2').on('click', function(){
            reset_display(' .verify, .register, .btn-login2, .btn-register, .login, .forgot, .login-form, .loginfor, .back-to-form')
            $('.register, .btn-login2').addClass('hide')
            $('.btn-register, .login').addClass('block')
            return false;
        });

        $('.btn-open-modal-login, .back-to-form').on('click', function(){
            reset_display(' .verify, .register, .btn-login2, .btn-register, .login, .forgot, .login-form, .loginfor, .back-to-form')
            $('.back-to-form').addClass('hide')
        });
        $('.btn-register').on('click', function(){
            reset_display(' .verify, .register, .btn-login2, .btn-register, .login, .forgot, .login-form, .loginfor, .back-to-form')
            $('.register, .btn-login2').addClass('block')
            $('.btn-register, .login').addClass('hide')
            return false;
        });
    });

    function reset_display(class_name){
        $(class_name).removeClass('block').removeClass('hide')
    }
</script>

<style>
.login,
.forgot,
.verify,

.register{
  padding: 50px 50px 20px 50px;
}
.verify,

.register{
  display: none;
}
.forgot{
  display: none;
}
.verify .heading-1,
.login .heading-1,
.change-password .heading-1,
.forgot .heading-1,
.register .heading-1{
  text-align: center;
  font-family: "Work Sans";
  line-height: 1;
  font-weight: bold;
  font-size: 32px;
  margin-bottom: 30px;
}
.login  .loginfor:not(:last-child){
  margin-bottom: 20px;
}
.login  .loginfor{
  position: relative;
}
.login  .loginfor a{
  display: block;
  padding: 15px 30px;
  text-align: center;
  border: 1px solid rgb(227 225 228);
  color: rgb(22, 24, 35);
}
  .loginfor:nth-child(2) i{
  left: 6%;;
}
 .loginfor:nth-child(5) i{
  left: 5%;;
}
 .loginfor i{
  position: absolute;
  top: 21%;
  left: 5%;
  font-size: 35px;
}
.login-foot{
  border-top: 1px solid rgb(227 225 228);
  text-align: center;
  padding: 20px 0;
}
.btn-register a{
  color: rgb(254, 44, 85);
}
.btn-forgot{
  display: none;
}
.btn-forgot a{
  color: rgb(254, 44, 85);
}
.btn-login2{
  display: none;
}
.btn-login2 a{
  color: rgb(254, 44, 85);
}
.uk-open .uk-modal-dialog {
  padding: 0;
}
.login-form{
  display: none;
}
.login-form {
  padding: 0 50px;
}
.login-form  input{
  width: 100%;
  border: 1px solid rgb(227 225 228);
  height: 50px;
  background: rgba(241, 241, 242, 1);
  border-radius: 5px;
}
.forgot-form{
  margin-bottom: 30px;
}
.forgot-form  input[type="submit" i]{
    cursor: pointer;
    position: absolute;
    width: 80px;
    right: 0;
    top: 29px;
    text-align: center;
    color: rgba(176,176,202,1);
    background: white;
}
.forgot-form  .wrap-input{
  position: relative;
}
.forgot-form {
  padding: 0 50px;
}
.forgot-form  input{
  width: 100%;
  border: 1px solid rgb(227 225 228);
  height: 50px;
  background: rgba(241, 241, 242, 1);
  border-radius: 5px;
}
.forgot-form  input{
  width: 100%;
  border: 1px solid rgb(227 225 228);
  height: 50px;
  background: rgba(241, 241, 242, 1);
  border-radius: 5px;
}
.verify-form  input,
.register-form  input{
  width: 100%;
  border: 1px solid rgb(227 225 228);
  height: 50px;
  background: rgba(241, 241, 242, 1);
  border-radius: 5px;
}
.btn-login button{
  border: 1px solid rgb(227 225 228);
  background: rgba(241, 241, 242, 1);
  color: #fff;
  display: inline-block;
  width: 100%;
  text-align: center;
  height: 50px;
  line-height: 50px;
}
.uk-modal-close.uk-close {
    background: #fff url(../public/close.png) center no-repeat;
}

.login-forgot-pass{
  font-size: 12px;
  color: #000;
}

.back-to-form{
  display: inline-block;
  width: 35px;
  height: 35px;
  position: absolute;
  top: 20px;
  left: 20px;
  font-size: 30px;
  line-height: 30px;
  cursor: pointer;
  text-align: center;
}

.custom-nav.stickyadd .container-fluid .navbar-nav li a {
    color: #000;
}

#login-modal input{
    padding: 0 15px;
}

.error{
    color: red;
}

.form-input.error{
    border: 1px solid red;
}

.disabled{
    cursor: not-allowed;
}

</style>
<script>
    window.fbAsyncInit = function () {
        FB.init({
            appId: "<?php echo FACEBOOK_APP_ID ?>",
            autoLogAppEvents: true,
            xfbml: true,
            version: "v14.0",
        });
    };

    (function (d, s, id) {
        var js,
            fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    })(document, "script", "facebook-jssdk");
</script>
<script>
    function fblogin() {
        FB.login(function (response) {
            if (response.authResponse) {
                FB.api("/me", function (response) {
                    let ajaxUrl = "frontend/auth/fb/login";
                    $.ajax({
                        method: "POST",
                        url: ajaxUrl,
                        data: {data: response},
                        dataType: "json",
                        cache: false,
                        success: function(data){
                            if($.trim(data) == 1){
                                toastr.success('Thành công!','Đăng nhập thành công!');
                            }else{
                                toastr.error('Có lỗi xảy ra!','Xin vui lòng thử lại!');
                            }
                            window.location.reload()
                        }
                    });
                    console.log("Good to see you, " + response.name + ".");
                });
            } else {
                console.log("User cancelled login or did not fully authorize.");
            }
        });
    }
</script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
