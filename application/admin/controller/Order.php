<?php

/**
 * @Author              : dzy
 * @QQ                  : 1069288356
 * @Date                : 2018-04-11 11:12:40
 * @Last Modified by    : dzy
 * @Last Modified time  : 2018-04-13 10:36:41
 */
namespace app\admin\controller;

use think\Controller;
class Order extends Controller
{
    protected $orderModel = ''; 
    protected $userModel = ''; 
    public function _initialize()
    {
        check_login(session('id'));
        $this->orderModel = model('order');
        $this->userModel = model('user');
    }
    public function index()
    {
        $status = input('get.status');
        $keys = trim(input('get.keys'));
        $condition = '1 ';
        if($status != '')
        {
            $condition .= ' and status ='.$status;
        }
        if(!empty($keys)){
            $condition .= ' and ordersn like "%'.$keys.'%"';
        }

        $orders = $this->orderModel->where($condition)->order('id desc')->select(); 
        
        foreach($orders as &$v)
        {
            $v['username'] = $this->userModel->getField(['id'=>$v['user_id']],'name');
        }
        unset($v); 
        return $this->fetch('',[
            'orders' => $orders
        ]);
    }
    public function switch()
    {
        if($this->request->isPost())
        {
            $id = input('post.id');
            $status = input('post.status');
            $data = [];
            $msg = '未操作';
            if($status)
            {
                $data['status'] = 2;
                $data['finishtime'] = time();
                $msg = '订单完成';
            }else{                
                $msg = '付款完成';
                $data['status'] = 1;
            }
            $this->orderModel->update_order($data,['id'=>$id]);
            return show_json(0,$msg);
        }
    }

}