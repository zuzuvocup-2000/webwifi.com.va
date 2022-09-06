 <section class="login-panel">
    <div class="container-1 uk-container-center">
        <div class="uk-grid uk-grid-large dt-reverse">
            <div class="uk-width-large-1-2 uk-width-medium-1-1 uk-width-small-1-1">
                <div class="login-box-wrap">
                    <div class="login-box">
                        <div class="login-box-title">
                            Xác nhận OTP
                        </div>
                        <?php 
                            $token = (isset($_GET['token']) ? json_decode(base64_decode($_GET['token']),true) : '');
                        ?>
                        <form class="login-form" method="post" action="frontend/auth/auth/verify?token=<?php echo (isset($_GET['token']) ? $_GET['token'] : '') ?>" >
                            <?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
                            <div class="form-row mb15">
                                <div class="input-logo">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </div>
                                
                                <input type="text" name="email" value="<?php echo (isset($token['email']) ? $token['email'] : '') ?>" readonly class="input-text" placeholder="Tên truy cập">
                            </div> 
                            <div class="form-row mb15">
                                <div class="input-logo">
                                    <i class="fa fa-unlock" aria-hidden="true"></i>
                                </div>
                                <input type="text" name="otp" value=""  class="input-text" placeholder="Nhập mã OTP...">
                            </div> 
                            <div class="form-row mb10">
                                <input type="submit" name="" class="btn-submit" value="Xác nhận OTP">
                            </div>                          
                            <div class="forgot-password">
                                Bạn đã có tài khoản, 
                                <a href="login.html" title="Đăng nhập">
                                    Đăng nhập
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="uk-width-large-1-2 uk-width-medium-1-1 uk-width-small-1-1">
                <div class="login-alert-panel">
                    <header class="header">
                        <h2 class="heading">
                            Thông báo
                        </h2>
                    </header>
                    <div class="login-alert-body">
                        <?php if(isset($panel['alert']['data']) && is_array($panel['alert']['data']) && count($panel['alert']['data'])){
                            foreach ($panel['alert']['data'] as $key => $value) {
                        ?>
                            <div class="login-alert-item">
                                <div class="panel-top uk-flex uk-flex-middle uk-flex-space-between mb10">
                                    <div class="date">
                                        <?php echo date('d-m-Y', strtotime($value['created_at'])) ?>
                                    </div>
                                    <div class="more">
                                        <a href="<?php echo $value['canonical'] ?>" title="<?php echo $value['title'] ?>" class="uk-flex uk-flex-middle">
                                            <span class="mr5">Xem thêm</span>
                                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-title">
                                    <a href="<?php echo $value['canonical'] ?>" title="<?php echo $value['title'] ?>" >
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                        <?php echo $value['title'] ?>
                                    </a>
                                </div>
                                <div class="panel-text line-2">
                                    <?php echo strip_tags($value['description']) ?>
                                </div>
                            </div>
                        <?php }}else{ ?>
                            <div class="text-danger">Không có thông báo để hiển thị</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>