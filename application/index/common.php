<?php
function auto_renewal_token()
{
	if(empty(session('userid')))
	{
		header('location: ' . url('index/user/index'));
	  	exit;
	}
}
/**
 * [createNO 创建订单号]
 * @param  [type] $table  [description]
 * @param  [type] $field  [description]
 * @param  [type] $prefix [description]
 * @return [type]         [description]
    function createNO($table, $field, $prefix)
 */
function createNO($prefix)
{
	$billno = date('YmdHis') . random(6, true);
	/*while (1) {
		$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_' . $table) . ' where ' . $field . '=:billno limit 1', array(':billno' => $billno));

		if ($count <= 0) {
			break;
		}

		$billno = date('YmdHis') . random(6, true);
	}*/
	return $prefix . $billno;
}

