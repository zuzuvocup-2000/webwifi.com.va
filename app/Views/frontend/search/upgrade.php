<?php 
    $model = new App\Models\AutoloadModel();
    $donvi  = $model->_get_where([
        'select' => 'id, title',
        'table' => 'member_info',
        'where' => [
            'deleted_at' => 0, 
            'type' => 'donvi'
        ],
        'order_by' => 'order asc, title asc'
    ],true);
    $donvi_list = convert_array([
        'data' => $donvi,
        'field' => 'id',
        'value' => 'title',
        'text' => 'Đơn vị',
    ]);
 ?>
<section class="update-panel">
    <div class="container-1 uk-container-center">
        <div class="update-search mb50">
            <form class="search-form mb30 uk-visible-large" method="get" action="tim-kiem.html">
    			<input type="text" value="<?php echo (isset($_GET['keyword']) ? $_GET['keyword'] : '') ?>" name="keyword" placeholder="Tìm kiếm danh bạ" class="input-text">
				<a href="<?php echo SEARCH_UPGRADE.HTSUFFIX ?>" title="Tìm kiếm nâng cao" class="upgrade-search">
  					Tìm kiếm nâng cao
				</a>
				<button class="btn-search">
  					<i class="fa fa-search" aria-hidden="true"></i>
				</button>
			</form>
        </div>
        <script>
            var cityid = '<?php echo (isset($_GET['cityid'])) ? $_GET['cityid'] : ''; ?>';
            var districtid = '<?php echo (isset($_GET['districtid'])) ? $_GET['districtid'] : ''; ?>'
            var wardid = '<?php echo (isset($_GET['wardid'])) ? $_GET['wardid'] : ''; ?>'
        </script>

        <div class="update-body">
            <header class="header">
                <h2 class="heading">
                    Tìm kiếm nâng cao
                </h2>
            </header>
            <form class="update-form" method="get" action="tim-kiem.html">
                <div class="form-row">
                    <div class="uk-grid uk-grid-large">
                        <div class="uk-width-large-1-2 uk-width-medium-1-1 uk-width-small-1-1">
                            <div class="learn-center">
                                <?php echo form_dropdown('donvi', $donvi_list, set_value('donvi'), 'class="niceSelect"  ');?>
                            </div>
                        </div>
                        <div class="uk-width-large-1-2 uk-width-medium-1-1 uk-width-small-1-1">
                            <div class="room">
                                <?php 
                                    $city = get_data(['select' => 'provinceid, name','table' => 'vn_province','order_by' => 'order desc, name asc']);
                                    $city = convert_array([
                                        'data' => $city,
                                        'field' => 'provinceid',
                                        'value' => 'name',
                                        'text' => 'Thành Phố',
                                    ]);
                                ?>
                                <?php echo form_dropdown('cityid', $city, set_value('cityid'), 'class="niceSelect"  id="city"');?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <input type="text" name="keyword" placeholder="Họ và tên" class="input-text">
                </div>
                <div class="form-row">
                    <div class="uk-grid uk-grid-large">
                        <div class="uk-width-large-1-2 uk-width-medium-1-1 uk-width-small-1-1">
                            <input type="text" name="phone" placeholder="Số điện thoại" class="input-text">
                        </div>
                        <div class="uk-width-large-1-2 uk-width-medium-1-1 uk-width-small-1-1">
                            <input type="text" name="email" placeholder="Email" class="input-text">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <input type="submit" name="" value="Tìm kiếm" class="btn-submit">
                </div>
            </form>
        </div>
       
        <div class="copy-right-panel">
            <span class="copy-right-text">
              Copy right @2021 VNPT TECHNOLOGY. All right reverved
            </span>
        </div>
    </div>
</section>