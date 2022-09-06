<div class="breadcrumb">
    <div class="uk-container uk-container-center">
        <h1 class="main-title">Giỏ hàng</h1>
        <ul class="uk-breadcrumb">
            <li><a href="" title=""><i class="fa fa-home"></i> Trang chủ</a></li>
            
            <li><a href="https://kimlientravel.com.vn/dat-mua.html" title="Giỏ hàng">Giỏ hàng</a></li>
        </ul>
    </div>
</div>
<div id="cart-page" class="page-container-mobile">
    <div class="uk-container uk-container-center">
        <section class="steps-nav delivery-nav">
            <h2 style="display: none">Thông tin giỏ hàng</h2>
            <ul class="uk-list uk-flex uk-flex-space-between  uk-visible-medium  uk-flex-wrap">
                <li class="item-mobile complete"><a href="" title=""><span class="number">1</span> Đăng nhập</a></li>
                <li class="item-mobile active"><a href="" title=""><span class="number">2</span> Thông tin giao hàng</a></li>
                <li class="item-mobile"><a href="" title=""><span class="number">3</span> Hình thức thanh toán</a></li>
            </ul>
        </section><!-- .paymentSep -->
        <?php 
                $sum_price = 0;
            ?>
        <div class="uk-clearfix wrapper">
            <aside class="aside-content-mobile">
                <form class="" id="cartForm" method="post" action="">
                    <section class="cart-panel panel-order">
                        <header class="panel-head uk-flex uk-flex-middle  uk-flex-space-between">
                            <h2 class="heading">Đơn hàng (<span class="count"><?php echo ((isset($cart)) ? count($cart) : 0) ?> Sản phẩm</span>)</h2>
                            <a class="link" href="">Thay đổi</a>
                        </header>
                        <div class="panel-body mb20">
                            <?php 
                                if(isset($cart) && is_array($cart) && count($cart)) {
                            ?>
                                <ul class="uk-list list-product-cart">
                                    <?php 
                                        foreach ($cart as $key => $value) {
                                     ?>
                                        <li class="mb10">
                                            <input type="hidden" name="code_tour" class="code_tour_hidden" value="<?php echo $value['code'] ?>">
                                            <div class="box uk-clearfix">
                                                <div class="prd-infor uk-clearfix">
                                                    <div class="thumb">
                                                        <?php echo render_a(BASE_URL.$value['url'].HTSUFFIX,$value['title'],'class="image img-scaledown"',render_img($value['avatar'],$value['title'])) ?>
                                                    </div>
                                                    <div class="desc">
                                                        <h3 class="title">
                                                            <?php echo render_a(BASE_URL.$value['url'].HTSUFFIX,$value['title'],'',$value['title']) ?>
                                                        </h3>
                                                                                                    
                                                        <button type="button" class="uk-button fc-cart-remove" data-cart-id="" style="border:0;background:0;font-size:11px;padding:0;color:#1d61ae;"><i class="fa fa-trash"></i> Xóa</button>
                                                    </div>
                                                </div>
                                                
                                                <div class="prd-price">
                                                    <div class="price price_view"><?php echo number_format(check_isset($value['price']),0,',','.') ?></div>
                                                    <div class="number_quantity"  style="color:red;">x <input min="1"  class="input-quantity" id="" type="number" value="<?php echo $value['quantity'] ?>" name="quantity" style="width:50px;text-align:right;"></div>
                                                    <div class="price new_price"><?php echo number_format(cal_quantity($value['price'], $value['quantity']),0,',','.') ?></div>
                                                </div>
                                            </div><!-- .box -->
                                            <div class="go">
                                                <?php 
                                                    $input = false;
                                                    if(isset($value['day_start']) && $value['day_start'] != ''){
                                                        $day = explode(',',$value['day_start']);
                                                        foreach ($day as $keyDay => $valueDay) {
                                                            $check  = strtolower(removeutf8($valueDay));
                                                            if($check == 'hang ngay'){
                                                                $input = true;
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <?php if($input == true){ ?>
                                                    <div class="day_start uk-flex uk-flex-middle">
                                                        <div class="lablel-day-start" style="width: 100px;">
                                                            Chọn ngày: 
                                                        </div>
                                                        <input type="date" name="day_start['<?php echo $value['code'] ?>']" value="<?php echo gmdate('Y-m-d', time() + 7*3600) ?>" style="width: calc(100% - 100px);padding: 0 10px;">    
                                                    </div>
                                                <?php }else{ ?>
                                                    <div class="day_start uk-flex uk-flex-middle">
                                                        <div class="lablel-day-start" style="width: 100px;">
                                                            Chọn ngày: 
                                                        </div>
                                                        <div class="day_start_tag uk-flex uk-flex-middle uk-flex-wrap" style="width: calc(100% - 100px);">
                                                            <?php 
                                                                if(isset($day) && is_array($day) && count($day)){
                                                                    foreach ($day as $keyDay => $valueDay) {
                                                             ?>
                                                                <div class="select_day_start ">
                                                                    <input type="radio" class="radio_day" <?php echo ($keyDay == 0) ? 'checked="checked"' : ''?> id="<?php echo slug($valueDay).'_in_'.$value['code'] ?>" name="day_start['<?php echo $value['code'] ?>']" value="<?php echo $valueDay ?>" style="display: none">
                                                                    <label for="<?php echo slug($valueDay).'_in_'.$value['code'] ?>" class="element_day"> <?php echo $valueDay ?></label><br>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                <?php }} ?>
                                            </div>
                                        </li>
                                        <?php $sum_price = $sum_price+cal_quantity($value['price'], $value['quantity']); ?>
                                    <?php } ?>
                                </ul>   
                            <?php }else{ ?>
                                <p class="info-cart text-danger">Chưa có đơn hàng nào được chọn</p>
                            <?php } ?>
                        </div>
                        <footer class="panel-foot">
                            <div class="total-amount">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between item">
                                    <div class="label">Tổng tiền</div>
                                    <div class="value" id="subtotal"><?php echo number_format($sum_price,0,',','.') ?></div>
                                </div>
                            </div>
                            <div class="uk-flex uk-flex-middle uk-flex-space-between total-purchase">
                                <div class="label">Số tiền còn lại cần thanh toán</div>
                                <div class="value" id="total"><?php echo number_format($sum_price,0,',','.') ?></div>
                            </div>
                        </footer>
                    </section><!-- .panel-order -->
                </form>
            </aside><!-- .aside -->
            <div class="main-cart-mobile mb20">
                <form action="Frontend/Tour/Cart" method="post" class="uk-form form form-cart">
                    <section class="cart-panel delivery delivery-address">
                        <header class="panel-head">
                            <h2 class="heading"><span>Địa chỉ nhận hàng</span></h2>
                        </header>
                        <section class="panel-body">
                            <div class="form-row uk-clearfix">
                                <div class="first-child">
                                    <div class="label">Họ và tên<span class="ml10 no-required">(*)</span></div>
                                </div>
                                <div class="last-child">
                                    <input type="text" name="fullname" value="<?php echo (isset($customer['fullname']) ? $customer['fullname'] : '') ?>" class="text uk-width-1-1" placeholder="Ví dụ: Nguyễn Văn A">
                                </div>
                            </div>
                            <div class="form-row uk-clearfix">
                                <div class="first-child">
                                    <div class="label">Điện thoại<span class="ml10 no-required">(*)</span></div>
                                    

                                </div>
                                <div class="last-child">
                                    <input type="text" name="phone" value="<?php echo (isset($customer['phone']) ? $customer['phone'] : '') ?>" class="text uk-width-1-1" placeholder="Ví dụ: 0987654321">
                                    <div class="text">Nhân viên giao nhận KIM LIEN TRAVEL sẽ liên hệ với SĐT này.</div>
                                </div>
                            </div>
                            <div class="form-row uk-clearfix">
                                <div class="first-child">
                                    <div class="label">Email<span class="ml10 no-required">(*)</span></div>
                                    
                                </div>
                                <div class="last-child">
                                    <input type="text" value="<?php echo (isset($customer['email']) ? $customer['email'] : '') ?>" name="email" class="text uk-width-1-1" placeholder="supportxyz@gmail.com">
                                </div>
                            </div>
                            <div class="form-row uk-clearfix">
                                <div class="first-child">
                                    <div class="label">Tỉnh/Thành phố<span class="ml10 no-required">(*)</span></div>
                                </div>
                                <div class="last-child">
                                    <script>
                                        var cityid = '<?php echo (isset($customer['cityid'])) ? $customer['cityid'] : ''; ?>';
                                        var districtid = '<?php echo (isset($customer['districtid'])) ? $customer['districtid'] : ''; ?>'
                                        var wardid = '<?php echo (isset($customer['wardid'])) ? $customer['wardid'] : ''; ?>'
                                    </script>
                                   <?php 
                                        $city = get_data(['select' => 'provinceid, name','table' => 'vn_province','order_by' => 'order desc, name asc']);
                                        $city = convert_array([
                                            'data' => $city,
                                            'field' => 'provinceid',
                                            'value' => 'name',
                                            'text' => 'Thành Phố',
                                        ]);
                                    ?>
                                    <?php echo form_dropdown('cityid', $city, set_value('cityid', (isset($user['cityid'])) ? $user['cityid'] : 0), 'class="form-control m-b city select2"  id="city"');?>
                                </div>
                            </div>
                            <div class="form-row uk-clearfix">
                                <div class="first-child">
                                    <div class="label">Quận huyện<span class="ml10 no-required">(*)</span></div>
                                </div>
                                <div class="last-child">
                                    <select name="districtid" id="district" class="form-control m-b location select2">
                                        <option value="0">[Chọn Quận/Huyện]</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row uk-clearfix">
                                <div class="first-child">
                                    <div class="label">Địa chỉ chi tiết<span class="ml10 no-required">(*)</span></div>
                                    

                                </div>
                                <div class="last-child">
                                    <input type="text" value="<?php echo (isset($customer['address']) ? $customer['address'] : '') ?>" name="address" class="text uk-width-1-1" placeholder="Ví dụ: Số 10, Ngõ 50, Đường ABC">
                                </div>
                            </div>
                            
                    
                            <div class="form-row uk-clearfix">
                                <div class="first-child">
                                    <div class="label">Lời nhắn</div>
                                    <span>(Không bắt buộc)</span>
                                </div>
                                <div class="last-child">
                                    <textarea name="message"  class="uk-width-1-1 form-textarea" placeholder="Ví dụ: Chuyển hàng ngoài giờ hành chính"><?php echo (isset($customer['message']) ? $customer['message'] : '') ?></textarea>
                                </div>
                            </div>
                        </section><!-- .panel-body -->
                    </section><!-- .delivery -->
                    <div class="continue-box uk-text-right">
                        <button type="submit" name="create" value="create" class="btn-continue">Tiếp tục thanh toán</button>
                    </div>
                </form><!-- form -->
            </div><!-- .main-content -->
            
            
        </div>
    </div>
</div>