<nav class="navbar-default navbar-static-side" role="navigation">
    <?php
    $user = authentication();
    $permission = json_decode($user['permission'],true);
    $uri = service('uri');
    $uri = current_url(true);
    $uriModule = $uri->getSegment(2);
    $uriModule_name = $uri->getSegment(3);
    $baseController = new App\Controllers\BaseController();
    $sidebar = new App\Controllers\Api\Sidebar\Sidebar();
    // pre($sidebar);
    $language = $baseController->currentLanguage();
    ?>
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                    <img alt="image" class="img-circle" src="<?php echo $user['image']; ?>" style="min-width:48px;height:48px;" />
                </span>
                <a data-toggle="dropdown" class="dropdown-toggle" href="<?php echo site_url('profile') ?>">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold" style="color:#fff"><?php echo $user['fullname'] ?></strong>
                        </span> <span class="text-muted text-xs block"><?php echo $user['job'] ?> <b class="caret" style="color: #8095a8"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="<?php echo base_url('backend/user/profile/profile/'.$user['id']) ?>">Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url('backend/authentication/auth/logout') ?>">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li class="special_link">
                    <a href="admin"><i class="fa fa-home"></i> <span class="nav-label">Trang chủ</span></a>
                </li>
                <?php if(in_array('backend/product/catalogue/index', $permission) || in_array('backend/product/product/index', $permission) || in_array('backend/product/brand/brand/index', $permission) || in_array('backend/product/store/index', $permission) || in_array('backend/product/warehouse/index', $permission) || in_array('backend/product/voucher/index', $permission)){ ?>
                <li class="<?php echo ( $uriModule == 'product' ) ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-desktop"></i> <span class="nav-label">QL Sản Phẩm</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('backend/product/catalogue/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/product/catalogue/index') ?>">QL Nhóm Sản Phẩm</a></li>
                        <?php } ?>
                        <?php if(in_array('backend/product/product/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'product') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/product/product/index') ?>">QL Sản Phẩm</a></li>
                        <?php } ?>
                        <?php if(in_array('backend/product/brand/brand/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'brand') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/product/brand/brand/index') ?>">QL Thông tin</a></li>
                        <?php } ?>
                        <?php if(in_array('backend/product/store/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'store') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/product/store/index') ?>">QL Cửa Hàng</a></li>
                        <?php } ?>
                        <?php if(in_array('backend/product/warehouse/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'warehouse') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/product/warehouse/index') ?>">QL Kho Hàng</a></li>
                        <?php } ?>
                        <?php if(in_array('backend/product/voucher/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'voucher') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/product/voucher/index') ?>">QL Voucher</a></li> 
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('backend/bill/bill/index', $permission)){ ?>
                <li class="<?php echo ( $uriModule == 'bill') ? 'active'  : '' ?>">
                    <a href="<?php echo base_url('backend/bill/bill/index') ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="nav-label">QL Đơn hàng</span> </a>
                </li>
                <?php } ?>
                <?php if(in_array('backend/price/price/index', $permission)){ ?>
                <li class="<?php echo ( $uriModule == 'price') ? 'active'  : '' ?>">
                    <a href="<?php echo base_url('backend/price/price/index') ?>"><i class="fa fa-truck" aria-hidden="true"></i><span class="nav-label">QL Phí Ship</span> </a>
                </li>
                <?php } ?>
                <?php if(in_array('backend/article/catalogue/index', $permission) || in_array('backend/article/article/index', $permission)){ ?>
                <li class="<?php echo ( $uriModule == 'article') ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-file"></i> <span class="nav-label"><?php echo translate('cms_lang.sidebar.sb_article', $language) ?></span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('backend/article/catalogue/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/article/catalogue/index') ?>"><?php echo translate('cms_lang.sidebar.sb_article_catalogue', $language) ?></a></li>
                        <?php } ?>
                        <?php if(in_array('backend/article/article/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'article') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/article/article/index') ?>"><?php echo translate('cms_lang.sidebar.sb_article', $language) ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('backend/landingpage/landingpage/index', $permission)){ ?>
                <li class="<?php echo ( $uriModule == 'landingpage') ? 'active'  : '' ?>">
                    <a href="<?php echo base_url('backend/landingpage/landingpage/index') ?>"><i class="fa fa-file"></i><span class="nav-label">QL Landingpage</span> </a>
                </li>
                <?php } ?>
                <?php if(in_array('backend/media/catalogue/index', $permission) || in_array('backend/media/media/index', $permission)){ ?>
                <li class="<?php echo ( $uriModule == 'media') ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-camera-retro" aria-hidden="true"></i> <span class="nav-label">QL Dự án</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('backend/media/catalogue/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/media/catalogue/index') ?>">QL Nhóm Dự án</a></li>
                        <?php } ?>
                        <?php if(in_array('backend/media/media/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'media') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/media/media/index') ?>">QL Dự án</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('backend/file/catalogue/index', $permission) || in_array('backend/file/file/index', $permission)){ ?>
                <li class="<?php echo ( $uriModule == 'file') ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-file-text" aria-hidden="true"></i> <span class="nav-label">QL Tài liệu</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('backend/file/catalogue/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/file/catalogue/index') ?>">QL Nhóm Tài liệu</a></li>
                        <?php } ?>
                        <?php if(in_array('backend/file/file/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'file') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/file/file/index') ?>">QL Tài liệu</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('backend/attribute/attribute/index', $permission) || in_array('backend/location/location/index', $permission) || in_array('backend/page/page/index', $permission)){ ?>
                <li class="<?php echo ( $uriModule == 'attribute' || $uriModule == 'location'|| $uriModule == 'page') ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="nav-label">QL Thông tin</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('backend/attribute/catalogue/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'attribute') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/attribute/attribute/index') ?>"><?php echo translate('cms_lang.sidebar.sb_attr', $language) ?></a></li>
                        <?php } ?>
                        <?php if(in_array('backend/location/location/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'location') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/location/location/index') ?>"><?php echo translate('cms_lang.sidebar.sb_location', $language) ?></a></li>
                        <?php } ?>
                        <?php if(in_array('backend/page/page/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'page') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/page/page/index') ?>">QL page tĩnh</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('backend/user/catalogue/index', $permission) || in_array('backend/user/user/index', $permission)){ ?>
                <li class="<?php echo ( $uriModule == 'user') ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-users" aria-hidden="true"></i> <span class="nav-label"><?php echo translate('cms_lang.sidebar.sb_user', $language) ?></span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('backend/user/catalogue/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/user/catalogue/index') ?>"><?php echo translate('cms_lang.sidebar.sb_user_catalogue', $language) ?></a></li>
                        <?php } ?>
                        <?php if(in_array('backend/user/user/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'user') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/user/user/index') ?>"><?php echo translate('cms_lang.sidebar.sb_user', $language) ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('backend/member/catalogue/index', $permission) || in_array('backend/member/member/index', $permission) || in_array('backend/member/info/index', $permission)){ ?>
                <li class="<?php echo ( $uriModule == 'member') ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-user"></i> <span class="nav-label">QL Khách hàng</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('backend/member/catalogue/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/member/catalogue/index') ?>">QL Nhóm Khách hàng</a></li>
                        <?php } ?>
                        <?php if(in_array('backend/member/info/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'info') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/member/info/index') ?>">QL Thông tin Khách hàng</a></li>
                        <?php } ?>
                        <?php if(in_array('backend/member/member/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'member') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/member/member/index') ?>">QL Khách hàng</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('backend/comment/comment/index', $permission) || in_array('backend/contact/contact/index', $permission)){ ?>
                <li class="<?php echo ( $uriModule == 'contact' || $uriModule == 'comment') ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-id-card" aria-hidden="true"></i> <span class="nav-label">QL Liên hệ</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('backend/contact/contact/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'contact') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/contact/contact/index') ?>"><?php echo translate('cms_lang.sidebar.sb_contact', $language) ?></a></li>
                        <?php } ?>
                        <?php if(in_array('backend/comment/comment/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'comment') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/comment/comment/index') ?>">QL Comment</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(in_array('backend/promotion/promotion/index', $permission)){ ?>
                <li class="<?php echo ( $uriModule == 'promotion') ? 'active'  : '' ?>">
                    <a href="<?php echo base_url('backend/promotion/promotion/index') ?>"><i class="fa fa-percent" aria-hidden="true"></i><span class="nav-label">QL Khuyến mãi</span> </a>
                </li>
                <?php } ?>
                <?php if(in_array('backend/language/language/index', $permission) || in_array('backend/slide/slide/index', $permission) || in_array('backend/panel/panel/index', $permission) || in_array('backend/widget/widget/index', $permission) || in_array('backend/system/general/index', $permission) || in_array('backend/system/system/store', $permission) || in_array('backend/menu/menu/listmenu', $permission)){ ?>
                <li class="<?php echo ( $uriModule == 'language' || $uriModule == 'system' || $uriModule == 'panel' || $uriModule == 'slide' || $uriModule == 'widget' || $uriModule == 'menu') ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-cog"></i> <span class="nav-label"><?php echo translate('cms_lang.sidebar.sb_setting', $language) ?></span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if(in_array('backend/language/language/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'language') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/language/language/index') ?>"><?php echo translate('cms_lang.sidebar.sb_language', $language) ?></a></li>
                        <?php } ?>
                        <?php if(in_array('backend/slide/slide/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'slide') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/slide/slide/index') ?>"><?php echo translate('cms_lang.sidebar.sb_slide', $language) ?></a></li>
                        <?php } ?>
                        <?php if(in_array('backend/panel/panel/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'panel') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/panel/panel/index') ?>"><?php echo translate('cms_lang.sidebar.sb_panel', $language) ?></a></li>
                        <?php } ?>
                        <?php if(in_array('backend/system/general/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'general') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/system/general/index') ?>"><?php echo translate('cms_lang.sidebar.sb_general', $language) ?></a></li>
                        <?php } ?>
                        <?php if(in_array('backend/widget/widget/index', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'widget') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/widget/widget/index') ?>"><?php echo translate('cms_lang.sidebar.sb_widget', $language) ?></a></li>
                        <?php } ?>
                        <?php if(in_array('backend/menu/menu/listmenu', $permission)){ ?>
                            <li class="<?php echo ( $uriModule_name == 'menu') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/menu/menu/listmenu') ?>"><?php echo translate('cms_lang.sidebar.sb_menu', $language) ?></a></li>
                        <?php } ?>
                        <?php if(in_array('backend/system/system/store', $permission)){ ?>
                            <li class="hidden <?php echo ( $uriModule_name == 'system') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/system/system/store') ?>">Quản lý Hệ thống</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </div>
    </nav>