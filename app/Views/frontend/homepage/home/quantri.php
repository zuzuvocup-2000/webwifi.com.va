<?php $company = get_slide(['keyword' => 'our' , 'language' => $language, ]); ?>
<?php if(isset($company) && is_array($company) && count($company)){ ?>
	<?php 
		$first = $company[0]; unset($company[0]); 
		$count = count($company);
		$last = [];
		if(($count - 1) % 3 == 0){
			$last = $company[$count];
			unset($company[$count]);
		}
	?>

	<div class="about-us-chief">
		<div class="uk-container uk-container-center">
			<h2 class="title-blue"><?php echo $first['cat_title'] ?></h2>
			<div class="uk-grid uk-clearfix uk-grid-medium first-chief">
				<div class="uk-width-1-1">
					<div class="figure-chief">
						<div class="figure-image">
							<a >
								<img src="<?php echo $first['image'] ?>" alt="<?php echo $first['description'] ?>">
							</a>
						</div>
						<div class="figcaption">
							<h2><?php echo $first['title'] ?></h2>
							<h3><?php echo $first['description'] ?></h3>
						</div>
					</div>
				</div>
			</div>
			<?php  if(isset($company) && is_array($company) && count($company)){ ?>
				<div class="uk-grid uk-clearfix uk-grid-medium three-row">
					<?php foreach ($company as $key => $value) { ?>
						<div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-1-3">
							<div class="figure-chief">
								<div class="figure-image">
									<a >
										<img src="<?php echo $value['image'] ?>" alt="<?php echo $value['description'] ?>">
									</a>
								</div>
								<div class="figcaption">
									<h2><?php echo $value['title'] ?>
									<div id="eJOY__extension_root" class="eJOY__extension_root_class" style="all: unset;">&nbsp;</div></h2>
									<h3><?php echo $value['description'] ?></h3>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
			<?php  if(isset($last) && is_array($last) && count($last)){ ?>
				<div class="uk-grid uk-clearfix uk-grid-medium second-chief uk-flex-center">
					<div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-1-3">
						<div class="figure-chief">
							<div class="figure-image">
								<a >
									<img src="<?php echo $last['image'] ?>" alt="<?php echo $last['description'] ?>">
								</a>
							</div>
							<div class="figcaption">
								<h2><?php echo $last['title'] ?><br>
								<div id="eJOY__extension_root" class="eJOY__extension_root_class" style="all: unset;">&nbsp;</div></h2>
								<h3><?php echo $last['description'] ?></h3>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>