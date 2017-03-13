<?php
/**
 * Base.php
 * 后台基础类
 * @author SONG
 * 2017-2-22 13:59
 *
 */
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Config;

class Base extends Controller{
	//初始化
	protected  $currentUrl = '' ;
	
	public function _initialize(){
		//动态添加配置
		$config = cache( 'DB_CONFIG_DATA' );
		if( !$config ){
			$configModel = new Config();
			$config = $configModel->lists();
			cache( 'DB_CONFIG_DATA' , $config );
		}
		config( $config );
		
		if( request()->controller() != 'Login' ){
			if( !is_admin_login() ){
				$this->redirect( url( 'admin/Login/login' , '' , true , true ) );
			}
		}
		
		//判断是否为超级管理员
		session( 'user_auth.uid' ) == 1 ? define( 'IS_ROOT' , TRUE ) : define( 'IS_ROOT' , FALSE );
		
		//当前访问的URL
		$this->currentUrl = url( request()->module().'/'.request()->controller().'/'.request()->action() );	
		//用户所属权限组
		$auth 	= 	db( 'auth' )->where( [ 'id' => session( 'user_auth.auth' ) ] )->field( 'auth' )->find();
		//用户可显示的菜单
		$menu	=	db( 'menu' )->where( [ 'id' => [ 'IN' , $auth[ 'auth' ] ] ] )->select();
		//用户可访问的URL
		foreach( $menu as $vl ){
			if( ! empty( $vl[ 'url' ] ) ){
				$url[ ] = url( $vl[ 'url' ] );
			} 
		}
		
		//不受限制的URL
		$allowController = config( 'ALLOW_CONTROLLER' ) ;
		foreach( $allowController as $vl ){
			empty( $vl ) ? $allowUrl = [ ] : $allowUrl[ ] = url( $vl ) ;
		}
		
		//仅超级管理员可访问的URL
		$adminController = config( 'ALLOW_ADMIN_CONTROLLER' );
		$adminUrl = [ ];
		foreach( $adminController as $vl ){
			empty( $vl ) ? $adminUrl = [ ] : $adminUrl[ ] = url( $vl ) ;
		}
		
		if( ! in_array( $this->currentUrl  , $allowUrl ) && ! in_array( $this->currentUrl , $url ) && IS_ROOT == FALSE ){
			$this->error( lang( 'unauthorized' ) );
		}
		
		if( in_array( $this->currentUrl , $adminUrl ) && IS_ROOT == FALSE ){
			$this->error( lang( 'unauthorized' ) );
		}
		
	}
}




