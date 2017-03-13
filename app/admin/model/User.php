<?php
/**
 * User.php
 * 后台用户表
 * @author SONG
 * 2017-2-21 16:25
 */
namespace app\admin\model;

use think\Model;

class User extends Model{
    protected $autoWriteTimestamp = true;

    protected $createTime = 'reg_time';

    protected $updateTime = 'last_login_time';

    protected $auto = [ 'reg_ip' , 'last_login_ip' ];

    protected function setRegIpAttr(){
        return request()->ip( 0 );
    }

    protected function setLastLoginIpAttr(){
        return request()->ip( 0 );
    }

    protected function setPasswordAttr( $value ){
        return md5( sha1( $value ) );
    }

    protected function getStatusAttr( $value ){
        $status = [ 0 => '禁用' , 1 => '正常' ];
        return $status[ $value ];
    }

    public function lists( $status = 1 , $order = 'uid DESC' , $field = true ){
        $map = array( 'status' => $status );
        return $this->where( $map )->column( $field )->order( $order )->select();
    }

    public function login( $uid ){
        /* 检测是否在当前应用注册 */
        $user = $this->get($uid);
        if( !$user || '正常' != $user[ 'status' ] ) {
            $this->error = '用户不存在或已被禁用！'; //应用级别禁用
            return false;
        }

        /* 登录用户 */
        $this->autoLogin($user);
        return true;
    }

    public function logout(){
        session( 'user_auth' , null );
        session( 'user_auth_sign' , null );
    }

    private function autoLogin($user){
        /* 更新登录信息 */
        $data = array(
            'login'           				=> 	array('exp', '`login`+1'),
            'last_login_time' 		=> 	time(),
            'last_login_ip'   			=> 	request()->ip(),
        	'last_login_address'	=>	get_ip_address( request()->ip() )
        );
        $this->save( $data ,[ 'uid' => $user[ 'uid' ] ] );

        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             			=> 	$user[ 'uid' ] ,
            'username'        	=> 	$user[ 'nickname' ] ,
            'last_login_time' 	=> 	$user[ 'last_login_time' ] ,
        	'auth'					=>	$user[ 'auth' ] ,
        );
        
        session( 'user_auth' , $auth );
        session( 'user_auth_sign' , data_auth_sign( $auth ) );
    }
}



