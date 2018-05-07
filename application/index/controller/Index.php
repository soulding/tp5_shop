<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
	protected $goodsModel = '';	
    protected $categorys = '';  
    protected $syssets = '';    
	protected $navs = '';	
	public function _initialize()
    {
        
        $this->goodsModel = model('goods');
        $this->syssets = model('sysset')->get_one(['id'=>1]);
        $this->categorys = model('category')->get_all();
        $this->navs = model('nav')->get_all();
    }
    public function index()
    {
    	$goods = $this->goodsModel->get_all_index();
        return $this->fetch('',[
        	'goods'		=> $goods,
        	'categorys'	=> $this->categorys,
            'syssets'   =>$this->syssets,
            'navs'   =>$this->navs,
        ]);
    }
}
