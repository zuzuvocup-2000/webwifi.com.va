<?php 
	helper('mydatafrontend');
	$widget['data'] = widget_frontend();
 ?>
<!DOCTYPE html>
<html lang="vi-VN">
	<head>
		<!-- CONFIG -->
		<base href="<?php echo BASE_URL ?>" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="robots" content="index,follow" />
		<meta name="author" content="<?php echo (isset($general['homepage_company'])) ? $general['homepage_company'] : ''; ?>" />
		<meta name="copyright" content="<?php echo (isset($general['homepage_company'])) ? $general['homepage_company'] : ''; ?>" />
		<meta http-equiv="refresh" content="1800" />
		<link rel="icon" href="<?php echo $general['homepage_favicon'] ?>" type="image/png" sizes="30x30">
		<!-- GOOGLE -->
		<title><?php echo isset($meta_title)?htmlspecialchars($meta_title):'';?></title>
		<meta name="description"  content="<?php echo isset($meta_description)?htmlspecialchars($meta_description):'';?>" />
		<?php echo isset($canonical)?'<link rel="canonical" href="'.$canonical.'" />':'';?>
		<meta property="og:locale" content="vi_VN" />

		<!-- for Facebook -->
		<meta property="og:title" content="<?php echo (isset($meta_title) && !empty($meta_title))?htmlspecialchars($meta_title):'';?>" />
		<meta property="og:type" content="<?php echo (isset($og_type) && $og_type != '') ? $og_type : 'article'; ?>" />
		<meta property="og:image" content="<?php echo (isset($meta_image) && !empty($meta_image)) ? $meta_image : base_url(isset($general['homepage_logo']) ? $general['homepage_logo'] : ''); ?>" />
		<?php echo isset($canonical)?'<meta property="og:url" content="'.$canonical.'" />':'';?>
		<meta property="og:description" content="<?php echo (isset($meta_description) && !empty($meta_description))?htmlspecialchars($meta_description):'';?>" />
		<meta property="og:site_name" content="<?php echo (isset($general['homepage_company'])) ? $general['homepage_company'] : ''; ?>" />
		<meta property="fb:admins" content=""/>
		<meta property="fb:app_id" content="" />
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:title" content="<?php echo isset($meta_title)?htmlspecialchars($meta_title):'';?>" />
		<meta name="twitter:description" content="<?php echo (isset($meta_description) && !empty($meta_description))?htmlspecialchars($meta_description):'';?>" />
		<meta name="twitter:image" content="<?php echo (isset($meta_image) && !empty($meta_image))?$meta_image:base_url((isset($general['homepage_logo'])) ? $general['homepage_logo']  : '');?>" />


		<link href="public/frontend/resources/fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" />
		<link href="public/frontend/resources/uikit/css/uikit.modify.css" rel="stylesheet" />
		<link href="public/frontend/resources/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
		<link href="public/frontend/resources/library/css/toastr/toastr.min.css" rel="stylesheet" />
		<link href="public/frontend/resources/library/css/general.css" rel="stylesheet" />
		<link href="public/frontend/resources/library/css/carousel.css" rel="stylesheet" />
		<?php echo view('mobile/homepage/common/style', $widget) ?>


		<?php echo view('mobile/homepage/common/head') ?>
		<link href="public/frontend/resources/style.css" rel="stylesheet" />
		<script src="public/frontend/resources/library/js/jquery.js"></script>
		<script src="public/frontend/resources/uikit/js/uikit.min.js"></script>
		<script type="text/javascript">
	        var BASE_URL = '<?php echo BASE_URL; ?>';
	        var SUFFIX = '<?php echo HTSUFFIX; ?>';
	    </script>
		<?php echo $general['analytic_google_analytic'] ?>
		<?php echo $general['facebook_facebook_pixel'] ?>
	</head>
	<body>

		<?php echo view('mobile/homepage/common/schema') ?>
		<?php echo view('mobile/homepage/common/header') ?>
		<?php echo view((isset($template)) ? $template : '') ?>
		<?php echo view('mobile/homepage/common/footer') ?>
		<?php echo view('mobile/homepage/common/offcanvas') ?>


		<!-- Tao Widget -->

		<?php 
			foreach ($widget['data'] as $key => $value) {
				echo  str_replace("[phone]", isset($general['contact_phone']) ? $general['contact_phone'] : '', $value['html']);
				echo '<script>'.$value['script'].'</script>';
			}
		?>

		<script src="public/frontend/resources/plugins/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
		<script src="public/frontend/resources/uikit/js/components/slideshow.min.js"></script>
		<script src="public/frontend/resources/uikit/js/components/sticky.min.js"></script>
		<script src="public/frontend/resources/plugins/select2/dist/js/select2.min.js"></script>
		<script src="public/frontend/resources/library/js/toastr/toastr.min.js"></script>
		<script src="public/frontend/resources/plugins/jquery.countdown.min.js"></script>
		<script src="public/frontend/resources/plugins/sweetalert.min.js"></script>
		<script src="public/frontend/resources/plugins/jquery.countdown.min.js"></script>
		<script src="public/frontend/resources/plugins/timeago.js"></script>
		<script src="public/frontend/resources/plugins/jquery_scroll_loading.js"></script>
		<script src="public/frontend/resources/uikit/js/components/accordion.min.js"></script>

		<script src="public/frontend/resources/function.js"></script>
		<script src="public/frontend/resources/plugins.js"></script>
	</body>
</html>
