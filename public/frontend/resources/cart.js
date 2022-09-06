(function($) {
	"use strict";
    var HT = {};

    var time = 100;
	/* MAIN VARIABLE */

    var $window            		= $(window),
		$document           	= $(document),
        $cart_button            = $('.add-cart'),
        $cart_modal            = $('.add_to_cart'),
        $voucher_button         = $('.btn-coupon__code'),
        $btn_pay         = $('.btn-pay'),
        $cart_combo            = $('.btn-create-cart-combo');

	// Check if element exists
    $.fn.elExists = function() {
        return this.length > 0;
    };
    HT.btn_pay = () => {
        $("body").on("click",'.btn-pay',function(e){
            e.preventDefault();
            var provincial = $('#city').find(':selected').val();
            if(provincial == '0'){
                $('.validate-ship__province').css({'display':'inherit'});
            }else{
                $(this).closest('form').submit();
            }
        });
    }
    HT.btn_wishlist = () => {
        $("body").on("click",".btn-wishlist",function(e){
            var product_wishlist = getCookie("product_wishlist");
            var product_id = $(this).data('id');
            var check_wishlist = getCookie("wishlist_"+product_id);
            if(product_id != check_wishlist){
                setCookie('wishlist_'+product_id,product_id);
                if(product_wishlist != null && product_wishlist != ''){
                    var product_id = product_wishlist+','+product_id;
                }else{
                    var product_id = product_id;
                }
                var count_wishlist = Math.floor($('.count_wishlist').val());
                var count_update = count_wishlist + 1;
                $('.count_wishlist').val(count_update);
                $('.wishlist-count').text(count_update);
                setCookie('product_wishlist',product_id);
            }
            var $product = $( this ).closest( '.product' );
            Riode.Minipopup.open( {
                message: 'Thêm sản phẩm vào danh sách yêu thích thành công',
                productClass: ' product-cart',
                name: $product.find( '.product-name' ).text(),
                nameLink: $product.find( '.product-name > a' ).attr( 'href' ),
                imageSrc: $product.find( '.product-media img' ).attr( 'src' ),
                imageLink: $product.find( '.product-name > a' ).attr( 'href' ),
                price: $product.find( '.product-price .new-price, .product-price .price' ).html(),
                count: $product.find( '.quantity' ).length > 0 ? $product.find( '.quantity' ).val() : 1,
                actionTemplate: '<div class="action-group d-flex"><a href="wishlist" class="btn btn-sm btn-outline btn-primary btn-rounded">Xem danh sách yêu thích</a></div>'
            } );
        });
    }
    HT.remove_wishlist = () => {
        $("body").on("click",".remove-wishlist",function(e){
            var product_id = $(this).data('id');
            var remove = $(this).data('remove');
            $('#'+remove).remove();
            deleteCookie("wishlist_"+product_id,product_id);
            var cookie_data = getCookie("product_wishlist");
            var id_new = cookie_data.replace(','+product_id, "");
            var id_new = id_new.replace(product_id, "");
            if(id_new == product_id){
                id_new = '';
            }
            deleteCookie('product_wishlist',product_id);
            setCookie('product_wishlist',id_new);
            var count_wishlist = Math.floor($('.count_wishlist').val());
            var count_update = count_wishlist - 1;
            $('.count_wishlist').val(count_update);
            $('.wishlist-count').text(count_update);
        });
    }

    HT.add_cart_new = () => {
        // Mua hàng
        $("body").on("click",".buy_now",function(e){
            let _this = $(this);
            let sku = _this.attr('data-sku');
            var qty = $(".input_qty").val();
            var product_id = $(this).data("id");
            if(qty == undefined) qty = 1;
            var qty = parseInt(qty);
            var $product = $( this ).closest( '.product' );
            Riode.Minipopup.open( {
                message: 'Thêm sản phẩm vào giỏ hàng thành công',
                productClass: ' product-cart',
                name: $product.find( '.product-name' ).text(),
                nameLink: $product.find( '.product-name > a' ).attr( 'href' ),
                imageSrc: $product.find( '.product-media img' ).attr( 'src' ),
                imageLink: $product.find( '.product-name > a' ).attr( 'href' ),
                price: $product.find( '.product-price .new-price, .product-price .price' ).html(),
                count: $product.find( '.quantity' ).length > 0 ? $product.find( '.quantity' ).val() : 1,
                actionTemplate: '<div class="action-group d-flex"><a href="gio-hang" class="btn btn-sm btn-outline btn-primary btn-rounded">Xem giỏ hàng</a></div>'
            } );
            $.ajax({
                type:'post',
                url:'ajax/frontend/cart/insert',
                data:{
                    'qty':qty,
                    'sku':sku,
                },success:function(data){
                    let json = JSON.parse(data)
                    $('.cart-count').text(json.response.totalItems);
                    $('.cart-price').text(json.response.cartTotal);
                }
            });
        });

    }

    HT.get_price_ship = () => {
        $('body').on('change', '.change-district', function(){
            var cityid = $('#city').find(':selected').val();
            var districtid = $('#district').find(':selected').val();
            load_box();
            $.ajax({
                type: 'post',
                data: {cityid : cityid,districtid:districtid},
                url: 'ajax/frontend/cart/get_price_ship',
                success:function(data){
                    let json = JSON.parse(data)
                    $('.total_shipping').html(format_curency(json.price.toString())+' đ')
                    let price_voucher =  $('#total_discount').attr('data-price')
                    $('.total_shipping').attr('data-price', json.price)
                    $('.cart-price').html(format_curency((json.total - price_voucher).toString())+' đ')
                    end_load_box();
                }
            });
        });
    }

    HT.show_cart = () => {
        $("body").on("click",".loadding-cart",function(e){
            $.ajax({
                type: 'post',
                dataType: 'json',
                data: {},
                url: 'ajax/frontend/cart/show',
                success:function(data){
                    if(data.response.code != 99){
                        $('.list-cart__loadding').remove();
                        $('.cart-total__loadding').remove();
                        $('.cart-action__loadding').remove();
                        $('.dropdown-box').append(data.response.html);
                    }
                }
            });
        });
    }

    HT.add_cart = () => {
        if($cart_button.elExists){
            $cart_button.on('click', function(){
                let _this = $(this);
                let sku = _this.attr('data-sku');
                let qty = $('input[name="quantity"]').val();
                console.log(qty);
                let ajaxUrl = 'ajax/frontend/cart/insert';
                if(qty > 0){
                    $.post(ajaxUrl, {
                        sku: sku, qty: qty},
                        function(data){
                            let json = JSON.parse(data);
                            if(json.response.code == 10){
                                $('.hlm-qty').html(json.response.totalItems);
                                toastr.success('Thêm sản phẩm vào giỏ hàng thành công!');
                            }else{
                                toastr.error('Có lỗi xảy ra, vui lòng thử lại, mã lỗi: !' + json.response.code);
                            }
                        });
                }else{
                    toastr.error('Có lỗi xảy ra, bạn phải mua ít nhất 1 sản phẩm');
                }

            });
        }
    }

    HT.add_combo = () => {
        if($cart_combo.elExists){
            $cart_combo.on('click', function(){
                let id = [];
                let _this = $(this);
                let sku = _this.attr('data-sku');
                $('.checkbox-item:checked').each(function(){
                    let _this = $(this);
                    id.push(_this.val());
                });

                if(id.length > 0){
                    swal({
                        title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
                        text: 'Thêm vào giỏ hàng các Combo được chọn?',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Thực hiện!",
                        cancelButtonText: "Hủy bỏ!",
                        closeOnConfirm: false,
                        closeOnCancel: false },
                    function (isConfirm) {
                        if (isConfirm) {
                            var formURL = 'ajax/frontend/cart/add_combo';
                            $.post(formURL, {
                                id: id,sku: sku },
                                function(data){
                                    let json = JSON.parse(data);
                                    if(json.response.code == 10){
                                        $('.hlm-qty').html(json.response.totalItems);
                                        swal("Thành công!", json.response.message , "success");
                                    }else{
                                        sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
                                    }
                                });
                        } else {
                            swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
                        }
                    });
                }
                else{
                    sweet_error_alert('Thông báo từ hệ thống!', 'Bạn phải chọn 1 bản ghi để thực hiện chức năng này');
                    return false;
                }
                return false;
            });
        }
    }

    


    HT.add_cart_modal = () => {
        if($cart_modal.elExists){
            $cart_modal.on('click', function(){
                let _this = $(this);
                let sku = _this.attr('data-sku');
                let qty = $('#qtym_modal').val();
                console.log(qty);
                let ajaxUrl = 'ajax/frontend/cart/insert';
                if(qty > 0){
                    $.post(ajaxUrl, {
                        sku: sku, qty: qty},
                        function(data){
                            let json = JSON.parse(data);
                            if(json.response.code == 10){
                                $('.bag .number').html(json.response.totalItems);
                                toastr.success('Thêm sản phẩm vào giỏ hàng thành công!');
                            }else{
                                toastr.error('Có lỗi xảy ra, vui lòng thử lại, mã lỗi: !' + json.response.code);
                            }
                        });
                }else{
                    toastr.error('Có lỗi xảy ra, bạn phải mua ít nhất 1 sản phẩm');
                }

            });
        }
    }

    HT.render_cart = (sum) => {
        $('.new_price').each(function(){
            let abc = $(this).html();
            abc = parseFloat(abc.replaceAll('.',''))
            sum = sum + abc;
        })
        let discount = parseFloat($('#total_discount').attr('data-price')) / 100;
        let shipping = parseFloat($('#total_shipping').attr('data-price')) ;
        let new_sum= 0;
        new_sum = (sum * discount) + shipping;
        sum = sum.toString()
        new_sum = new_sum.toString()
        $('#subtotal').html(format_curency(sum) + 'đ');
        $('.pay_total').val(sum);
        $('#total').html(format_curency(new_sum) + 'đ');
        $('#total_primary').html(format_curency(new_sum) + 'đ');
    }
    HT.update = (__this, type) => {
        let _this = __this;
        let price = _this.parents('li').find('.price_view').html();
        let code = _this.parents('li').find('.productid_hidden').val();
        let quantity;
        if(type == 'button'){
             quantity = _this.siblings('.input-quantity').val()
        }else{
             quantity = _this.val()
        }
        let new_price = 0;
        let sum = 0;
        price = parseFloat(price.replaceAll('.',''))
        new_price = price*quantity;
        let form_URL = 'ajax/frontend/cart/change_quantity';
        $.post(form_URL, {
            quantity: quantity,code:code
        },
        function(data){
            new_price = new_price.toString()
            _this.parents('li').find('.new_price').html(format_curency(new_price) + 'đ');
            HT.render_cart(sum);
        });
    }

    HT.cart_update_new = () => {
        $("body").on("click",".cart-btnPlus",function(e){
            var rowId = $(this).attr('data-update');
            var number = $(this).data('soluong');
            e = $(this);
            load_box();
            $.ajax({
                type: 'post',
                dataType: 'json',
                data: {code:rowId, quantity:number, type: 'plus'},
                url: 'ajax/frontend/cart/change_quantity_new',
                success:function(data){
                    $('.coupon_code').val('');
                    $('.alert-coupon').text('');
                    $('.cart-count').text(data.totalItems);
                    let price_ship = $('.total_shipping').attr('data-price')
                    $('.cart-price').text(format_curency((parseFloat(data.cartTotal) + parseFloat(price_ship)).toString()) +' đ');
                    end_load_box();
                    e.parent('.product-quantity__number').children('.cart-btnMinus').data('soluong',data.qty);
                    e.parent('.product-quantity__number').children('.cart-btnPlus').data('soluong',data.qty);
                    e.parent('.product-quantity__number').children('.count-product').val(data.qty);
                    e.parent('.product-quantity__number').parent('.product-quantity').parent('.table-cart').children('.subtotal').children('.amount').text(data.price);
                }
            });
        });


        $("body").on("click",".cart-btnMinus",function(e){
            var rowId = $(this).attr('data-update');
            var number = $(this).data('soluong');
            let price_ship = $('.total_shipping').attr('data-price')

            e = $(this);
            load_box();
            if(number > 1){
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    data: {code:rowId, quantity:number, type:'minus' },
                    url: 'ajax/frontend/cart/change_quantity_new',
                    success:function(data){
                        $('.coupon_code').val('');
                        $('.alert-coupon').text('');
                        $('.cart-count').text(data.totalItems);
                        $('.cart-price').text(format_curency((parseFloat(data.cartTotal) + parseFloat(price_ship)).toString()) +' đ');
                        end_load_box();
                        e.parent('.product-quantity__number').children('.cart-btnMinus').data('soluong',data.qty);
                        e.parent('.product-quantity__number').children('.cart-btnPlus').data('soluong',data.qty);
                        e.parent('.product-quantity__number').children('.count-product').val(data.qty);
                        e.parent('.product-quantity__number').parent('.product-quantity').parent('.table-cart').children('.subtotal').children('.amount').text(data.price);
                    }
                });
            }else{
                if (confirm('Bạn có muốn xoá sản phẩm khỏi giỏ hàng không?')) {
                    $.ajax({
                        type: 'post',
                        url:'ajax/frontend/cart/remove',
                        data:{code:rowId},
                        success: function(data) {
                            let json = JSON.parse(data)
                            $('.coupon_code').val('');
                            $('.alert-coupon').text('');
                            $('.delete-cart-'+rowId).remove();
                            end_load_box();
                            $('.cart-count').text(json.totalItems);
                            $('.cart-price').text(format_curency((parseFloat(data.cartTotal) + parseFloat(price_ship)).toString()) +' đ');
                        }
                    });
                }
            }
        });
    }

    HT.cart_update = () => {
        $('.input-quantity').on('change', function(){
            HT.update($(this));
    	})
        $('.button_quantity_cart').on('click', function(){
    		HT.update($(this), 'button');
    	})
    }

    HT.cart_remove_new = () => { 
        $("body").on("click",".cart-remove",function(e){
            var code = $(this).data("update");
            load_box();
            $.ajax({
                type: 'post',
                url:'ajax/frontend/cart/remove',
                data:{code:code},
                success: function(data) {
                    let json = JSON.parse(data)
                    $('.coupon_code').val('');
                    $('.alert-coupon').text('');
                    $('.delete-cart-'+code).remove();
                    $('.cart-count').text(json.totalItems);
                    $('.cart-price').text(json.cartTotal);
                    end_load_box();
                }
            });
        });
    }

    HT.check_voucher = () => {
        if($voucher_button.elExists){
            $voucher_button.on('click', function(){
                let _this = $(this);
                let voucherid = $('.discount_code').val();
                load_box();
                let ajaxUrl = 'ajax/frontend/cart/voucher';
                if(voucherid.length > 0){
                    $.post(ajaxUrl, {
                        voucherid: voucherid
                    },
                    function(data){
                        let json = JSON.parse(data);
                        end_load_box();
                        toast_voucher(json, voucherid)
                    });
                }
                return false;
            });
        }
    }

    HT.cart_remove = () => {
        $('.fc-cart-remove').on('click', function(){
    		let _this = $(this)
    		let code = _this.parents('li').find('.productid_hidden').val();
            let comboid = _this.attr('data-comboid')
            let type = _this.attr('data-type')
            let value = _this.attr('data-value')
            let sum = 0;
            
            if(comboid == ''){
        		let form_URL = 'ajax/frontend/cart/remove';
        		$.post(form_URL, {
        			code: code
        		},
        		function(data){
        			_this.parents('li').remove()
        			let count = $('.list-product-cart li').length;
        			$('.panel-head .count').html(count+' Sản phẩm');
                    $('.hlm-qty').html(count);
        			if(count == 0){
        				$('.list-product-cart').remove();
        				$('.panel-body ').append('<p class="info-cart text-danger">Chưa có đơn hàng nào được chọn</p>');
        				$('#subtotal').html(0);
        				$('#total').html(0);
        			}else{

                        HT.render_cart(sum);
        			}
        		});
            }else{
                swal({
                    title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
                    text: 'Khi xóa sản phẩm này đồng nghĩa bạn sẽ xóa toàn bộ combo, bạn có chắc chắn khi sử dụng chức năng này?',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Thực hiện!",
                    cancelButtonText: "Hủy bỏ!",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        var formURL = 'ajax/frontend/cart/remove_combo';
                        $.post(formURL, {
                            code: code,comboid: comboid,type: type ,value: value },
                        function(data){
                            let json = JSON.parse(data);
                            if(json.response.code == 10){
                                $('.cart-combo-'+comboid).remove()
                                let count = $('.list-product-cart li').length;
                                $('.panel-head .count').html(count+' Sản phẩm');
                                $('.hlm-qty').html(count);
                                if(count == 0){
                                    $('.list-product-cart').remove();
                                    $('.panel-body ').append('<p class="info-cart text-danger">Chưa có đơn hàng nào được chọn</p>');
                                    $('#subtotal').html(0);
                                    $('#total').html(0);
                                }else{
                                    HT.render_cart(sum);
                                }
                                swal("Thành công!", json.response.message , "success");
                            }else{
                                sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
                            }
                        });
                    } else {
                        swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
                    }
                });
            }
    	})
    }





  // Document ready functions
    $document.on('ready', function() {
        HT.add_cart_new();
        HT.add_cart();
        HT.cart_update_new();
        HT.cart_update();
        HT.btn_pay();
        HT.add_combo();
        HT.btn_wishlist();
        HT.remove_wishlist();
        HT.cart_remove();
        HT.get_price_ship();
        HT.check_voucher();
        HT.add_cart_modal();
        HT.cart_remove_new();
        HT.show_cart();
    });

})(jQuery);
function sweet_error_alert(title, message){
    swal({
        title: title,
        text: message
    });
}

function toast_voucher(data, val) {
    if(data.type == 'error'){
        toastr.error(data.text);
    }
    if(data.type == 'success'){
        toastr.success(data.text);
        $('.voucherid_hidden').val(val)
        $('.voucher_price_hidden').val(data.price)
    }
    let price_ship = $('.total_shipping').attr('data-price')

    $('#total_discount').attr('data-price',data.price)
    $('#total_discount').html(format_curency(data.price)+'₫')
    let sum = parseFloat(data.cartTotal) - parseFloat(data.price) + parseFloat(price_ship);
    sum = sum.toString()
    $('#total').html(format_curency(sum) + 'đ');
}

function format_curency(data) {
    let format = data.replace(/\B(?=(\d{3})+(?!\d))/g, '.')
    return format;
}

function load_box() {
    $('#loading_box').css({"opacity":"1"});
    $('#loading_box').css({"visibility":"inherit"});    
}
function end_load_box() {
    $('#loading_box').css({"opacity":"0"});
    $('#loading_box').css({"visibility":"hidden"}); 
}

function setCookie(key, value) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (365 * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';path=/;expires=' + expires.toUTCString();
}
function setCookieWithPath(key, path ,value) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (365 * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';path='+path+';expires=' + expires.toUTCString();
}
function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}
function deleteCookie(key,path) {
    var expires = new Date();
    expires.setTime(expires.getTime()-1);
    document.cookie = key + '=; path='+path+'; expires=' + expires.toUTCString();
}