<div class="global-breadcrumb">
    <div class="container">
        <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="ul clearfix">
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="/" itemprop="item" class="nopad-l">
                    <span itemprop="name" class="icons icon-home">Trang chủ</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>

            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a href="/lien-he" itemprop="item" class="nopad-l">
                    <span itemprop="name"> Thông tin liên hệ </span>
                </a>
                <meta itemprop="position" content="2" />
            </li>
        </ol>
    </div>
</div>

<style>
    .about-page h1,
    .about-page h2,
    .about-page h3,
    .about-page h4,
    .about-page h5,
    .about-page h6 {
        line-height: 22px !important;
    }
</style>

<div class="bg-white about-page">
    <div class="container" style="padding-top: 30px; padding-bottom: 30px;">
        <div class="row">
            <div class="col-6">
                <?php echo $general['contact_contact_text_1'] ?>
                <p>
                    <span style="font-size: 12pt;">
                        <?php echo $general['contact_contact_map_1'] ?>
                    </span>
                </p>
                <div
                    style="
                        color: #001a33;
                        font-family: 'Segoe UI', SegoeuiPc, 'San Francisco', 'Helvetica Neue', Helvetica, 'Lucida Grande', Roboto, Ubuntu, Tahoma, 'Microsoft Sans Serif', Arial, sans-serif;
                        font-size: 15px;
                        font-style: normal;
                        font-variant-ligatures: normal;
                        font-variant-caps: normal;
                        font-weight: 400;
                        letter-spacing: normal;
                        orphans: 2;
                        text-align: start;
                        text-indent: 0px;
                        text-transform: none;
                        white-space: normal;
                        widows: 2;
                        word-spacing: 0px;
                        -webkit-text-stroke-width: 0px;
                        background-color: #ffffff;
                        text-decoration-style: initial;
                        text-decoration-color: initial;
                    "
                >
                    <span style="font-size: 12pt;"> ========================================================</span>
                </div>
                <?php echo $general['contact_contact_text_2'] ?>
                <p>
                    <span style="font-size: 12pt;">
                        <?php echo $general['contact_contact_map_2'] ?>
                    </span>
                </p>
            </div>

            <div class="col-6 mb-col">
                <p>Quý khách vui lòng gửi thông tin liên hệ theo form sau :</p>
                <form method="post" enctype="multipart/form-data" action="frontend/contact/contact/index" >
                    <table width="100%" class="tbl-common">
                        <tr>
                            <td><b>Tên đầy đủ</b></td>
                            <td><input type="text" size="50" name="fullname" id="contact_name_detail" class="form-control" autocomplete="off" /></td>
                        </tr>
                        <tr>
                            <td><b>Email</b></td>
                            <td><input type="text" size="50" name="email" id="contact_email_detail" class="form-control" autocomplete="off" /></td>
                        </tr>
                        <tr>
                            <td><b>Điện thoại</b></td>
                            <td><input type="text" size="50" name="phone"  class="form-control" autocomplete="off" /></td>
                        </tr>
                        <tr>
                            <td><b>Địa chỉ</b></td>
                            <td><input type="text"  name="address"  class="form-control" autocomplete="off" /></td>
                        </tr>
                        <tr>
                            <td><b>Thông tin liên hệ</b></td>
                            <td><textarea rows="8" name="message" id="contact_message_detail" class="form-control" style="width: 100%; height: 90px;"></textarea></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" class="btn btn-outline-info mt-3" value="Gửi liên hệ" style="cursor: pointer;" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>