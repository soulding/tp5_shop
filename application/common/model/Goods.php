<?php

namespace app\common\model;

use think\Model;

class Goods extends Model
{
    //添加数据
    public function add($data){
    	$data['createtime'] = time();
    	return $this->save($data);
    }
    //查询一条数据
    public function get_one($data){
        return $this->get($data);
    }

    public function getField($condition, $field){
        return $this->where($condition)->value($field);
    }

    public function get_all(){
        return $this->all(function($query){
            $query->order('listorder', 'desc');
        });
    }
    public function get_all_index(){
        return $this->all(function($query){
            $query->where('status',1)->order('listorder', 'desc');
        });
    }

    public function update_goods($data,$condition)
    {
    	return $this->save($data, $condition);
    }

    public function del($data)
    {
    	return $this->destroy($data);
    }
}
