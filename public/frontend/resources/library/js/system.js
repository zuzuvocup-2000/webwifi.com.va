// lazy load
$(document).ready(function(){
    $('body').on('click', '.show-menu-level2', function(){
        var data_show = $(this).attr('data-show');
        if(data_show == 1){
            $(this).attr('data-show', '0');
            $(this).parent().find('ul').slideDown();
        } else{
            $(this).attr('data-show', '1');
            $(this).parent().find('ul').slideUp();
        }
    });

    
});
$(function() {
    $("img.lazy").lazyload({
        effect : "fadeIn"
    });
});
// thĂªm cookie
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
// láº¥y cookie
function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}
// XĂ³a cookie
function deleteCookie(key,path) {
    var expires = new Date();
    expires.setTime(expires.getTime()-1);
    document.cookie = key + '=; path='+path+'; expires=' + expires.toUTCString();
}
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}
function isPhone(phone) {
    var regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
    return regex.test(phone);
}
function alertLine(text, title='') {
    $.alert({
        width :'auto',
        title: title,
        content: text,
        useBootstrap: false
    });
}
// hĂ m khá»Ÿi táº¡o hiá»‡u á»©ng loadding
function load_box() {
    $('#loading_box').css({"opacity":"1"});
    $('#loading_box').css({"visibility":"inherit"});    
}
// hĂ m táº¯t hiá»‡u á»©ng loadding
function end_load_box() {
    $('#loading_box').css({"opacity":"0"});
    $('#loading_box').css({"visibility":"hidden"}); 
}

// setup ajax
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('body').on('click', '.send_registration', function(e){
    e.preventDefault();
    var name = $('.form-name').val();
    var content = $('.form-content').val();
    var email = $('.form-email').val();
    $('.validate-message').css({'display':'none'});

    if(content == '') {
        $('.form-content').focus();
        $('.validate-contact__detail').css({'display':'inherit'});
    } else if(name == '') {
        $('.form-name').focus();
        $('.validate-contact__name').css({'display':'inherit'});    
    } else if(email == '') {
        $('.form-email').focus();
        $('.validate-contact__email').css({'display':'inherit'});
    } else if(!isEmail(email)) {
        $('.form-email').focus();
        $('.check-contact__email').css({'display':'inherit'});
    } else {
        let form_URL = 'ajax/frontend/action/contact_full';
        $.post(form_URL, {
            email : email,fullname : name,message : content
        },
        function(data){
            if(data.trim() == 'success'){
                toastr.success('Bạn đã gửi yêu cầu thành công, chúng tôi sẽ liên hệ với bạn sớm nhất!','Thành công');
            }else{
                toastr.error('Có lỗi xảy ra!','Xin vui lòng thử lại!');
            }
        });
    }
});

$('body').on('click', '.submit-endow', function(e){
    e.preventDefault();
    var form = $(this).data('endow');
    var email = $('.'+form).val();
    var type = $(this).data('type');

    if(type == 1){
        if(email == '') {
            alertLine('Xin vui lòng điền số điện thoại!');
        } else if(!isPhone(email)) {
            alertLine('Số điện thoại không hợp lệ!');
        } else {
            load_box();
            $.ajax({
                type: 'post',
                dataType: 'text',
                data: {email:email},
                url: 'ajax/frontend/action/contact_phone',
                success:function(data){
                    end_load_box();
                    $('.'+form).val('');
                    $('.mfp-close').click();
                    alert('Gửi yêu cầu thành công!');
                }
            });
        }
    }else{
        if(email == '') {
            alertLine('Xin vui lòng điền email!');
        } else if(!isEmail(email)) {
            alertLine('Email không hợp lệ!');
        } else {
            load_box();
            $.ajax({
                type: 'post',
                dataType: 'text',
                data: {email:email},
                url: 'ajax/frontend/action/contact_email',
                success:function(data){
                    end_load_box();
                    $('.'+form).val('');
                    $('.mfp-close').click();
                    alert('Gửi yêu cầu thành công!');
                }
            });
        }
    }
    
});

$(document).ready(function(){
    $('#sort_product').on('change',function(){
        var sort = $('select[name="sort_product"]').val();
        if(sort != ''){
          window.location = window.location.origin+window.location.pathname+'?sort='+sort;
        }else{
          window.location = window.location.origin+window.location.pathname;
        }
    })
});



// Mua hĂ ng kĂ¨m biáº¿n thá»ƒ
$("body").on("click",".buy_now_verzion",function(e){
    var token = $("input[name='_token']").val(); 
    var qty = $(".input_qty").val();
    var product_id = $(this).data("id");
    var qty = parseInt(qty);
    var key_verzion = $('.box-color .color-item.active').attr('data-id');
    var verzion = $('.box-color .color-item.active').attr('data-title');

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
        url:'/ajax/add-card',
        data:{
            "_token":token,
            'qty':qty,
            'product_id':product_id,
            'key_verzion':key_verzion,
            'verzion':verzion,
        },success:function(result){
            $('.cart-count').text(result.count);
            $('.cart-price').text(result.price);
            // $('.loadding-cart').click();
        }
    });
});



// load data huyá»‡n (Ä‘áº·t hĂ ng)
$('#province_id').on('change', function(){
    var province_id = $(this).val();
    var token = $('input[name="_token"]').val();
    var coupon_code = $('.coupon_code').val();
    $('.validate-message').css({'display':'none'});
    load_box();
    $.ajax({
        type: 'post',
        dataType: 'json',
        data: {"_token":token,province_id : province_id,coupon_code:coupon_code},
        url: '/ajax/load-data-districts',
        success:function(data){
            if(data.price_ship > '0'){
                $('.alert-ship').css({'display':'revert'});
            }
            if(data.price_reduction > '0'){
                $('.alert-price_reduction').css({'display':'revert'});
                $('.price-reduction').text(data.price_reduction);
            }else{
                $('.alert-price_reduction').css({'display':'none'});
            }
            $('#district_id').html(data.district);
            $('.total_shipping').text(data.price_ship);
            $('.total_shipping_price').text(data.price_all);
            end_load_box();
        }
    });
});

function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}
// thĂªm cookie
function setCookie(key, value) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';path=/;expires=' + expires.toUTCString();
}
// XĂ³a cookie
function deleteCookie(key,path) {
    var expires = new Date();
    expires.setTime(expires.getTime()-1);
    document.cookie = key + '=; path='+path+'; expires=' + expires.toUTCString();
}
// them vao danh sach yeu thich
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
$("body").on("click",".view-product",function(e){
    let _this = $(this)
    let id = _this.attr('data-id')
    let form_URL = 'ajax/frontend/dashboard/view_product';
    $.post(form_URL, {
        id: id
    },
    function(data){
        let json = JSON.parse(data)
        $('.form-product-view').html(json.html)
    }); 
});
// remove san pham khoi danh sach yeu thich
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
// Ä‘áº·t hĂ ng 
$("body").on("click",".button_order",function(e){
    e.preventDefault();
    var name = $('.formcart-name').val();
    var phone = $('.formcart-phone').val();
    var email = $('.formcart-email').val();
    var note = $('.formcart-note').val();
    var token = $("input[name='_token']").val();
    var provincial = $('#city').find(':selected').val();
    var district = $('#district').find(':selected').val();
    var address = $('.formcart-address').val();
    var check_rules = $('input[name="terms-condition"]:checked').val();
    $('.validate-message').css({'display':'none'});
    if(name == ''){
        $('.validate-name').css({'display':'inherit'});
        $('.formcart-name').focus();
    }else if(phone == ''){
        $('.validate-phone').css({'display':'inherit'});
        $('.formcart-phone').focus();
    }else if(!isPhone(phone)){
        $('.check-phone').css({'display':'inherit'});
        $('.formcart-phone').focus();
    }else if(!isEmail(email) && email != ''){
        $('.check-email').css({'display':'inherit'});
        $('.formcart-email').focus();
    }else if(provincial == ''){
        $('.validate-province').css({'display':'inherit'});
    }else if(district == ''){
        $('.validate-district').css({'display':'inherit'});
    }else if(address == ''){
        $('.formcart-address').focus();
        $('.validate-address').css({'display':'inherit'});
    }else if(check_rules != '1'){
        $('.validate-rules').css({'display':'inherit'});
    }else{
        $(this).closest('form').submit();
    }
});

// Xem thêm bài viết
$("body").on("click",".viewadd_detail",function(e){
    $('.product-body').addClass('product-showall');
    $(this).removeClass('viewadd_detail');
    $(this).addClass('viewadd_hide');
    $(this).text('Ẩn bớt');
});

$("body").on("click",".viewadd_hide",function(e){
    $('.product-body').removeClass('product-showall');
    $(this).removeClass('viewadd_hide');
    $(this).addClass('viewadd_detail');
    $(this).text('Xem thêm');
});

$("body").on("click",".btn-login",function(e){
    $('.btn-login').removeClass('active');
    $(this).addClass('active');
    var tab = $(this).data('tab');
    $('.tab-pane').removeClass('active');
    $('.'+tab).addClass('active');
});

$('body').on('click', '.btn-register', function(e){
    e.preventDefault();
    var name = $('#register-name').val();
    var email = $('#register-email').val();
    var phone = $('#register-phone').val();
    var password = $('#register-password').val();
    var count_pass = password.length;
    var address = $('#register-address').val();
    if(name == ''){
        alertLine('Họ tên không được để trống!');
    }else if(email == ''){
        alertLine('Email không được để trống!');
    }else if(!isEmail(email)){
        alertLine('Email không đúng định dạng!');
    }else if(password == ''){
        alertLine('Mật khẩu không được để trống!');
    }else if(count_pass < 6){
        alertLine('Mật khẩu phải từ 6 ký tự trở lên!')
    }else if(phone == ''){
        alertLine('Số điện thoại không được để trống!');
    }else if(!isPhone(phone)){
        alertLine('Số điện thoại không đúng định dạng!');
    }else if(address == ''){
        alertLine('Địa chỉ không được để trống!')
    }else{
        load_box();
        let form_URL = 'ajax/frontend/auth/signup_ajax';
        $.post(form_URL, {
            fullname: name,  email: email,  password: password,  address: address,  phone: phone
        },
        function(data){
            end_load_box();
            if(data == 0){
                toastr.error('Xin vui lòng thử lại!', 'Có lỗi xảy xa!');
            }else if(data== 2){
                toastr.error('Email đã tồn tại trong hệ thống!','Xin vui lòng thử lại!');
            }else{
                toastr.success('Tạo tài khoản thành công!','Thành công!');
                $('.btn-register').parents('form')[0].reset();
            }
        }); 
    }
});

$("body").on("click",".remove-alert",function(e){
    $('.alert-login').remove();
});


$("body").on("click",".push-login",function(e){
    e.preventDefault();
    var email = $('#singin-email').val();
    var password = $('#singin-password').val();
    var check_rules = $('input[name="signin-remember"]:checked').val();
    if(email == '' && password == ''){
        alertLine('Vui lòng nhập Email và mật khẩu!');
    }else if(email == ''){
        alertLine('Vui lòng điền Email đăng nhập!!');
    }else if(password == ''){
        alertLine('Vui lòng điền mật khẩu đăng nhập!!')
    }else{
        load_box();
        let form_URL = 'ajax/frontend/auth/login';
        $.post(form_URL, {
            email: email,  password: password,  check: check_rules
        },
        function(data){
            end_load_box();
            if(data == 0){
                toastr.error('Email hoặc mật khẩu không chính xác!','Có lỗi xảy xa!');
            }else if(data== 1){
                toastr.error('Tài khoản của bạn đã bị khoá!', 'Có lỗi xảy xa!');
            }else if(data.trim() == 'complete'){
                toastr.success('Đăng nhập thành công!','Thành công!');
                window.location.reload()
            }else{
                toastr.error('Xin vui lòng thử lại!' ,'Có lỗi xảy xa!');
            }
        }); 
    }
});

$("body").on("click",".mobile-menu-toggle",function(e){
    $('.loaded').addClass('mmenu-active');
});

$("body").on("click",".mobile-menu-close",function(e){
    $('.loaded').removeClass('mmenu-active');
});

$("body").on("click",".mobile-menu-overlay",function(e){
    $('.loaded').removeClass('mmenu-active');
});



$("body").on("click",".btn-updateShip",function(e){
    e.preventDefault();
    var token = $("input[name='_token']").val();
    var provincial = $('#province_id').find(':selected').val();
    var coupon_code = $('.coupon_code').val();
    $('.validate-message').css({'display':'none'});
    if(provincial == ''){
        $('.validate-ship__province').css({'display':'inherit'});
    }else{
        load_box();
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: {"_token":token,provincial:provincial,coupon_code:coupon_code},
            url: '/ajax/loadding-ship',
            success:function(data){
                $('.total_shipping').text(data.price_ship);
                $('.total_shipping_price').text(data.price_all);
                $('.price-reduction').text(data.price_reduction);
                end_load_box();
                console.log(data);
            }
        });
    }
});

$("body").on("click",".btn-pay",function(e){
    e.preventDefault();
    var provincial = $('#city').find(':selected').val();
    if(provincial == '0'){
        $('.validate-ship__province').css({'display':'inherit'});
    }else{
        $(this).closest('form').submit();
    }
});

$("body").on("click",".btn-feedback",function(e){
    var token = $("input[name='_token']").val();
    var content = $('.input-feedback').val();
    if(content == ''){
        $('.validate-feedback').css({'display':'inherit'});
        $('.input-feedback').focus();
    }else{
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: {"_token":token,content:content},
            url: '/ajax/feedback',
            success:function(data){
                console.log(data);
                if(data.status == 2){
                    $('.form-feedback').remove();
                    $('.alert-feedback').text(data.alert);
                }else{
                    alertLine('Xin vui lòng thử lại, có lỗi xảy ra!');
                }
            }
        });
    }
});

$("body").on("click",".btn-save-info",function(e){
    e.preventDefault();
    var name = $('.profile-name').val();
    var email = $('.profile-email').val();
    var phone = $('.profile-phone').val();
    var address = $('.profile-address').val();
    var current_password = $('.profile-current__password').val();
    var new_password = $('.profile-new__password').val();
    var confirm_password = $('.profile-confirm__password').val();
    var count_new_password = new_password.length;
    var count_confirm_password = confirm_password.length;
    $('.validate-message').css({'display':'none'});

    if(name == ''){
        $('.profile-name').focus();
        $('.validate-profile__name').css({'display':'inherit'});
    }else if(email == ''){
        $('.profile-email').focus();
        $('.validate-profile__email').css({'display':'inherit'}); 
    }else if(!isEmail(email)){
        $('.profile-email').focus();
        $('.check-profile__email').css({'display':'inherit'});
    }else if(phone == ''){
        $('.profile-phone').focus();
        $('.validate-profile__phone').css({'display':'inherit'}); 
    }else if(!isPhone(phone)){
        $('.profile-phone').focus();
        $('.check-profile__phone').css({'display':'inherit'});
    }else if(address == ''){
        $('.profile-address').focus();
        $('.validate-profile__address').css({'display':'inherit'}); 
    }else if(current_password == '' && new_password != '' || current_password == '' && confirm_password != ''){
        $('.profile-current__password').focus();
        $('.validate-current__password').css({'display':'inherit'}); 
    }else if(current_password != '' && new_password == ''){
        $('.profile-new__password').focus();
        $('.validate-new__password').css({'display':'inherit'}); 
    }else if(current_password != '' && new_password != '' && confirm_password == ''){
        $('.profile-confirm__password').focus();
        $('.validate-confirm__password').css({'display':'inherit'}); 
    }else if(new_password != confirm_password){
        $('.profile-confirm__password').focus();
        $('.check-confirm__password').css({'display':'inherit'}); 
    }else if(current_password != '' && new_password != '' && confirm_password != '' && count_new_password < 6 && count_confirm_password < 6){
        $('.profile-confirm__password').focus();
        $('.count-confirm__password').css({'display':'inherit'});
    }else{
        load_box();
        let form_URL = 'ajax/frontend/auth/update_info_member';
        $.post(form_URL, {
            id: $('.btn-save-info').attr('data-id'),fullname: name,  email: email, address: address,  phone: phone, current_password: current_password, new_password: new_password
        },
        function(data){
            end_load_box();
            if(data.trim() == 'no_exist'){
                toastr.error('Tài khoản không tồn tại hoặc đã bị khoá!', 'Có lỗi xảy xa!');
            }else if(data.trim() == 'error'){
                toastr.error('Có lỗi xảy ra!','Xin vui lòng thử lại!');
            }else if(data.trim() == 'error_password'){
                toastr.error('Mật khẩu không chính xác!','Xin vui lòng thử lại!');
            }else{
                toastr.success('Cập nhật tài khoản thành công!','Thành công!');
                window.location.reload();
            }
        }); 
    }
});

$("body").on("click",".button-plus",function(e){
    var count = Math.floor($('.quantity').val());
    var count = count+1;
    $('.quantity').val(count);
});

$("body").on("click",".button-minus",function(e){
    var count = Math.floor($('.quantity').val());
    if(count == 1){
        var count = count;
    }else{
        var count = count-1;
    }
    $('.quantity').val(count);
});

function sendAjax(href){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: href,
        beforeSend:function(){
            history.pushState(null, null, href);
            $("#loading_box").css({visibility:"visible", opacity: 0.0}).animate({opacity: 1.0},200);
        },
        success:function(data){
            $("#loading_box").animate({opacity: 0.0}, 200, function(){
                $("#loading_box").css("visibility","hidden");
            });
            $('.category-list').html(data.html);
            $("img.lazy").lazyload({
                effect : "fadeIn"
            });
            $('.box-filter__content').slideUp();
            if(data.view_more == 2){
                $('.view-more__product').css("display","none");
            }
            if(data.view_more == 1){
                $('.view-more__product').css("display","initial");
            }
        },error:function(){
            $("#loading_box").animate({opacity: 0.0}, 200, function(){
                $("#loading_box").css("visibility","hidden");
            });
            alert('CĂ³ lá»—i sáº£y ra');
        }
    });
}

// function loadAjaxGet(url,option){
//     var _option = {
//         beforeSend:function(){},
//         success:function(){}
//     }
//     $.extend(_option,option);
//     $.ajax({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type: 'GET',
//         url: url,
//         beforeSend: function(){
//             _option.beforeSend();
//         },
//         success:function(result){
//             _option.success(result);
//         }
//     })
// }

$('body').on('click', '.filter_button', function(e){
    var check_checked = $(this).attr('data-checked');
    var data_href = $(this).data('href');
    var data_class = $(this).data('active');
    if(check_checked == 0){
        $('.'+data_class).addClass('active');
        $(this).attr('data-checked', 1);
        $(this).addClass('active');
        $(this).find('input').prop('checked', true);
        $(this).find('i').removeClass('fa-square');
        $(this).find('i').addClass('fa-check-square');
    }else{
        $('.'+data_class).removeClass('active');
        $(this).attr('data-checked', 0);
        $(this).removeClass('active');
        $(this).find('input').prop('checked', false);
        $(this).find('i').removeClass('fa-check-square');
        $(this).find('i').addClass('fa-square');
    }
    var k = 0;
    var url_filter_custom = [];
    $(".filter-group-custom .filter_button").each(function(){
        if($(this).find('input').is(':checked')){
            url_filter_custom[k] = $(this).find('input').val();
            k++;
        }
    });

    var url_filter = '?';
    for(var i = 0; i < url_filter_custom.length; i ++){
        if(i == 0){
            url_filter += 'filter=';
        }
        url_filter += url_filter_custom[i];
        if(i != url_filter_custom.length - 1){
            url_filter += '_';
        }
    }
    var href = data_href+url_filter;
    sendAjax(href);
    $('.view-more__product').attr('data-url', href);
    $('.view-more__product').attr('data-page', 2);
    $('.view-more__product').html('Xem thêm');
    $('.sidebar-close').click();
});

$('body').on('click', '.view-more__product' ,function(){
    var page = $(this).attr('data-page');
    var url = $(this).attr('data-url');
    var check_sort = url.indexOf('?sort=');
    var check_filter = url.indexOf('?filter=');
    if(check_sort > 0 || check_filter > 0){
        url = url+'&page='+page;
    }else{
        url = url+'?page='+page;
    }
    loadAjaxGet(url,{
        beforeSend:function(){
            $("#loading_box").css({visibility:"visible", opacity: 0.0}).animate({opacity: 1.0},200);
        },
        success:function(result){
            $("#loading_box").animate({opacity: 0.0}, 200, function(){
                $("#loading_box").css("visibility","hidden");
            });
            if(result.status == 1){
                $('.category-list').append(result.html);
                $('.view-more__product').attr('data-page', result.page);
                $("img.lazy").lazyload({
                    effect : "fadeIn"
                });
            }else{
                $('.view-more__product').css("display","none");
            }
        },
        error: function (error) {
            $("#loading_box").animate({opacity: 0.0}, 200, function(){
                $("#loading_box").css("visibility","hidden");
            });
            alert('Có lỗi xảy ra! Xin vui lòng thử lại');
        }
    });
});

$('body').on('click', '.sort-price', function(e){
    var link = $(this).data('href');
    var url = $(this).data('url');
    var check = $('.input-filter').is(":checked")
    if(check == ''){
        var url = '?'+url;
    }else{
        var url = '&'+url;
    }
    var href = url+link;
    sendAjax(href);
});

$("body").on("click",".btn-layout",function(e){
    var layout = $(this).data('value');
    setCookie('layout',layout);
    window.location.reload();
});

$("body").on("click",".active-category",function(e){
    var category = $(this).data('category');
    $('.'+category).slideDown();
    $(this).removeClass('active-category');
    $(this).addClass('hiddent-category');
});

$("body").on("click",".hiddent-category",function(e){
    var category = $(this).data('category');
    $('.'+category).slideUp();
    $(this).addClass('active-category');
    $(this).removeClass('hiddent-category');
});

$("body").on("click",".category-button__viewadd",function(e){
    $(this).removeClass('category-button__viewadd');
    $(this).addClass('category-button__hiddent');
    $(this).text('Ẩn bớt nội dung');
    $('.category-detail').css({'max-height':'inherit'});
});

$("body").on("click",".category-button__hiddent",function(e){
    $(this).addClass('category-button__viewadd');
    $(this).removeClass('category-button__hiddent');
    $(this).text('Xem thêm nội dung');
    $('.category-detail').css({'max-height':'700px'});
});

var timeoutID=null
// back to top
var mybutton = document.getElementById("scroll-top");
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};
function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        $('.scroll-top').css({'display':'block'});
    } else {
        $('.scroll-top').css({'display':'none'});
    }
}

$("body").on("click",".scroll-top",function(e){
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '500');
});

$("body").on("click",".button-detail__product",function(e){
    $('.button-detail__product').removeClass('button-detail__active');
    $(this).addClass('button-detail__active');
    var active = '.'+$(this).data('active');
    $('.tab-detail__product').removeClass('tab-detail__active');
    $(active).addClass('tab-detail__active');
});
if($('.slides-detail__bottom').length > 0){
    $('.slides-detail__top').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slides-detail__bottom'
    });
    $('.slides-detail__bottom').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.slides-detail__top',
        dots: false,
        centerMode: false,
        focusOnSelect: true,
        prevArrow:"<button type='button' class='slick-prev pull-left'><i class='fa fa-chevron-left'></i></button>",
        nextArrow:"<button type='button' class='slick-next pull-right'><i class='fa fa-chevron-right'></i></button>",
    });
}
if($('.slides-detail__bottom_va').length > 0){
    $('.slides-detail__top').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slides-detail__bottom_va'
    });
    $('.slides-detail__bottom_va').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        asNavFor: '.slides-detail__top',
        dots: false,
        centerMode: false,
        focusOnSelect: true,
        prevArrow:"<button type='button' class='slick-prev pull-left'><i class='fa fa-chevron-left'></i></button>",
        nextArrow:"<button type='button' class='slick-next pull-right'><i class='fa fa-chevron-right'></i></button>",
    });
}