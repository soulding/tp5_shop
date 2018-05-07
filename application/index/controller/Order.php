<?php

/**
 * @Author				: dzy
 * @QQ    				: 1069288356
 * @Date  				: 2018-04-15 18:18:27
 * @Last Modified by	: dzy
 * @Last Modified time	: 2018-05-02 15:11:14
 */
namespace app\index\controller;
use think\Controller;
class Order extends Controller
{
    protected $goodsModel = '';
	protected $orderModel = '';
    protected $categorys = '';  
	protected $syssets = '';	
	public function _initialize()
    {
        auto_renewal_token();
        $this->goodsModel = model('goods');
        $this->orderModel = model('order');
        $this->categorys = model('category')->get_all();
        $this->syssets = model('sysset')->get_one(['id'=>1]);
    }
    public function index()
    {
    	$data = input('post.orderdata');
        $orderdata  = json_decode($data);
        $allprice = 0;
        $goodlist = [];
        foreach($orderdata as $k=>$v)
        {
            $allprice += $this->goodsModel->getField(['id'=>$k] ,'price') * $v;

            $temp['title'] = $this->goodsModel->getField(['id'=>$k] ,'title');
            $temp['total'] = $v;
            $temp['price'] = $this->goodsModel->getField(['id'=>$k] ,'price');
            $goodlist[] = $temp;
            unset($temp);
        }
        $realprice = $allprice;
        return $this->fetch('',[
            'allprice'  => $allprice,
            'realprice' => $realprice,
            'goodlist'  => $goodlist,
            'ordersn'   => createNo('CG'),
            'goodsdata' => $data

        ]);
    }

    public function orderList()
    {
        $uid = decrypt(session('userid'));
        $orderstatus0 = $this->orderModel->get_all(['user_id' => $uid,'status' => 0]);
        $orderstatus1 = $this->orderModel->get_all(['user_id' => $uid,'status' => 1]);
        $orderstatus2 = $this->orderModel->get_all(['user_id' => $uid,'status' => 2]);
        $orderstatus_1 = $this->orderModel->get_all(['user_id' => $uid,'status' => -1]);
        return $this->fetch('',[
            'orderstatus0' => $orderstatus0,
            'orderstatus1' => $orderstatus1,
            'orderstatus_1' => $orderstatus_1,
            'orderstatus2' => $orderstatus2,
            'syssets'   =>$this->syssets
        ]);
    }

    public function create()
    {
        $param = [
            'user_id' => 'userid',
            'table_id' => 'tableid',
            'ordersn' => 'ordersn',
            'goodsdata' => 'goodsdata'
        ];
    	$data = $this->buildParam($param);
        $order = $this->orderModel->get_one(['ordersn'=>$data['ordersn']]);
        if(empty($order)){
            $orderdata  = json_decode($data['goodsdata']);
            $realprice = 0;
            foreach($orderdata as $k=>$v)
            {
                $realprice += $this->goodsModel->getField(['id'=>$k] ,'price') * $v;
            }
            $data['price'] = $realprice;
            $data['status'] = 0;
            $data['createtime'] = time();
            $this->orderModel->add($data);
            $orderid = $this->orderModel->id;
        }else{
            $data = $order;
            $orderid = $data['id'];
        }
    	
    	return $this->fetch('',[
            'realprice' =>  $data['price'],
            'ordersn'   =>  $data['ordersn'],
            'orderid'   =>  $orderid

        ]);
    }
    public function cancel()
    {
        $ordersn = $this->request->param('ordersn');
        
        $order = $this->orderModel->get_one(['ordersn'=>$ordersn]);
        if(empty($order))
        {
            return show_json(1,'订单不存在');
        }else{
            $this->orderModel->update_order(['status' => -1],['ordersn'=>$ordersn]);
            return show_json(0,'已取消',url('order/orderList'));
        }

    }
    public function payOrder()
    {
        if($this->request->isPost())
        {
            $orderid = input('post.orderid');
            $order = $this->orderModel->get_one(['id'=>$orderid]);
            if(empty($order))
            {
                return show_json(1,'订单不存在');
            }
            $orderdata  = json_decode($order['goodsdata']);
            $realprice = 0;
            foreach($orderdata as $k=>$v)
            {
                $realprice += $this->goodsModel->getField(['id'=>$k] ,'price') * $v;
            }
            //此处计算出realprice用来对接支付，传入金额，但是暂时忽略            
            $this->orderModel->update_order(['status'=>1],['id' => $orderid]);
            return show_json(0,'支付成功',url('index/index'));

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