<section class="block-comment-panel pt50 pb50">
    <div class="uk-container uk-container-center">
        <div class="block-comments">
            <div class="info-customer">
                <div class="ibox mb20">
                    <div class="ibox-header">
                        <h5><?php echo $language == 'vi' ? 'Đánh giá của Khách Hàng' : 'Customer reviews' ?></h5>
                    </div>
                    <div class="ibox-content" style="position:relative; padding: 20px;">
                        <form action="" method="" class="form uk-form" id="form-front-comment" data-module="<?php echo $module ?>" data-canonical="<?php echo $object['canonical'] ?>">
                            <div class="uk-flex uk-flex-middle uk-grid uk-grid-medium mb30">
                                <div class="uk-width-large-1-1">
                                    <section id="comment-front">
                                        <div class="ibox">
                                            <div class="uk-grid uk-grid-large uk-clearfix uk-flex uk-flex-middle">
                                                <div class="uk-width-large-2-3">
                                                    <section class="comment-statistic">
                                                        <div class="wrap-star uk-flex uk-flex-column-reverse">
                                                            <?php
                                                                if(!isset($star['calculator'])){
                                                                    $star['calculator'] = [
                                                                        '1' => 0,
                                                                        '2' => 0,
                                                                        '3' => 0,
                                                                        '4' => 0,
                                                                        '5' => 0,
                                                                    ];
                                                                }
                                                             ?>
                                                             <?php if(isset($rate['calculator'])){
                                                                foreach ($rate['calculator'] as $key => $value) {
                                                              ?>
                                                            <div class="uk-flex uk-flex-middle mb5 uk-flex-wrap">
                                                                <div class="five-star mr20 text-left">
                                                                    <span class="rating order-1" data-stars="<?php echo $key ?>"  style="display: inline-block;">
                                                                        <?php
                                                                            for ($i=1; $i <= $key ; $i++) {
                                                                                echo '<i class="star-rating fa fa-star" aria-hidden="true"></i>';
                                                                            }
                                                                            for ($i=1; $i <= 5-$key ; $i++) {
                                                                                echo '<i class="star-rating fa fa-star-o" aria-hidden="true"></i>';
                                                                            }
                                                                         ?>

                                                                    </span>
                                                                </div>
                                                                <div class="uk-flex uk-flex-middle">
                                                                    <div class="uk-progress mr20">
                                                                        <?php
                                                                            if($rate['sum'] != 0){
                                                                                $width = $value/$rate['sum']*100 ;
                                                                            }else{
                                                                                $width = 0;
                                                                            }
                                                                        ?>
                                                                        <div class="uk-progress-bar" style="width: <?php echo $width ?>%"></div>
                                                                    </div>
                                                                    <div class="total-comment"><?php echo $value ?></div>
                                                                </div>
                                                            </div>
                                                            <?php }} ?>
                                                        </div>
                                                    </section>
                                                </div>
                                                <div class="uk-width-large-1-3">
                                                    <div class="uk-flex uk-flex-center">
                                                        <section class="wrap-total">
                                                            <div class="">
                                                                <div class="number-average">
                                                                    <span class="big-number"><?php echo isset($rate['total']) ? $rate['total'] : 0 ?></span>/
                                                                    <span class="small-number">5</span>
                                                                </div>
                                                                <div class="star-average">
                                                                    <div class="text-left">
                                                                        <span class="rating"  style="display: inline-block;">
                                                                            <?php
                                                                                $number = 0;
                                                                                if(isset($rate['total'])){
                                                                                    $number = $rate['total'];
                                                                                }
                                                                                for ($i=1; $i <= round($number) ; $i++) {
                                                                                    echo '<i class="star-rating-big fa fa-star" aria-hidden="true"></i>';
                                                                                }
                                                                                for ($i=1; $i <= 5-round($number) ; $i++) {
                                                                                    echo '<i class="star-rating-big fa fa-star-o" aria-hidden="true"></i>';
                                                                                }
                                                                             ?>
                                                                        </span>
                                                                    </div>
                                                                    <p><?php echo isset($rate['sum']) ? $rate['sum'] : 0 ?> <?php echo $language == 'vi' ? 'đánh giá' : 'rates' ?></p>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <div class="uk-grid uk-grid-small uk-grid-width-large-1-2">
                                <div class="form-row">
                                    <textarea name="comment_note" cols="40" rows="10" placeholder="<?php echo $language == 'vi' ? 'Viết nhận xét' : 'Write a review' ?>" class="textarea cmt-content" autocomplete="off"></textarea>
                                </div>
                                <div class="comment-infomation">
                                    <div class="uk-grid uk-grid-small uk-grid-width-large-1-2 mb10">
                                        <div class="form-row">
                                            <input type="text" name="comment_name" value="" placeholder="<?php echo $language == 'vi' ? 'Họ tên' : 'Fullname' ?>" class="input-text cmt-name" autocomplete="off">
                                        </div>
                                        <div class="form-row">
                                            <input type="text" name="comment_phone" value="" placeholder="<?php echo $language == 'vi' ? 'Số Điện thoại' : 'Phone' ?>" class="input-text cmt-phone" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="uk-grid uk-grid-small uk-grid-width-large-1-2 mb10">
                                        <div class="form-row">
                                            <input type="text" name="comment_email" value="" placeholder="Email" class="input-text cmt-email" autocomplete="off">
                                        </div>
                                        <div class="btn-cmt sent-cmt">
                                            <button type="submit" name="sent_comment" value="sent_comment" class="btn btn-success  comment-btn uk-width-1-1" ><?php echo $language == 'vi' ? 'Gửi' : 'Send' ?></button>
                                        </div>
                                    </div>
                                    <div class="uk-flex uk-flex-middle mt10">
                                        <div class="">
                                            <input type="number" style="display: none" class="data-rate" name="data-rate" value="5">
                                            <div class="rate">
                                                <input type="radio" id="star5" name="rate" value="5" />
                                                <label for="star5" title="text"></label>
                                                <input type="radio" id="star4" name="rate" value="4" />
                                                <label for="star4" title="text"></label>
                                                <input type="radio" id="star3" name="rate" value="3" />
                                                <label for="star3" title="text"></label>
                                                <input type="radio" id="star2" name="rate" value="2" />
                                                <label for="star2" title="text"></label>
                                                <input type="radio" id="star1" name="rate" value="1" />
                                                <label for="star1" title="text"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
                $check = [];
                if(isset($_COOKIE[AUTH.'backend']) && $_COOKIE[AUTH.'backend'] != ''){
                    $check = $rate['all_comment'];
                }else{
                    $check = $rate['comment_publish_1'];
                }
            ?>
            <?php if(isset($check) && is_array($check) && count($check)){ ?>
                <div class="ibox">
                    <div class="ibox-header">
                        <h5><?php echo $language == 'vi' ? 'Danh sách đánh giá' : 'List of reviews' ?></h5>
                    </div>
                    <div class="ibox-content" style="position:relative;padding-right:10px;padding-left:10px;">
                        <div class="block-comment in-active">


                            <?php if(isset($check) && is_array($check) && count($check)){ ?>
                                <ul class="list-comment uk-list uk-clearfix">
                                    <?php foreach ($check as $key => $value) { ?>
                                    <?php if($key == 10)	break; ?>
                                        <li class="list-comment-item ajax_get_cmt">
                                            <div class="comment admin_select_hidden" data-user="<?php echo (isset($_COOKIE[AUTH.'backend']) ? base64_encode($_COOKIE[AUTH.'backend']) : '') ?>" data-value="<?php echo base64_encode(json_encode($value)) ?>">
                                                <div class="uk-flex uk-flex-space-between mb5">
                                                    <div class="cmt-profile">
                                                        <div class="uk-flex">
                                                            <div class="_cmt-avatar"><img src="<?php echo ((isset($value['image']) && $value['image'] != '') ? $value['image'] : 'public/avatar.png') ?>" alt="" class="img-sm"></div>
                                                            <div class="_cmt-info">
                                                                <div class="uk-flex uk-flex-middle">
                                                                    <div class="_cmt-name"><?php echo ((isset($value['fullname']) && $value['fullname'] != '') ? $value['fullname'] : 'Ẩn danh') ?></div>
                                                                    <div class="label label-primary _cmt-tag">Khách hàng</div>
                                                                </div>
                                                                <?php if(isset($_COOKIE[AUTH.'backend']) && $_COOKIE[AUTH.'backend'] != ''){ ?>
                                                                    <div class="switch mt10 ml10 ml10 publishonoffswitch" data-field="publish" data-module="comment" data-id="<?php echo $value['id'] ?>">
                                                                        <div class="onoffswitch">
                                                                            <input type="checkbox" id="publish-<?php echo $value['id'] ?>" class="onoffswitch-checkbox publish" <?php echo ($value['publish'] == 1 ? 'checked' : '') ?>>
                                                                            <label class="onoffswitch-label" for="publish-<?php echo $value['id'] ?>">
                                                                                <span class="onoffswitch-inner"></span>
                                                                                <span class="onoffswitch-switch"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php $replace_phone = substr($value['phone'],0,7); ?>
                                                                <?php /*<div class="_cmt-phone"><?php echo $replace_phone.'xxx' ?></div>*/ ?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    
                                                </div>

                                                <div class="cmt-content w100">
                                                    <?php echo $value['comment'] ?>
                                                    <div class="_cmt-reply">
                                                        <?php if(isset($_COOKIE[AUTH.'backend']) && $_COOKIE[AUTH.'backend'] != ''){ ?>
                                                            <a href="" title="" class="btn-reply" data-comment="1" data-id="<?php echo $value['id'] ?>" data-module="<?php echo $module ?>">Trả lời</a>
                                                        <?php } ?>
                                                        <span class="rating"  style="display: inline-block;">
                                                            <?php
                                                                $number = 0;
                                                                if(isset($value['rate'])){
                                                                    $number = $value['rate'];
                                                                }
                                                                for ($i=1; $i <= round($number) ; $i++) {
                                                                    echo '<i class="star-rating fa fa-star" aria-hidden="true"></i>';
                                                                }
                                                                for ($i=1; $i <= 5-round($number) ; $i++) {
                                                                    echo '<i class="star-rating fa fa-star-o" aria-hidden="true"></i>';
                                                                }
                                                             ?>
                                                        </span>
                                                        <span class="dash">-</span>
                                                        <span class="cmt-time">
                                                            <i class="fa fa-clock-o"></i>
                                                            <time class="timeago" datetime="<?php echo check_isset($value['created_at']) ?>"></time>
                                                        </span>
                                                    </div>
                                                    <div class="show-reply">
                                                        <!-- đổ cấu trúc comment vào đây -->
                                                    </div>
                                                    <div class="wrap-list-reply">
                                                        <ul class="list-reply list-comment uk-list uk-clearfix" id="reply-to-<?php echo $value['id'] ?>">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>

                                </ul>
                                <div class="loadmore-cmt"><a href="" title="" class="btn-loadmore" data-module="product" data-detailid="6" data-start="1" data-limit="5" data-total="6" data-permissioncomment="admin">Xem thêm</a></div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</section>
<style>

</style>
