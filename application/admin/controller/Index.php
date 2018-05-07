<?php
/**
 * @Author              : dzy
 * @QQ                  : 1069288356
 * @Date                : 2018-03-11 17:20:28
 * @Last Modified by    : dzy
 * @Last Modified time  : 2018-04-04 17:06:44
 */
namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    public function _initialize()
    {
        check_login(session('id'));
    }
    public function index()
    {
        return $this->fetch();
    }
    public function welcome()
    {
        $cate   = db('category')->count();
        $order  = db('order')->count();
        $goods  = db('goods')->count();
        $user   = db('user')->count();
        $admin  = db('admin')->count();
        return $this->fetch('',[
            'cate'      => $cate,
            'order'     => $order,
            'goods'     => $goods,
            'user'      => $user,
            'admin'     => $admin,
        ]);
    }
}
