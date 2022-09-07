<script>
    $(document).ready(function () {
        globalFooterCheckScreen();

        $("#js-goTop").click(function () {
            $("html,body").animate({ scrollTop: 0 }, 800);
        });

        $("#js-footer-brand").owlCarousel({
            items: 8,
            loop: true,
            margin: 11,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplaySpeed: 1000,
            autoplayHoverPause: true,
            dots: false,
            nav: true,
            navText: ["<i class='arrow arrow-left'></i>", "<i class='arrow'></i>"],
            lazyLoad: true,
        });

        var lazyLoadInstance = new LazyLoad({
            elements_selector: ".lazy",
        });

        $(window).scroll(function () {
            _scrollFixedHeader();

            globalFooterCheckScreen();
        });

        setTimeout(function () {
            $("#js-fontawesome-lib").html('\x3Cscript src="https://kit.fontawesome.com/3b023d18d9.js">\x3C/script>');
        }, 500);
    });

    function globalFooterCheckScreen() {
        if (isOnScreen($("#js-global-article")) && $("#js-global-article").hasClass("loaded") == false) {
            $("#js-global-article").addClass("loaded");
        }

        if (isOnScreen($("#js-global-history-container")) && $("#js-global-history-container").hasClass("loaded") == false) {
            $("#js-global-history-container").addClass("loaded");
        }
    }

    function _scrollFixedHeader() {
        var fixed_height = 800;
        if ($(window).scrollTop() > fixed_height) {
            $(".global-header-container").addClass("header-fixed");
            $(".global-header-block").show();
            $("#js-goTop").fadeIn();
        } else {
            $(".global-header-container").removeClass("header-fixed");
            $(".global-header-block").hide();
            $("#js-goTop").fadeOut();
        }
    }

    function run_carousel(holder) {
        $(holder + " .owl-carousel").owlCarousel({
            margin: 12,
            lazyLoad: true,
            loop: false,
            autoplay: false,
            autoplayTimeout: 4000,
            autoplaySpeed: 1500,
            autoplayHoverPause: true,
            dots: false,
            nav: true,
            navText: ["<i class='arrow arrow-left'></i>", "<i class='arrow'></i>"],
            items: 5,
        });
    }

    function addProductToCart(product_id, quantity, redirect) {
        $.ajax({
            type:'post',
            url:'ajax/frontend/cart/insert',
            data:{
                'qty':quantity,
                'sku': 'SKU_'+product_id,
            },success:function(data){
                if (redirect == '/gio-hang') {
                    location.href = redirect;
                } 
                $(".success-form").show();
                setTimeout(function () {
                    $(".success-form").fadeOut();
                }, 1000);
                let json = JSON.parse(data)
                $('.js-cart-count').text(json.response.totalItems);
            }
        });
    }

    function getProductHistory(holder) {
        var url = "/ajax/get_json.php?action=view-history&action_type=product";

        $(holder).html(`<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>`);

        $.getJSON(url, function (result) {
            if (result.length > 0) {
                var data = result;
                var html = [];

                Object.keys(data).forEach(function (key, keyIndex) {
                    html.push(buildProductHTML(data[key]));
                });

                var format_html = html.join("");

                $(holder).html('<div class="owl-carousel owl-theme custom-nav">' + format_html + "</div>");

                $(document).ajaxStop(function () {
                    run_carousel(holder);
                });
            } else {
                $("#js-global-history-container").remove();
            }
        });
    }

    function buildProductHTML(data) {
        var html_list = "";
        var productName = data.title;
        var productUrl = data.canonical;
        var productId = data.id;

        var productImage = data.image;
        if (productImage == "") productImage = "<?php echo $general['homepage_logo'] ?>";

        var price = parseInt(data.price_promotion);
        var priceFormat = formatCurrency(price) + " đ";
        if (price == 0) priceFormat = "Liên hệ";

        var marketPrice = "";
        var discount = "";
        if (parseInt(data.price) > price && price > 0) {
            marketPrice = formatCurrency(data.price) + " đ";

            var percent = Math.ceil(100 - (price * 100) / data.price);
            discount = "<span class='p-discount'> -" + percent + "% </span>";
        }

        html_list +=
            `
    <div class="p-item">
        <a href="` +
            productUrl +
            `" class="p-img">
            <img src="` +
            productImage +
            `" alt="` +
            productName +
            `" />
        </a>

        <div class="p-text">
            <a href="` +
            productUrl +
            `" class="p-name"> <h3>` +
            productName +
            `</h3> </a>

            <div class="p-price-group">
                <span class="p-price">` +
            priceFormat +
            `</span>
                <span class="p-old-price">` +
            marketPrice +
            `</span>
                ` +
            discount +
            `
            </div>

            <a href="javascript:void(0)" class="p-item-btn icon-cart" onclick="addProductToCart(` +
            productId +
            `, ` +
            1 +
            ` , '')"></a>
        </div>
    </div>
`;
        return html_list;
    }

    function timeCountDown() {
        $(".js-item-deal-time").each(function () {
            var current_time = new Date().getTime() / 1000;
            var to_time = $(this).attr("data-time");
            var time_left = to_time - current_time;
            show_time_left(time_left, this);
        });
    }
</script>

<script>
    $(document).ready(function () {
        ajaxLoadProduct();

        ajaxLoadDeal();

        $("#js-home-slider").owlCarousel({
            items: 1,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplaySpeed: 1000,
            autoplayHoverPause: true,
            dots: true,
            nav: false,
            lazyLoad: true,
        });

        $(window).scroll(function () {
            ajaxLoadProduct();

            ajaxLoadDeal();
        });
    });

    $(document).ajaxStop(function () {
        timeCountDown();
    });

    function ajaxLoadProduct() {
        $(".js-box-container").each(function () {
            if (isOnScreen($(this)) && $(this).hasClass("loaded") == false) {
                var catId = $(this).attr("data-id");
                var holder = $("#js-holder-" + catId);
                var url = "ajax/frontend/dashboard/get_product?id=" + catId ;

                getProductList(url, holder);
                $(this).addClass("loaded");
            }
        });
    }

    function getProductList(url, holder) {
        $(holder).html(`<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>`);

        $.getJSON(url, function (result) {
            if (result.length > 0) {
                var html = [];
                for (var i = 0; i < result.length; i++) {
                    html.push(buildProductHTML(result[i]));
                }

                $(holder).html(html.join(""));
            } else {
                $(holder).html('<p class="align-items-center d-flex font-600 justify-content-center text-26" style="height: 362px;">Sản phẩm đang được cập nhật ...!</p>');
            }
        });
    }

    function ajaxLoadDeal() {
        if (isOnScreen($("#js-home-deal-container")) && $("#js-home-deal-container").hasClass("loaded") == false) {
            getFeaturedDeal();

            $("#js-home-deal-container").addClass("loaded");
        }
    }

    function getFeaturedDeal() {
        var url = "/ajax/frontend/dashboard/get_product_deal";

        $("#js-home-deal-holder").html(`<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>`);

        $.getJSON(url, function (result) {
            if (result.length > 0) {
                var html = [];
                for (var i = 0; i < result.length; i++) {
                    var productName = result[i].title;
                    var productUrl = result[i].canonical;
                    var productId = result[i].id;

                    var productImage = result[i].image;
                    if (productImage == "") productImage = "<?php echo $general['homepage_logo'] ?>";

                    var price = parseInt(result[i].price_promotion);
                    var priceFormat = formatCurrency(price) + " đ";
                    if (price == 0) priceFormat = "Liên hệ";

                    var marketPrice = "";
                    var discount = "";
                    if (parseInt(result[i].price) > price && price > 0) {
                        marketPrice = formatCurrency(result[i].price) + " đ";

                        var percent = Math.ceil(100 - (price * 100) / result[i].price);
                        discount = "<span class='p-discount'> -" + percent + "% </span>";
                    }

                    html += `<div class="p-item">
                        <a href="` + productUrl + `" class="p-img">
                            <img src="` + productImage + `" alt="` + productName + `" />
                        </a>
                        <div class="p-text">
                                <a href="` +
                                productUrl +
                                `" class="p-name">` +
                                productName +
                                `</a>

                                <div class="p-price-group">
                                    <span class="p-price">` +
                                priceFormat +
                                `</span>
                                    <span class="p-old-price">` +
                                marketPrice +
                                `</span>
                                    ` +
                                discount +
                                `
                                </div>

                                <a href="javascript:void(0)" class="p-item-btn icon-cart" onclick="addProductToCart(` +
                                productId +
                                `, ` +
                                1 +
                                `, '')"></a>
                            </div>
                        </div>
                    `;
                }
                $("#js-home-deal-holder").html(html);
            } else {
                $("#js-home-deal-container").remove();
            }
        });
    }
</script>