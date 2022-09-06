<section id="body">
	<section class="index-section uk-margin-large-bottom">
		<div class="uk-container uk-container-center">
			'<div class="uk-grid uk-grid-medium margin-top-25px">
				<section class="right-panel uk-width-medium-2-3 uk-width-large-3-4 fc-push-medium-1-3 fc-push-large-1-4">
					<div class="uk-panel product-catalogue-grid uk-margin-large-bottom">
						<nav class="breadcrumb-nav fc-breadcrumb mb15">
                            <ul class="breadcrumb">
                                <li><a href="/"><i class="d-icon-home"></i></a></li>
                                <?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){
                                foreach ($breadcrumb as $value) {
                                ?>
                                <li><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a></li>
                                <?php }} ?>
                                <li><a  title="Tìm kiếm theo Tags: <?php echo isset($tag_info['title']) ? $tag_info['title'] : '' ?>">Tìm kiếm theo Tags: <?php echo isset($tag_info['title']) ? $tag_info['title'] : '' ?></a></li>
                            </ul>
                        </nav>
						<div class="fc-panel-body ">
							<div class="uk-grid uk-grid-medium fc-product-grid" data-uk-grid-match="{target:'.grid-match'}">
								 <?php if(isset($productList) && is_array($productList) && count($productList)){
                                    foreach ($productList as $value) {
                                 ?>
								<div class="uk-width-large-1-4 uk-width-medium-1-2 margin-bottom-25px ">
									<article class="fc-product uk-text-center">
										<div class="fc-product-thumb grid-match uk-margin-bottom"><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><img src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>" class="lazyload" /></a></div>
										<div class="fc-product-title uk-margin-bottom" ><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="uk-text-bold"><?php echo $value['title'] ?></a></div>
										<div class="fc-product-readmore"><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="uk-button">Chi tiết</a></div>
									</article>
								</div>
                                <?php }} ?>
								
							</div>
							<section class="fc-pagination uk-clearfix uk-margin-top ">
								<?php if(isset($pagination) && !empty($pagination)){ ?>
                                    <?php echo (isset($pagination)) ? $pagination : ''; ?>
	                            <?php } ?>  
							</div>
						</div>
						
					</section>
					<aside class="left-panel uk-width-medium-1-3 uk-width-large-1-4 fc-pull-medium-2-3 fc-pull-large-3-4">
						<?php echo view('frontend/homepage/common/asideproduct') ?>
					</aside>
				</div>
			</div>
		</section>