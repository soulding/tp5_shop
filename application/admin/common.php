<?php
/**
 * [check_login 检测是否登录]
 * @param  [type] $id [传入session中存入的id]
 * @return [type]     [null]
 */
function check_login($id)
{
	if(session('is_hold') != 1)
	{
		$user = model('admin')->get_one(['id'=> decrypt($id)]);
		if(empty($user)){
			header('location: ' . url('/admin/account'));
	  		exit;
		}
	}
}

function show_message($status = 1,$msg = NULL){
	if($status == 0){
		echo "<script>window.onload=function(){layer.msg('".$msg."')}</script>";
	}else{
		echo "<script>window.onload=function(){layer.msg('".$msg."',function(){parent.frameElement.contentWindow.location.reload(true)})}</script>";
	}

	
}