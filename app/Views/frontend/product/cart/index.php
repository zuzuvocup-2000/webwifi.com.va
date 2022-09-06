<?php
$widget = [];
// $widget['data'] = widget_frontend();
$system = get_system();
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
                    <main class="main cart">
                        <div class="page-content pt-7 pb-10">
                            <div class="step-by pr-4 pl-4">
                                <h3 class="title title-simple title-step active"><a>1. Giỏ hàng</a></h3>
                                <h3 class="title title-simple title-step"><a>2. Thanh toán</a></h3>
                                <h3 class="title title-simple title-step"><a>3. Hoàn tất đơn hàng</a></h3>
                            </div>
                            <div class="container mt-7 mb-2">
                                <form class="row"  method="POST">
                                    <div class="col-lg-8 col-md-12 pr-lg-4">
                                        <table class="shop-table cart-table">
                                            <thead>
                                                <tr>
                                                    <th><span>Sản phẩm</span></th>
                                                    <th></th>
                                                    <th><span>Giá bán</span></th>
                                                    <th><span>Số lượng</span></th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(isset($cart) && is_array($cart) && count($cart)){
                                                    foreach ($cart as $key =>  $value) {
                                                ?>
                                                    <tr class="table-cart delete-cart-<?php echo $key ?>" id="delete-cart-<?php echo $key ?>">
                                                        <td class="product-thumbnail">
                                                            <figure>
                                                                <a href="<?php echo $value['detail']['canonical'].HTSUFFIX ?>">
                                                                    <figure>
                                                                        <img src="<?php echo $value['detail']['image'] ?>" width="100" height="100"
                                                                        alt="<?php echo $value['detail']['title'] ?>">
                                                                    </figure>
                                                                </a>
                                                            </figure>
                                                        </td>
                                                        <td class="product-name">
                                                            <div class="product-name-section">
                                                                <a href="<?php echo $value['detail']['canonical'].HTSUFFIX ?>"><?php echo $value['detail']['title'] ?></a>
                                                            </div>
                                                        </td>
                                                        <td class="product-subtotal">
                                                            <span class="amount"> <?php echo number_format($value['price'],0,',','.') ?> ₫ </span>
                                                        </td>
                                                        <td class="product-quantity">
                                                            <div class="input-group product-quantity__number">
                                                                <button type="button" data-soluong = "<?php echo $value['qty'] ?>" data-update="<?php echo $key ?>" class="cart-btnMinus quantity-minus d-icon-minus"></button>
                                                                <input disabled class="form-control count-product" value="<?php echo $value['qty'] ?>" type="text">
                                                                <button type="button" data-soluong = "<?php echo $value['qty'] ?>" data-update="<?php echo $key ?>" class="cart-btnPlus quantity-plus d-icon-plus"></button>
                                                            </div>
                                                        </td>
                                                        <td class="product-price product-subtotal subtotal">
                                                            <span class="amount"> <?php echo number_format($value['subtotal'],0,',','.') ?> ₫ </span>
                                                        </td>
                                                        <td class="product-remove product-close">
                                                            <div>
                                                                <a class="cart-remove remove" data-update="<?php echo $key ?>" title="Xóa sản phẩm khỏi giỏ hàng"><i
                                                                class="d-icon-times"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }} ?>
                                            </tbody>
                                        </table>
                                        <div class="cart-actions mb-6 pt-4">
                                            <a href="/" class="btn btn-dark btn-md btn-rounded btn-icon-left mr-4 mb-4"><i class="d-icon-arrow-left"></i>Tiếp tục mua sắm</a>
                                            
                                        </div>
                                        <div class="cart-coupon-box mb-8">
                                            <input type="hidden" name="_token" value="LkoyM4n3bbuyoR3HhIhaQdHAdIT8AyuJPzC6NND7">                        <h4 class="title coupon-title text-uppercase ls-m">Mã giảm giá</h4>
                                            <input type="text" name="coupon_code" class="coupon_code discount_code input-text form-control text-grey ls-m mb-4" id="coupon_code" value="<?php echo isset($voucher['voucherid']) ? $voucher['voucherid'] : '' ?>" placeholder="Nhập mã phiếu giảm giá tại đây...">
                                            <input type="hidden" value="<?php echo isset($voucher['price']) ? $voucher['price'] : '' ?>" class="voucher_price_hidden">
                                            <input type="hidden" value="<?php echo isset($voucher['voucherid']) ? $voucher['voucherid'] : '' ?>" class="voucherid_hidden">
                                            <p class="validate-message validate-ship__coupon">Vui lòng nhập mã giảm giá!</p>
                                            <p class="validate-message check-ship__coupon">Mã giảm giá không đúng hoặc đã hết hạn!</p>
                                            <p class="alert-notification alert-coupon"></p>
                                            <button type="submit" class="btn-coupon__code btn btn-md btn-dark btn-rounded btn-outline">Áp dụng</button>
                                        </div>
                                    </div>
                                    <aside class="col-lg-4 sticky-sidebar-wrapper">
                                        <div class="sticky-sidebar" data-sticky-options="{'bottom': 20}">
                                            <div class="summary mb-4">
                                                <h3 class="summary-title text-left">Giỏ hàng</h3>
                                                <table class="shipping">
                                                    <tr class="sumnary-shipping shipping-row-last">
                                                        <td colspan="2">
                                                            <h4 class="summary-subtitle">Cách thức thanh toán</h4>
                                                            <ul>
                                                                <li>
                                                                    <div class="custom-radio">
                                                                        <input type="radio" id="payment_method_1" name="payment_method" class="custom-control-input" value="1" checked>
                                                                        <label class="custom-control-label" for="payment_method_1">COD (Thanh toán khi nhận hàng)</label>
                                                                    </div>
                                                                    <div class="custom-radio">
                                                                        <input type="radio" id="payment_method_2" name="payment_method" class="custom-control-input" value="2">
                                                                        <label class="custom-control-label" for="payment_method_2">Thanh toán online (Chuyển khoản)</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <?php $info = (isset($_COOKIE['data_cart']) ? json_decode($_COOKIE['data_cart'],true) : []); ?>
                                                <script>
                                                    var cityid = '<?php echo (isset($_POST['cityid'])) ? $_POST['cityid'] : ((isset($info['cityid']) ? $info['cityid'] : '')); ?>';
                                                    var districtid = '<?php echo (isset($_POST['districtid'])) ? $_POST['districtid'] : ((isset($info['districtid']) ? $info['districtid'] : '')); ?>'
                                                    var wardid = '<?php echo (isset($_POST['wardid'])) ? $_POST['wardid'] : ((isset($info['wardid']) ? $info['wardid'] : '')); ?>'
                                                </script>
                                                <div class="shipping-address">
                                                    <label>Chọn địa điểm <strong>nhận hàng.</strong></label>
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
                                                    <p class="validate-message validate-ship__province">Vui lòng chọn tỉnh/ thành phố!</p>
                                                    <div class="select-box">
                                                        <select name="districtid" id="district" class="form-control m-b location change-district">
                                                            <option value="0">[Chọn Quận/Huyện]</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <table class="total">
                                                    <tr class="sumnary-shipping shipping-row-last">
                                                        <tr class="alert-ship">
                                                            <td class="product-name">Phí vận chuyển</td>
                                                            <td class="product-total text-body total_shipping">0₫</td>
                                                        </tr>
                                                        <tr class="alert-price_reduction">
                                                            <td class="product-name">Giảm giá</td>
                                                            <td class="price-reduction text-body " id="total_discount" data-price="<?php echo isset($voucher['price']) ? $voucher['price'] : '' ?>"><?php echo isset($voucher['price']) ? number_format($voucher['price'],0,',','.') : '' ?>₫</td>
                                                        </tr>
                                                    </tr>
                                                    
                                                    <tr class="summary-subtotal">
                                                        <td>
                                                            <h4 class="summary-subtitle">Thành tiền</h4>
                                                        </td>
                                                        <td>
                                                            <p class="summary-subtotal-price cart-price summary-total-price ls-s total_shipping_price" id="total"><?php echo number_format($cartTotal,0,',','.') ?>₫</p>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <a class="btn btn-dark btn-rounded btn-checkout btn-pay">Tiến hành thanh toán</a>
                                            </div>
                                        </div>
                                    </aside>
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