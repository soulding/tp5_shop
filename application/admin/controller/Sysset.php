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
class Sysset extends Controller
{
    protected $syssetModel = ''; 
    public function _initialize()
    {
        check_login(session('id'));
        $this->syssetModel = model('sysset');
    }
    public function index()
    {
        
        $syssets = $this->syssetModel->get_all();
        return $this->fetch('',[
            'syssets' => $syssets
        ]);
    }
    


    public function edit()
    {
        if($this->request->isPost())
        {
            $param  =   [
            	'id'		=> 'id',
                'title'   	=> 'title',
                'keywords'  => 'keywords',
                'desc'		=> 'desc',
                'js'		=> 'js'
            ];
            $data   = $this->buildParam($param);
            if(empty($data['title']))
            {
                return show_json(1, '餐厅名称不能为空');
            }
            if(empty($data['keywords']))
            {
                return show_json(1, '关键词不能为空');
            }
            if(empty($data['desc']))
            {
                return show_json(1, '描述不能为空');
            }
            if(empty($data['id']))
            {
            	$this->syssetModel->add($data);
            }else{
				$this->syssetModel->update_sysset($data,['id'=>$data['id']]);
            }            
            return show_json(0,'系统设置更新成功');
            
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