<?php 
namespace App\Libraries;

class Nestedsetbie{
	protected $builder;
	
	function __construct($params = NULL){
		$this->params = $params;
		$this->checked = NULL;
		$this->data = NULL;
		$this->count = 0;
		$this->count_level = 0;
		$this->lft = NULL;
		$this->rgt = NULL;
		$this->level = NULL;
		$this->db = \Config\Database::connect();
	}

	public function Get($order = 'lft ASC, order ASC', $language = ''){
		$moduleExtract = explode('_', $this->params['table']);
		if($moduleExtract[0] == 'menu' && $language != ''){
			$this->params['language'] = $language;
		}
		$this->builder = $this->db->table($this->params['table'].' as tb1');	
		$this->builder->select('tb1.id, tb2.title, tb1.parentid, tb1.lft, tb1.rgt, tb1.level, tb1.order');
		$this->builder->join($moduleExtract[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.language = \''.$this->params['language'].'\' ', 'inner');
		$this->builder->orderBy($order);
		$this->builder->where(['tb1.deleted_at' => 0, 'tb2.module' => $this->params['table']]);
		$result = $this->builder->get()->getResultArray();
		$this->data = $result;

	}

	public function Set(){	
		if(isset($this->data) && is_array($this->data)){
			$arr = NULL;
			foreach($this->data as $key => $val){
				$arr[$val['id']][$val['parentid']] = 1;
				$arr[$val['parentid']][$val['id']] = 1;
			}
			return $arr;
		}
	}

	public function Recursive($start = 0, $arr = NULL){
		$this->lft[$start] = ++$this->count;
		$this->level[$start] = $this->count_level;
		if(isset($arr) && is_array($arr)){
			foreach($arr as $key => $val){
				if((isset($arr[$start][$key]) || isset($arr[$key][$start])) &&(!isset($this->checked[$key][$start]) && !isset($this->checked[$start][$key]))){
					$this->count_level++;
					$this->checked[$start][$key] = 1;
					$this->checked[$key][$start] = 1;
					$this->recursive($key, $arr);
					$this->count_level--;
				}
			}
		}
		$this->rgt[$start] = ++$this->count;
	}

    public function Action(){
		if(isset($this->level) && is_array($this->level) && isset($this->lft) && is_array($this->lft) && isset($this->rgt) && is_array($this->rgt)){
			$data = NULL;
			foreach($this->level as $key => $val){
				$data[] = array(
					'id' => $key,
					'level' => $val,
					'lft' => $this->lft[$key],
					'rgt' => $this->rgt[$key],
				);
			}
			$this->builder = $this->db->table($this->params['table']);	
			$this->builder->updateBatch($data, 'id'); 
		}
    }

	public function Dropdown($param = NULL){
		$this->get();
		if(isset($this->data) && is_array($this->data)){
			$temp = NULL;
			$temp[0] = (isset($param['text']) && !empty($param['text']))?$param['text']:'[Root]';
			foreach($this->data as $key => $val){
				$temp[$val['id']] = str_repeat('|-----', (($val['level'] > 0)?($val['level'] - 1):0)).$val['title'];
			}
			return $temp;
		}
	}

}