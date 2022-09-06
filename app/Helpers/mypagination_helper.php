<?php
if (! function_exists('pagination_config_bt')){
	function pagination_config_bt(array $param = [],array $config = []){

		$config['base_url'] = base_url($param['url']);
		$config['suffix'] = (!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config['per_page'] = $param['perpage'];
		$config['uri_segment'] = 5;
		$config['num_links'] = 3;
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<ul class="pagination no-margin">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a class="btn-primary">';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		return $config;


	}
}
if (! function_exists('pagination_frontend')){
	function pagination_frontend(array $param = [],array $config = [],$page = 1){

		$config['base_url'] = base_url($param['url']);
		$config['suffix'] = (!empty($_SERVER['QUERY_STRING'])?(HTSUFFIX.'?'.$_SERVER['QUERY_STRING']): HTSUFFIX);
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config['per_page'] = $param['perpage'];
		$config['cur_page'] = $page;
		$config['uri_segment'] = 2;
		$config['num_links'] = 2;
		$config['prefix'] = 'trang-';
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<ul class="pagination no-margin">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a class="btn-primary">';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		return $config;


	}
}

if (! function_exists('pagination_frontend_search')){
	function pagination_frontend_search(array $param = [],array $config = [],$page = 1,$module = ''){
		$config['base_url'] = base_url($param['url']);
		$config['suffix'] = (!empty($_SERVER['QUERY_STRING']) ? ('/'.$module.HTSUFFIX.'?'.$_SERVER['QUERY_STRING']): HTSUFFIX);
		$config['first_url'] = str_replace('/'.$module, '', $config['base_url'].$config['suffix']);
		$config['per_page'] = $param['perpage'];
		$config['cur_page'] = $page;
		$config['uri_segment'] = 2;
		$config['num_links'] = 2;
		$config['prefix'] = 'trang-';
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<ul class="pagination no-margin">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a class="btn-primary">';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		return $config;


	}
}

?>
