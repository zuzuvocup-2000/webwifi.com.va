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
            <ul class="uk-list uk-clearfix uk-flex uk-flex-space-between uk-visible-medium">
                <li class="item-mobile complete"><a href="" title=""><span class="number">1</span> Đăng nhập</a></li>
                <li class="item-mobile complete"><a href="" title=""><span class="number">2</span> Thông tin giao hàng</a></li>
                <li class="item-mobile"><a href="" title=""><span class="number">3</span> Hình thức thanh toán</a></li>
            </ul>
        </section><!-- .paymentSep -->
        <?php 
                $sum_price = 0;
            ?>
        <div class="uk-clearfix wrapper">
            <aside class="aside-content-mobile">
                <section class="cart-panel panel-order address">
                    <header class="panel-head uk-flex uk-flex-middle uk-flex-space-between">
                        <h2 class="heading">Địa chỉ nhận hàng</h2>
                        <a class="link" href="<?php echo BASE_URL.'gio-hang'.HTSUFFIX ?>" title="Giỏ hàng">Thay đổi</a>
                    </header>
                    <section class="panel-body">
                        <?php if(isset($customer) && is_array($customer) && count($customer)){ ?>
                        <p><?php echo $customer['fullname'] ?></p>
                        <p>Điện thoại: <?php echo $customer['phone'] ?></p>
                        <p><?php echo $customer['address'] ?></p>
                        <?php } ?>
                    </section>
                </section>
                <form class="" id="cartForm" method="post" action="">
                    <section class="cart-panel panel-order">
                        <header class="panel-head uk-flex uk-flex-middle uk-flex-space-between">
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
                <form action="Frontend/Tour/Cart" method="post" classs="uk-form form">
                    <section class="cart-panel delivery payment-method">
                        <header class="panel-head">
                            <h2 class="heading"><span>Phương thức thanh toán</span></h2>
                        </header>
                        <section class="panel-body">
                            
                            <div class="form-row check-box">
                                <input type="radio" name="user_type" class="input-check radio" checked="" value="2">
                                <label class="input-check-label radio">
                                    <div class="content uk-clearfix">
                                        <div class="icon"><span class="img-scaledown"><img src="public/frontend/resources/img/icon/thanhtoantaicuahang.png" alt=""></span></div>
                                        <div class="text">
                                            <div class="title">Thanh toán tại cửa hàng</div>
                                            <div class="subtitle">
                                                <p>Quý khách có thể tới địa chỉ <?php echo $general['contact_address'] ?> để đặt mua hàng và thanh toán</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="form-row check-box">
                                <input type="radio" name="user_type" class="input-check radio" value="3">
                                <label class="input-check-label radio">
                                    <div class="content uk-clearfix">
                                        <div class="icon"><span class="img-scaledown"><img src="public/frontend/resources/img/icon/thanhtoanbangthe.png" alt=""></span></div>
                                        <div class="text">
                                            <div class="title">Thanh toán bằng thẻ thanh toán quốc tế</div>
                                            <div class="subtitle">
                                                <p>Hỗ trợ Credit và Debit.</p>
                                                <p>Bạn sẽ được chuyển tới VnPay để thanh toán.</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="form-row check-box">
                                <input type="radio" name="user_type" class="input-check radio" value="4">
                                <label class="input-check-label radio">
                                    <div class="content uk-clearfix">
                                        <div class="icon"><span class="img-scaledown"><img src="public/frontend/resources/img/icon/chuyenkhoannganhang.png" alt=""></span></div>
                                        <div class="uk-position-relative text">
                                            <div class="title">Thanh toán chuyển khoản qua ngân hàng</div>
                                            <div class="subtitle">
                                                <select name="" id="bankname" class="form-select uk-width-1-1">
                                                    <option value="">Viettinbank</option>
                                                    <option value="">Vietcombank</option>
                                                </select>
                                            </div>

                                            <div class="uk-hidden bankinfor">
                                                <div class="uk-clearfix box">
                                                    <div class="logo">
                                                        <span class="image img-scaledown"><img src="https://www.vietcombank.com.vn/images/logo30.png" alt=""></span>
                                                    </div>
                                                    <div class="excerpt">
                                                        <ul class="uk-list">
                                                            <li>Chủ tài khỏa: Ngô Thị Lan Phương</li>
                                                            <li>Số TK: Ngô Thị Lan Phương</li>
                                                            <li>VP Giao dịch: Techcombank CN Đông Đô - PGD Big C</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="changebank"><i class="fa fa-close"></i></span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </section><!-- .panel-body -->
                    </section><!-- .panel -->
                    <div class="edit-delivery">
                        <a href="<?php echo BASE_URL.'gio-hang'.HTSUFFIX ?>" title="Giỏ hàng"><i class="fa fa-angle-double-left"></i> Chỉnh sửa thông tin giao hàng</a>
                    </div>
                    <div class="pay-box uk-text-right mb20">
                        <input type="submit" name="create" value="Thanh toán" class="btn-pay">
                    </div>
                    <div class="policy-box">
                        <p>Bằng việc ấn nút thanh toán trên, Quý khách xác nhận đã kiểm tra kỹ đơn hàng và đồng ý với <a href="<?php echo BASE_URL.'chinh-sach-bao-mat'.HTSUFFIX ?>" target="_blank" title="Chính sách bảo mật">Điều khoản và điều kiện</a> giao dịch của KIM LIEN TRAVEL</p>
                    </div>
                </form>
            </div><!-- .main-content -->
            
            
        </div>
    </div>
</div>