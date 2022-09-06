//@public

function saveUserInfo(payload) {
    /*payload = {
        "name" :  "",
        "email"     : "",
        "tel"       : "",
        "mobile"    : "",
        "address"   : "",
        "district"  : 0,
        "province"  : 0,
        "ship_to_name" : "",
        "ship_to_tel" : "",
        "ship_to_address" : "",
        "ship_to_country" : "",
        "ship_to_district" : 0,
        "ship_to_province" : 0,
        "tax_company" : "",
        "tax_address" : "",
        "tax_code" : "",
        "ship_instruction" : "",
    }*/
    var url = "/ajax/user.php";
    $.post(url, { action: "save-personal-info", info: payload}, function (result) {
        console.info("save-info = " + result);
    })
}

function setUserOption(key, value, return_url) {
    window.location = "/ajax/user_set_option.php?key="+key+"&value="+value+"&return_url=" + encodeURIComponent(return_url);
}

//this simple version is for very simple template which does not have ifelse condition
//this method will skip the compile process
function parseTemplate(key_value, tpl){
    var translated_tpl = tpl, key;
    for(key in key_value){
        if(key_value.hasOwnProperty(key)){
            translated_tpl = translated_tpl.replace(new RegExp("{{"+key+"}}","g"), key_value[key]);
        }
    }
    return translated_tpl;
}

var Base64 = {

    // private property
    _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

    // public method for encoding
    encode : function (input) {
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;

        input = Base64._utf8_encode(input);

        while (i < input.length) {

            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }

            output = output +
                this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
                this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

        }

        return output;
    },

    // public method for decoding
    decode : function (input) {
        var output = "";
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;

        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        while (i < input.length) {

            enc1 = this._keyStr.indexOf(input.charAt(i++));
            enc2 = this._keyStr.indexOf(input.charAt(i++));
            enc3 = this._keyStr.indexOf(input.charAt(i++));
            enc4 = this._keyStr.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            output = output + String.fromCharCode(chr1);

            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }

        }

        output = Base64._utf8_decode(output);

        return output;

    },

    // private method for UTF-8 encoding
    _utf8_encode : function (string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";

        for (var n = 0; n < string.length; n++) {

            var c = string.charCodeAt(n);

            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }

        return utftext;
    },

    // private method for UTF-8 decoding
    _utf8_decode : function (utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;

        while ( i < utftext.length ) {

            c = utftext.charCodeAt(i);

            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            }
            else if((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            }
            else {
                c2 = utftext.charCodeAt(i+1);
                c3 = utftext.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }

        }

        return string;
    }

}

var default_price_currency = 'usd';
var SHOPPING_CART_URL = '/gio-hang';

var ProductAddon = {
    addCart : function(productId, selected_addon) {
        console.log("selected_addon =" + selected_addon);
        if(hura_read_cookie('shopping_cart_addon') == null){
            hura_create_cookie('shopping_cart_addon',',',30);
        }
        var current_cart = hura_read_cookie('shopping_cart_addon');
        if(current_cart.search(','+productId+':'+selected_addon+',') == -1){
            var new_cart = ','+productId+':'+selected_addon + current_cart;
            hura_create_cookie('shopping_cart_addon', new_cart, 30);
        }else{
            console.log("đã có trong giỏ hàng: " + current_cart);
        }
    },
    removeFromCart : function(productId, selected_addon) {
        var current_cart = hura_read_cookie('shopping_cart_addon');
        if(current_cart == null) return ;

        if(current_cart.search(','+productId+':'+selected_addon) !== -1){
            var new_cart = current_cart.replace(','+productId+':'+selected_addon, ",");
            hura_create_cookie('shopping_cart_addon', new_cart, 30);
            window.location = SHOPPING_CART_URL;
        }
    },
    //remove a product
    removeProduct : function(productId) {
        var current_cart = hura_read_cookie('shopping_cart_addon');
        if(current_cart == null) return ;
        var re = new RegExp(","+productId+":([0-9]+),","i");
        var new_cart = current_cart.replace(re, ",");
        hura_create_cookie('shopping_cart_addon',new_cart,30);
    },
    //search for addon selected
    checkSelect : function(productId) {
        var self = this;
        $(".product-addon-"+productId).each(function() {
            if($(this).prop('checked')) {
                var selected_addon = parseInt(this.value);
                if(selected_addon > 0) self.addCart(productId, selected_addon);
            }
        });
    }
};

function checkBrowserEnableCookie(){var cookieEnabled=(navigator.cookieEnabled)?true:false
    if(typeof navigator.cookieEnabled=="undefined"&&!cookieEnabled){document.cookie="testcookie"
        cookieEnabled=(document.cookie.indexOf("testcookie")!=-1)?true:false}
    if(cookieEnabled)return true;else return false;}

function hura_create_cookie(name,value,days){if(days){var date=new Date();date.setTime(date.getTime()+(days*24*60*60*1000));var expires="; expires="+date.toGMTString();}
else var expires="";document.cookie=name+"="+Base64.encode(value)+expires+"; path=/;";}

function hura_read_cookie(name){
    var nameEQ=name+"=";
    var ca=document.cookie.split(';');
    for(var i=0;i<ca.length;i++){
        var c=ca[i];
        while(c.charAt(0)==' ')c=c.substring(1,c.length);
        if(c.indexOf(nameEQ)==0) return Base64.decode(c.substring(nameEQ.length,c.length));
    }
    return null;
}

//format a number for readability
//covert: 12334,5 -> 12.334,5
function format_number(str){
    if(str == '0' || str == 0) return "";

    str = _strToNumber(str) + '';//make sure it is a number, then convert to string
    str = str.replace(/\s/g,'');

    var decimal_part = (str.indexOf(',') > 0)  ? str.substr(str.indexOf(',')) : '';
    if(decimal_part != '') {
        str = str.substr(0, str.indexOf(','));
    }
    str = (str+'').replace(/\./g, "");
    var first_group = str.substr(0, str.length % 3);
    var remain_group = str.replace(first_group,"");
    var num_group = remain_group.length/3;
    var result = "";
    var group_of_three = '';

    for(var i=0;i < num_group;i++){
        group_of_three = remain_group.substr(i*3,3);
        result += group_of_three;
        if(i != (num_group-1)) result += ".";
    }
    if(first_group.length > 0) {
        if(result != "") return first_group + "." + result + decimal_part;
        else return first_group + decimal_part;
    }else{
        if(result != "") return result + decimal_part;
        else return "";
    }

    //convert string to number
    function _strToNumber(str) {
        str += ''; //convert to str incase it's already a number
        while(str.indexOf(".") > 0){
            str = str.replace('.','');
        }
        var result = parseFloat(str);
        return isNaN(result) ? 0 : result;
    }
}

function hura_erase_cookie(name){hura_create_cookie(name,"",-1);}
function countShoppingCart(name){

    var cart_holder_number = document.getElementById('count_shopping_cart_store');
    var cart_holder_total = document.getElementById('total_shopping_cart_store');

    if(hura_read_cookie(name)==null){
        hura_create_cookie(name,'-',30);
        if(cart_holder_number != 'underfined' && cart_holder_number != null){
            cart_holder_number.innerHTML=0;
        }

    }else{
        var current_cart = hura_read_cookie(name);
        //alert(current_cart);

        var ca=current_cart.split(',');
        var number_product=ca.length;

        if(cart_holder_number != 'underfined' && cart_holder_number != null){
            cart_holder_number.innerHTML=number_product-1;
        }

        if(cart_holder_total != 'underfined' && cart_holder_total != null){
            if($("#total_shopping_cart_store").length > 0) {
                //count total value
                var total_value = 0, item_content, item_detail, item_type, pro_id, pro_quantity, unit_price;
                for(var i=0;i<ca.length;i++){
                    item_content = ca[i];
                    if(item_content.length > 1){
                        item_detail = item_content.split("-");
                        item_type = item_detail[0];
                        pro_id = item_detail[1];
                        pro_quantity = parseFloat(item_detail[2]);
                        unit_price = parseFloat(item_detail[3]);
                        total_value += unit_price * pro_quantity;
                    }
                }
                cart_holder_total.innerHTML = writeStringToPrice(total_value +'');
            }
        }
    }}

function emptyShoppingCart(name){hura_create_cookie(name,'-',30);}

//item_type : pro, combo, deal
function addItemToCart(item_type, sellid, quantity, unit_price){

    if(hura_read_cookie('shopping_cart_store')==null){
        hura_create_cookie('shopping_cart_store',',',30);
    }

    var current_cart = hura_read_cookie('shopping_cart_store');
    if(current_cart.search(','+item_type+'-'+sellid+'-')==-1){
        var new_cart=current_cart+','+item_type+'-'+sellid+'-'+quantity+'-'+unit_price;
        hura_create_cookie('shopping_cart_store',new_cart,30);
    }
    //add addon
    if(item_type == 'pro') {
        //find the correct productID since sellid might be a config
        /*var productId = sellid;
         if(sellid.indexOf("_") > -1) {
         var el = sellid.split("_");
         productId = parseInt(el[0]);
         }*/
        ProductAddon.checkSelect(sellid);
    }
}

function addToShoppingCart(item_type,sellid,quantity,unit_price){
    addItemToCart(item_type,sellid,quantity,unit_price);
    window.location = SHOPPING_CART_URL;
}

function addToShoppingCartStop(item_type, sellid, quantity, unit_price, holder_id){
    addItemToCart(item_type,sellid,quantity,unit_price);
    var element =  document.getElementById(holder_id);
    if (typeof(element) != 'undefined' && element != null)
    {
        $("#"+holder_id).html("Đã thêm vào giỏ hàng");
    }
}

function deleteShoppingCartItem(item_type, sellid){
    if(confirm('Bạn muốn xóa bỏ sản phẩm này khỏi giỏ hàng ? ')){
        removeShoppingCartItem(item_type, sellid);
        window.location = SHOPPING_CART_URL;
    }
}

function removeShoppingCartItem(item_type,sellid){
    var current_cart = hura_read_cookie('shopping_cart_store');
    if(current_cart == null) return ;
    current_cart += ",";
    var re = new RegExp(","+item_type+"-"+sellid+"-(.*?)-(.*?),","i");
    var new_cart = current_cart.replace(re, ",");
    var new_cart = new_cart.substr(0, new_cart.length-1);
    hura_create_cookie('shopping_cart_store',new_cart,30);
    //remove all addons if any
    ProductAddon.removeProduct(sellid);
}

function writeStringToPrice(str){
    str = (str+'').replace(/\./g, "");
    var first_group = str.substr(0,str.length % 3);
    var remain_group = str.replace(first_group,"");
    var num_group = remain_group.length/3;
    var result = "", group_of_three;
    for(var i=0;i < num_group;i++){
        group_of_three = remain_group.substr(i*3,3);
        result += group_of_three;
        if(i != (num_group-1)) result += ".";
    }
    if(first_group.length > 0) {
        if(result != "") return first_group + "." + result ;
        else return first_group;
    }else{
        if(result != "") return result;
        else return "";
    }
}

function getItemUnitPrice(item_type, id){
    var unit_price = document.getElementById('sell_price_'+item_type+'_'+id).innerHTML;
    while(unit_price.indexOf(".") > 0){
        unit_price = unit_price.replace('.','');
    }
    unit_price = parseInt(unit_price);
    return unit_price;
}


function updatePrice(item_type, id, new_quantity){
    if(!check_interger(new_quantity)){
        alert('Vui lòng nhập số > 0');
        //reset quantity
        new_quantity = 1;
        $("#quantity_"+item_type+'_'+id).val(new_quantity);
    }
    /*	else{
     unit_price = getItemUnitPrice(id);
     document.getElementById('price_'+id).innerHTML = writeStringToPrice(unit_price * new_quantity + '');
     reCountTotal();
     }
     */
    show_cart_total(item_type, id, new_quantity);

    //01-10-2013
    //check if user is using coupon, recount
    var coupon_code = $('#discount_code').val();
    if(coupon_code.length > 0) {
        var cart_total = document.getElementById('total_value').innerHTML;
        while(cart_total.indexOf(".") > 0){
            cart_total = cart_total.replace('.','');
        }
        check_discount('coupon', coupon_code, parseInt(cart_total));
    }
}

function show_cart_total(item_type, id, quantity){
    var unit_price = getItemUnitPrice(item_type, id);
    document.getElementById('price_'+item_type+'_'+id).innerHTML = writeStringToPrice(unit_price * quantity + '');
    reCountTotal();
}

function check_interger(quantity){
    var intRegex = /^\d+$/;
    if(intRegex.test(quantity)) {
        if(parseInt(quantity) > 0) return true;
        else return false;
    }
    return false;
}

function reCountTotal(){
    var new_cart = "";
    var all_item = 	document.getElementById('item_update_quantity').value;
    var all_item_array = all_item.split(",");
    var total_price = 0;
    var combo_array = [], item_id, unformat_price, item_price, item_quantity, default_price_currency;
    for(var i=0;i<all_item_array.length;i++){
        item_id = all_item_array[i];
        if(item_id.length > 0){
            unformat_price = document.getElementById('sell_price_'+item_id.replace("-","_")).innerHTML;

            if(default_price_currency == 'usd') {
                while(unformat_price.indexOf(",") > 0){
                    unformat_price = unformat_price.replace(',','');
                }
            }else{
                //vnd
                while(unformat_price.indexOf(".") > 0){
                    unformat_price = unformat_price.replace('.','');
                }
            }

            item_price = parseFloat(unformat_price);
            item_quantity = parseInt(document.getElementById('quantity_'+item_id.replace("-","_")).value);
            new_cart += ","+item_id+"-"+item_quantity+"-"+item_price;
            total_price += item_price * item_quantity;
        }
    }
    hura_create_cookie('shopping_cart_store',new_cart,30);
    document.getElementById('total_value').innerHTML = writeStringToPrice(total_price + '');
    document.getElementById('total_cart_value').value = total_price;

    var cart_holder_total = document.getElementById('total_shopping_cart_store');
    if(cart_holder_total != 'undefined' && cart_holder_total != null){
        cart_holder_total.innerHTML = writeStringToPrice(total_price + '');
    }

}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function makeUrlAcceptQuery(url){
    if(url.search("?") > 0) return url;
    else return url + "?";
}

function checkCartForm(){
    //check cart has item
    var current_cart=hura_read_cookie("shopping_cart_store");
    if(current_cart == null) return false;

    var ca=current_cart.split(',');
    var number_product=ca.length;
    if(number_product <=1 ){
        if(confirm("Giỏ hàng chưa có sản phẩm. Vui lòng chọn sản phẩm vào giỏ hàng")){
            window.location = "/";
        };
        return false;
    }else{
        //check user information
        var error = "";
        var check_name = document.getElementById('buyer_name').value;
        if(check_name.length < 4) error += "- Bạn chưa nhập tên\n";
        var check_tel = document.getElementById('buyer_mobile').value;
        if(check_tel.length < 5) error += "- Bạn chưa nhập số di động\n";
        var check_add = document.getElementById('buyer_address').value;
        if(check_add.length < 10) error += "- Bạn chưa nhập địa chỉ";
        //var check_note = document.getElementById('buyer_note').value;
        //if(check_name.length < 4) error += "- Bạn chưa nhập tên\n";
        if(error != "") {
            alert(error); return false;
        }
        return true;
    }
}

function add_compare_product(productId) {
    var current_list = document.getElementById("product_compare_list");
    if(current_list == 'undefined' || current_list == null){
        alert("Cần có biến product_compare_list trong template");
        return false;
    }
    if(current_list.value == '') current_list.value = ",";
    //count current item
    var currentNumItem = 0;
    if(current_list.value.length > 1){
        current_list_id = current_list.value.split(",");
        currentNumItem = current_list_id.length - 1;
    }

    var check_box_id = document.getElementById("compare_box_" + productId);
    var text_compare = document.getElementById("text_compare_" + productId);
    if (check_box_id.checked) {
        if (currentNumItem > 6) {
            //Cho phep so sánh tối đa 3 sản phẩm
            check_box_id.checked = "";
            alert("Bạn chỉ có thể so sánh tối đa 6 sản phẩm\nDanh sách đã có đủ 6");
        }
        else {
            document.getElementById("product_compare_list").value = current_list.value + productId + ",";
            if(text_compare != 'undefined' && text_compare != null){
                text_compare.innerHTML = "Chờ so sánh";
                text_compare.style.backgroundColor = '#FFCC00';
            }
        }
    } else {
        document.getElementById("product_compare_list").value = current_list.value.replace("," + productId + ",", ",");
        if(text_compare != 'undefined' && text_compare != null){
            text_compare.innerHTML = "Chọn so sánh ";
            text_compare.style.backgroundColor = '#FFF';
        }
    }
}

function compare_product(){
    var current_list = document.getElementById("product_compare_list");
    if(current_list == 'undefined' || current_list == null){
        alert("Cần có biến product_compare_list trong template");
        return false;
    }
    var currentNumItem = 0;
    if(current_list.value.length > 1){
        current_list_id = current_list.value.split(",");
        currentNumItem = current_list_id.length - 2;
    }

    if (currentNumItem > 1) {
        window.location = "/so-sanh?list=" + current_list.value;
    }else{
        alert("Bạn cần chọn tối thiểu 2 sản phẩm để so sánh");
        return false;
    }
}

// add product to history by time order (latest viewed first, if already viewed before, remove it before add to list)
function save_product_view_history(product_id){
    if(!check_interger(product_id)){
        return ;
    }

    var cookie_name = 'product_view_history';
    var cookie_value = hura_read_cookie(cookie_name);
    var current_list = (cookie_value != null) ? cookie_value.split(",") : [];

    // if id in the list, remove it
    var index = current_list.indexOf(product_id);
    if (index !== -1) current_list.splice(index, 1);

    // add it to the front
    current_list.unshift(product_id);

    // set cookie
    hura_create_cookie(cookie_name, current_list.join(","),30);
}

function remove_from_history(product_id){
    if(confirm("Bạn chắc chắn muốn xóa sản phẩm này ?")) {
        if(!check_interger(product_id)){
            return;
        }
        var cookie_name = 'product_view_history';
        var cookie_value = hura_read_cookie(cookie_name);
        var current_list = (cookie_value != null) ? cookie_value.split(",") : [];

        // if id in the list, remove it
        var index = current_list.indexOf(product_id);
        if (index !== -1) current_list.splice(index, 1);

        // set cookie
        hura_create_cookie(cookie_name, current_list.join(","),30);

        //refresh page
        window.location = window.location;
    }
}

//item_id : id cua noi dung can luu
function user_like_content(item_id, content, data_holder){
    $.post("/ajax/user_like.php", {item_id : item_id, content_type : content}, function(data) {
        if(data === 'error-not-login') {
            //show login form or alert user
            if(confirm("Để sử dụng chức năng này bạn cần đăng nhập. Click OK để đăng nhập")){
                window.location = "/dang-nhap?returnTo=" + window.location;
            }
        }else if(data === 'error') {
            alert("Bạn đã thực hiện rồi");
        }else{
            $("#"+data_holder).html(data);
            //alert("Cảm ơn bạn");
        }
    });
}

function user_vote_review(review_id, vote){
    $.post("/ajax/vote_product_review.php", {review_id : review_id, vote : vote}, function(data) {
        if(data == 'error-not-login') {
            //show login form or alert user
            if(confirm("Để sử dụng chức năng này bạn cần đăng nhập. Click OK để đăng nhập")){
                window.location = "/dang-nhap?return_url=" + window.location;
            }
        }else if(data == 'error-has-voted') {
            alert("Bạn đã chọn rồi");
        }else{

            if(vote == 'dislike') {
                message = "Bạn không đồng ý với ý kiến này. Bạn có thể muốn viết ý kiến của mình không ?";
                if(confirm(message)){
                    var url = window.location;
                    var review_url = encodeURI(url).replace("=review", "=write-review");
                    if(review_url.search("=write-review") == -1) review_url += "?section=write-review";

                    window.location = review_url;
                }
            }else{
                alert("Cảm ơn bạn đã bày tỏ quan điểm");
            }
        }
    });
}

//function apply shopping cart discount
function check_discount(discount_type, discount_code, cart_value){
    if(discount_type == 'coupon') {
        $("#checking_discount_code").html("vui lòng đợi...");
        $.post("ajax/check_coupon.php", {code : discount_code, order : cart_value  }, function(data){
            //alert(data);
            var result =  jQuery.parseJSON(data);
            if(result.error != '') {
                $("#checking_discount_code").html(result.error);
                //remove this code
                $("#discount_code").val('');
            }else{

                var discount_mssg = "";
                var new_cart_value = 0;
                //$type_list = array('pro' => "Tặng sản phẩm", 'cash' => "Tặng tiền mặt", 'priceoff' => "Giảm giá %", 'other' => "Khác");
                var current_cart_total =document.getElementById('total_value').innerHTML;
                while(current_cart_total.indexOf(".") > 0){
                    current_cart_total = current_cart_total.replace('.','');
                }

                switch(result.type) {
                    case "pro":
                        discount_mssg = result.content;
                        break;
                    case "cash":
                        discount_mssg = "Giảm " + writeStringToPrice(result.content + '') + " đ";
                        new_cart_value = parseInt(current_cart_total) - parseInt(result.content);
                        $("#total_value").html(writeStringToPrice(new_cart_value + ''));
                        break;
                    case "priceoff":
                        discount_mssg = "Giảm " + result.content + '%';
                        new_cart_value = parseInt(current_cart_total) * parseInt(100 - result.content) / 100;
                        //alert(new_cart_value);
                        $("#total_value").html(writeStringToPrice(new_cart_value + ''));
                        break;
                    case "other":
                        discount_mssg = result.content;
                        break;
                }

                //alert(result.type + " = "+result.content);
                $("#checking_discount_code").html(result.title + ": "  + discount_mssg);
                $("#discount_message").html(result.title + ": "  + discount_mssg);
            }

            //$("#discount_code_full").val(data);

        });
    }
}

function loadAjaxContent(holder_id, content_url){
    //check animate
    if($("#anchor_top").length > 0){
        var target_offset = $("#anchor_top").offset();
        var target_top = target_offset.top;
        $('html, body').animate({scrollTop:target_top}, 500);
    }
    $("#"+holder_id).load(content_url);
}

//change captcha image
function change_captcha(holder){
    var unixtime_ms = new Date().getTime();
    $("#"+holder).attr("src","/includes/captcha/captcha.php?v="+unixtime_ms);
}

//allow customer to cancel order just ordered by yet processed
function user_cancel_order(order_id, system_status){
    if(system_status != 'new') {
        alert("Bạn chỉ hủy được đơn hàng chưa được xử lý. Vui lòng liên hệ bộ phận hỗ trợ của chúng tôi");
        return false;
    }
    if(confirm("Bạn chắc chắn muốn hủy đơn hàng này ?"))	{
        $.post("/ajax/user_account.php", {action : 'cancel-order', order_id : order_id, status : system_status}, function(data) {
            //custom message here
            alert("Bạn đã hủy đơn thành công !");
        } );
    }
}

function user_vote_review(review_id, vote){
    $.post("/ajax/vote_product_review.php", {review_id : review_id, vote : vote}, function(data) {
        if(data == 'error-not-login') {
            //show login form or alert user
            if(confirm("Để sử dụng chức năng này bạn cần đăng nhập. Click OK để đăng nhập")){
                window.location = "/dang-nhap?return_url=" + window.location;
            }
        }else if(data == 'error-has-voted') {
            alert("Bạn đã chọn rồi");
        }else{

            if(vote == 'dislike') {
                message = "Bạn không đồng ý với ý kiến này. Bạn có thể muốn viết ý kiến của mình không ?";
                if(confirm(message)){
                    var url = window.location;
                    var review_url = encodeURI(url).replace("=review", "=write-review");
                    if(review_url.search("=write-review") == -1) review_url += "?section=write-review";

                    window.location = review_url;
                }
            }else{
                alert("Cảm ơn bạn đã bày tỏ quan điểm");
            }
        }
    });
}


//prevent being included in a iframe
if (window.top !== window.self) window.top.location.replace(window.self.location.href);

//load this when page load
$(function(){
    countShoppingCart('shopping_cart_store');
});