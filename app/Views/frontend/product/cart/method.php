<?php
    $widget['data'] = widget_frontend();
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
                if(isset($module) && $value['module'] == $module && $value['keyword'] == $module.'_css'){
                    $check_css = true;
                    echo $system[$value['module'].'_css']['content'];
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
        <link href="public/frontend/resources/library/css/general.css" rel="stylesheet">
    </head>
    <body>

        <div id="cart-page" class="page-container">
            <div class="uk-container uk-container-center uk-text-center">
                <div class="cart-container">
                    <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
                        <div class="uk-width-large-1-3">
                            <div class="thumb">
                                <span class="image img-scaledown"><img src="https://cdn.nhanh.vn/cdn/store/26/artCT/57165/mau_thu_cam_on_khach_hang_da_su_dung_dich_vu_2.jpg" alt=""></span>
                            </div>
                        </div>
                        <div class="uk-width-large-2-3">
                            <div class="cart-information">
                                <div class="heading">C???m ??n b???n <span style="color:#012196;"><?php echo $orderDetail['fullname'] ?></span> ???? cho ch??ng t??i c?? h???i ph???c v???</div>
                                <div class="cart-order-code">M?? S??? ????n h??ng c???a b???n: <span style="color:#012196;"><?php echo $orderDetail['bill_id'] ?></span></div>
                                <div class="cart-order-description">
                                    Qu?? kh??ch ???? ?????t h??ng th??nh c??ng!
                                    Ch??ng t??i s??? li??n h??? v???i qu?? kh??ch trong th???i gian s???m nh???t.
                                    C???m ??n qu?? kh??ch ???? s??? d???ng s???n ph???m c???a ch??ng t??i. Xin c???m ??n!
                                </div>
                                <div class="cart-order-button"><a href="<?php echo BASE_URL; ?>" title="Ti???p t???c mua h??ng">Ti???p t???c mua s???m</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Tao Widget -->

        <?php
            foreach ($widget['data'] as $key => $value) {
                echo  str_replace("[phone]", isset($general['contact_phone']) ? $general['contact_phone'] : '', $value['html']);
                echo '<script>'.$value['script'].'</script>';
            }
        ?>

        <?php
            $check_script = false;
            foreach ($system as $key => $value) {
                if(isset($module) && $value['module'] == $module && $value['keyword'] == $module.'_script'){
                    $check_script = true;
                    echo $system[$value['module'].'_script']['content'];
                }
            }
            if($check_script == false){
                echo $system['normal_script']['content'];
            }

        ?>

        <?php echo $system['general_script_bottom']['content'] ?>
    </body>
</html>
