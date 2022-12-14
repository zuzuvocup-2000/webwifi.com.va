<?php
$widget = [];
// $widget['data'] = widget_frontend();
$system = get_system();
$info = isset($_COOKIE['data_cart']) ? json_decode($_COOKIE['data_cart'], true) : [];
?>
<!DOCTYPE html>
<html lang="vi-VN">
    <head>
        <!-- CONFIG -->
        <base href="<?php echo BASE_URL; ?>" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="index,follow" />
        <meta name="author" content="<?php echo isset($general['homepage_company']) ? $general['homepage_company'] : ''; ?>" />
        <meta name="copyright" content="<?php echo isset($general['homepage_company']) ? $general['homepage_company'] : ''; ?>" />
        <meta http-equiv="refresh" content="1800" />
        <link rel="icon" href="<?php echo $general['homepage_favicon']; ?>" type="image/png" sizes="30x30">
        <!-- GOOGLE -->
        <title><?php echo isset($meta_title) ? htmlspecialchars($meta_title) : ''; ?></title>
        <meta name="description"  content="<?php echo isset($meta_description) ? htmlspecialchars($meta_description) : ''; ?>" />
        <?php echo isset($canonical) ? '<link rel="canonical" href="' . $canonical . '" />' : ''; ?>
        <meta property="og:locale" content="vi_VN" />
        <!-- for Facebook -->
        <meta property="og:title" content="<?php echo isset($meta_title) && !empty($meta_title) ? htmlspecialchars($meta_title) : ''; ?>" />
        <meta property="og:type" content="<?php echo isset($og_type) && $og_type != '' ? $og_type : 'article'; ?>" />
        <meta property="og:image" content="<?php echo isset($meta_image) && !empty($meta_image) ? $meta_image : base_url(isset($general['homepage_logo']) ? $general['homepage_logo'] : ''); ?>" />
        <?php echo isset($canonical) ? '<meta property="og:url" content="' . $canonical . '" />' : ''; ?>
        <meta property="og:description" content="<?php echo isset($meta_description) && !empty($meta_description) ? htmlspecialchars($meta_description) : ''; ?>" />
        <meta property="og:site_name" content="<?php echo isset($general['homepage_company']) ? $general['homepage_company'] : ''; ?>" />
        <meta property="fb:admins" content=""/>
        <meta property="fb:app_id" content="" />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="<?php echo isset($meta_title) ? htmlspecialchars($meta_title) : ''; ?>" />
        <meta name="twitter:description" content="<?php echo isset($meta_description) && !empty($meta_description) ? htmlspecialchars($meta_description) : ''; ?>" />
        <meta name="twitter:image" content="<?php echo isset($meta_image) && !empty($meta_image) ? $meta_image : base_url(isset($general['homepage_logo']) ? $general['homepage_logo'] : ''); ?>" />
        <?php
        $check_css = false;
        foreach ($system as $key => $value) {
            if ($value['module'] == 'cart' && $value['keyword'] == 'cart_css') {
                $check_css = true;
                echo $system['cart_css']['content'];
            }
        }
        if ($check_css == false) {
            echo $system['normal_css']['content'];
        }
        ?>
        <?php echo view('frontend/homepage/common/style', $widget); ?>
        <?php echo view('frontend/homepage/common/head'); ?>
        <?php echo $system['general_css']['content']; ?>
        <link href="public/frontend/resources/fonts/fontawesome-free-5.15.4-web/css/all.min.css" rel="stylesheet" />
        <link href="public/frontend/resources/riode.css" rel="stylesheet" />
        <link href="public/frontend/resources/facybox.min.css" rel="stylesheet" />
        <link href="public/frontend/resources/all.css" rel="stylesheet"  />
        <?php echo $system['general_script_top']['content']; ?>
        <script type="text/javascript">
        var BASE_URL = '<?php echo BASE_URL; ?>';
        var SUFFIX = '<?php echo HTSUFFIX; ?>';
        </script>
        <?php echo $general['analytic_google_analytic']; ?>
        <?php echo $general['facebook_facebook_pixel']; ?>
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
        <?php echo view('frontend/homepage/common/header'); ?>
        <div class="page-wrapper">
            <!-- End Header -->
            <main class="main">
                <div class="page-content">
                    <!-- End Header -->
                    <main class="main checkout">
                        <div class="page-content pt-7 pb-10 mb-10">
                            <div class="step-by pr-4 pl-4">
                                <h3 class="title title-simple title-step"><a href="gio-hang.html">1. Gi??? h??ng</a></h3>
                                <h3 class="title title-simple title-step active"><a>2. Thanh to??n</a></h3>
                                <h3 class="title title-simple title-step"><a>3. Ho??n t???t ????n h??ng</a></h3>
                            </div>
                            <div class="container mt-7">
                                <?php
                                /*<?php if(!isset($member) || !is_array($member) || count($member) == 0){ ?>
                                    <div class="card accordion">
                                        <div class="alert alert-light alert-primary alert-icon mb-4 card-header">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span class="text-body">Ph???n h???i kh??ch h??ng?</span>
                                            <a href="#alert-body1" class="text-primary collapse">Nh???n v??o ????y ????? ????ng nh???p</a>
                                        </div>
                                        <div class="alert-body collapsed" id="alert-body1">
                                            <p>Vui l??ng ????ng nh???p. N???u b???n l?? kh??ch h??ng m???i, vui l??ng t???o t??i kho???n ho???c chuy???n ?????n ph???n Thanh to??n.</p>
                                            <div class="row cols-md-2">
                                                <form class="mb-4 mb-md-0">
                                                    <label for="username">Email ????ng nh???p *</label>
                                                    <input type="text" class="email-login input-text form-control mb-0" name="username" id="singin-email" autocomplete="username">
                                                </form>
                                                <form class="mb-4 mb-md-0">
                                                    <label for="password">M???t kh???u *</label>
                                                    <input class="password-login input-text form-control mb-0" type="password" name="password" id="singin-password" autocomplete="current-password">
                                                </form>
                                                <p class="validate-message validate-login"></p>
                                            </div>
                                            <div class="checkbox d-flex align-items-center justify-content-between">
                                                <div class="form-checkbox pt-0 mb-0">
                                                    <input type="checkbox" class="custom-checkbox" id="signin-remember"
                                                    name="signin-remember" />
                                                    <label class="form-control-label" for="signin-remember">Nh??? t??i</label>
                                                </div>
                                                
                                            </div>
                                            <div class="link-group">
                                                <a style="margin-right: 20px;" class="btn btn-dark btn-rounded mb-4 push-login">????ng nh???p</a> ho???c <a class="text-primary" href="login.html">????ng k?? t??i kho???n m???i</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>*/
?>
                                
                                <form method="post" >
                                    <div class="card accordion uk-hidden">
                                        <div class="alert alert-light alert-primary alert-icon mb-4 card-header">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span class="text-body">B???n c?? m?? gi???m gi???</span>
                                            <a href="#alert-body2" class="text-primary">B???m v??o ????y ????? nh???p m?? c???a b???n</a>
                                        </div>
                                        <div class="alert-body mb-4 collapsed" id="alert-body2">
                                            <p>N???u b???n c?? m?? gi???m gi??, vui l??ng ??p d???ng n?? b??n d?????i.</p>
                                            <div class="check-coupon-box d-flex">
                                                <input type="text" name="coupon_code" class="coupon_code discount_code input-text form-control text-grey ls-m mr-4" id="coupon_code" value="<?php echo isset($voucher['voucherid'])
                                                    ? $voucher['voucherid']
                                                    : ''; ?>" placeholder="Nh???p m?? phi???u gi???m gi?? t???i ????y...">
                                                <input type="hidden" value="<?php echo isset($voucher['price']) ? $voucher['price'] : ''; ?>" class="voucher_price_hidden">
                                                <input type="hidden" value="<?php echo isset($voucher['voucherid']) ? $voucher['voucherid'] : ''; ?>" class="voucherid_hidden">
                                                <button type="submit" class="btn-coupon__code btn btn-dark btn-rounded btn-outline">??p d???ng</button>
                                            </div>
                                            <p class="validate-message validate-ship__coupon">Vui l??ng nh???p m?? gi???m gi??!</p>
                                            <p class="validate-message check-ship__coupon">M?? gi???m gi?? kh??ng ????ng ho???c ???? h???t h???n!</p>
                                            <p class="alert-notification alert-coupon"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-7 mb-6 mb-lg-0 pr-lg-4">
                                            <h3 class="title title-simple text-left text-uppercase">CHI TI???T THANH TO??N</h3>
                                            <label>H??? t??n *</label>
                                            <input value="<?php echo isset($member['fullname']) ? $member['fullname'] : (isset($info['fullname']) ? $info['fullname'] : ''); ?>" type="text" class="form-control formcart-name" name="name"
                                            placeholder="H??? t??n"/>
                                            <p class="validate-message validate-name">Vui l??ng ??i???n h??? t??n!</p>
                                            <label>S??? ??i???n tho???i *</label>
                                            <input type="number" value="<?php echo isset($member['phone'])
                                                ? $member['phone']
                                                : (isset($info['phone'])
                                                    ? $info['phone']
                                                    : ''); ?>" class="form-control formcart-phone" name="phone" placeholder="S??? ??i???n tho???i" />
                                            <p class="validate-message validate-phone">Vui l??ng ??i???n s??? ??i???n tho???i!</p>
                                            <p class="validate-message check-phone">S??? ??i???n tho???i kh??ng ????ng ?????nh d???ng!</p>
                                            <label>Email</label>
                                            <input type="text" value="<?php echo isset($member['email'])
                                                ? $member['email']
                                                : (isset($info['email'])
                                                    ? $info['email']
                                                    : ''); ?>" class="form-control formcart-email" name="email" placeholder="Email" />
                                            <script>
                                            var cityid = '<?php echo isset($_POST['cityid']) ? $_POST['cityid'] : (isset($info['cityid']) ? $info['cityid'] : ''); ?>';
                                            var districtid = '<?php echo isset($_POST['districtid']) ? $_POST['districtid'] : (isset($info['districtid']) ? $info['districtid'] : ''); ?>'
                                            var wardid = '<?php echo isset($_POST['wardid']) ? $_POST['wardid'] : (isset($info['wardid']) ? $info['wardid'] : ''); ?>'
                                            </script>
                                            <p class="validate-message check-email">Email kh??ng ????ng ?????nh d???ng!</p>
                                            <label>T???nh/ Th??nh ph??? *</label>
                                            <div class="select-box">
                                                <?php
                                                $city = get_data(['select' => 'provinceid, name', 'table' => 'vn_province', 'order_by' => 'order desc, name asc']);
                                                $city = convert_array([
                                                    'data' => $city,
                                                    'field' => 'provinceid',
                                                    'value' => 'name',
                                                    'text' => 'Th??nh Ph???',
                                                ]);
                                                ?>
                                                <?php echo form_dropdown('cityid', $city, set_value('cityid', isset($info['cityid']) ? $info['cityid'] : 0), 'class="form-control m-b city"  id="city"'); ?>
                                            </div>
                                            <p class="validate-message validate-province">Vui l??ng ch???n t???nh/ th??nh ph??? nh???n h??ng!</p>
                                            <label>Ch???n Qu???n/ Huy???n *</label>
                                            <div class="select-box">
                                                <select name="districtid" id="district" class="form-control m-b location change-district">
                                                    <option value="0">[Ch???n Qu???n/Huy???n]</option>
                                                </select>
                                            </div>
                                            <p class="validate-message validate-district">Vui l??ng ch???n qu???n/ huy???n nh???n h??ng!</p>
                                            <label>?????a ch??? *</label>
                                            <input type="text" value="<?php echo isset($member['address'])
                                                ? $member['address']
                                                : (isset($info['address'])
                                                    ? $info['address']
                                                    : ''); ?>" class="form-control formcart-address" name="address" placeholder="S??? nh??, th??n, x??m,..." />
                                            <p class="validate-message validate-address">Vui l??ng ??i???n ?????a ch??? nh???n h??ng!</p>
                                            <h2 class="title title-simple text-uppercase text-left">Th??ng tin th??m</h2>
                                            <label>Ghi ch?? ????n h??ng (T??y ch???n)</label>
                                            <textarea class="form-control formcart-note" name="note"
                                            placeholder="Ghi ch??"></textarea>
                                        </div>
                                        <aside class="col-lg-5 sticky-sidebar-wrapper">
                                            <div class="sticky-sidebar mt-1" data-sticky-options="{'bottom': 50}">
                                                <div class="summary pt-5">
                                                    <h3 class="title title-simple text-left text-uppercase">????N H??NG C???A B???N</h3>
                                                    <table class="order-table">
                                                        <thead>
                                                            <tr>
                                                                <th>S???n ph???m</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (isset($cart) && is_array($cart) && count($cart)) {
                                                                foreach ($cart as $key => $value) { ?>
                                                            <tr>
                                                                <td style="padding-bottom: 0" class="product-name">
                                                                    <?php echo $value['detail']['title']; ?>
                                                                    <span class="product-quantity">?? <?php echo $value['qty']; ?></span>
                                                                </td>
                                                                <td style="padding-bottom: 0" class="product-total text-body"><?php echo number_format($value['subtotal'], 0, ',', '.'); ?> ???</td>
                                                            </tr>
                                                            <?php }
                                                            } ?>
                                                            
                                                            <tr class="summary-subtotal">
                                                                <td>
                                                                    <h4 class="summary-subtitle">T???ng</h4>
                                                                </td>
                                                                <?php $voucher_price = isset($voucher['price']) ? $voucher['price'] : 0; ?>
                                                                <td class="summary-subtotal-price pb-0 pt-0"><?php echo number_format($cartTotal + $voucher_price, 0, ',', '.'); ?>???
                                                                </td>
                                                            </tr>
                                                            <div class="sumnary-shipping shipping-row-last uk-hidden" >
                                                                <tr>
                                                                    <td class="product-name">Ph?? v???n chuy???n</td>
                                                                    <td class="product-total text-body total_shipping">0 ??</td>
                                                                </tr>
                                                                <tr class="" >
                                                                    <td class="product-name">Gi???m gi??</td>
                                                                    <td class="price-reduction text-body " id="total_discount" data-price="<?php echo isset($voucher['price']) ? $voucher['price'] : ''; ?>"><?php echo isset($voucher['price']) ? number_format($voucher['price'], 0, ',', '.') : ''; ?>???</td>
                                                                </tr>
                                                            </div>
                                                            <tr class="summary-total">
                                                                <td class="pb-0">
                                                                    <h4 class="summary-subtitle">Th??nh ti???n</h4>
                                                                </td>
                                                                <td class=" pt-0 pb-0">
                                                                    <p class="summary-total-price cart-price ls-s text-primary total_shipping_price"  id="total"><?php echo number_format($cartTotal, 0, ',', '.'); ?>??</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="payment accordion radio-type">
                                                        <h4 class="summary-subtitle ls-m pb-3">Ph????ng th???c thanh to??n</h4>
                                                        <div class="custom-radio" style="margin-bottom: 15px;">
                                                            <input type="radio" id="payment_method_1" name="payment_method" class="custom-control-input" value="1"  checked >
                                                            <label class="custom-control-label" for="payment_method_1">COD (Thanh to??n khi nh???n h??ng)</label>
                                                        </div>
                                                        <div class="custom-radio">
                                                            <input type="radio" id="payment_method_2" name="payment_method" class="custom-control-input" value="2" >
                                                            <label class="custom-control-label" for="payment_method_2">Thanh to??n online (Chuy???n kho???n)</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-checkbox mt-4 mb-5">
                                                        <input type="checkbox" checked class="custom-checkbox" id="terms-condition"
                                                        name="terms-condition" value='1' checked/>
                                                        <label class="form-control-label uk-hidden" for="terms-condition">
                                                            T??i ???? ?????c v?? ?????ng ?? v???i c??c ??i???u kho???n v?? ??i???u ki???n c???a trang web *
                                                        </label>
                                                        <p class="validate-message validate-rules">Vui l??ng ?????ng ?? v???i ??i???u kho???n c???a ch??ng t??i!</p>
                                                    </div>
                                                    <button type="submit" class="btn btn-dark btn-rounded btn-order button_order">?????t h??ng</button>
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
        <?php echo isset($script) ? $script : ''; ?>
        </script>
        <?php echo view('frontend/homepage/common/footer'); ?>
        <?php echo view('frontend/homepage/common/offcanvas'); ?>
        <?php echo view('backend/dashboard/common/notification'); ?>
        <!-- Tao Widget -->
        <?php if (isset($widget['data']) && is_array($widget['data']) && count($widget['data'])) {
            foreach ($widget['data'] as $key => $value) {
                echo str_replace("[phone]", isset($general['contact_phone']) ? $general['contact_phone'] : '', $value['html']);
                echo '<script>' . $value['script'] . '</script>';
            }
        } ?>
        <?php
        $check_script = false;
        foreach ($system as $key => $value) {
            if ($value['module'] == 'cart' && $value['keyword'] == 'cart_script') {
                $check_script = true;
                echo $system['cart_script']['content'];
            }
        }
        if ($check_script == false) {
            echo $system['normal_script']['content'];
        }
        ?>
        <?php echo $system['general_script_bottom']['content']; ?>
        <?php echo view('frontend/homepage/common/script') ?>
        <script src="public/frontend/resources/all.js"></script>
        <script src="public/frontend/resources/fancybox.min.js"></script>
        <script src="public/frontend/resources/main.min.js"></script>
        <script src="public/frontend/resources/function.js"></script>
        <script src="public/frontend/resources/cart.js"></script>
    </body>
</html>