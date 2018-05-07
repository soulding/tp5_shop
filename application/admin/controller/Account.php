<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Account extends Controller
{
    
    public function index()
    {
        if(session('is_hold') == 1){
            header('location: ' . url('/admin'));
            exit;
        }else{
            session(null);
        }
        return $this->fetch();
    }
    public function loginOut(){
        session(null);
        header('location: ' . url('/admin/account'));
        exit;
    }
    public function login()
    {
        $online = input('post.online');        
        $param  =   [
            'name'  => 'name',
            'pwd'   => 'pwd',
            'captcha' => 'verifycode'
        ];
        $data   = $this->buildParam($param);
        $validate = validate('User');
        if(!$validate->check($data))
        {
            return show_json(1, $validate->getError());
        }
        $user   = model('admin')->get_one(['name'=> $data['name']]);
        if(empty($user))
        {
            return show_json(1, '用户名或密码错误！');
        }
        if(md5($data['pwd'].$user['salt']) !== $user['pwd'])
        {
            return show_json(1, '用户名或密码错误！');
        }
        if($online == 1){
            session('is_hold',1);
        }
        session('name',encrypt($user['name']));
        session('id',encrypt($user['id']));
        return show_json(0, '', url('/admin'));
    }
    protected function buildParam($array)
    {
        $data=[];
        if (is_array($array)){
            foreach( $array as $item=>$value ){
                $data[$item] = $this->request->param($value);
            }
        }
        return $data;
    }
    
}
