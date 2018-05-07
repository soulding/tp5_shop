<?php

/**
 * @Author				: dzy
 * @QQ    				: 1069288356
 * @Date  				: 2018-04-18 11:50:26
 * @Last Modified by	: dzy
 * @Last Modified time	: 2018-04-29 11:42:48
 */
namespace app\common\model;

use think\Model;

class Order extends Model
{
    //添加数据
    public function add($data){
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
            $query->order('createtime', 'desc');
        });
    }
    public function update_order($data,$condition)
    {
    	return $this->save($data, $condition);
    }

    public function del($data)
    {
    	return $this->destroy($data);
    }
}
