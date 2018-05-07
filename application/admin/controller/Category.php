<?php

/**
 * @Author				: dzy
 * @QQ    				: 1069288356
 * @Date  				: 2018-04-10 11:06:25
 * @Last Modified by	: dzy
 * @Last Modified time	: 2018-04-10 19:14:07
 */
namespace app\admin\controller;

use think\Controller;
class Category extends Controller
{
	protected $categoryModel = '';	
	public function _initialize()
    {
        check_login(session('id'));
        $this->categoryModel = model('category');
    }
    public function index()
    {    	
    	$categorys = $this->categoryModel->get_all();
    	return $this->fetch('',[
    		'categorys' => $categorys
    	]);
    }
    public function add()
    {	
    	if($this->request->isPost()){
    		$name = $this->request->param('name');
    		$listorder = $this->request->param('listorder');
    		if(empty($name))
    		{
    			return show_json(1, '分类名不能为空');
    		}
    		$category = $this->categoryModel->get_one(['name' => $name]);
    		if(!empty($category))
    		{
    			return show_json(1, '分类名已存在');
    		}
    		$data = [
    			'name' => $name
    		];
    		if(!empty($listorder))
    		{
    			$data['listorder'] = intval($listorder);
    		}
    		$this->categoryModel->add($data);
    		return show_json(0, '添加成功');
    	}
    	return $this->fetch();
    }

    public function del()
    {    
    	if($this->request->isPost())
    	{
    		$id = intval($this->request->param('id'));
    		$category = $this->categoryModel->get_one(['id' => $id]);
    		if(empty($category))
    		{
    			return show_json(1, '分类名不存在');
    		}
    		$res = $this->categoryModel->del(['id' => $id]);
    		return show_json(0, '删除成功');
    	}
    }

    public function edit($id)
    {
    	if($this->request->isPost()){
    		$name = $this->request->param('name');
    		$listorder = $this->request->param('listorder');
    		if(empty($name))
    		{
    			return show_json(1, '分类名不能为空');
    		}
    		$category = $this->categoryModel->where("id <> $id and name = '$name'")->select();    		
    		if(!empty($category))
    		{
    			return show_json(1, '分类名已存在');
    		}
    		$data = [
    			'name' => $name
    		];
    		if(!empty($listorder))
    		{
    			$data['listorder'] = intval($listorder);
    		}
    		$this->categoryModel->update_cate($data, ['id' => $id]);
    		return show_json(0, '修改成功');
    	}
    	$category = $this->categoryModel->get_one(['id' => $id]);
    	return $this->fetch('',[
    		'category' => $category
    	]);
    }
}