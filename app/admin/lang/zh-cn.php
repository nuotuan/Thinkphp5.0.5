<?php
return [

	//分页
	'page_msg'				=>	'共 %s 条数据，第 %s 页，共 %s 页' ,
	'unauthorized'			=>	'未授权访问' ,
	
	//菜单管理
	'menu' => [
		//controller
		'input_title' 			=> 	'请输入标题！' ,
		'add_error' 			=> 	'添加失败！' ,	
		'add_success'		=>	'添加成功！' ,
		'edit_error'			=>	'编辑失败！' ,
		'edit_success'		=>	'编辑成功！' ,
		'del_error'				=> 	'删除失败！' ,
		'del_success' 		=> 	'删除成功！' ,
		'check_error'			=>	'状态更改失败！' ,
		'check_success'	=>	'状态更改成功！' ,
		'parameter_error'	=>	'参数错误！' ,
		'del_menu_error'	=> 	'此菜单还有下级数据，请先删除下级数据！' ,
		
		//view
		'menu_manage'	=>	'栏目管理' ,
		'add_column'			=>	'添加栏目' ,
		'edit_column'			=>	'编辑栏目' ,
		'top_column'			=>	'顶级栏目' ,
		'icon'						=>	'栏目图标' ,
		'url'						=>	'栏目链接' ,
		'black'					=>	'返 回' ,
		'yes'						=>	'确定'	,
		'refresh'				=>	'刷 新' ,
		'id'						=>	'ID' ,
		'column_name'		=>	'栏目名称' ,
		'column_address'	=>	'栏目地址' ,
		'sort'						=>	'排序' ,
		'status'					=>	'状态' ,
		'operate'				=>	'操作' ,
		'empty'					=>	'暂无数据' ,
		'using'					=>	'启用' ,
		'edit'						=>	'编 辑' ,
		'del'						=>	'删除' ,
		'confirm'				=> 	'删除后无法恢复，是否继续？！' ,
		'icon_placeholder' 	=> 	'支持layui、font-awesome两套字体图标' ,
	],
	
	//配置管理
	'config' => [
		//controller
		'add_success'		=>	'添加成功！' ,
		'add_error'			=>	'添加失败！' ,
		'edit_success'		=>	'修改成功！' ,
		'edit_error'			=>	'修改失败！' ,
		'del_success'		=>	'删除成功！' ,
		'del_error'				=>	'删除失败！' ,
		'parameter_error'	=>	'参数错误！' ,
		
		//validate
		'name_require'		=>	'配置标识必须填写',
		'name_unique' 		=>  	'配置标识已经存在',
		'title_require' 		=> 	'配置标题必须填写',
		
		//view
		'id'						=>	'ID' ,
		'operate'				=>	'操作' ,
		'edit'						=>	'编 辑' ,
		'del'						=> 	'删 除' ,
		'refresh' 				=> 	'刷 新' ,
		'add_config' 			=> 	'添加配置' ,
		'edit_config' 			=> 	'编辑配置' ,
		'config_manage' 	=> 	'配置管理' ,
		'config_charac'		=> 	'配置标识' , 
		'config_title' 			=> 	'配置标题' ,
		'sort' 					=> 	'排序' ,
		'value' 					=> 	'配置值' ,
		'remark' 				=> 	'配置说明' ,
		'black' 					=> 	'返 回' ,
		'refresh' 				=> 	'刷 新' ,
		'yes' 						=> 	'确 定' ,
		'search'					=>	'查 询' ,
		'input_keyword'		=>	'请输入关键字' ,
		'empty'					=> 	'暂无数据',
		'confirm'				=>	'删除后无法恢复，是否继续？！' ,
	],
	
	//用户管理
	'user' => [
		//controller
		'edit_success'		=>	'编辑成功！' ,
		'edit_error'			=>	'编辑失败！' ,
		'add_success'		=>	'添加成功！' ,
		'add_error'			=>	'添加失败！' ,
		'del_success'		=>	'删除成功！' ,
		'del_error'				=>	'删除失败！' ,
		'check_error'			=>	'状态更改失败！' ,
		'check_success'	=>	'状态更改成功！' ,
		'pwd_error'			=>	'密码修改失败！' ,
		'pwd_success'		=>	'密码修改成功！' ,
		'old_pwd_no'			=>	'原始密码不正确' ,
		'admin_no_del'		=>	'超级管理员无法被删除' ,
		'parameter_error'	=>	'参数错误！' ,
		
		
		//validate
		'nickname_require' 		=> 	'昵称必须填写' ,
		'nickname_unique'  		=> 	'昵称已经存在' ,
		'nickname_max' 			=> 	'昵称长度为1-20个字符' ,
		'password_require' 		=> 	'密码必须填写' ,
		'repassword_require' 	=> 	'确定密码必须填写' ,
		'repassword_confirm' 	=> 	'两次密码不一致' ,
		'email_require' 				=> 	'邮件必须填写' ,
		'email_email' 				=> 	'邮件格式不正确' ,
		'email_unique' 				=> 	'邮件已经被占用' ,
				
		//view
		'user_manage'		=>	'用户管理' ,
		'add_user'				=>	'添加用户' ,
		'edit_user' 			=> 	'编辑用户' ,
		'edit_pwd'				=>	'修改密码' ,
		'refresh'				=>	'刷 新' ,
		'search'					=>	'查 询' ,
		'edit'						=>	'编 辑' ,
		'del'						=>	'删 除' ,
		'black'					=>	'返 回' ,
		'yes'						=>	'确 定' ,
		'input_keyword'		=>	'请输入关键字' ,
		'uid'						=>	'UID' ,
		'email'					=>	'Email' ,
		'name'					=>	'昵称' ,
		'oldpassword'		=>	'原始密码' ,
		'password'			=>	'新密码' ,
		'not_password'		=>	'确认密码' ,
		'power'					=>	'权限' ,
		'unauth'					=>	'未授权' ,
		'enable'					=>	'启用' ,
		'last_login_time'		=>	'最后登录时间' ,
		'last_login_ip'			=>	'最后登录地址' ,
		'login_num'			=>	'登录次数' ,
		'user_status'			=>	'用户状态' ,
		'operate'				=>	'操作' ,
		'empty'					=> 	'暂无数据',
		'confirm'				=>	'删除后无法恢复，是否继续？！' ,
	] ,
	
	//权限管理
	'auth' => [
		//controller	
		'input_title' 			=> 	'请输入标题！' ,
		'check_auth'			=>	'请勾选权限' ,
		'edit_success'		=>	'编辑成功！' ,
		'edit_error'			=>	'编辑失败！' ,
		'add_success'		=>	'添加成功！' ,
		'add_error'			=>	'添加失败！' ,
		'del_success'		=>	'删除成功！' ,
		'del_error'				=>	'删除失败！' ,
		'check_error'			=>	'状态更改失败！' ,
		'check_success'	=>	'状态更改成功！' ,
		'parameter_error'	=>	'参数错误！' ,

		//view
		'auth_manage'		=>	'权限管理' ,
		'add_auth'				=>	'添加分组' ,
		'edit_auth' 			=> 	'编辑分组' ,
		'auth' 					=> 	'分配权限' ,
		'refresh'				=>	'刷 新' ,
		'search'					=>	'查 询' ,
		'edit'						=>	'编 辑' ,
		'del'						=>	'删 除' ,
		'black'					=>	'返 回' ,
		'yes'						=>	'确 定' ,
		'input_keyword'		=>	'请输入关键字' ,
		'id'						=>	'ID' ,
		'auth_name'			=>	'分组名称' ,
		'remark'				=>	'分组描述' ,
		'operate'				=>	'操作' ,
		'status'					=>	'状态' ,
		'enable'					=>	'启用' ,
		'empty'					=> 	'暂无数据',
		'confirm'				=>	'删除后无法恢复，是否继续？！' ,
	] ,
	
	
	
];






