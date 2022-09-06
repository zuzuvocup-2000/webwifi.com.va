<?php
    helper(['mydatafrontend','mydata']);
    $baseController = new App\Controllers\FrontendController();
    $language = $baseController->currentLanguage();
    $footer = get_panel([
        'locate' => 'footer',
        'language' => $language
    ]);
?>
<section class="breadcrumb-panel">
    <div class="uk-container-center uk-container">
        <ul class="uk-breadcrumb uk-clearfix ">
            <li class="breadcrumb-home"><a href=""> <i class="fa fa-home"></i> Trang chủ</a></li>
            <li class=""><a href="<?php echo BASE_URL.$_SERVER['REDIRECT_URL'] ?>" ><span><?php echo ($_SERVER['REDIRECT_URL'] == '/thuong-hieu.html') ? 'Thương hiệu' : 'Tất cả sản phẩm' ?></span></a></li>
        </ul>
    </div>
</section>
<section class="va-articleCat-panel"  data-module="<?php echo check_isset($module); ?>" data-canonical="">
    <div class="uk-container uk-container-center">
        <div class="productList">
            
            <div class="uk-grid uk-grid-medium uk-clearfix">
                <div class="uk-width-large-1-4 uk-visible-large">
                    <?php echo view('frontend/homepage/common/asideproduct') ?>
                </div>
                <div class="uk-width-large-3-4">
                    <div class="product-filter-panel mb20">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                            <div class="product-filter-title">
                                <h2><?php echo ($_SERVER['REDIRECT_URL'] == '/thuong-hieu.html') ? 'Thương hiệu' : 'Tất cả sản phẩm' ?></h2>
                            </div>
                            <!-- <div class="product-filter-top">
                                <div id="sort-by">
                                    <span class="left mr10">Sắp xếp: </span>
                                    <ul class="sort-type">
                                        <li><span>Thứ tự <i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                            <ul class="content_sort">                    
                                                <li><a href="" onclick="sortby('alpha-asc')">A → Z</a></li>
                                                <li><a href="" onclick="sortby('alpha-desc')">Z → A</a></li>
                                                <li><a href="" onclick="sortby('price-asc')">Giá tăng dần</a></li>
                                                <li><a href="" onclick="sortby('price-desc')">Giá giảm dần</a></li>
                                                <li><a href="" onclick="sortby('created-desc')">Hàng mới nhất</a></li>
                                                <li><a href="" onclick="sortby('created-asc')">Hàng cũ nhất</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>    -->       
                        </div>
                    </div>
                    <section class="artcatalogue mb50">
                        <section class="panel-body product_list_panel">
                            <ul class="list-product uk-grid uk-grid-small uk-grid-width-small-1-1 uk-grid-width-medium-1-2 uk-grid-width-large-1-4 uk-clearfix">
                                <?php 
                                    if(isset($object) && is_array($object) && count($object)){
                                    foreach ($object as $key => $value) {
                                ?>
                                <li class="mb15">
                                    <article class="product">
                                        <div class="thumb img-zoomin">
                                            <?php echo render_a(base_url($value['canonical'].HTSUFFIX), $value['product_title'], 'class="image img-cover"',render_img(['src' => $value['image'],'alt' => $value['product_title']])) ?>
                                            <div class="product-action">
                                                <a href="#modal-product" data-uk-modal class="product-view-detail" data-module="<?php echo $value['module'] ?>"  data-id="<?php echo $value['id'] ?>" title="<?php echo $value['product_title'] ?>">
                                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                                </a>
                                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['product_title'] ?>" class="product-btn-canonical">
                                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <div class="wrap-content-product">
                                                <h3 class="title mb10"><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['product_title'] ?>"> <?php echo $value['product_title'] ?></a></h3>
                                                <div class="wrap-price mb10">
                                                    <span class="old <?php echo (isset($value['price_promotion']) && $value['price_promotion'] != 0) ? 'line-price' : '' ?>"><?php echo number_format(check_isset($value['price']),0,',','.') ?> đ</span>
                                                    <span class="new" style="<?php echo (isset($value['price_promotion']) && $value['price_promotion'] != 0) ? '' : 'display: none;' ?>">
                                                        <?php echo number_format(check_isset($value['price_promotion']),0,',','.') ?> đ
                                                    </span>
                                                </div>
                                                <div class="five-star mr20 text-left">
                                                    <span class="rating order-1" data-stars="<?php echo $value['rate'] ?>"  style="display: inline-block;">
                                                        <?php 
                                                            for ($i=1; $i <= $value['rate'] ; $i++) { 
                                                                echo '<i class="star-rating fa fa-star" aria-hidden="true"></i>';
                                                            }
                                                            for ($i=1; $i <= 5-$value['rate'] ; $i++) { 
                                                                echo '<i class="star-rating fa fa-star-o" aria-hidden="true"></i>';
                                                            }
                                                         ?>
                                                        
                                                    </span>
                                                </div>
                                            </div>  
                                        </div>
                                    </article>
                                </li>
                                <?php 
                                    }}else{ 
                                ?>
                                    <span class="text-danger mt30">Không có dữ liệu để hiển thị...</span>
                                <?php 
                                    } 
                                ?>
                            </ul>
                            <div id="pagination" class="va-num-page">
                                <?php echo (isset($pagination)) ? $pagination : ''; ?>
                            </div>
                        </section>
                        <seciton class="product_search_panel"></seciton>
                    </section>
                    <section class="product_catalogue_description mt50">
                        <strong>
                            <?php  ?>
                        </strong>
                        <?php  ?>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="modal-product" class="uk-modal">
    <div class="uk-modal-dialog product-modal-panel">
        <a class="uk-modal-close uk-close"></a>
        <div class="wrap-modal-panel">
            <div class="uk-grid uk-grid-medium uk-grid-width-1-2 uk-clearfix">
                <div class="panel-modal-row">
                    <div class="slide-img-modal">
                    </div>  
                </div>
                <div class="panel-modal-row">
                    <div class="info-product-modal">
                        <div class="product-modal-title">
                            
                        </div>
                        <div class="product-detail-body product-modal-price">
                            <div class="wrap-price mb10">
                                <span class="new" style="">
                                    
                                </span>
                                <span class="old line-price"></span>
                            </div>
                            <div class="form-product section uk-clearfix mb50">
                                <div class="form-group form_button_details margin-top-15">
                                    <div class="form_product_content type1 ">
                                        <div class="soluong soluong_type_1 show">
                                            <label class="section margin-bottom-10">Số lượng:</label>
                                            <div class="custom input_number_product custom-btn-number form-control">        
                                                <button class="btn_num num_1 button button_qty" onclick="var result = document.getElementById('qtym_modal'); var qtypro = result.value; if( !isNaN( qtypro ) &amp;&amp; qtypro > 1 ) result.value--;return false;" type="button">
                                                    <i class="fa fa-minus-circle"></i>
                                                </button>
                                                <input type="text" id="qtym_modal" name="quantity" value="1" maxlength="3" class="form-control prd_quantity" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" onchange="if(this.value == 0)this.value=1;">
                                                <button class="btn_num num_2 button button_qty" onclick="var result = document.getElementById('qtym_modal'); var qtypro = result.value; if( !isNaN( qtypro )) result.value++;return false;" type="button">
                                                    <i class="fa fa-plus-circle"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="button_actions uk-clearfix">
                                            <button type="submit" class="btn btn_base normal_button btn_add_cart btn-cart add_to_cart">
                                                <span class="text_1"><i class="fa fa-shopping-basket"></i> Thêm vào giỏ hàng</span>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

