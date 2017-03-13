<?php
/**
 * Config.php
 * 配置模型
 * @author SONG
 * 2017-2-22 14:04
 *
 */
namespace app\admin\model;

use think\Model;

class Config extends Model{
    protected $autoWriteTimestamp = true;

    public function getTypeAttr( $value ){
        $type = config( 'CONFIG_TYPE_LIST' );
        if( $type ){
            return $type[ $value ];
        }else{
            return $value;
        }
    }

    //获取配置列表
    public function lists(){
        $map   = array( 'status' => 1 );
        $data   = $this->where( $map )->field( 'type , name , value' )->select();

        $config = array();
        if($data && is_array($data)){
            foreach ($data as $value) {
                $config[$value['name']] = $this->parse($value['type'], $value['value']);
            }
        }
        return $config;
    }

    //根据配置类型解析配置值
    private function parse($type, $value){
        switch ($type) {
            case 3: //解析数组
                $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
                if(strpos($value,':')){
                    $value  = array();
                    foreach ($array as $val) {
                        list($k, $v) = explode(':', $val);
                        $value[$k]   = $v;
                    }
                }else{
                    $value =    $array;
                }
                break;
        }
        return $value;
    }
}