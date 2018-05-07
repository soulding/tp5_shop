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
class Admin extends Controller
{
    protected $adminModel = ''; 
    public function _initialize()
    {
        check_login(session('id'));
        $this->adminModel = model('admin');
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

            $admins = $this->adminModel->where($condition)->order('id desc')->select(); 
        }else{
            $admins = $this->adminModel->get_all();
        }       
        
        return $this->fetch('',[
            'admins' => $admins
        ]);
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
            $admin = $this->adminModel->get_one(['id' => $id]);
            if(empty($admin))
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
            $this->adminModel->update_admin($updateData,['id'=>$id]);
            return show_json(0,'密码重置成功');
            
        }
        $admin = $this->adminModel->get_one(['id' => $id]);
        return $this->fetch('',[
            'admin'      => $admin
        ]);
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