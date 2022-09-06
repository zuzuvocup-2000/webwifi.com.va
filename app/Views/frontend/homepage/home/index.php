<?php $main_slide = get_slide(['keyword' => 'main-slide' , 'language' => $language ]); ?>
<?php $category_img = get_slide(['keyword' => 'image-category' , 'language' => $language ]); ?>
<?php 
	$model = new App\Models\AutoloadModel();
    $product_love = $model->_get_where([
        'select' => 'tb2.title, tb1.image, tb2.canonical, tb1.price, tb1.price_promotion, tb1.model, tb1.bar_code, tb2.made_in',
        'where' => [
            'tb1.deleted_at' => 0,
            'tb1.hot' => 1,
            'tb1.publish' => 1,
        ],
        'table' => 'product as tb1',
        'join' => [
            [
                'product_translate as tb2','tb2.module = "product" AND tb2.objectid = tb1.id AND tb2.language = \''.$language.'\'', 'inner'
            ]
        ],
        'limit' => 5,
        'group_by' => 'tb1.id',
        'order_by' => 'tb1.created_at desc'
    ], true);
?>
<div class="homepage">
	<?php if(isset($main_slide) && is_array($main_slide) && count($main_slide)){ ?>
	    <div class="home-slider-group">
	        <div class="container">
	            <div class="owl-carousel owl-theme custom-dots" id="js-home-slider">
	            	<?php foreach ($main_slide as $value) { ?>
		                <a href="<?php echo $value['canonical'] ?>"><img data-src="<?php echo $value['image'] ?>" alt="" width="1" height="1" class="owl-lazy" /></a>
		            <?php } ?>
	            </div>
	        </div>
	    </div>
	<?php } ?>
    <div class="container">
		<?php if(isset($category_img) && is_array($category_img) && count($category_img)){ ?>
	        <div class="home-banner-under-group hover-img d-flex flex-wrap">
            	<?php foreach ($category_img as $value) { ?>
            		<a href="<?php echo $value['canonical'] ?>"><img data-src="<?php echo $value['image'] ?>" alt="" width="1" height="1" class="lazy w-auto h-auto" /></a>
	            <?php } ?>
	        </div>
		<?php } ?>
		<?php if(isset($product_love) && is_array($product_love) && count($product_love)){ ?>
	        <div class="home-deal-group" id="js-home-deal-container">
	            <p class="title"><span>DEALS HOT HÔM NAY</span></p>

	            <div class="p-container" id="js-home-deal-holder"><!-- // get featured deal --></div>

	            <a href="deal" class="btn-deal">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
	        </div>
	    <?php } ?>
        <div class="home-product-new-group">
            <p class="title"><span>SẢN PHẨM MỚI</span></p>

            <div class="p-container">
                <div class="p-item">
                    <a href="huawei-b535.html" class="p-img">
                        <img
                            data-src="media/product/250_2580_dsc02361_copy.jpg"
                            alt="Bộ Phát Wifi 4G Huawei B535 tốc độ 300Mbps Wifi 2 Băng Tần 1167Mbps Hỗ Trợ Tối Đa 64 Thiết bị"
                            class="lazy"
                            src="template/2022/images/wifi-logo.png"
                        />

                        <span class="p-type-new">NEW</span>
                    </a>

                    <div class="p-text">
                        <a href="huawei-b535.html" class="p-name"><h3>Bộ Phát Wifi 4G Huawei B535 tốc độ 300Mbps Wifi 2 Băng Tần 1167Mbps Hỗ Trợ Tối Đa 64 Thiết bị</h3></a>

                        <div class="p-price-group">
                            <span class="p-price">
                                2.750.000 đ
                            </span>

                            <span class="p-old-price">3.480.000 đ</span>
                            <span class="p-discount">-21%</span>
                        </div>
                        
                        <a href="javascript:void(0)" class="p-item-btn icon-cart" onclick="addProductToCart(2580, 1, '')"></a>
                    </div>
                </div>

                <div class="p-item">
                    <a href="bo-phat-wifi-4g-huawei-e5577bs-937-toc-do-150mbps-pin-3000mah.html" class="p-img">
                        <img data-src="media/product/250_2093_huawei_e5577bs_937__7____copy.jpg" alt="Bộ Phát Wifi 4G Huawei E5577Bs-937, Tốc Độ 150Mbps, Pin 3000mAh" class="lazy" src="template/2022/images/wifi-logo.png" />

                        <span class="p-type-new">NEW</span>
                    </a>

                    <div class="p-text">
                        <a href="bo-phat-wifi-4g-huawei-e5577bs-937-toc-do-150mbps-pin-3000mah.html" class="p-name"><h3>Bộ Phát Wifi 4G Huawei E5577Bs-937, Tốc Độ 150Mbps, Pin 3000mAh</h3></a>

                        <div class="p-price-group">
                            <span class="p-price">
                                1.690.000 đ
                            </span>

                            <span class="p-old-price">1.890.000 đ</span>
                            <span class="p-discount">-11%</span>
                        </div>
                        
                        <a href="javascript:void(0)" class="p-item-btn icon-cart" onclick="addProductToCart(2093, 1, '')"></a>
                    </div>
                </div>

                <div class="p-item">
                    <a href="wifi-4g-netmax-m5-plus.html" class="p-img">
                        <img
                            data-src="media/product/250_2562_bo_phat_wifi_4g_sac_du_phong_netmax_nm_m5_plus_000.jpg"
                            alt="Bộ phát WiFi 4G di động Netmax M5 Plus, Tốc độ 150Mbps, Pin 10000mAh, Pin dự phòng sạc nhanh 22.5W"
                            class="lazy"
                            src="template/2022/images/wifi-logo.png"
                        />

                        <span class="p-type-new">NEW</span>
                    </a>

                    <div class="p-text">
                        <a href="wifi-4g-netmax-m5-plus.html" class="p-name"><h3>Bộ phát WiFi 4G di động Netmax M5 Plus, Tốc độ 150Mbps, Pin 10000mAh, Pin dự phòng sạc nhanh 22.5W</h3></a>

                        <div class="p-price-group">
                            <span class="p-price">
                                1.390.000 đ
                            </span>

                            <span class="p-old-price">1.690.000 đ</span>
                            <span class="p-discount">-18%</span>
                        </div>
                        
                        <a href="javascript:void(0)" class="p-item-btn icon-cart" onclick="addProductToCart(2562, 1, '')"></a>
                    </div>
                </div>

                <div class="p-item">
                    <a href="wifi-6-ruijie-rg-rap2260g.html" class="p-img">
                        <img data-src="media/product/250_2616_bo_phat_wifi_6_ruijie_rg_rap2260g_01.jpg" alt="Bộ phát WiFi 6 Ruijie RG-RAP2260(G) Chuẩn AX tốc độ 1800Mbps" class="lazy" src="template/2022/images/wifi-logo.png" />

                        <span class="p-type-new">NEW</span>
                    </a>

                    <div class="p-text">
                        <a href="wifi-6-ruijie-rg-rap2260g.html" class="p-name"><h3>Bộ phát WiFi 6 Ruijie RG-RAP2260(G) Chuẩn AX tốc độ 1800Mbps</h3></a>

                        <div class="p-price-group">
                            <span class="p-price">
                                2.640.000 đ
                            </span>

                            <span class="p-old-price">3.220.000 đ</span>
                            <span class="p-discount">-19%</span>
                        </div>
                        
                        <a href="javascript:void(0)" class="p-item-btn icon-cart" onclick="addProductToCart(2616, 1, '')"></a>
                    </div>
                </div>

                <div class="p-item">
                    <a href="wifi-ruijie-rg-rap2200e.html" class="p-img">
                        <img
                            data-src="media/product/250_2622_bo_phat_wifi_ruijie_rg_rap2200_e__01.jpg"
                            alt="Bộ phát WiFi Ruijie RG-RAP2200(E) Chuẩn AC tốc độ 1267Mbps Tốc độ cổng LAN 1000Mbps"
                            class="lazy"
                            src="template/2022/images/wifi-logo.png"
                        />

                        <span class="p-type-new">NEW</span>
                    </a>

                    <div class="p-text">
                        <a href="wifi-ruijie-rg-rap2200e.html" class="p-name"><h3>Bộ phát WiFi Ruijie RG-RAP2200(E) Chuẩn AC tốc độ 1267Mbps Tốc độ cổng LAN 1000Mbps</h3></a>

                        <div class="p-price-group">
                            <span class="p-price">
                                1.660.000 đ
                            </span>

                            <span class="p-old-price">2.060.000 đ</span>
                            <span class="p-discount">-20%</span>
                        </div>
                        
                        <a href="javascript:void(0)" class="p-item-btn icon-cart" onclick="addProductToCart(2622, 1, '')"></a>
                    </div>
                </div>

                <div class="p-item">
                    <a href="wifi-ruijie-rg-rap2200f.html" class="p-img">
                        <img
                            data-src="media/product/250_2623_bo_phat_wifi_ruijie_rg_rap2200e_01.jpg"
                            alt="Bộ phát WiFi Ruijie RG-RAP2200(F) Chuẩn AC tốc độ 1267Mbps Tốc độ cổng LAN 100Mbps"
                            class="lazy"
                            src="template/2022/images/wifi-logo.png"
                        />

                        <span class="p-type-new">NEW</span>
                    </a>

                    <div class="p-text">
                        <a href="wifi-ruijie-rg-rap2200f.html" class="p-name"><h3>Bộ phát WiFi Ruijie RG-RAP2200(F) Chuẩn AC tốc độ 1267Mbps Tốc độ cổng LAN 100Mbps</h3></a>

                        <div class="p-price-group">
                            <span class="p-price">
                                1.265.000 đ
                            </span>

                            <span class="p-old-price">1.560.000 đ</span>
                            <span class="p-discount">-19%</span>
                        </div>
                        
                        <a href="javascript:void(0)" class="p-item-btn icon-cart" onclick="addProductToCart(2623, 1, '')"></a>
                    </div>
                </div>

                <div class="p-item">
                    <a href="wifi-5g-huawei-cpe-pro-2-h122-373-toc-do-3.6gbps-64-ket-noi.html" class="p-img">
                        <img
                            data-src="media/product/250_2621_3e440e3fb17a0e2e757587cc02a80d53_copy.jpg"
                            alt="Bộ Phát Wifi 4G/5G LTE Huawei CPE Pro 2 H122-373 tốc độ 3.6Gbps. Wifi thế hệ 6 tốc độ 2976Mbps. Hỗ trợ 64 kết nối. Cổng LAN 1Gb"
                            class="lazy"
                            src="template/2022/images/wifi-logo.png"
                        />

                        <span class="p-type-new">NEW</span>
                    </a>

                    <div class="p-text">
                        <a href="wifi-5g-huawei-cpe-pro-2-h122-373-toc-do-3.6gbps-64-ket-noi.html" class="p-name">
                            <h3>Bộ Phát Wifi 4G/5G LTE Huawei CPE Pro 2 H122-373 tốc độ 3.6Gbps. Wifi thế hệ 6 tốc độ 2976Mbps. Hỗ trợ 64 kết nối. Cổng LAN 1Gb</h3>
                        </a>

                        <div class="p-price-group">
                            <span class="p-price">
                                18.690.000 đ
                            </span>
                        </div>
                        
                        <a href="javascript:void(0)" class="p-item-btn icon-cart" onclick="addProductToCart(2621, 1, '')"></a>
                    </div>
                </div>

                <div class="p-item">
                    <a href="sim-4g-vina-big50y-16-thang.html" class="p-img">
                        <img data-src="media/product/250_2588_vina_1.jpg" alt="Sim 4G Vinaphone gói BIG50Y Trọn gói 16 tháng, mỗi ngày có 5GB dung lượng" class="lazy" src="template/2022/images/wifi-logo.png" />

                        <span class="p-type-new">NEW</span>
                    </a>

                    <div class="p-text">
                        <a href="sim-4g-vina-big50y-16-thang.html" class="p-name"><h3>Sim 4G Vinaphone gói BIG50Y Trọn gói 16 tháng, mỗi ngày có 5GB dung lượng</h3></a>

                        <div class="p-price-group">
                            <span class="p-price">
                                990.000 đ
                            </span>

                            <span class="p-old-price">1.210.000 đ</span>
                            <span class="p-discount">-19%</span>
                        </div>
                        
                        <a href="javascript:void(0)" class="p-item-btn icon-cart" onclick="addProductToCart(2588, 1, '')"></a>
                    </div>
                </div>

                <div class="p-item">
                    <a href="usb-wifi-3g4g-dongle-uf01-toc-do-150mbps.html" class="p-img">
                        <img data-src="media/product/250_2582_dsc02503_copy.jpg" alt="USB Phát WiFi 3G/4G Dongle NetMax UF01 Tốc Độ 150Mbps" class="lazy" src="template/2022/images/wifi-logo.png" />

                        <span class="p-type-new">NEW</span>
                    </a>

                    <div class="p-text">
                        <a href="usb-wifi-3g4g-dongle-uf01-toc-do-150mbps.html" class="p-name"><h3>USB Phát WiFi 3G/4G Dongle NetMax UF01 Tốc Độ 150Mbps</h3></a>

                        <div class="p-price-group">
                            <span class="p-price">
                                599.000 đ
                            </span>
                        </div>
                        
                        <a href="javascript:void(0)" class="p-item-btn icon-cart" onclick="addProductToCart(2582, 1, '')"></a>
                    </div>
                </div>

                <div class="p-item">
                    <a href="wifi-6-zyxel-nwa50ax.html" class="p-img">
                        <img data-src="media/product/250_2558_bo_phat_wifi_zyxel_nwa50ax_02.jpg" alt="Bộ phát WiFi 6 Zyxel NWA50AX - Chuẩn AX tốc độ 1800Mbps" class="lazy" src="template/2022/images/wifi-logo.png" />

                        <span class="p-type-new">NEW</span>
                    </a>

                    <div class="p-text">
                        <a href="wifi-6-zyxel-nwa50ax.html" class="p-name"><h3>Bộ phát WiFi 6 Zyxel NWA50AX - Chuẩn AX tốc độ 1800Mbps</h3></a>

                        <div class="p-price-group">
                            <span class="p-price">
                                3.300.000 đ
                            </span>

                            <span class="p-old-price">3.900.000 đ</span>
                            <span class="p-discount">-16%</span>
                        </div>
                        
                        <a href="javascript:void(0)" class="p-item-btn icon-cart" onclick="addProductToCart(2558, 1, '')"></a>
                    </div>
                </div>
            </div>

            <a href="san-pham-moi" class="btn-new">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
        </div>

        <div class="home-banner-product-group d-flex flex-wrap justify-content-between hover-img">
            <a href="ad.php?id=47"><img data-src="media/banner/23_Jun062a20f9eb1e3bea84e81e3378416121.png" alt="" width="1" height="1" class="lazy w-auto h-auto" /></a>

            <a href="ad.php?id=48"><img data-src="media/banner/23_Jund532a7fe608e92c479d5eed9875e06b9.png" alt="" width="1" height="1" class="lazy w-auto h-auto" /></a>
        </div>

        <div class="home-box-group js-box-container" data-id="25">
            <div class="box-title-group">
                <div class="box-holder clearfix">
                    <h2 class="title">Thiết Bị Wifi 3G - Wifi 4G - Wifi 5G</h2>

                    <a href="sim-3g.html"><h3>Sim 3G - 4G</h3></a>

                    <a href="usb-3g.html"><h3>USB 3G - USB 4G</h3></a>

                    <a href="router-wifi-3g.html"><h3>Router Wifi 3G - 4G</h3></a>

                    <a href="modem-wifi-3g.html"><h3>Modem Wifi 3G - 4G - 5G (Wifi di động)</h3></a>
                </div>
            </div>

            <div class="p-container has-cat-image">
                <div class="cat-image hover-img d-flex align-items-center" style="width: 245px;">
                    <a href="thiet-bi-wifi-3g.html" target="_blank">
                        <img data-src="media/category/cb_c3546eca0b572015cbd381b1309c1157.jpg" alt="Thiết Bị Wifi 3G - Wifi 4G - Wifi 5G" width="1" height="1" class="lazy w-auto h-auto" />
                    </a>
                </div>

                <div id="js-holder-25"><!-- // Get Product Hot --></div>
            </div>

            <a href="thiet-bi-wifi-3g.html" class="btn-box">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
        </div>

        <div class="home-box-group js-box-container" data-id="24">
            <div class="box-title-group">
                <div class="box-holder clearfix">
                    <h2 class="title">Wifi Dân Dụng</h2>

                    <a href="wifi-the-he-thu-6.html"><h3>Wifi Thế Hệ Thứ 6</h3></a>

                    <a href="modem-adsl.html"><h3>Modem ADSL</h3></a>

                    <a href="modem-wifi.html"><h3>Modem Wifi (ADSL + Phát wifi)</h3></a>

                    <a href="router-wifi-bo-phat-wifi.html"><h3>Router Wifi (Bộ Phát Wifi)</h3></a>
                </div>
            </div>

            <div class="p-container has-cat-image">
                <div class="cat-image hover-img d-flex align-items-center" style="width: 245px;">
                    <a href="thiet-bi-wifi.html" target="_blank"><img data-src="media/category/cb_5dcd26a207d5b787b1d2a0841233ac8e.png" alt="Wifi Dân Dụng" width="1" height="1" class="lazy w-auto h-auto" /></a>
                </div>

                <div id="js-holder-24"><!-- // Get Product Hot --></div>
            </div>

            <a href="thiet-bi-wifi.html" class="btn-box">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
        </div>

        <div class="home-box-group js-box-container" data-id="29">
            <div class="box-title-group">
                <div class="box-holder clearfix">
                    <h2 class="title">Wifi Chuyên Dụng - Diện Rộng</h2>

                    <a href="cisco.html"><h3>Cisco</h3></a>

                    <a href="ubiquiti.html"><h3>Ubiquiti</h3></a>

                    <a href="wifigrandstream.html"><h3>Grandstream</h3></a>

                    <a href="router-wifi-marketing-hicity.html"><h3>Router WiFi Marketing HiCity</h3></a>
                </div>
            </div>

            <div class="p-container has-cat-image">
                <div class="cat-image hover-img d-flex align-items-center" style="width: 245px;">
                    <a href="wifi-chuyen-dung-dien-rong.html" target="_blank">
                        <img data-src="media/category/cb_a1d949bb58f10540fe03d4998948b488.png" alt="Wifi Chuyên Dụng - Diện Rộng" width="1" height="1" class="lazy w-auto h-auto" />
                    </a>
                </div>

                <div id="js-holder-29"><!-- // Get Product Hot --></div>
            </div>

            <a href="wifi-chuyen-dung-dien-rong.html" class="btn-box">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
        </div>

        <div class="home-box-group js-box-container" data-id="123">
            <div class="box-title-group">
                <div class="box-holder clearfix">
                    <h2 class="title">Wifi Chuyên Dụng D-Link</h2>

                    <a href="d-link-outdoor.html"><h3>D-Link Outdoor</h3></a>

                    <a href="d-link-indoor.html"><h3>D-Link Indoor</h3></a>

                    <a href="d-link-switch.html"><h3>D-Link Switch</h3></a>
                </div>
            </div>

            <div class="p-container has-cat-image">
                <div class="cat-image hover-img d-flex align-items-center" style="width: 245px;">
                    <a href="wifi-chuyen-dung-d-link.html" target="_blank"><img data-src="media/category/cb_c0afb3848729b830730a1c0abb85b9e8.png" alt="Wifi Chuyên Dụng D-Link" width="1" height="1" class="lazy w-auto h-auto" /></a>
                </div>

                <div id="js-holder-123"><!-- // Get Product Hot --></div>
            </div>

            <a href="wifi-chuyen-dung-d-link.html" class="btn-box">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
        </div>

        <div class="home-box-group js-box-container" data-id="188">
            <div class="box-title-group">
                <div class="box-holder clearfix">
                    <h2 class="title">Wifi Chuyên Dụng NetMax</h2>

                    <a href="netmax-outdoor.html"><h3>NetMax Outdoor</h3></a>

                    <a href="netmax-indoor.html"><h3>NetMax Indoor</h3></a>

                    <a href="netmax-switch.html"><h3>NetMax Switch</h3></a>

                    <a href="netmax-controler.html"><h3>NetMax Gateway Controler</h3></a>
                </div>
            </div>

            <div class="p-container has-cat-image">
                <div class="cat-image hover-img d-flex align-items-center" style="width: 245px;">
                    <a href="wifi-chuyen-dung-netmax.html" target="_blank"><img data-src="media/category/cb_898b9543505ec5c7d664e2893f5f7f6b.jpg" alt="Wifi Chuyên Dụng NetMax" width="1" height="1" class="lazy w-auto h-auto" /></a>
                </div>

                <div id="js-holder-188"><!-- // Get Product Hot --></div>
            </div>

            <a href="wifi-chuyen-dung-netmax.html" class="btn-box">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
        </div>

        <div class="home-box-group js-box-container" data-id="26">
            <div class="box-title-group">
                <div class="box-holder clearfix">
                    <h2 class="title">Anten - Phụ Kiện Mạng</h2>

                    <a href="anten-wifi.html"><h3>Anten</h3></a>

                    <a href="poe-adapter.html"><h3>PoE Adapter, Switch PoE</h3></a>

                    <a href="cap-anten-dau-noi-dau-chuyen.html"><h3>Cáp anten, đầu nối, đầu chuyển</h3></a>
                </div>
            </div>

            <div class="p-container has-cat-image">
                <div class="cat-image hover-img d-flex align-items-center" style="width: 245px;">
                    <a href="anten-phu-kien-mang.html" target="_blank"><img data-src="media/category/cb_b50e9234fa6414b4207b2eda4dce3e91.png" alt="Anten - Phụ Kiện Mạng" width="1" height="1" class="lazy w-auto h-auto" /></a>
                </div>

                <div id="js-holder-26"><!-- // Get Product Hot --></div>
            </div>

            <a href="anten-phu-kien-mang.html" class="btn-box">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
        </div>

        <div class="home-box-group js-box-container" data-id="28">
            <div class="box-title-group">
                <div class="box-holder clearfix">
                    <h2 class="title">Camera Giám Sát</h2>

                    <a href="camera-easyn.html"><h3>Camera Easyn</h3></a>

                    <a href="camera-dahua.html"><h3>Camera Dahua</h3></a>

                    <a href="camera-eview.html"><h3>Camera eView</h3></a>

                    <a href="camera-ezvizhikvision.html"><h3>Camera Ezviz/HIKvision</h3></a>
                </div>
            </div>

            <div class="p-container has-cat-image">
                <div class="cat-image hover-img d-flex align-items-center" style="width: 245px;">
                    <a href="camera-giam-sat.html" target="_blank"><img data-src="media/category/cb_bd5ce73dd2285c316a5f77ec1cb2f66c.jpg" alt="Camera Giám Sát" width="1" height="1" class="lazy w-auto h-auto" /></a>
                </div>

                <div id="js-holder-28"><!-- // Get Product Hot --></div>
            </div>

            <a href="camera-giam-sat.html" class="btn-box">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
        </div>

        <div class="home-box-group js-box-container" data-id="194">
            <div class="box-title-group">
                <div class="box-holder clearfix">
                    <h2 class="title">Xiaomi - Tivi - Air Purifier - Robot - Accessories</h2>

                    <a href="tai-nghe-avantree.html"><h3>Tai Nghe Avantree</h3></a>

                    <a href="thiet-bi-bluetooth-loa.html"><h3>Thiết Bị Bluetooth - Loa</h3></a>

                    <a href="phu-kien.html"><h3>Phụ Kiện</h3></a>
                </div>
            </div>

            <div class="p-container">
                <div id="js-holder-194"><!-- // Get Product Hot --></div>
            </div>

            <a href="xiaomi.html" class="btn-box">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
        </div>
    </div>
</div>