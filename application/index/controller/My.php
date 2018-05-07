<?php
namespace app\index\controller;
use think\Controller;
class My extends Controller
{
	protected $myModel = '';	
	public function _initialize()
    {
        
        $this->myModel = model('user');
    }
    public function index()
    {
    	$uid = decrypt(session('userid'));
    	$user = $this->myModel->get_one(['id' => $uid]);

        return $this->fetch('',[
        	'user' => $user
        ]);
    }
}
