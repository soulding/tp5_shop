<?php

/**
 * @Author				: dzy
 * @QQ    				: 1069288356
 * @Date  				: 2018-04-11 11:12:40
 * @Last Modified by	: dzy
 * @Last Modified time	: 2018-04-13 10:36:41
 */
namespace app\admin\controller;

use think\Controller;
class Goods extends Controller
{
	protected $goodsModel = '';	
	protected $categorys = '';	
	public function _initialize()
    {
        check_login(session('id'));
        $this->goodsModel = model('goods');
        $this->categorys = model('category')->get_all();
    }
    public function index()
    {
    	$title = trim(input('get.title'));
    	$cid  = input('get.category_id');
    	$condition = '1 ';
    	if(!empty($title)){
    		$condition .= ' and title like "%'.$title.'%"';
    	}
    	if(!empty($cid)){
    		$condition .= ' and category_id = '.$cid;
    	}
    	if(!empty($title) || !empty($cid))
    	{

    		$goods = $this->goodsModel->where($condition)->order('listorder desc')->select(); 
    	}else{
    		$goods = $this->goodsModel->get_all();
    	}    	
    	
    	return $this->fetch('',[
    		'goods' => $goods,
    		'categorys' => $this->categorys
    	]);
    }
    public function switch()
    {
    	if($this->request->isPost())
		{
			$id = input('post.id');
			$status = input('post.status');
			return $this->goodsModel->update_goods(['status'=>$status],['id'=>$id]);
		}
    }

    public function add()
    {
		if($this->request->isPost())
		{
    		$param  =   [
	            'title'  		=> 'title',
	            'category_id'   => 'category_id',
	            'listorder'   	=> 'listorder',
	            'price'			=> 'price',
	            'originalprice'	=> 'originalprice'
	        ];
	        $data   = $this->buildParam($param);
    		$file = $this->request->file('img');
    		if($file)
    		{
    			$dir = 'uploads'. DS . 'images'. DS . 'goods';
    			$info = $file->move($dir);
    			if($info)
    			{
    				$data['thumb_url'] = DS. $dir .DS. $info->getSaveName();
    			}
    			$this->goodsModel->add($data);
    			show_message(1,'添加成功！');
    		}else{
    			show_message(0,'添加失败！');
    		}
    		
    	}
    	
    	return $this->fetch('',[
    		'categorys' => $this->categorys
    	]);
    }

    public function edit($id)
    {
		if($this->request->isPost())
		{
    		$param  =   [
	            'title'  		=> 'title',
	            'category_id'   => 'category_id',
	            'listorder'   	=> 'listorder',
	            'price'			=> 'price',
	            'originalprice'	=> 'originalprice'
	        ];
	        $data   = $this->buildParam($param);
    		$file = $this->request->file('img');
    		if($file)
    		{
    			$dir = 'uploads'. DS . 'images'. DS . 'goods';
    			$info = $file->move($dir);
    			if($info)
    			{
    				$data['thumb_url'] = DS. $dir .DS. $info->getSaveName();
    			}
    		}
    		$res = $this->goodsModel->update_goods($data, ['id' => $id]);
    		if($res)
    		{
    			show_message(1,'修改成功！');
    		}else{
    			show_message(0,'修改失败！');
    		}
    		
    	}
    	$good = $this->goodsModel->get_one(['id' => $id]);
    	return $this->fetch('',[
    		'categorys' => $this->categorys,
    		'good'		=> $good
    	]);
    }

    public function del()
    {    
    	if($this->request->isPost())
    	{
    		$id = intval($this->request->param('id'));
    		$good = $this->goodsModel->get_one(['id' => $id]);
    		if(empty($good))
    		{
    			return show_json(1, '商品不存在');
    		}

    		$res = $this->goodsModel->del(['id' => $id]);
    		@unlink('.'.$good['thumb_url']);
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