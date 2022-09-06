<?php
	$model = new App\Models\AutoloadModel();
	$cookie  = [];
    if(isset($_COOKIE[AUTH.'member'])) $cookie = json_decode($_COOKIE[AUTH.'member'],TRUE);
?>
<?php
	if(isset($cookie['check_promotion']) && $cookie['check_promotion'] == 0){
		$promotion  = $model->_get_where([
			'select' => 'title, image',
			'table' => 'promotion',
			'where' => [
				'publish' => 1,
				'deleted_at' => 0,
				'login' => 1,
			],
		]);
?>
<?php if(isset($promotion) && is_array($promotion) && count($promotion)){ ?>
	<div id="popup_01" class="uk-modal">
		<form action="" method="post" class="uk-form form loading" id="">
			<div class="uk-modal-dialog" style="padding: 0; width: 650px; margin: 50px auto auto auto;">
				<a class="uk-modal-close uk-close">
					<i class="fa fa-times"></i>
				</a>
				<div class="modal-content dt_modal-content">
					<div class="image"><img src="<?php echo $promotion['image'] ?>" alt=""></div>
				</div>
			</div>
		</form>
	</div>

	<script>
		var time = 3*60*1000;

		$(window).load(function(){
			var date = new Date();
			date.setTime(date.getTime() + (1440 * 60 * 1000));
			if ( $.cookie('popup') == undefined){
	    		setTimeout(function(){
	    			show_modal(); 
	    		}, 3000);
			 	$.cookie('popup', '1', { expires: date, path: '/' });
			} 
			$('#popup_01').on({
		        'show.uk.modal': function(){

		        },
		        'hide.uk.modal': function(){
		        	circle_time(time);
		        }
		    });
		    function circle_time(time){
				setTimeout(function(){
					show_modal();
				}, time);
			}

			function show_modal(){
				var modal = UIkit.modal("#popup_01");
				modal.show();
			}
		});
	</script>
<?php }} ?>