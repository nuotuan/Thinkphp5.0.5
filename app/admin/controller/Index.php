<?php
/**
 * Index.php
 * 后台首页
 * @author SONG
 * 2017-2-22 11:37
 *
 */
namespace app\admin\controller;

class Index extends Base{
	
    public function index(){
    	
    	//用户所属权限组
    	$auth 	= 	db( 'auth' )->where( [ 'id' => session( 'user_auth.auth' ) ] )->field( 'auth' )->find();
    	$menu 	= 	db( 'Menu' )->where( [ 'pid'=> 0 , 'id' => [ 'IN' , $auth[ 'auth' ] ] ] )->order( 'sort' , 'asc' )->select();
    	
    	foreach( $menu as $k=>$v ){
    		$menu[ $k ][ 'spreadOne' ] = true;
    		$children = db( 'Menu' )->where( [ 'pid' => $v[ 'id' ] , 'id' => [ 'IN' , $auth[ 'auth' ] ] ] )->order( 'sort' , 'asc' )->select();
    		foreach( $children as $a=>$b ){
    			$children[ $a ][ 'href' ] = url( $b['url'] );
    		}
    		$menu[ $k ][ 'children' ] = $children;
    	}
    	$this->assign( 'menu' , $menu ) ;
    	return view();
    }
    
    public function main(){
    	
    	$info = array(
    			'操作系统'					=>		PHP_OS,
    			'运行环境'					=>		$_SERVER["SERVER_SOFTWARE"],
    			'主机名'						=>		$_SERVER['SERVER_NAME'],
    			'WEB服务端口'			=>		$_SERVER['SERVER_PORT'],
    			'网站文档目录'			=>		$_SERVER["DOCUMENT_ROOT"],
    			'浏览器信息'				=>		substr($_SERVER['HTTP_USER_AGENT'], 0, 40),
    			'通信协议'					=>		$_SERVER['SERVER_PROTOCOL'],
    			'请求方法'					=>		$_SERVER['REQUEST_METHOD'],
    			'PHP版本'					=>		PHP_VERSION,
    			'ThinkPHP版本'			=>		THINK_VERSION,
    			'上传附件限制'			=>		ini_get('upload_max_filesize'),
    			'执行时间限制'			=>		ini_get('max_execution_time').'秒',
    			'运行最大内存'			=>		get_cfg_var ("memory_limit")?get_cfg_var("memory_limit"):"无" ,
    			'MySQL最大连接数'	=>		@get_cfg_var("mysql.max_links")==-1 ? "不限" : @get_cfg_var("mysql.max_links") ,
    			'服务器时间'				=>		date("Y年n月j日 H:i:s"),
    			'北京时间'					=>		gmdate("Y年n月j日 H:i:s",time()+8*3600),
    			'服务器域名/IP'			=>		$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
    			'用户的IP地址'			=>		$_SERVER['REMOTE_ADDR'],
    			'剩余空间'					=>		round((disk_free_space(".")/(1024*1024)),2).'M',
    	);

    	$this->assign( 'info' , $info );
    	
    	return view();
    }
    
    
    //获取左侧菜单
    public function left_menu(){
    	//用户所属权限组
    	$auth 	= 	db( 'auth' )->where( [ 'id' => session( 'user_auth.auth' ) ] )->field( 'auth' )->find();
    	$menu 	= 	db( 'Menu' )->where( [ 'pid'=> 0 , 'id' => [ 'IN' , $auth[ 'auth' ] ] ] )->order( 'sort' , 'asc' )->select();
    
    	foreach( $menu as $k=>$v ){
    		$menu[ $k ][ 'spreadOne' ] = true;
    		$children = db( 'Menu' )->where( [ 'pid' => $v[ 'id' ] , 'id' => [ 'IN' , $auth[ 'auth' ] ] ] )->order( 'sort' , 'asc' )->select();
    		foreach( $children as $a=>$b ){
    			$children[ $a ][ 'href' ] = url( $b['url'] );
    		}
    		$menu[ $k ][ 'children' ] = $children;
    	}

    	return json( $menu );
    }
}
