<?php
/**
 * Menu.php
 * 菜单管理
 * @author SONG
 * 2017-2-22 10:09
 *
 */
namespace app\admin\controller;

class Menu extends Base{
	
	protected $lang ;
	
	public function _initialize(){
		parent::_initialize();
		$this->lang = lang( 'menu' ) ;
		$this->assign( 'lang' , $this->lang ) ;
	}
	
	//栏目管理列表
    public function index(){
        $data = db( 'Menu' )->order( 'sort' , 'asc' )->select();
        $data = tree( $data , 0 );
        return view( 'index' , [ 'data' => $data ] );
    }
    
    //Ajax更改状态
    public function menuAjax(){
    	if( request()->isAjax() ){
    		$params = request()->get();
    		empty( $params[ 'id' ] ) && $this->error( $this->lang[ 'parameter_error' ] );
    		$params[ 'status' ] = empty( $params[ 'status' ] ) ? 0 : 1 ;
    		$result = db( 'menu' )->where( 'id' , $params[ 'id' ] )->update( [ 'status' => $params[ 'status' ] ] );
    		empty( $result ) ? $this->error( $this->lang[ 'check_error' ] ) : $this->success( $this->lang[ 'check_success' ] );
    	}
    }

    //添加栏目
    public function menuAdd(){
        if( request()->isPost() ){
            $params = request()->post();
            empty( $params[ 'title' ] ) && $this->error( $this->lang[ 'input_title' ] );
            $params[ 'sort' ] = $params[ 'sort' ] ? $params[ 'sort' ] : 0;
            $params[ 'hide' ] = isset( $params[ 'hide' ] ) ? 1 : 0;
            $params[ 'status' ] = isset( $params[ 'status' ] ) ? 1 : 0;
            $result = db( 'Menu' )->insert( $params );
            empty( $result ) ? $this->error( $this->lang[ 'add_error' ] ) : $this->success( $this->lang[ 'add_success' ] , url('admin/Menu/index'));
        }
        $menu = db( 'Menu' )->order( 'sort' , 'asc' )->select();
        $menu = tree( $menu , 0 );
        return view( 'edit' , [ 'info' => [] , 'menu' => $menu ] );
    }

    //修改栏目
    public function menuEdit( $id ){
        if( request()->isPost() ){
            $params = request()->post();
            empty( $params[ 'title' ] ) && $this->error( lang( 'input_title' ) );
            $params[ 'sort' ] = $params[ 'sort' ] ? $params[ 'sort' ] : 0;
            $params[ 'hide' ] = isset( $params[ 'hide' ] ) ? 1 : 0;
            $params[ 'status' ] = isset( $params[ 'status' ] ) ? 1 : 0;
            $result = db('Menu')->update($params);
            $url = url('admin/Menu/index') ;
            ! empty( $result ) || $result === 0 ? $this->success( $this->lang[ 'edit_success' ] , $url ) : $this->error( $this->lang[ 'edit_error' ] );
        }
        empty( $id ) && $this->error( $this->lang[ 'parameter_error' ] );
        $info = db( 'Menu' )->where( [ 'id' => $id ] )->find();
        $menu = db( 'Menu' )->order( 'sort' , 'asc' )->select();
        $menu = tree( $menu , 0 );
        return view( 'edit' , [ 'info' => $info , 'menu' => $menu ] );
    }

    //删除栏目
    public function menuDel( $id ){
        empty( $id ) && $this->error( $this->lang[ 'parameter_error' ] );
        $children = db( 'Menu' )->where( [ 'pid' => $id ] )->count();
        if( $children > 0 ){
            $this->error( $this->lang[ 'del_menu_error' ] );
        }
        db( 'Menu' )->where( [ 'id' => $id ] )->delete();
        $this->success( $this->lang[ 'del_success' ] , url( 'admin/Menu/index' ) );
    }

}


