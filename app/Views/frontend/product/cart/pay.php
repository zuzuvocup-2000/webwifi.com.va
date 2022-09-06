<?php
$widget = [];
// $widget['data'] = widget_frontend();
$system = get_system();
$info = (isset($_COOKIE['data_cart']) ? json_decode($_COOKIE['data_cart'],true) : []);
?>
<!DOCTYPE html>
<html lang="vi-VN">
    <head>
        <!-- CONFIG -->
        <base href="<?php echo BASE_URL ?>" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="index,follow" />
        <meta name="author" content="<?php echo (isset($general['homepage_company'])) ? $general['homepage_company'] : ''; ?>" />
        <meta name="copyright" content="<?php echo (isset($general['homepage_company'])) ? $general['homepage_company'] : ''; ?>" />
        <meta http-equiv="refresh" content="1800" />
        <link rel="icon" href="<?php echo $general['homepage_favicon'] ?>" type="image/png" sizes="30x30">
        <!-- GOOGLE -->
        <title><?php echo isset($meta_title)?htmlspecialchars($meta_title):'';?></title>
        <meta name="description"  content="<?php echo isset($meta_description)?htmlspecialchars($meta_description):'';?>" />
        <?php echo isset($canonical)?'<link rel="canonical" href="'.$canonical.'" />':'';?>
        <meta property="og:locale" content="vi_VN" />
        <!-- for Facebook -->
        <meta property="og:title" content="<?php echo (isset($meta_title) && !empty($meta_title))?htmlspecialchars($meta_title):'';?>" />
        <meta property="og:type" content="<?php echo (isset($og_type) && $og_type != '') ? $og_type : 'article'; ?>" />
        <meta property="og:image" content="<?php echo (isset($meta_image) && !empty($meta_image)) ? $meta_image : base_url(isset($general['homepage_logo']) ? $general['homepage_logo'] : ''); ?>" />
        <?php echo isset($canonical)?'<meta property="og:url" content="'.$canonical.'" />':'';?>
        <meta property="og:description" content="<?php echo (isset($meta_description) && !empty($meta_description))?htmlspecialchars($meta_description):'';?>" />
        <meta property="og:site_name" content="<?php echo (isset($general['homepage_company'])) ? $general['homepage_company'] : ''; ?>" />
        <meta property="fb:admins" content=""/>
        <meta property="fb:app_id" content="" />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="<?php echo isset($meta_title)?htmlspecialchars($meta_title):'';?>" />
        <meta name="twitter:description" content="<?php echo (isset($meta_description) && !empty($meta_description))?htmlspecialchars($meta_description):'';?>" />
        <meta name="twitter:image" content="<?php echo (isset($meta_image) && !empty($meta_image))?$meta_image:base_url((isset($general['homepage_logo'])) ? $general['homepage_logo']  : '');?>" />
        <?php
        $check_css = false;
        foreach ($system as $key => $value) {
        if($value['module'] == 'cart' && $value['keyword'] == 'cart_css'){
        $check_css = true;
        echo $system['cart_css']['content'];
        }
        }
        if($check_css == false){
        echo $system['normal_css']['content'];
        }
        ?>
        <?php echo view('frontend/homepage/common/style', $widget) ?>
        <?php echo view('frontend/homepage/common/head') ?>
        <?php echo $system['general_css']['content'] ?>
        <?php echo $system['general_script_top']['content'] ?>
        <script type="text/javascript">
        var BASE_URL = '<?php echo BASE_URL; ?>';
        var SUFFIX = '<?php echo HTSUFFIX; ?>';
        </script>
        <?php echo $general['analytic_google_analytic'] ?>
        <?php echo $general['facebook_facebook_pixel'] ?>
        <style>
        .comboid{
        background: #ed2e33;
        color: #fff;
        width: 20px;
        height: 20px;
        text-align: center;
        line-height: 20px;
        border-radius: 100%;
        position: absolute;
        top: -10px;
        right: -10px;
        }
        </style>
    </head>
    <body>
        <?php echo view('frontend/homepage/common/header') ?>
        <div class="page-wrapper">
            <!-- End Header -->
            <main class="main">
                <div class="page-content">
                    <!-- End Header -->
                    <main class="main checkout">
                        <div class="page-content pt-7 pb-10 mb-10">
                            <div class="step-by pr-4 pl-4">
                                <h3 class="title title-simple title-step"><a href="gio-hang.html">1. Giỏ hàng</a></h3>
                                <h3 class="title title-simple title-step active"><a>2. Thanh toán</a></h3>
                                <h3 class="title title-simple title-step"><a>3. Hoàn tất đơn hàng</a></h3>
                            </div>
                            <div class="container mt-7">
                                <?php 
                                /*<?php if(!isset($member) || !is_array($member) || count($member) == 0){ ?>
                                    <div class="card accordion">
                                        <div class="alert alert-light alert-primary alert-icon mb-4 card-header">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span class="text-body">Phản hồi khách hàng?</span>
                                            <a href="#alert-body1" class="text-primary collapse">Nhấn vào đây để đăng nhập</a>
                                        </div>
                                        <div class="alert-body collapsed" id="alert-body1">
                                            <p>Vui lòng đăng nhập. Nếu bạn là khách hàng mới, vui lòng tạo tài khoản hoặc chuyển đến phần Thanh toán.</p>
                                            <div class="row cols-md-2">
                                                <form class="mb-4 mb-md-0">
                                                    <label for="username">Email đăng nhập *</label>
                                                    <input type="text" class="email-login input-text form-control mb-0" name="username" id="singin-email" autocomplete="username">
                                                </form>
                                                <form class="mb-4 mb-md-0">
                                                    <label for="password">Mật khẩu *</label>
                                                    <input class="password-login input-text form-control mb-0" type="password" name="password" id="singin-password" autocomplete="current-password">
                                                </form>
                                                <p class="validate-message validate-login"></p>
                                            </div>
                                            <div class="checkbox d-flex align-items-center justify-content-between">
                                                <div class="form-checkbox pt-0 mb-0">
                                                    <input type="checkbox" class="custom-checkbox" id="signin-remember"
                                                    name="signin-remember" />
                                                    <label class="form-control-label" for="signin-remember">Nhớ tôi</label>
                                                </div>
                                                
                                            </div>
                                            <div class="link-group">
                                                <a style="margin-right: 20px;" class="btn btn-dark btn-rounded mb-4 push-login">Đăng nhập</a> hoặc <a class="text-primary" href="login.html">Đăng ký tài khoản mới</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>*/
                                 ?>
                                
                                <form method="post" >
                                    <div class="card accordion">
                                        <div class="alert alert-light alert-primary alert-icon mb-4 card-header">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span class="text-body">Bạn có mã giảm giá?</span>
                                            <a href="#alert-body2" class="text-primary">Bấm vào đây để nhập mã của bạn</a>
                                        </div>
                                        <div class="alert-body mb-4 collapsed" id="alert-body2">
                                            <p>Nếu bạn có mã giảm giá, vui lòng áp dụng nó bên dưới.</p>
                                            <div class="check-coupon-box d-flex">
                                                <input type="text" name="coupon_code" class="coupon_code discount_code input-text form-control text-grey ls-m mr-4" id="coupon_code" value="<?php echo isset($voucher['voucherid']) ? $voucher['voucherid'] : '' ?>" placeholder="Nhập mã phiếu giảm giá tại đây...">
                                                <input type="hidden" value="<?php echo isset($voucher['price']) ? $voucher['price'] : '' ?>" class="voucher_price_hidden">
                                                <input type="hidden" value="<?php echo isset($voucher['voucherid']) ? $voucher['voucherid'] : '' ?>" class="voucherid_hidden">
                                                <button type="submit" class="btn-coupon__code btn btn-dark btn-rounded btn-outline">Áp dụng</button>
                                            </div>
                                            <p class="validate-message validate-ship__coupon">Vui lòng nhập mã giảm giá!</p>
                                            <p class="validate-message check-ship__coupon">Mã giảm giá không đúng hoặc đã hết hạn!</p>
                                            <p class="alert-notification alert-coupon"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-7 mb-6 mb-lg-0 pr-lg-4">
                                            <h3 class="title title-simple text-left text-uppercase">CHI TIẾT THANH TOÁN</h3>
                                            <label>Họ tên *</label>
                                            <input value="<?php echo (isset($member['fullname']) ? $member['fullname'] : (isset($info['fullname']) ? $info['fullname'] : '')) ?>" type="text" class="form-control formcart-name" name="name"
                                            placeholder="Họ tên"/>
                                            <p class="validate-message validate-name">Vui lòng điền họ tên!</p>
                                            <label>Số điện thoại *</label>
                                            <input type="number" value="<?php echo (isset($member['phone']) ? $member['phone'] : (isset($info['phone']) ? $info['phone'] : '')) ?>" class="form-control formcart-phone" name="phone" placeholder="Số điện thoại" />
                                            <p class="validate-message validate-phone">Vui lòng điền số điện thoại!</p>
                                            <p class="validate-message check-phone">Số điện thoại không đúng định dạng!</p>
                                            <label>Email</label>
                                            <input type="text" value="<?php echo (isset($member['email']) ? $member['email'] : (isset($info['email']) ? $info['email'] : '')) ?>" class="form-control formcart-email" name="email" placeholder="Email" />
                                            <script>
                                            var cityid = '<?php echo (isset($_POST['cityid'])) ? $_POST['cityid'] : ((isset($info['cityid']) ? $info['cityid'] : '')); ?>';
                                            var districtid = '<?php echo (isset($_POST['districtid'])) ? $_POST['districtid'] : ((isset($info['districtid']) ? $info['districtid'] : '')); ?>'
                                            var wardid = '<?php echo (isset($_POST['wardid'])) ? $_POST['wardid'] : ((isset($info['wardid']) ? $info['wardid'] : '')); ?>'
                                            </script>
                                            <p class="validate-message check-email">Email không đúng định dạng!</p>
                                            <label>Tỉnh/ Thành phố *</label>
                                            <div class="select-box">
                                                <?php
                                                $city = get_data(['select' => 'provinceid, name','table' => 'vn_province','order_by' => 'order desc, name asc']);
                                                $city = convert_array([
                                                'data' => $city,
                                                'field' => 'provinceid',
                                                'value' => 'name',
                                                'text' => 'Thành Phố',
                                                ]);
                                                ?>
                                                <?php echo form_dropdown('cityid', $city, set_value('cityid', (isset($info['cityid'])) ? $info['cityid'] : 0), 'class="form-control m-b city"  id="city"');?>
                                            </div>
                                            <p class="validate-message validate-province">Vui lòng chọn tỉnh/ thành phố nhận hàng!</p>
                                            <label>Chọn Quận/ Huyện *</label>
                                            <div class="select-box">
                                                <select name="districtid" id="district" class="form-control m-b location change-district">
                                                    <option value="0">[Chọn Quận/Huyện]</option>
                                                </select>
                                            </div>
                                            <p class="validate-message validate-district">Vui lòng chọn quận/ huyện nhận hàng!</p>
                                            <label>Địa chỉ *</label>
                                            <input type="text" value="<?php echo (isset($member['address']) ? $member['address'] : (isset($info['address']) ? $info['address'] : '')) ?>" class="form-control formcart-address" name="address" placeholder="Số nhà, thôn, xóm,..." />
                                            <p class="validate-message validate-address">Vui lòng điền địa chỉ nhận hàng!</p>
                                            <h2 class="title title-simple text-uppercase text-left">Thông tin thêm</h2>
                                            <label>Ghi chú đơn hàng (Tùy chọn)</label>
                                            <textarea class="form-control formcart-note" name="note"
                                            placeholder="Ghi chú"></textarea>
                                        </div>
                                        <aside class="col-lg-5 sticky-sidebar-wrapper">
                                            <div class="sticky-sidebar mt-1" data-sticky-options="{'bottom': 50}">
                                                <div class="summary pt-5">
                                                    <h3 class="title title-simple text-left text-uppercase">ĐƠN HÀNG CỦA BẠN</h3>
                                                    <table class="order-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Sản phẩm</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(isset($cart) && is_array($cart) && count($cart)){
                                                            foreach ($cart as $key =>  $value) {
                                                            ?>
                                                            <tr>
                                                                <td style="padding-bottom: 0" class="product-name">
                                                                    <?php echo $value['detail']['title'] ?>
                                                                    <span class="product-quantity">× <?php echo $value['qty'] ?></span>
                                                                </td>
                                                                <td style="padding-bottom: 0" class="product-total text-body"><?php echo number_format($value['subtotal'],0,',','.') ?> ₫</td>
                                                            </tr>
                                                            <?php }} ?>
                                                            
                                                            <tr class="summary-subtotal">
                                                                <td>
                                                                    <h4 class="summary-subtitle">Tổng</h4>
                                                                </td>
                                                                <?php $voucher_price = (isset($voucher['price']) ? $voucher['price'] : 0) ?>
                                                                <td class="summary-subtotal-price pb-0 pt-0"><?php echo number_format($cartTotal + $voucher_price,0,',','.') ?>₫
                                                                </td>
                                                            </tr>
                                                            <tr class="sumnary-shipping shipping-row-last">
                                                                <tr>
                                                                    <td class="product-name">Phí vận chuyển</td>
                                                                    <td class="product-total text-body total_shipping">0 đ</td>
                                                                </tr>
                                                                <tr class="" >
                                                                    <td class="product-name">Giảm giá</td>
                                                                    <td class="price-reduction text-body " id="total_discount" data-price="<?php echo isset($voucher['price']) ? $voucher['price'] : '' ?>"><?php echo isset($voucher['price']) ? number_format($voucher['price'],0,',','.') : '' ?>₫</td>
                                                                </tr>
                                                            </tr>
                                                            <tr class="summary-total">
                                                                <td class="pb-0">
                                                                    <h4 class="summary-subtitle">Thành tiền</h4>
                                                                </td>
                                                                <td class=" pt-0 pb-0">
                                                                    <p class="summary-total-price cart-price ls-s text-primary total_shipping_price"  id="total"><?php echo number_format($cartTotal,0,',','.') ?>đ</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="payment accordion radio-type">
                                                        <h4 class="summary-subtitle ls-m pb-3">Phương thức thanh toán</h4>
                                                        <div class="custom-radio" style="margin-bottom: 15px;">
                                                            <input type="radio" id="payment_method_1" name="payment_method" class="custom-control-input" value="1"  checked >
                                                            <label class="custom-control-label" for="payment_method_1">COD (Thanh toán khi nhận hàng)</label>
                                                        </div>
                                                        <div class="custom-radio">
                                                            <input type="radio" id="payment_method_2" name="payment_method" class="custom-control-input" value="2" >
                                                            <label class="custom-control-label" for="payment_method_2">Thanh toán online (Chuyển khoản)</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-checkbox mt-4 mb-5">
                                                        <input type="checkbox" checked class="custom-checkbox" id="terms-condition"
                                                        name="terms-condition" value='1'/>
                                                        <label class="form-control-label" for="terms-condition">
                                                            Tôi đã đọc và đồng ý với các điều khoản và điều kiện của trang web *
                                                        </label>
                                                        <p class="validate-message validate-rules">Vui lòng đồng ý với điều khoản của chúng tôi!</p>
                                                    </div>
                                                    <button type="submit" class="btn btn-dark btn-rounded btn-order button_order">Đặt hàng</button>
                                                </div>
                                            </div>
                                        </aside>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </main>
                    <!-- End Main -->
                </div>
            </main>
        </div>
        <script>
        <?php echo isset($script) ? $script : '' ?>
        </script>
        <?php echo view('frontend/homepage/common/footer') ?>
        <?php echo view('frontend/homepage/common/offcanvas') ?>
        <?php echo view('backend/dashboard/common/notification') ?>
        <!-- Tao Widget -->
        <?php
        if(isset($widget['data']) && is_array($widget['data']) && count($widget['data'])){
        foreach ($widget['data'] as $key => $value) {
        echo  str_replace("[phone]", isset($general['contact_phone']) ? $general['contact_phone'] : '', $value['html']);
        echo '<script>'.$value['script'].'</script>';
        }
        }
        ?>
        <?php
        $check_script = false;
        foreach ($system as $key => $value) {
        if($value['module'] == 'cart' && $value['keyword'] == 'cart_script'){
        $check_script = true;
        echo $system['cart_script']['content'];
        }
        }
        if($check_script == false){
        echo $system['normal_script']['content'];
        }
        ?>
        <?php echo $system['general_script_bottom']['content'] ?>
    </body>
</html>