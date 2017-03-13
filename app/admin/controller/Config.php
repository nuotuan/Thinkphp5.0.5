<?php
/**
 * Config.php
 * 配置管理
 * @author SONG
 * 2017-1-6 9:30
 *
 */
namespace app\admin\controller;

class Config extends Base{
	
	protected $lang ;
	
	public function _initialize(){
		parent::_initialize();
		$this->lang = lang( 'config' ) ;
		$this->assign( 'lang' , $this->lang ) ;
	}
	
    //配置管理列表
    public function index(){
    	$search 	= 	input( 'search' );
    	$where		= 	'' ;
    	if( !empty( $search ) ){
    		$where = [ 'name|title' => [ 'like' , '%'.$search.'%' ] ] ;
    	}
    	$data = model( 'Config' )->where( $where )->paginate( config( 'PAGES_NUM' ) );
    	// 获取分页显示
    	$page = $data->render();
    	//分页信息提示
    	$page_msg = lang( 'page_msg' , [ $data->total() , $data->currentPage() , $data->lastPage() ] );
    	
    	$this->assign( 'page', $page );
    	$this->assign( 'page_msg' , $page_msg ) ;
    	$this->assign( 'data' , $data ) ;
        return view( 'index' );
    }

    //列表添加
    public function configAdd(){
        if( request ()->isPost() ){
            $params = request()->post();
            //验证字段
            $result = $this->validate($params, 'Config');
            $result !== true && $this->error( $result ) ;
            
            $data = model( 'Config' )->allowField( true )->save( $params );
            cache('DB_CONFIG_DATA',null);
            empty( $data ) ? $this->error( $this->lang[ 'add_error' ] ) : $this->success( $this->lang[ 'add_success' ] , url( 'admin/Config/index' ) ) ;
            exit();
        }
        return view( 'edit' );
    }

    //列表编辑
    public function configEdit( $id ){
        if( request()->isPost() ){
            $params = request()->post();
            //字段验证
            $result = $this->validate( $params, 'Config' );
            $result !== true && $this->error( $result ) ;

            $data = model( 'Config' )->save( $params , [ 'id' => $params[ 'id' ] ] );
            cache( 'DB_CONFIG_DATA' , null );
            empty( $data ) ? $this->error( $this->lang[ 'edit_error' ] ) : $this->success( $this->lang[ 'edit_success' ] , url( 'admin/Config/index' ) ) ;
            exit();
        }
        
        $info = model( 'Config' )->where( [ 'id' => $id ] )->find();
        empty( $info ) && $this->error( 'parameter_error' ) ;
        
        return view( 'edit' , array( 'info' => $info ) );
    }

    //列表删除
    public function configDel( $id ){
        empty( $id ) && $this->error( $this->lang[ 'parameter_error' ] ) ;
        $result = model( 'Config' )->where( [ 'id' => $id ] )->delete();
        cache('DB_CONFIG_DATA',null);
        empty( $result ) ? $this->error( $this->lang[ 'del_error' ] ) : $this->success( $this->lang[ 'del_success' ] , url( 'admin/Config/index' ) ) ;
    }
}


