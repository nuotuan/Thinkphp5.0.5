<?php
/**
 * User.php
 *用户信息验证
 * @author SONG
 * 2017-2-28 15:28
 *
 */
namespace app\admin\validate;

use think\Validate;

class User extends Validate{
	
    protected $rule = [
        'nickname' 		=> 	'require|max:20|unique:user' ,
        'password' 		=> 	'require' ,
        'repassword'		=>	'require|confirm:password' ,
        'email'    			=> 	'require|email|unique:user'
    ];
    
    protected $scene = [
    	'add'  	=> 	[ 'nickname' , 'password' , 'repassword' , 'email' ],
   	 	'edit'		=> 	[ 'nickname' , 'email' ] ,
   	 	'pwd'		=>	[ 'password' , 'repassword' ] ,
    ];

    protected $message = [ ];

    public function __construct(){
    	$lang = lang( 'user' ) ;
    	$this->message = [
	    	'nickname.require' 	=> 	$lang[ 'nickname_require' ],
	    	'nickname.unique'  	=> 	$lang[ 'nickname_unique' ],
	    	'nickname.max' 		=> 	$lang[ 'nickname_max' ],
	    	'password.require' 	=> 	$lang[ 'password_require' ],
	    	'repassword.require' 	=> 	$lang[ 'repassword_require' ],
	    	'repassword.confirm' => 	$lang[ 'repassword_confirm' ],
	    	'email.require' 			=> 	$lang[ 'email_require' ],
	    	'email.email' 				=> 	$lang[ 'email_email' ],
	    	'email.unique' 			=> 	$lang[ 'email_unique' ],
    	];
    }
    
}


