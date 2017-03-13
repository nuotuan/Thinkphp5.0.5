<?php
/**
 * User.php
 *用户管理
 * @author SONG
 * 2017-2-22 16:19
 * 
 */
namespace app\admin\controller;

class User extends Base{

	protected $lang ;
	
	public function _initialize(){
		parent::_initialize();
		$this->lang = lang( 'user' ) ;
		$this->assign( 'lang' , $this->lang ) ;
	}
	
	//用户列表管理
    public function index(){
        $search 	= 	input( 'search' );
    	$where		= 	'' ;
    	if( !empty( $search ) ){
    		$where = [ 'nickname|email' => [ 'like' , '%'.$search.'%' ] ] ;
    	}
    	$data = model( 'User' )->where( $where )->paginate( config( 'PAGES_NUM' ) );
    	// 获取分页显示
    	$page = $data->render();
    	//分页信息提示
    	$page_msg = lang( 'page_msg' , [ $data->total() , $data->currentPage() , $data->lastPage() ] );

    	$this->assign( 'page', $page );
    	$this->assign( 'page_msg' , $page_msg ) ;
    	$this->assign( 'data' , $data ) ;
        return view( 'index' );
    }
    
    //Ajax更改状态
    public function userAjax(){
    	if( request()->isAjax() ){
    		$params = request()->get();
    		empty( $params[ 'uid' ] ) && $this->error( $this->lang[ 'parameter_error' ] );
    		$params[ 'status' ] = empty( $params[ 'status' ] ) ? 0 : 1 ;
    		$result = db( 'user' )->where( 'uid' , $params[ 'uid' ] )->update( [ 'status' => $params[ 'status' ] ] );
    		empty( $result ) ? $this->error( $this->lang[ 'check_error' ] ) : $this->success( $this->lang[ 'check_success' ] );
    	}
    }

    //添加用户
    public function userAdd(){
        if( request()->isPost() ){
            $params = request()->post();
            $params[ 'status' ] = isset( $params[ 'status' ] ) ? 1 : 0;
            //字段验证
            $result = $this->validate( $params , 'User' );
            $result !== true && $this->error( $result ) ;
            
            $data = model( 'User' )->allowField( true )->save( $params );
            empty( $data ) ? $this->error( $this->lang[ 'add_error' ] ) : $this->success( $this->lang[ 'add_success' ] , url( 'admin/User/index' ) ) ;
            exit();
        }
        $auth = db('Auth')->select();
        return view('edit',['auth'=>$auth]);
    }

    //编辑用户信息
    public function userEdit( $uid ){
    	$this->checkUser( $uid ) ;
        if( request()->isPost() ){
            $params = request()->post();
            $params[ 'status' ] = isset( $params[ 'status' ] ) ? 1 : 0;
            //字段验证
            $result = $this->validate( $params , 'User.edit' );
            $result !== true && $this->error( $result ) ;
            $data = model( 'User' )->save( $params , [ 'uid' => $params[ 'uid' ] ] );
            empty( $data ) ? $this->error( $this->lang[ 'edit_error' ] ) : $this->success( $this->lang[ 'edit_success' ] , url( 'admin/User/index' ) ) ;
            exit();
        }
        $info = model('User')->where( [ 'uid' => $uid ] )->find();
        empty( $info ) && $this->error( 'parameter_error' ) ;
        $auth = db( 'Auth' )->select();
        return view( 'edit' ,[ 'info' => $info , 'auth' => $auth ] );
    }
    
    //修改密码
    public function userPwd( $uid ){
		$this->checkUser( $uid ) ;
    	if( request()->isPost() ){
    		$params = request()->post();
    		$password = model( 'User' )->where( [ 'uid' => $params[ 'uid' ] ] )->field( 'password' )->find();
    		
    		if( $password[ 'password' ] != md5( sha1( $params[ 'oldpassword' ] ) ) ){
    			$this->error( $this->lang[ 'old_pwd_no' ] ) ;
    		}
    		//字段验证
            $result = $this->validate( $params , 'User.pwd' );
            $result !== true && $this->error( $result ) ;
            
    		unset( $params[ 'oldpassword' ] );
    		unset( $params[ 'repassword' ] );

    		//字段验证
    		$data = model( 'User' )->save( $params , [ 'uid' => $params[ 'uid' ] ] );
    		empty( $data ) ? $this->error( $this->lang[ 'pwd_error' ] ) : $this->success( $this->lang[ 'pwd_success' ] , url( 'admin/User/index' ) ) ;
    		exit();
    	}
    	$info = model('User')->where( [ 'uid' => $uid ] )->find();
    	empty( $info ) && $this->error( 'parameter_error' ) ;
    	$auth = db( 'Auth' )->select();
    	return view( 'pwd' ,[ 'info' => $info , 'auth' => $auth ] );
    }

    //删除用户
    public function userDel( $uid ){
    	$this->checkUser( $uid ) ;
    	$uid == 1 && $this->error( $this->lang[ 'admin_no_del' ] ) ;
        empty( $uid ) && $this->error( $this->lang[ 'parameter_error' ] ) ;
        $result = model('User')->where( ['uid' => $uid ] )->delete();
        empty( $result ) ? $this->error( $this->lang[ 'del_error' ] ) : $this->success( $this->lang[ 'del_success' ] , url( 'admin/User/index' ) ) ;
    }
    
    /**
     * 用户权限限制
     * @param $uid
     */
    private function checkUser( $uid ){
    	if( $uid == 1 && IS_ROOT == FALSE ){
    		$this->error( lang( 'unauthorized' ) ) ;
    	}
    }
    
}



