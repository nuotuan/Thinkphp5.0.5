<?php
/**
 * Auth.php
 *权限管理
 * @author SONG
 * 2017-3-31 10:44
 *
 */
namespace app\admin\controller;

class Auth extends Base{
	
	protected $lang ;
	
	public function _initialize(){
		parent::_initialize();
		$this->lang = lang( 'auth' ) ;
		$this->assign( 'lang' , $this->lang ) ;
	}
	
	//权限管理列表
    public function index(){
        $search 	= 	input( 'search' );
    	$where		= 	'' ;
    	if( !empty( $search ) ){
    		$where = [ 'title' => [ 'like' , '%'.$search.'%' ] ] ;
    	}
    	$data = db( 'Auth' )->where( $where )->paginate( config( 'PAGES_NUM' ) );
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
    public function authAjax(){
    	if( request()->isAjax() ){
    		$params = request()->get();
    		empty( $params[ 'id' ] ) && $this->error( $this->lang[ 'parameter_error' ] );
    		$params[ 'status' ] = empty( $params[ 'status' ] ) ? 0 : 1 ;
    		$result = db( 'auth' )->where( 'id' , $params[ 'id' ] )->update( [ 'status' => $params[ 'status' ] ] );
    		empty( $result ) ? $this->error( $this->lang[ 'check_error' ] ) : $this->success( $this->lang[ 'check_success' ] );
    	}
    }
    
    //添加权限分组
    public function authAdd(){
        if( request()->isPost() ){
            $params = request()->post();
            empty( $params[ 'title' ] ) && $this->error( $this->lang[ 'input_title' ] );
            empty( $params[ 'auth' ] ) && $this->error( $this->lang[ 'check_auth' ] );
            $params[ 'status' ] = isset( $params[ 'status' ] ) ? 1 : 0;
            $params[ 'auth' ] = implode( $params[ 'auth' ] , ',' );
            $result = db( 'Auth' )->insert( $params );
            empty( $result ) ? $this->error( $this->lang[ 'add_error' ] ) : $this->success( $this->lang[ 'add_success' ] , url( 'admin/Auth/index' ) );
            exit();
        }
        $menu = $this->menu();
        $this->assign( 'menu' , $menu );
        return view('edit');
    }

    //编辑权限分组
    public function authEdit( $id ){
        if( request()->isPost() ){
            $params = request()->post();
            empty( $params[ 'title' ] ) && $this->error( $this->lang[ 'input_title' ] );
            empty( $params[ 'auth' ] ) && $this->error( $this->lang[ 'check_auth' ] );
            $params[ 'status' ] = isset( $params[ 'status' ] ) ? 1 : 0;
            $params['auth'] = implode( $params[ 'auth' ] , ',' );
            $result = db( 'Auth' )->update( $params );
            $url = url( 'admin/Auth/index' ) ;
            $result || $result === 0 ? $this->success( $this->lang[ 'edit_success' ] , $url ) : $this->error( $this->lang[ 'edit_error' ] );
            exit();
        }
        $info = db( 'Auth ')->where( [ 'id' => $id ] )->find();
        empty( $info ) && $this->error( 'parameter_error' ) ;
        $menu = $this->menu();
        $this->assign( 'menu' , $menu );
        $this->assign( 'info' , $info );
        return view( 'edit' );
    }

    //删除权限分组
    public function authDel( $id ){
        empty( $id ) && $this->error( 'parameter_error' ) ;
        $result = db( 'Auth' )->where( [ 'id' => $id ] )->delete();
       	empty( $result ) ? $this->error( $this->lang[ 'del_error' ] ) : $this->success( $this->lang[ 'del_success' ] , url( 'admin/Auth/index' ) ) ;
    }
    
    /**
     * 菜单分类树
     * @return Ambigous <multitype:array, multitype:multitype:array >
     */
    protected function menu(){
    	$menu 	= 	db( 'Menu' )->order( 'sort' , 'asc' )->select();
    	$menu	=	children( $menu );
    	return $menu ;
    }

}