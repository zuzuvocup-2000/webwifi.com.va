<?php
	helper('mydatafrontend');
	// $widget['data'] = widget_frontend();
	$system = get_system();
	
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


		<?php
			$check_css = false;
			foreach ($system as $key => $value) {
				if(isset($module) && $value['module'] == $module && $value['keyword'] == $module.'_css'){
					$check_css = true;
					echo $system[$value['module'].'_css']['content'];
				}
			}
			if($check_css == false){
				echo $system['normal_css']['content'];
			}

		?>

		<?php /*echo view('frontend/homepage/common/style', $widget)*/ ?>
		<?php echo $system['general_css']['content'] ?>
		<?php echo $system['general_script_top']['content'] ?>
		<script type="text/javascript">
	        var BASE_URL = '<?php echo BASE_URL; ?>';
	        var SUFFIX = '<?php echo HTSUFFIX; ?>';
	    </script>
		<?php echo $general['analytic_google_analytic'] ?>
		<?php echo $general['facebook_facebook_pixel'] ?>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
		<?php echo view('frontend/homepage/common/head') ?>
	</head>
	<body class="canhcam homepage <?php echo isset($module) ? $module.'_wrapper' : '' ?>"  onload="$('body').addClass('loaded');">
		<div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
		<?php echo view('frontend/homepage/common/schema') ?>
		<?php echo view('frontend/homepage/common/header') ?>
		<div class="page-wrapper">
			<main class="main">
				<?php echo view((isset($template)) ? $template : '') ?>
			</main>
		</div>
		<?php echo view('frontend/homepage/common/footer') ?>
		<?php /*echo view('frontend/homepage/common/offcanvas')*/ ?>
		<?php echo view('backend/dashboard/common/notification') ?>
		<!-- Tao Widget -->
		<?php
			// foreach ($widget['data'] as $key => $value) {
			// 	echo  str_replace("[phone]", isset($general['contact_phone']) ? $general['contact_phone'] : '', $value['html']);
			// 	echo '<script>'.$value['script'].'</script>';
			// }
		?>
		<?php
			$check_script = false;
			foreach ($system as $key => $value) {
				if(isset($module) && $value['module'] == $module && $value['keyword'] == $module.'_script'){
					$check_script = true;
					echo $system[$value['module'].'_script']['content'];
				}
			}
			if($check_script == false){
				echo $system['normal_script']['content'];
			}
			if(isset($module) && $module == 'member'){
	            echo ' <script src="public/frontend/resources/login.js"></script>';
	        }
		?>
		<?php echo $system['general_script_bottom']['content'] ?>
		<?php echo view('frontend/homepage/common/script') ?>
	</body>
</html>
