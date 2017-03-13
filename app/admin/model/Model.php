<?php
/**
 * Model.php
 * @author SONG
 * 2017-2-22 10:59
 *
 */
namespace app\admin\model;

use think\Model as ThinkModel;

class Model extends ThinkModel{
    protected $autoWriteTimestamp = true;

    protected function getNeedPkAttr( $value ){
        $status = [0=>'否',1=>'是'];
        return $status[$value];
    }

    protected function getStatusAttr( $value ){
        $status = [0=>'禁用',1=>'正常'];
        return $status[$value];
    }

    protected function getCreateTimeAttr( $value ){
        return date('Y-m-d H:i:s', $value);
    }
}