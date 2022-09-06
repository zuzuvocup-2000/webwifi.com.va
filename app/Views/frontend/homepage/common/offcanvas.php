<?php $main_nav = get_menu(array('keyword' => 'main-menu','language' => 'vi', 'output' => 'array')); ?>
<?php 
	$cookie  = [];
    if(isset($_COOKIE[AUTH.'member'])) $cookie = json_decode($_COOKIE[AUTH.'member'],TRUE);
 ?>
<div id="offcanvas" class="uk-offcanvas offcanvas">
	<div class="uk-offcanvas-bar">
		<form class="uk-search" action="<?php echo HTSEARCH.HTSUFFIX ?>" data-uk-search="{}">
		    <input class="uk-search-field" value="<?php echo (isset($_GET['keyword']) ? $_GET['keyword'] : '') ?>" type="search" name="keyword" placeholder="Tìm kiếm...">
        </form>
        <?php if(isset($main_nav['data']) && is_array($main_nav['data']) && count($main_nav['data'])) {?>
		<ul class="l1 uk-nav uk-nav-offcanvas uk-nav uk-nav-parent-icon" data-uk-nav>

			<?php foreach ($main_nav['data'] as $key => $val) { ?>
			<li class="l1 <?php echo (isset($val['children']) && is_array($val['children']) && count($val['children']))?'uk-parent uk-position-relative':''; ?>">
				<?php echo (isset($val['children']) && is_array($val['children']) && count($val['children']))?'<a href="#" title="" class="dropicon"></a>':''; ?>
				<a href="<?php echo $val['canonical']; ?>" title="<?php echo $val['title']; ?>" class="l1"><?php echo $val['title']; ?></a>
				<?php if(isset($val['children']) && is_array($val['children']) && count($val['children'])) { ?>
					<?php echo render_offcanvas($val['children']) ?>
				<?php } ?>
			</li>
			<?php } ?>
		</ul>
		<?php } ?>
	</div>
</div><!-- #offcanvas -->

<?php 
	function render_offcanvas($param = []){
		$html = '';
		if(isset($param) && is_array($param) && count($param)){
			$html = $html .'<ul class="l2 uk-nav-sub">';
				foreach ($param as $keyItem => $valItem) {
					$html = $html .'<li class="l2"><a href="'.$valItem['canonical'].'" title="'.$valItem['title'].'" class="l2">'.$valItem['title'].'</a>';
						if(isset($valItem['children']) && is_array($valItem['children']) && count($valItem['children'])) {
							$html = $html.render_offcanvas($valItem['children']);
						}
					$html = $html .'</li>';
				} 
			$html = $html .'</ul>';
		}
		return $html;
	}
 ?>
