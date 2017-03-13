<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author rexsea
 */
function data_auth_sign($data){
	//数据类型检测
	if(!is_array($data)){
		$data = (array)$data;
	}
	ksort($data); //排序
	$code = http_build_query($data); //url编码并生成query字符串
	$sign = sha1($code); //生成签名
	return $sign;
}

/**
 * 检测后台用户登录状态
 * @return number
 */
function is_admin_login(){
	$user = session('user_auth');
	if (empty($user)){
		return 0;
	}else{
		return session('user_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
	}
}

/**
 * 无限极分类树
 * @param $list		分类数组
 * @param $pid	顶级ID
 * @param $level	等级
 * @param $html
 * @return multitype:string
 */
function tree( &$list , $pid=0 , $level=0 , $html='　' ){
	static $tree = array();
	foreach($list as $v){
		if( $v[ 'pid' ] == $pid ){
			$v[ 'order' ] 	= 	$level;
			$level == 1 ? $_level = 0 : $_level = $level ; 
			$level >= 2 ? $_level = $level -1 : $_level ;
			$v[ 'html' ]		= 	str_repeat( $html , $_level );
			$tree[] = $v;
			tree( $list , $v[ 'id' ] , $level + 1 );
		}
	}
	return $tree;
}

/**
 * 分类树
 * @param $list		分类数组
 * @param $pid	父类ID
 * @return multitype:array
 */
function children( $list , $pid = 0 ){
	$tree = array();                         
	foreach( $list as $v){
		if( $v[ 'pid' ] == $pid ){      
			$v[ 'child' ] = children( $list , $v[ 'id' ] );
			if( $v[ 'child' ] == null ){
				unset( $v[ 'child' ] );
			}
			$tree[ ] = $v;
		}
	}
	return $tree;
}

/**
 * 权限控制分类递归显示子菜单
 * @param $list		数组
 * @return string
 */
function auth_menu_view( $list ){
	static $string ;
	foreach( $list as $vl ){
		$string 	.= '<label class="child">';
		$string 	.=	'<input class="auth_rules rules" type="checkbox" name="auth[]" value="'.$vl[ 'id' ].'"/><span>'.$vl[ 'title' ].'</span>';
		$string 	.=	'</label>';
		if( isset( $vl[ 'child' ] ) ){
			auth_menu_view( $vl[ 'child' ] );
			return $string ;
		}else{
			return $string ;
		}
	}
}

/**
 * 分类树
 * @param unknown $tree
 * @param unknown $id
 * @return multitype:
 */
function Data2Array( $tree ,$id ){
	$Tree = array();
	foreach($tree as $leaf){
		if($leaf['pid'] == $id){
			array_push($Tree,$leaf);
			foreach($tree as $l){
				if($l['pid'] == $leaf['id']){
					$Children = Data2Array($tree,$leaf['id']);
					foreach( $Children as $Child ){
						array_push($Tree,$Child);
					}
					break;
				}
			}
		}
	}
	return $Tree;
}

/**
 * 判断值是否存在于数组内
 * @param $data
 * @param $id
 * @return bool
 */
function IsChecked($data,$id) {
	if( empty($data) ) return false;
	$info = in_array($id,$data);
	if( $info ) {
		return true;
	} else {
		return false;
	}
}

/**
 * 是否为一个合法的url
 * @param string $url
 * @return boolean
 */
function is_url($url){
	if (filter_var ($url, FILTER_VALIDATE_URL )) {
		return true;
	} else {
		return false;
	}
}

/**
 * 获取权限分组名称
 * @param $id
 * @return string
 */
function AuthName( $id ){
	if( !$id ){
		return '未授权';
	}else{
		$auth = db('Auth')->where( ['id'=>$id] )->find();
		return $auth['title'];
	}
}

/**
 * 获取IP地理位置（新浪IP地址库 ）
 * @param $ip	IP地址
 * @return string
 */
function get_ip_address( $ip ){
	$opts = array( 'http' => array( 'method' => 'GET' , 'timeout' => 10 ) );
	$context = stream_context_create($opts);
	$url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$ip;
	$data = file_get_contents( $url , false , $context ) ;
	$data = json_decode( $data , true ) ;
	if( $data[ 'province' ] == $data[ 'city' ] ){
		$string = $data[ 'city' ] . ' ' . $data[ 'isp' ] ;
	}else{
		$string = $data[ 'province' ] . $data[ 'city' ] .' '. $data[ 'isp' ] ;
	}
	return $string ;
}

/**
 * 获取当前页面完整URL地址
 * @return string
 */
function get_url() {
	$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	$php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	$relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
	return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}

