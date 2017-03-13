<?php
/**
 * Model.php
 *
 * @author rexsea
 * 2017-1-18 15:50
 *
 */
namespace app\admin\validate;

use think\Validate;
class Model extends Validate
{
    protected $rule = [
        'name' => 'require|unique:model|regex:/^[a-zA-Z]\w{0,39}$/',
        'title' => 'require|length:1,30'
    ];

    protected $message = [
        'name.require' => '标识不能为空',
        'name.unique'  => '标识已经存在',
        'name.regex'   => '文档标识不合法',
        'title.require' => '标题不能为空',
        'title.length' => '标题长度不能超过30个字符'
    ];

    protected $scene = [
        'add'  => ['name','title'],
        'edit' => ['name.require','name.regex','title']
    ];
}