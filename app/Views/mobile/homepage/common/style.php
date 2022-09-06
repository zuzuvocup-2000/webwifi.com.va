<style>
	<?php 
		foreach ($data as $key => $value) {
			echo htmlspecialchars_decode(html_entity_decode($value['css']),ENT_QUOTES);
		}
	 ?>
</style>