
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-12">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div>
                <h2>Quản Lý Widget</h2>
                <ol class="breadcrumb" style="margin-bottom:10px;">
                    <li>
                        <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Home</a>
                    </li>
                    <li class="active"><strong>Quản lý Widget</strong></li>
                </ol>
            </div>
        </div>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <form method="post" action="" class="form-horizontal box">
       <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Quản lý Widget </h5>
                    </div>
                    <div class="ibox-content">
                        <?php if(isset($widgetMatch) && is_array($widgetMatch) && count($widgetMatch)){ ?>
                            <?php foreach ($widgetMatch as $key => $val) { ?>
                                <div class="wrap-catalogue-widget" data-keyword="<?php echo $val['keyword'] ?>" data-id="<?php echo $key ?>">
                                    <div class="catalogue-widget-title">
                                        <h2 class="text-success text-bold"><?php echo $val['title'] ?></h2>
                                    </div>
                                    <div class="wrap-widget">
                                        <?php if($val['data'] != []){ ?>
                                        <div class="uk-grid uk-grid-large uk-grid-width-large-1-4 uk-clearfix">
                                            <?php foreach ($val['data'] as $keyChild => $valChild) { ?>
                                                <div class="widget-panel">
                                                    <div class="widget-body text-center" data-id="<?php echo $valChild['id'] ?>" data-keyword="<?php echo $valChild['keyword'] ?>">
                                                        <div class="widget-img mb10">
                                                            <img src="<?php echo API_WIDGET.$valChild['image'] ?>" alt="<?php echo $valChild['title'] ?>">
                                                        </div>
                                                        <div class="va_checkbox">
                                                            <label> 
                                                                <input type="checkbox" class="va-option-input" <?php echo ((isset($valChild['publish']) && $valChild['publish'] == 1)) ? 'checked' : '' ?> data-keyword="<?php echo $valChild['keyword'] ?>" data-title="<?php echo $valChild['title'] ?>" data-script="<?php echo $valChild['script'] ?>" data-css="<?php echo $valChild['css'] ?>" data-html="<?php echo $valChild['html'] ?>" value="<?php echo $valChild['id'] ?>" name="<?php echo $val['keyword'] ?>"> <i></i> 
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php }if($val['data'] == []){ ?>
                                            <div><span class="text-danger">Không có dữ liệu phù hợp...</span></div>
                                        <?php } ?>
                                    </div> 
                                    <hr>                               
                                </div>
                        <?php }} ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
