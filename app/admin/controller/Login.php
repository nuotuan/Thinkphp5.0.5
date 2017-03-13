<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\User;

/**
 * Login.php
 * 后台登录注销
 * @author SONG
 * 2017-2-21 10:17
 *
 */
class Login extends Controller{
	
	//后台用户登录
    public function login(){
    	if( request()->isPost() ){
    		
    		$post = request()->post();
    		
    		$errornum = session( 'errornum' ) ;
    		if( empty( $errornum ) ){
    			$errornum = 0 ;
    			session( 'errornum' , 0 ) ;
    		}
    		if( $errornum >= 3 ){
    			if( !captcha_check( $post[ 'code' ] ) ){
    				$error[ 'error' ] = '验证码输入错误！' ;
    				$error[ 'num' ] = $errornum + 1;
    				$this->error( $error );
    			}
    		}
			
    		session( 'errornum' , $errornum + 1 ) ;
    		$error[ 'num' ] = $errornum + 1;
    		
    		if( empty( $post[ 'nickname' ] ) ){
    			$error[ 'error' ] = '请输入用户名！' ;
    			$this->error( $error );
    		}
    		if( empty( $post[ 'password' ] ) ){
    			$error[ 'error' ] = '请输入密码！' ;
    			$this->error( $error );
    		}
    	
    		$where = array( 'nickname' => $post['nickname'] , 'password' => md5( sha1( $post[ 'password' ] ) ) );
    		$userModel = new User();
    		$user = $userModel->where( $where )->find();

    		if( $user ){
    			if( $user[ 'status' ] == '正常' ){
    				if( $userModel->login( $user[ 'uid' ] ) ){
    					session( 'errornum' , null );
    					$this->success( '登录成功！', url( 'admin/Index/index' ) );
    				}else{
    					$error[ 'error' ] = '登录失败！' ;
    					$this->error( $error );
    				}
    			}else{
    				$error[ 'error' ] = '用户不存在或被禁用！' ;
    				$this->error( $error );
    			}
    		}else{
    			$error[ 'error' ] = '用户名或密码错误！' ;
    			$this->error( $error );
    		}
    	}else{
    		if( is_admin_login() ){
    			$this->redirect( url( 'admin/Index/index' ) );
    			exit;
    		}
    		if( session( 'errornum' ) >= 3 ){
    			$this->assign( 'verify' , true ) ;
    		}
    		return view();
    	}
    }
    
    //注销
    public function logout(){
    	if( is_admin_login() ){
    		$userModel = new User();
    		$userModel->logout();
    		session(null);
    		$this->success( '注销成功！', url('admin/Login/login') );
    	}else{
    		$this->redirect( url('admin/Login/login') );
    	}
    }

}
