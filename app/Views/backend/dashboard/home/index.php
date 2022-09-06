<?php
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $bill['present'] = 0;
    $bill['ago'] = 0;
    $member['present'] = 0;
    $member['ago'] = 0;
    if(isset($billList['bill']) && is_array($billList['bill']) && count($billList['bill'])){
        $count = 0;
        foreach ($billList['bill'] as $key => $value) {
            if($count + 1 == count($billList['bill'])){
                $bill['present'] = $value;
            }
            if($count + 2 == count($billList['bill'])){
                $bill['ago'] = $value;
            }
            $count ++;
        }
    }
    if(isset($memberList['member']) && is_array($memberList['member']) && count($memberList['member'])){
        $count = 0;
        foreach ($memberList['member'] as $key => $value) {
            if($count + 1 == count($memberList['member'])){
                $member['present'] = $value;
            }
            if($count + 2 == count($memberList['member'])){
                $member['ago'] = $value;
            }
            $count ++;
        }
    }
?>
<div class="wrapper wrapper-content va-note">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title uk-flex uk-flex-middle uk-flex-space-between">
                    <div class="uk-flex uk-flex-middle">
                        <h5 class="mb0 ">NOTE</h5>
                    </div>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="display: none;">
                    <div class="va-container active">
                        <header>
                            <button id="add_note" title="Add new note">
                                <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                            </button>
                            <h3>Notes</h3>
                            <div class="buttons">
                                <button id="removenote" title="Delete note">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                                <button id="save" class="btn-save-note" title="Save note">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                </button>
                            </div>
                        </header>
                        <aside>
                            <span id="toggle">
                                <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                            </span>
                            <div class="search-box">
                                <i class="fa fa-search"></i>
                                <input type="text" id="search_note" placeholder="Search" />
                            </div>
                            <ul id="notelist"></ul>
                        </aside>
                        <main>
                            <textarea name="noteinput" id="noteinput" cols="50" rows="50" placeholder="Create new note"></textarea>
                        </main>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">Tháng</span>
                    <h5>Khách mới</h5>
                </div>
                <div class="ibox-content uk-flex uk-flex-middle" style="height: 116px;">
                    <div class="va-wrap">
                        <h1 class="no-margins"><?php echo round($member['present'],2) ?></h1>
                        <?php
                            $result_member = cal_percent([
                                'present' => $member['present'],
                                'ago' => $member['ago'],
                                'sum' => $memberList['member_sum'],
                            ]);
                         ?>
                        <div class="stat-percent font-bold ml10   <?php echo ($result_member < 0) ? 'text-danger' : ($result_member == 0 ? 'text-navy' : 'text-success') ?>"><?php echo $result_member ?>% <?php echo ($result_member < 0) ? '<i class="fa fa-level-down"></i>' : ($result_member == 0 ? '' : '<i class="fa fa-level-up"></i>') ?></div>
                        <small>Tỉ lệ</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">Tháng</span>
                    <h5>Đơn hàng</h5>
                </div>
                <div class="ibox-content uk-flex uk-flex-middle" style="height: 116px;">
                    <div class="va-wrap">
                        <?php
                            $result_bill = cal_percent([
                                'present' => $bill['present'],
                                'ago' => $bill['ago'],
                                'sum' => $billList['bill_sum'],
                            ]);
                         ?>
                        <h1 class="no-margins"><?php echo round($bill['present'],2) ?></h1>
                        <div class="stat-percent font-bold  ml10 <?php echo ($result_bill < 0) ? 'text-danger' : ($result_bill == 0 ? 'text-navy' : 'text-success') ?>"><?php echo $result_bill ?>% <?php echo ($result_bill < 0) ? '<i class="fa fa-level-down"></i>' : ($result_bill == 0 ? '' : '<i class="fa fa-level-up"></i>') ?></div>
                        <small>Tỉ lệ</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">Hàng Ngày</span>
                    <h5>Thống kê chung</h5>
                </div>
                <div class="ibox-content uk-flex uk-flex-middle" style="height: 116px;">
                    <div class="va-wrap" style="width: 100%;">
                        <div class="row">
                            <div class="col-md-6">
                                 <?php
                                    $result_bill_day = ($billList['bill_sum'] > 0) ? ($billList['bill_day'] / $billList['bill_sum'] * 100) : 0;
                                 ?>
                                <h1 class="no-margins"><?php echo round($billList['bill_day'],2) ?></h1>
                                <div class="font-bold <?php echo ($result_bill_day < 0) ? 'text-danger' : ($result_bill_day == 0 ? '' : 'text-navy') ?>"><?php echo round($result_bill_day,2) ?>% <?php echo ($result_bill_day < 0) ? '<i class="fa fa-level-down"></i>' : ($result_bill_day == 0 ? '' : '<i class="fa fa-level-up"></i>') ?> <small>Tổng đơn hàng</small></div>
                            </div>
                            <div class="col-md-6">
                                <?php
                                    $result_member_day = (($memberList['member_sum'] > 0) ? ($memberList['member_day'] / $memberList['member_sum'] * 100) : 0);
                                 ?>
                                <h1 class="no-margins"><?php echo round($memberList['member_day'],2) ?></h1>
                                <div class="font-bold <?php echo ($result_member_day < 0) ? 'text-danger' : ($result_member_day == 0 ? '' : 'text-navy') ?>"><?php echo round($result_member_day,2) ?>% <?php echo ($result_member_day < 0) ? '<i class="fa fa-level-down"></i>' : ($result_member_day == 0 ? '' : '<i class="fa fa-level-up"></i>') ?></i> <small>Tổng khách hàng</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Biểu đồ khách hàng mới</h5>
                    <div class="ibox-tools">
                        <span class="label label-primary">Cập nhật <?php echo date('d-m-Y') ?></span>
                    </div>
                </div>
                <div class="ibox-content no-padding">
                    <div>
                        <canvas id="lineChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div>
                        <span class="pull-right text-right">
                            <small>Giá trị trung bình của doanh số bán hàng tại: <strong>Việt Nam</strong></small>
                            <br />
                            Tổng số đơn hàng: [<?php echo $billList['bill_sum'] ?>]
                        </span>
                        <h3 class="font-bold no-margins">
                            Biểu đồ doanh thu
                        </h3>
                        <small>Marketing.</small>
                    </div>

                    <div class="m-t-sm">
                        <div class="row">
                            <div class="col-md-8">
                                <div>
                                    <canvas id="billChart" height="182" width="453" style="display: block;"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <ul class="stat-list m-t-lg">
                                    <li>
                                        <h2 class="no-margins"><?php echo $bill['present'] ?></h2>
                                        <small>Tổng số đơn hàng trong tháng</small>
                                        <div class="progress progress-mini">
                                            <div class="progress-bar" style="width: <?php echo ($billList['bill_sum'] > 0) ? ($bill['present'] / $billList['bill_sum'] * 100) : 0 ?>%;"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <h2 class="no-margins"><?php echo $bill['ago'] ?></h2>
                                        <small>Tổng số đơn hàng tháng cuối cùng</small>
                                        <div class="progress progress-mini">
                                            <div class="progress-bar" style="width: <?php echo ($billList['bill_sum'] > 0) ? ($bill['ago'] / $billList['bill_sum'] * 100) : 0 ?>%;"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="m-t-md">
                        <small class="pull-right">
                            <i class="fa fa-clock-o"> </i>
                            Cập nhật lúc <?php echo date('d-m-Y H:i:s') ?>
                        </small>
                        <?php
                            $key_bill = count($billList['total']) - 2;
                         ?>
                        <small> <strong>Phân tích doanh số:</strong> Doanh số tháng cuối cùng đạt <span class="text-success"><?php echo (($billList['total'][$key_bill] != '' || $billList['total'][$key_bill] != 0) ? number_format(check_isset($billList['total'][$key_bill]),0,',','.') : '0') ?> vnđ</span>. </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">Update ngày <?php echo date('d-m-Y') ?></span>
                    <h5>Danh sách quản trị viên</h5>
                </div>
                <div class="va-wrap-user">
                    <?php if(isset($userList) && is_array($userList) && count($userList)){
                        $count_user = 1;
                        foreach ($userList as $key => $value) {
                    ?>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-xs-2">
                                    <div class="text-center">
                                        <small class="stats-label">Avatar</small>
                                        <div class="wrap-img-user">
                                            <a href="<?php echo base_url('backend/user/user/update/'.$value['id']) ?>"
                                                class="img-cover img-user-dashboard" title="<?php echo $value['fullname'] ?>">
                                                <img src="<?php echo (isset($value['image']) && $value['image'] != '' ? $value['image'] : 'public/not-found.png') ?>" alt="<?php echo $value['fullname'] ?>" >
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="text-center">
                                        <small class="stats-label">Họ và tên</small>
                                        <h4 style="margin-top: 10px"><?php echo $value['fullname'] ?></h4>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="text-center">
                                        <small class="stats-label">Chức vụ</small>
                                        <h4 style="margin-top: 10px"><?php echo $value['title'] ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php $count_user++;}} ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách đơn hàng</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="" class="form-search mb20" method="">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input class="form-control active" type="text" name="daterange" value="<?php echo (isset($_GET['daterange']) && $_GET['daterange'] != '' ? $_GET['daterange'] : '') ?>" autocomplete="off" placeholder="Chọn thời gian">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="Tìm kiếm đơn hàng" name="keyword" class="input-sm form-control" /> <span class="input-group-btn"> <button type="submit" class="btn btn-primary mb0 btn-sm">Tìm kiếm</button> </span>
                                </div>
                            </div>
                        </div>
                </form>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Mã Đơn</th>
                                    <th>Họ Tên</th>
                                    <th class="text-center">Điện thoại</th>
                                    <th>Email</th>
                                    <th>Địa chỉ</th>
                                    <th class="text-center">SL</th>
                                    <th class="text-center" style="width: 100px;">Ngày đặt</th>
                                    <th class="text-center">Tình trạng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($billListDetail) && is_array($billListDetail) && count($billListDetail)){
                                    foreach ($billListDetail as $key => $value) {
                                ?>
                                    <tr>
                                        <td class="text-center">
                                            <a type="button" href="<?php echo base_url('backend/bill/bill/detail/'.$value['id']) ?>" class="btn btn-success "><?php echo $value['bill_id'] ?></a>
                                        </td>
                                        <td>
                                            <?php echo $value['fullname'] ?>
                                        </td>
                                        <td class="text-center"><?php echo $value['phone'] ?></td>
                                        <td><?php echo $value['email'] ?></td>
                                        <td>
                                            <div class="text-of-x" style="width: 180px;">
                                                <?php echo $value['address'] ?>
                                            </div>
                                        </td>
                                        <td class="text-center"><?php echo $value['quantity'] ?></td>
                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($value['created_at'])) ?></td>
                                        <?php
                                            $status =  ($value['status'] == 0) ? '<span class="text-small btn btn-danger">Chờ giao hàng</span>' : '<span class="text-small btn btn-primary">Thành công</span>';
                                         ?>
                                        <td class="text-center text-status-bill" >
                                            <?php echo $status ?>
                                        </td>
                                    </tr>
                                <?php }}else{ ?>
                                    <tr>
                                        <td colspan="100%"><span class="text-danger"><?php echo translate('cms_lang.post.empty', $language) ?></span></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div id="pagination">
                            <?php echo (isset($pagination)) ? $pagination : ''; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php
        $month = [];
        if(isset($cycle) && is_array($cycle) && count($cycle)){
            foreach ($cycle as $key => $value) {
                $month[] = $value['month'];
            }
        }
    ?>
<script src="public/backend/js/plugins/chartJs/Chart.min.js"></script>
<script src="public/backend/js/plugins/flot/jquery.flot.js"></script>
<script>
    $(document).ready(function() {
        var barOptions = {
            tooltips: {
              callbacks: {
                    label: function(tooltipItem, data) {
                        var value = tooltipItem.yLabel;
                        value = value.toString();
                        value = value.split(/(?=(?:...)*$)/);
                        value = value.join('.');
                        return value;
                    }
              } // end callbacks:
            }, //end tooltips
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        userCallback: function(value, index, values) {
                            // Convert the number to a string and splite the string every 3 charaters from the end
                            value = value.toString();
                            value = value.split(/(?=(?:...)*$)/);
                            value = value.join('.');
                            return value;
                        }
                    }
                }],
                xAxes: [{
                    ticks: {
                    }
                }]
            }
        };

        // Line chart
        <?php $month_list = base64_encode(json_encode($month)) ?>
        <?php $member_list = base64_encode(json_encode($memberList['member'])) ?>
        let month = JSON.parse(atob("<?php echo $month_list ?>"));
        let memberList = JSON.parse(atob("<?php echo $member_list ?>"));
        var lineData = {
            labels: month,
            datasets: [
                {
                    label: "Số lượng",
                    backgroundColor: 'rgba(26,179,148,0.5)',
                    borderColor: "rgba(26,179,148,1)",
                    pointBackgroundColor: "rgba(26,179,148,1)",
                    pointBorderColor: "#fff",
                    data: memberList
                }
            ]
        };

        var ctx = document.getElementById("lineChart").getContext("2d");
        new Chart(ctx, {type: 'line', data: lineData});
        // chart
        <?php $bill_total = base64_encode(json_encode($billList['total'])) ?>
        let billTotal = JSON.parse(atob("<?php echo $bill_total ?>"));
        var barData = {
            labels: month,
            datasets: [
                {
                    label: "Tổng tiền",
                    backgroundColor: 'rgba(26,179,148,0.5)',
                    borderColor: "rgba(26,179,148,1)",
                    pointBackgroundColor: "rgba(26,179,148,1)",
                    pointBorderColor: "#fff",
                    data: billTotal
                }
            ]
        };

        var ctx2 = document.getElementById("billChart").getContext("2d");
        var chartProfit = new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});
    });
</script>
