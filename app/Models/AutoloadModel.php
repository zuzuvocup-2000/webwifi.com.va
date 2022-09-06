<?php
namespace App\Models;
use CodeIgniter\Model;


class AutoloadModel extends Model{

	protected $db;
	protected $builder;


	public function __construct(){
		$this->db = \Config\Database::connect();

	}

	public function _query(string $query = ''){
		$query = $this->db->query($query);
		return $query->getResultArray();
	}

	// Hàm truy xuất dữ liệu
	public function _get_where(array $param, bool $flag = false){
		// echo 1;die();
		try{
			$this->builder = $this->db->table($param['table']);
			$param['select'] = $param['select'] ?? '*';
			$param['start'] = isset($param['start']) ? $param['start'] : 0;
			$param['where_in_field'] = isset($param['where_in_field']) ? $param['where_in_field'] : 'id';

			$this->builder->select($param['select']);
			if(isset($param['where']) && is_array($param['where']) && count($param['where'])){
				$this->builder->where($param['where']);
			}
			// $this->builder->from($param['table']);
			if(isset($param['keyword']) && !empty($param['keyword']) ){
				$this->builder->where($param['keyword']);
			}
			if(isset($param['query']) && !empty($param['query']) ){
				$this->builder->where($param['query']);
			}
			if(isset($param['group_by']) && !empty($param['group_by'])){
				$this->builder->groupBy($param['group_by']);
			}
			if(isset($param['having']) && !empty($param['having'])){
				$this->builder->having($param['having']);
			}
			if(isset($param['join']) && is_array($param['join']) && count($param['join'])){
				foreach ($param['join'] as $key => $value) {
					$this->builder->join($value[0],$value[1],$value[2]);
				}
			}
			if(isset($param['distinct']) && !empty($param['distinct'])){
				$this->builder->distinct();
			}


			if(isset($param['limit']) && $param['limit'] > 0){
				$this->builder->limit($param['limit'], $param['start']);
			}
			if(isset($param['order_by']) && !empty($param['order_by'])){
				$this->builder->orderBy($param['order_by']);
			}
			if(isset($param['where_in']) && is_array($param['where_in']) && count($param['where_in']) && isset($param['where_in_field']) && $param['where_in_field'] != ''){
				$this->builder->whereIn($param['where_in_field'], $param['where_in']);
			}
			if(isset($param['where_not_in']) && is_array($param['where_not_in']) && count($param['where_not_in']) && isset($param['where_in_field']) && $param['where_in_field'] != ''){
				$this->builder->whereNotIn($param['where_in_field'], $param['where_not_in']);
			}
			if(isset($param['count']) && $param['count'] == TRUE){
				$result = $this->builder->countAllResults();
			}else{
				if($flag == FALSE){
					$result = $this->builder->get()->getRowArray();
				}else{
					$result = $this->builder->get()->getResultArray();
				}

			}
			return $result;
		}catch(\Exception $e){
			echo '<pre>';
			pre($this->db->error());die();
		}
	}

	// Hàm Insert Dữ liệu
	public function _insert(array $param = []){
		$this->builder = $this->db->table($param['table']);
		$this->builder->insert($param['data']);
		$result = $this->db->insertID();
		return $result; // insert_id
	}

	// Hàm Update Dữ liệu
	public function _update(array $param = []){
		$this->builder = $this->db->table($param['table']);
		if(isset($param['where'])){
			$this->builder->where($param['where']);
		}

		if(isset($param['where_in']) && is_array($param['where_in']) && count($param['where_in']) && isset($param['where_in_field']) && $param['where_in_field'] != ''){
				$this->builder->whereIn($param['where_in_field'], $param['where_in']);
			}
		$this->builder->update($param['data']);
		$result = $this->db->affectedRows();
		return $result;
	}

	// Hàm xóa Dữ liệu

	public function _delete(array $param = []){
		$this->builder = $this->db->table($param['table']);
		$this->builder->where($param['where']);
		if(isset($param['where_in']) && is_array($param['where_in']) && count($param['where_in']) && isset($param['where_in_field']) && $param['where_in_field'] != ''){
				$this->builder->whereIn($param['where_in_field'], $param['where_in']);
			}
		$this->builder->delete();
		$result = $this->db->affectedRows();
		return $result;
	}

	public function delete_batch($data = ''){  // tú viết
		if(isset($data['data']) && is_array($data['data']) && count($data['data'])){
			$this->db->where_in($data['field'], $data['data']);
			$this->builder->where($data['where']);
			$this->db->delete($data['table']);
			$result = $this->db->affected_rows();
			$this->db->flush_cache();
			return $result;
		}
	}

	// Hàm Insert Nhiều bản ghi Dữ liệu
	public function _create_batch(array $param = []){
		$this->builder = $this->db->table($param['table']);
		$this->builder->insertBatch($param['data']);
		$result = $this->db->affectedRows();
		return $result;
	}
	public function _update_batch(array $param = []){
		$this->builder = $this->db->table($param['table']);
		$this->builder->updateBatch($param['data'], $param['field']);
		$result = $this->db->affectedRows();
		return $result;
	}
}
