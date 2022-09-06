<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <base href="<?php echo BASE_URL; ?>">
    <title>HT VIETNAM CMS 3.0 | Dashboard</title>
    <?php  
        $css = [
            ASSET_BACKEND.'css/bootstrap.min.css',
            ASSET_BACKEND.'font-awesome/css/font-awesome.css',
            ASSET_BACKEND.'css/plugins/toastr/toastr.min.css',
            ASSET_BACKEND.'js/plugins/gritter/jquery.gritter.css',
            ASSET_BACKEND.'css/animate.css',
            ASSET_BACKEND.'css/inputTags.min.css',
            ASSET_BACKEND.'plugin/select2/dist/css/select2.min.css',
            ASSET_BACKEND.'plugin/jquery-ui.css', 
            ASSET_BACKEND.'css/plugins/slick/slick.css', 
            ASSET_BACKEND.'css/plugins/slick/slick-theme.css', 
            ASSET_BACKEND.'css/style.css', 
            ASSET_BACKEND.'css/customize.css', 
            ASSET_BACKEND.'css/vastyle.css', 
            ASSET_BACKEND.'css/plugins/sweetalert/sweetalert.css', 
            ASSET_BACKEND.'css/plugins/codemirror/codemirror.css', 
            ASSET_BACKEND.'css/plugins/codemirror/ambiance.css', 
        ];
    ?>
    <?php foreach($css as $key => $val){
        echo '<link href="'.$val.'" rel="stylesheet">';
    } ?>
    <script type="text/javascript">
        var BASE_URL = '<?php echo BASE_URL; ?>';
        var SUFFIX = '<?php echo HTSUFFIX; ?>';
    </script>
</head>
<body>
    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg dashbard-1 " style="margin-left:0;">
            <?php echo view( (isset($template)) ? $template  :'' ) ?>
        </div>
    </div>
    <!-- Mainly scripts -->
    <?php  
        $script = [
            ASSET_BACKEND.'js/jquery-3.1.1.min.js',
            ASSET_BACKEND.'js/bootstrap.min.js',
            ASSET_BACKEND.'js/plugins/metisMenu/jquery.metisMenu.js',
            ASSET_BACKEND.'js/plugins/slimscroll/jquery.slimscroll.min.js',
            ASSET_BACKEND.'js/inspinia.js',
            ASSET_BACKEND.'js/plugins/pace/pace.min.js',
            ASSET_BACKEND.'js/plugins/jquery-ui/jquery-ui.min.js',
            ASSET_BACKEND.'js/plugins/gritter/jquery.gritter.min.js',
            ASSET_BACKEND.'js/plugins/sparkline/jquery.sparkline.min.js',
            ASSET_BACKEND.'js/plugins/nestable/jquery.nestable.js',
            ASSET_BACKEND.'js/demo/sparkline-demo.js',
            ASSET_BACKEND.'js/plugins/codemirror/codemirror.js',
            ASSET_BACKEND.'js/plugins/codemirror/mode/javascript/javascript.js',
            ASSET_BACKEND.'js/plugins/toastr/toastr.min.js',
            ASSET_BACKEND.'js/plugins/datapicker/bootstrap-datepicker.js',
            ASSET_BACKEND.'js/plugins/sweetalert/sweetalert.min.js',
            ASSET_BACKEND.'js/plugins/slick/slick.min.js',
            ASSET_BACKEND.'plugin/timeago.js',
            ASSET_BACKEND.'plugin/inputTags.jquery.min.js',
            ASSET_BACKEND.'plugin/ckfinder/ckfinder.js',
            ASSET_BACKEND.'plugin/ckeditor5/build/ckeditor.js',
            ASSET_BACKEND.'library/ckfinder.js',
            // ASSET_BACKEND.'plugin/ckeditor5/packages/ckeditor5-build-classic/build/ckeditor.js',
            ASSET_BACKEND.'plugin/select2/dist/js/select2.min.js',
            ASSET_BACKEND.'plugin/Select-All-Checkboxes-jQuery-checkboxAll/jquery.checkboxall-1.0.min.js',
            ASSET_BACKEND.'library/library.js',
        ];
        
        if(isset($module) && !empty($module)){
            if(file_exists(ASSET_BACKEND.'library/module/'.$module.'.js')){
                $script[count($script)+1] = ASSET_BACKEND.'library/module/'.$module.'.js';
            }
        }

        
    ?>
    <?php foreach($script as $key => $val){
        echo '<script src="'.$val.'"></script>';
    } ?>
    
  <?php echo view('backend/dashboard/common/notification') ?>
</body>
</html>


