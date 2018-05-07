<?php
// 应用公共文件
/**
 * [random 生成随机字符串或数字]
 * @param  [type]  $length  [生成字符长度]
 * @param  boolean $numeric [是否生成数字字符串]
 * @return [type]           [字符串]
 */
function random($length, $numeric = FALSE)
{
	$seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
	if ($numeric) {
		$hash = '';
	} else {
		$hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
		$length--;
	}
	$max = strlen($seed) - 1;
	for ($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}
/**
 *返回json提示
 *
 */
function show_json($status = 0, $msg = '', $url = '')
{	
	$data = array(
		'error' => $status,
		'msg'	=> $msg,
		'url'	=> $url
	);
	return json($data);
}
/**
 * [encrypt aes加密]
 * @param [type]     $input [要加密的数据]
 * @param [type]     $key [加密key]
 * @return [type]       [加密后的数据]
 */
function encrypt($input, $key='dzy')
{
    $data = openssl_encrypt($input, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
    $data = base64_encode($data);
    return $data;
}
/**
 * [decrypt aes解密]
 * @param [type]     $sStr [要解密的数据]
 * @param [type]     $key [加密key]
 * @return [type]       [解密后的数据]
 */
function decrypt($sStr, $sKey='dzy')
{
    $decrypted = openssl_decrypt(base64_decode($sStr),'AES-128-ECB', $sKey, OPENSSL_RAW_DATA);
    return $decrypted;
}
/**
 * [goodsData 把序列化数据转换为字符串]
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function goodsData($data)
{
	$goodsdata  = json_decode($data);
	$str = '';
    foreach($goodsdata as $k=>$v)
    {
        $str .= model('goods')->getField(['id'=>$k] ,'title') ."x". $v." + ";
    }
    return rtrim($str,' + ');

}