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
class User extends Controller
{
    protected $userModel = ''; 
    public function _initialize()
    {
        check_login(session('id'));
        $this->userModel = model('user');
    }
    public function index()
    {
        $name = trim(input('get.name'));
        $condition = '1 ';
        if(!empty($name)){
            $condition .= ' and name like "%'.$name.'%"';
        }
        if(!empty($name))
        {

            $users = $this->userModel->where($condition)->order('id desc')->select(); 
        }else{
            $users = $this->userModel->get_all();
        }       
        
        return $this->fetch('',[
            'users' => $users
        ]);
    }
    public function switch()
    {
        if($this->request->isPost())
        {
            $id = input('post.id');
            $status = input('post.status');
            return $this->userModel->update_user(['status'=>$status],['id'=>$id]);
        }
    }

    public function add()
    {
        if($this->request->isPost())
        {
            $param  =   [
                'name'  => 'name',
                'pwd'   => 'pwd',
                'pwd1'  => 'pwd1'
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
            if(empty($data['pwd']))
            {
                return show_json(1, '密码不能为空');
            }
            if($data['pwd'] != $data['pwd1'])
            {

               return show_json(1, '两次密码不一致');
            }
            $salt = random(16);
            $addData = [
                'name'      =>  $data['name'],
                'pwd'       =>  md5($data['pwd'].$salt),
                'salt'      =>  $salt,
                'status'    =>  0,
                'type'      =>  0,
                'createtime'    => time()
            ];
            $this->userModel->add($addData);
            return show_json(0,'添加成功');
        }        
        return $this->fetch('');
    }

    public function edit($id)
    {
        if($this->request->isPost())
        {
            $param  =   [
                'pwd'   => 'pwd',
                'pwd1'  => 'pwd1'
            ];
            $data   = $this->buildParam($param);
            $user = $this->userModel->get_one(['id' => $id]);
            if(empty($user))
            {
                return show_json(1, '账号不存在');
            }
            if(empty($data['pwd']))
            {
                return show_json(1, '新密码不能为空');
            }
            if($data['pwd'] != $data['pwd1'])
            {

               return show_json(1, '两次密码不一致');
            }
            $salt = random(16);
            $updateData = [
                'pwd'       =>  md5($data['pwd'].$salt),
                'salt'      =>  $salt
            ];
            $this->userModel->update_user($updateData,['id'=>$id]);
            return show_json(0,'密码重置成功');
            
        }
        $user = $this->userModel->get_one(['id' => $id]);
        return $this->fetch('',[
            'user'      => $user
        ]);
    }
    
    public function del()
    {    
        if($this->request->isPost())
        {
            $id = intval($this->request->param('id'));
            $user = $this->userModel->get_one(['id' => $id]);
            if(empty($user))
            {
                return show_json(1, '会员不存在');
            }

            $res = $this->userModel->del(['id' => $id]);
            return show_json(0, '删除成功');
        }
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