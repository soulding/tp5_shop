<?php

/**
 * @Author				: dzy
 * @QQ    				: 1069288356
 * @Date  				: 2018-04-15 13:14:59
 * @Last Modified by	: dzy
 * @Last Modified time	: 2018-04-15 16:45:41
 */

namespace app\index\controller;

use think\Controller;
use think\Request;

class User extends Controller
{
	protected $userModel = '';
	public function _initialize()
    {
    	//auto_renewal_token();
        $this->userModel = model('user');
    }
    
    public function index()
    {
    	if($this->request->isPost())
    	{
    		$param  =   [
	            'name'  => 'mobile',
	            'pwd'   => 'pwd'
	        ];
	        $data   = $this->buildParam($param);
	        if (empty($data['name']) || !preg_match('/^1[3|4|5|7|8][0-9]\d{8}$/',$data['name'])) 
			{
				return show_json(1, '请输入正确的手机号');
			}
			$user = $this->userModel->get_one(['name' => $data['name']]);
			if(!$user)
			{
				return show_json(1, '此手机号不存在');
			}
			if($user['status'])
			{
				return show_json(1, '此手机号已封');
			}
			if(md5($data['pwd'].$user['salt']) !== $user['pwd'])
			{
				return show_json(1, '密码错误');
			}
			cookie('token', encrypt($user['name']), 7*24*3600);
			session('username',encrypt($user['name']));
        	session('userid',encrypt($user['id']));
			//cookie('token', encrypt(time()), 7*3600);
	        return show_json(0,'登录成功',url('index/index'));
    	}
        return $this->fetch();
    }
    public function reg()
    {
    	if($this->request->isPost())
    	{
    		$param  =   [
	            'name'  => 'mobile',
	            'pwd'   => 'pwd',
	            'pwd1'  => 'pwd1',
	            'code' => 'verifycode'
	        ];
	        $data   = $this->buildParam($param);
	        if (empty($data['name']) || !preg_match('/^1[3|4|5|7|8][0-9]\d{8}$/',$data['name'])) 
			{
				return show_json(1, '请输入正确的手机号');
			}
			$user = $this->userModel->get_one(['name' => $data['name']]);
			if($user)
			{
				return show_json(1, '此手机号已注册');
			}
			if(empty($data['pwd']) || !preg_match('/^[.0-9A-Za-z]{6,21}$/',$data['pwd']))
			{
				return show_json(1, '密码格式错误');
			}
			if($data['pwd'] !== $data['pwd1'])
			{
				return show_json(1, '两次密码不一致');
			}
			$salt = random(16);
			$regdata = [
				'name'		=>	$data['name'],
				'pwd'		=>	md5($data['pwd'].$salt),
				'salt'		=>	$salt,
				'status'	=>	0,
				'type'		=>	0,
				'createtime'	=> time()

			];
			$res = $this->userModel->add($regdata);
			if(!$res)
			{
				return show_json(1, '注册失败');
			}
			cookie('loginname', $regdata['name'], 600);
	        return show_json(0,'注册成功',url('index/user/index'));
    	}
    	return $this->fetch();
    }
    public function loginOut(){
        session(null);
        header('location: ' . url('/index/user'));
        exit;
    }
    public function login()
    {       
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
