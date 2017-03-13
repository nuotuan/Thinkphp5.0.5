<?php
/**
 * Config.php
 *配置信息字段验证
 * @author SONG
 * 2017-2-27 14:23
 *
 */
namespace app\admin\validate;

use think\Validate;

class Config extends Validate{
	
    protected $rule = [
        'name' 	=> 	'require|unique:config',
        'title' 		=> 	'require'
    ];
    
    protected $scene = [
        'add'  	=> 	[ 'name' , 'title' ],
        'edit' 	=> 	[ 'name' , 'title' ]
    ];
    
    protected $message = [ ];
    
    public function __construct(){
    	$lang = lang( 'config' ) ;
    	$this->message = [
			'name.require' 	=> 	$lang[ 'name_require' ] ,
        	'name.unique'  	=> 	$lang[ 'name_unique' ] ,
        	'title.require' 		=> 	$lang[ 'title_require' ] ,
    	];
    }
    
}






