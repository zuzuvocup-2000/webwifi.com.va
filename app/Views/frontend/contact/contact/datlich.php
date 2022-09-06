<?php 
    $benh = explode('|', $general['another_benh']);
    $thammy = explode('|', $general['another_phauthuat']);
 ?>
<div class="wrap-contact-primary  pb50">
    <div class="background-news ">
        <div class="img-cover">
            <img src="<?php echo $general['another_banner_contact'] ?>" alt="banner">
        </div>
        <div class="banner-song ">
            <img src="/public/frontend/resources/img/song-contact.png" alt="song">
        </div>
    </div>
    <div class="contact-panel uk-width-1-1 uk-width-large-3-5 uk-container-center">

        <div class="form-contact-panel">
            <div class="header-form-contact">
                <div class="title-form-contact">Tờ khai y tế</div>
                <p class="uk-text-center mb15">Quý khách vui lòng điền các thông tin và trả lời câu hỏi bên dưới</p>
            </div>
            <div class="box-body">
                <?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
            </div>
            <div class="body-form-contact">
                <form class="form-contact-by-va" method="post" action="frontend/contact/contact/datlich">
                    <div class="form-input">
                        <?php echo form_input('fullname', validate_input(set_value('fullname')), 'class="form-control " placeholder="Họ và tên *" '); ?>
                    </div>
                    <div class="form-input">
                        <?php echo form_input('info[Năm sinh]', validate_input(set_value('info[Năm sinh]')), 'class="form-control " placeholder="Năm sinh" '); ?>
                    </div>
                    <div class="form-radio">
                        <span class="mr50">Giới tính</span>
                        <input type="radio" name="info[Giới tính]" <?php echo isset($_POST['info']['Giới tính']) && $_POST['info']['Giới tính'] == 'Nam' ? 'checked' : '' ?> id="male" value="Nam" class="form-radio">
                        <label for="male" class="form__radio-label mr30">Nam</label>
                        <input type="radio" name="info[Giới tính]" <?php echo isset($_POST['info']['Giới tính']) && $_POST['info']['Giới tính'] == 'Nữ' ? 'checked' : '' ?> id="female" value="Nữ" class="form-radio">
                        <label for="female" class="form__radio-label">Nữ</label>
                    </div>
                    <div class="form-input">
                        <?php echo form_input('info[Cân nặng]', validate_input(set_value('info[Cân nặng]')), 'class="form-control " placeholder="Cân nặng" '); ?>
                    </div>
                    <div class="form-input">
                        <?php echo form_input('info[Chiều cao]', validate_input(set_value('info[Chiều cao]')), 'class="form-control " placeholder="Chiều cao" '); ?>
                    </div>
                    <div class="form-input">
                        <?php echo form_input('info[Vòng bụng]', validate_input(set_value('info[Vòng bụng]')), 'class="form-control " placeholder="Vòng bụng" '); ?>
                    </div>
                    <div class="form-input">
                        <?php echo form_input('info[Nghề nghiệp]', validate_input(set_value('info[Nghề nghiệp]')), 'class="form-control " placeholder="Nghề nghiệp" '); ?>
                    </div>
                    <div class="form-input">
                        <?php echo form_input('email', validate_input(set_value('email')), 'class="form-control " placeholder="Email" '); ?>
                    </div>
                    <div class="form-input">
                        <?php echo form_input('phone', validate_input(set_value('phone')), 'class="form-control " placeholder="Số điện thoại *" '); ?>
                    </div>
                    <div class="form-input">
                        <?php echo form_input('address', validate_input(set_value('address')), 'class="form-control " placeholder="Bạn đang được tư vấn tại đâu? *" '); ?>
                    </div>
                    <div class="warning-contact">Để giúp cho việc đưa ra khuyến nghị liệu trình chăm sóc sức khỏe và sắc đẹp tốt nhất, xin quý khách hàng cung cấp một số thông tin sức khỏe cơ bản thông qua các câu hỏi thể hiện dưới đây:</div>
                    <div class="wrap-warning-form">
                        <div class="title-warning">CÁC VẤN ĐỀ VỀ Y TẾ VÀ BỆNH BẠN ĐANG CẦN ĐƯỢC LƯU TÂM</div>
                        <div class="wrap-form">
                            <?php echo form_input('info[Các vấn đề về y tế và bệnh đang cần lưu tâm][0]', validate_input(set_value('info[Các vấn đề về y tế và bệnh đang cần lưu tâm][0]')), 'class="form-control " placeholder="1" '); ?>
                            <?php echo form_input('info[Các vấn đề về y tế và bệnh đang cần lưu tâm][1]', validate_input(set_value('info[Các vấn đề về y tế và bệnh đang cần lưu tâm][1]')), 'class="form-control " placeholder="2" '); ?>
                            <?php echo form_input('info[Các vấn đề về y tế và bệnh đang cần lưu tâm][2]', validate_input(set_value('info[Các vấn đề về y tế và bệnh đang cần lưu tâm][2]')), 'class="form-control " placeholder="3" '); ?>
                            <?php echo form_input('info[Các vấn đề về y tế và bệnh đang cần lưu tâm][4]', validate_input(set_value('info[Các vấn đề về y tế và bệnh đang cần lưu tâm][4]')), 'class="form-control " placeholder="4" '); ?>
                        </div>
                    </div>
                    <div class="wrap-warning-form">
                        <div class="title-warning">THUỐC ĐANG SỬ DỤNG - TÊN, LIỀU LƯỢNG, CÁCH SỬ DỤNG</div>
                        <div class="wrap-form">
                            <?php echo form_input('info[Thuốc đang sử dụng][0]', validate_input(set_value('info[Thuốc đang sử dụng][0]')), 'class="form-control " placeholder="1" '); ?>
                            <?php echo form_input('info[Thuốc đang sử dụng][1]', validate_input(set_value('info[Thuốc đang sử dụng][1]')), 'class="form-control " placeholder="2" '); ?>
                            <?php echo form_input('info[Thuốc đang sử dụng][2]', validate_input(set_value('info[Thuốc đang sử dụng][2]')), 'class="form-control " placeholder="3" '); ?>
                            <?php echo form_input('info[Thuốc đang sử dụng][3]', validate_input(set_value('info[Thuốc đang sử dụng][3]')), 'class="form-control " placeholder="4" '); ?>
                        </div>
                    </div>
                    <?php if(isset($benh) && is_array($benh) && count($benh)){ ?>
                        <div class="wrap-checkbox-form">
                            <div class="title-warning">BỆNH ÁN CỦA GIA ĐÌNH (BỐ, MẸ, ANH CHỊ EM RUỘT)</div>
                            <div class="wrap-checkbox-contact">
                                <div class="warning-checkbox-contact">Chọn các bệnh và ghi rõ người thân nào mắc bên dưới ( nếu có )</div>
                                <div class="uk-flex uk-flex-wrap">
                                    <?php foreach ($benh as $key => $value) { ?>
                                        <div class="form-checkbox">
                                            <input type="checkbox" name="info[Bệnh án của gia đình][]" id="box-1-<?php echo slug($value) ?>" <?php echo isset($_POST['info']['Bệnh án của gia đình']) && in_array($value, $_POST['info']['Bệnh án của gia đình']) == true  ? 'checked' : '' ?> value="<?php echo $value ?>" class="form-radio">
                                            <label for="box-1-<?php echo slug($value) ?>" class="form__radio-label"><?php echo $value ?></label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-input">
                        <?php echo form_input('info[Bệnh khác]', validate_input(set_value('info[Bệnh khác]')), 'class="form-control " placeholder="Bệnh khác" '); ?>
                    </div>
                    <div class="form-input">
                        <?php echo form_input('info[Người thân mắc bệnh khi nào?]', validate_input(set_value('info[Người thân mắc bệnh khi nào?]')), 'class="form-control " placeholder="Người thân mắc bệnh khi nào?" '); ?>
                    </div>
                    <div class="form-input">
                        <?php echo form_input('info[Ghi chú khác]', validate_input(set_value('info[Ghi chú khác]')), 'class="form-control " placeholder="Ghi chú khác" '); ?>
                    </div>
                    <?php if(isset($benh) && is_array($benh) && count($benh)){ ?>
                    <div class="wrap-checkbox-form">
                        <div class="title-warning">Bạn đã từng mắc các bệnh</div>
                        <div class="wrap-checkbox-contact">
                            <div class="warning-checkbox-contact">Chọn các bệnh và ghi chú rõ ( nếu có )</div>
                            <div class="uk-flex uk-flex-wrap">
                                <?php foreach ($benh as $key => $value) { ?>
                                    <div class="form-checkbox">
                                        <input type="checkbox" name="info[Bạn đã từng mắc các bệnh][]" id="box-2-<?php echo slug($value) ?>" <?php echo isset($_POST['info']['Bạn đã từng mắc các bệnh']) && in_array($value, $_POST['info']['Bạn đã từng mắc các bệnh']) == true ? 'checked' : '' ?> value="<?php echo $value ?>" class="form-radio">
                                        <label for="box-2-<?php echo slug($value) ?>" class="form__radio-label"><?php echo $value ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="form-input">
                        <?php echo form_input('info[Bạn đã mắc bệnh khác]', validate_input(set_value('info[Bạn đã mắc bệnh khác]')), 'class="form-control " placeholder="Bệnh khác" '); ?>
                    </div>
                    <div class="form-input">
                        <?php echo form_input('info[Ghi chú khác của bạn]', validate_input(set_value('info[Ghi chú khác của bạn]')), 'class="form-control " placeholder="Ghi chú khác" '); ?>
                    </div>
                    <div class="wrap-warning-form">
                        <div class="title-warning">NHỮNG CA PHẪU THUẬT TRƯỚC ĐÂY ĐÃ TRẢI QUA</div>
                        <div class="form-input">
                            <?php echo form_input('info[Những ca phẫu thuật trước đây đã trải qua]', validate_input(set_value('info[Những ca phẫu thuật trước đây đã trải qua]')), 'class="form-control " placeholder="Những ca phẫu thuật trước đây đã trải qua" '); ?>
                        </div>
                    </div>
                    <?php if(isset($thammy) && is_array($thammy) && count($thammy)){ ?>
                    <div class="wrap-checkbox-form">
                        <div class="title-warning">ĐIỀU TRỊ THẨM MỸ TRƯỚC ĐÂY</div>
                        <div class="wrap-checkbox-contact">
                            <div class="warning-checkbox-contact">Chọn các phương pháp đã điều trị và ghi rõ phương pháp khác nếu có</div>
                            <div class="uk-flex uk-flex-wrap">
                                <?php foreach ($thammy as $key => $value) { ?>
                                    <div class="form-checkbox">
                                        <input type="checkbox" <?php echo isset($_POST['info']['Điều trị thẩm mỹ trước đây']) && in_array($value, $_POST['info']['Điều trị thẩm mỹ trước đây']) == true ? 'checked' : '' ?> name="info[Điều trị thẩm mỹ trước đây][]" id="<?php echo slug($value) ?>" value="<?php echo $value ?>" class="form-radio">
                                        <label for="<?php echo slug($value) ?>" class="form__radio-label"><?php echo $value ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-input">
                        <?php echo form_input('info[Phương thức điều trị thẩm mỹ khác]', validate_input(set_value('info[Phương thức điều trị thẩm mỹ khác]')), 'class="form-control " placeholder="Ghi rõ phương pháp khác" '); ?>
                    </div>
                    <button class="btn-submit-form-contact" type="submit">
                        Gửi yêu cầu
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>