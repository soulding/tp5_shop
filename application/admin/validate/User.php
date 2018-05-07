<?php

/**
 * @Author				: dzy
 * @QQ    				: 1069288356
 * @Date  				: 2018-03-14 21:32:47
 * @Last Modified by	: dzy
 * @Last Modified time	: 2018-04-10 09:43:36
 */
namespace app\admin\validate;
use think\Validate;
/**
* 
*/
class User extends Validate
{
	
	protected $rule = [
		['name', 'require', '用户名不能为空'],
		['pwd', 'require', '密码不能为空'],
		['captcha|验证码', 'require|captcha', '验证码不能为空|验证码错误']
	];
}