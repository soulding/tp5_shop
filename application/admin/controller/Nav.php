<?php

/**
 * @Author				: dzy
 * @QQ    				: 1069288356
 * @Date  				: 2018-04-10 11:06:25
 * @Last Modified by	: dzy
 * @Last Modified time	: 2018-05-02 16:17:36
 */
namespace app\admin\controller;

use think\Controller;
class Nav extends Controller
{
	protected $navModel = '';	
	public function _initialize()
    {
        check_login(session('id'));
        $this->navModel = model('nav');
    }
    public function index()
    {    	
    	$navs = $this->navModel->get_all();
    	return $this->fetch('',[
    		'navs' => $navs
    	]);
    }
    public function add()
    {	
    	if($this->request->isPost())
		{
    		
	        $data['listorder']   = $this->request->param('listorder');
    		$file = $this->request->file('img');
    		if($file)
    		{
    			$dir = 'uploads'. DS . 'images'. DS . 'navs';
    			$info = $file->move($dir);
    			if($info)
    			{
    				$data['url'] = DS. $dir .DS. $info->getSaveName();
    			}
    			$this->navModel->add($data);
    			show_message(1,'添加成功！');
    		}else{
    			show_message(0,'添加失败！');
    		}
    		
    	}
    	
    	return $this->fetch();
    }

    public function del()
    {    
    	if($this->request->isPost())
    	{
    		$id = intval($this->request->param('id'));
    		$nav = $this->navModel->get_one(['id' => $id]);
    		if(empty($nav))
    		{
    			return show_json(1, '图片不存在');
    		}
    		$res = $this->navModel->del(['id' => $id]);
    		return show_json(0, '删除成功');
    	}
    }

    public function edit($id)
    {
    	if($this->request->isPost()){
    		$data['listorder']   = $this->request->param('listorder');
    		$file = $this->request->file('img');
    		if($file)
    		{
    			$dir = 'uploads'. DS . 'images'. DS . 'navs';
    			$info = $file->move($dir);
    			if($info)
    			{
    				$data['url'] = DS. $dir .DS. $info->getSaveName();
    			}
    		}
    		$res = $this->navModel->update_nav($data,['id'=>$id]);
    		if($res){
    			show_message(1,'修改成功！');    		
    		}else{
    			show_message(0,'修改失败！');
    		}
    	}
    	$nav = $this->navModel->get_one(['id' => $id]);
    	return $this->fetch('',[
    		'nav' => $nav
    	]);
    }
}