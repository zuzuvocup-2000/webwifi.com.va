<div class="page-wrapper">
    <!-- End Header -->
    <main class="main">
        <div class="page-content">
            <main class="main">
                <nav class="breadcrumb-nav">
                    <div class="container">
                        <ul class="breadcrumb">
                            <li><a href="/"><i class="d-icon-home"></i></a></li>
                            <li>Đăng nhập</li>
                        </ul>
                    </div>
                </nav>
                <div class="page-content mt-6 pb-2 mb-10">
                    <div class="container">
                        <div class="login-popup">
                            <div class="form-box">
                                <div class="tab tab-nav-simple tab-nav-boxed form-tab">
                                    <ul class="nav nav-tabs nav-fill align-items-center border-no justify-content-center mb-5" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active border-no lh-1 ls-normal btn-login" data-tab='tab-1'>Đăng nhập</a>
                                        </li>
                                        <li class="delimiter">hoặc</li>
                                        <li class="nav-item">
                                            <a class="nav-link border-no lh-1 ls-normal btn-login" data-tab='tab-2'>Đăng ký</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active tab-1" id="signin">
                                            <form method="POST">
                                                <div class="form-group mb-3">
                                                <input type="text" class="form-control" id="singin-email" name="email" placeholder="Email đăng nhập *" required />
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" id="singin-password" name="password" placeholder="Mật khẩu *"
                                                required />
                                            </div>
                                            <div class="form-footer">
                                                <div class="form-checkbox">
                                                    <input type="checkbox" class="custom-checkbox" id="signin-remember"
                                                    name="signin-remember" />
                                                    <label class="form-control-label" for="signin-remember">Nhớ tôi</label>
                                                </div>
                                                
                                            </div>
                                            <button class="btn btn-dark btn-block btn-rounded push-login" type="submit">Đăng nhập</button>
                                        </form>
                                    </div>
                                    <div class="tab-pane tab-2" id="register">
                                        <form  method="POST">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="register-name" name="name" placeholder="Họ tên *"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="register-email" name="email" placeholder="Email đăng nhập *"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" id="register-password" name="password" placeholder="Mật khẩu *"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control" id="register-phone" name="phone" placeholder="Số điện thoại *"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="register-address" name="address" placeholder="Địa chỉ *"/>
                                            </div>
                                            <button class="btn btn-dark btn-block btn-rounded btn-register">Đăng ký</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</main>
</div>