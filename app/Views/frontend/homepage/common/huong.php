<?php 
    $from_date = '1900-01-01';
    $to_date = gmdate('Y-m-d H:i:s', time() + 7*3600);

    $from_date = new DateTime($from_date);
    $to_date = new DateTime($to_date);
    $date_array = [];
    for ($date = $from_date; $date <= $to_date; $date->modify('+1 year')) {
        $key = $date->format('Y');
        $date_array[$key] = $key;
    }

    
?>
<?php   
    $gender = [
        0 => 'Nữ',
        1 => 'Nam',
    ];
    $huong = [
        'Đông' => 'Hướng Đông',
        'Tây' => 'Hướng Tây',
        'Nam' => 'Hướng Nam',
        'Bắc' => 'Hướng Bắc',
        'Đông Bắc' => 'Hướng Đông Bắc',
        'Đông Nam' => 'Hướng Đông Nam',
        'Tây Bắc' => 'Hướng Tây Bắc',
        'Tây Nam' => 'Hướng Tây Nam',
    ];
?>
<div class="showmobile_xemhuongnha hidden-lg hidden-md">
    <a class="item-link downs"> Xem hướng nhà
        <i class="fa fa-angle-down"></i>
    </a>
</div>
<div id="xemhuongnha">
    <div class="wp_phongthuy_form wp_xemhuongnha wp-xemhuongnha wp-xhn">
        <div class="form-title">
            <span>Xem hướng nhà
            </span>
        </div>
        <div class="form-group">
            <label for="name" class="control-label required">Năm sinh gia chủ</label>
            <div class="select">
                <table style="width:100%">
                    <tr>
                        <td style="padding-right:5px">
                            <?php echo form_dropdown('namsinh', $date_array, set_value('namsinh'), 'class="ns "');?>
                        </td>
                        <td>
                            <?php echo form_dropdown('gender', $gender, set_value('gender'), 'class="gt "');?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="control-label required">Hướng nhà</label>
            <div class="select">
                <?php echo form_dropdown('huong', $huong, set_value('huong'), 'class="hn"');?>
            </div>
        </div>
        <div class="form-group" style="text-align: center">
            <button class="xem btn btn-primary  xemhuong" data-catalogueid="12">Xem ngay</button>
        </div>
    </div>
</div>

<script>
    $(document).on('click','.xemhuong', function(){
        let catalogueid = $(this).attr('data-catalogueid');
        let namsinh = $(this).parents('.wp_phongthuy_form').find('.ns').val()
        let huong = $(this).parents('.wp_phongthuy_form').find('.hn').val()
        let gender = $(this).parents('.wp_phongthuy_form').find('.gt').val()
        let ajaxUrl = "ajax/frontend/dashboard/search_huongnha";
        $.ajax({
            method: "POST",
            url: ajaxUrl,
            data: {catalogueid: catalogueid,gender: gender,namsinh: namsinh,huong: huong},
            dataType: "json",
            cache: false,
            success: function(data){
                if(data.code == 'error'){
                    toastr.error('Không có dữ liệu phù hợp!','Xin vui lòng thử lại!');
                }else{
                    var modal = UIkit.modal("#huongnha");
                    $('.title-modal').text(data.title)
                    $('.desc-modal').html(b64DecodeUnicode(data.description))
                    $('.content-modal-abc').html(b64DecodeUnicode(data.content))
                    modal.show();
                }
            }
        });
    });

    function b64DecodeUnicode(str) {
    // Going backwards: from bytestream, to percent-encoding, to original string.
        return decodeURIComponent(atob(str).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
    }
</script>
<style>
    .uk-modal *{
        color: #000;
    }

    .uk-modal-dialog-blank {
        width: 80%;
        position: absolute;
        top: 50%;
        background: #fff;
        padding: 20px;
        left: 50%;
        overflow: auto;
        height: 80vh;
        transform: translate(-50%, -50%) !important;
    }

    .content-modal-abc table{
        text-align: center;
        margin-left: auto;
        margin-right: auto;
        color: white;
        border-collapse: separate;
        border-spacing: 2px;
        border-color: gray;
    }

    .content-modal-abc table td{
        border: 1px solid #ccc;
    }

    .title-modal{
        font-size: 30px;
    }
</style>

<div id="huongnha" class="uk-modal">
    <div class="uk-modal-dialog uk-modal-dialog-blank">
        <div class="content-modal">
            <h2 class="title-modal"></h2>
            <div class="desc-modal"></div>
            <div class="content-modal-abc"></div>
        </div>
    </div>
</div>