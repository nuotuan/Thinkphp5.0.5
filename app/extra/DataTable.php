<?php
/**
 * DataTable.php
 * datatable插件类
 * @author rexsea
 * 2017-1-6 12:47
 *
 */
class DataTable
{

    private $table_id = 'datatable';

    private $table_class = 'layui-table';

    private $table_thead;

    private $order = '0,"desc"';

    private $aTargets;

    private $ajax;

    private $columns;

    private $edit_url;

    private $del_url;

    public $err_msg;

    //构造函数
    public function __construct( $config = array() )
    {

    }

    public function table_id( $table_id )
    {
        if( $table_id )
        {
            $this->table_id = $table_id;
        }
        return $this;
    }

    public function table_class( $table_class )
    {
        if( $table_class )
        {
            $this->table_class = $table_class;
        }
        return $this;
    }

    public function table_thead( $table_thead )
    {
        if( $table_thead )
        {
            $this->table_thead = $table_thead;
            return $this;
        }
        else
        {
            return $this->err_msg = '表格表头未配置！';
        }
    }

    public function order( $order )
    {
        if( $order )
        {
            $this->order = $order;
        }
        return $this;
    }

    public function aTargets( $aTargets )
    {
        if( $aTargets )
        {
            $this->aTargets = $aTargets;
        }
        return $this;
    }

    public function ajax( $ajax )
    {
        if( $ajax )
        {
            $this->ajax = $ajax;
        }
        else
        {
            $this->ajax = url( request()->module() . '/' . request()->controller() . '/ajax_'
                . strtolower( request()->controller() ) );
        }
        return $this;
    }

    public function columns( $columns, $type = 0 )
    {
        if( $type )
        {
            $this->columns = $columns;
            return $this;
        }
        else
        {
            if( is_array( $columns ) )
            {
                $col = '[';
                foreach( $columns as $v )
                {
                    $col .= '{"data":"' . $v . '","defaultContent":"null"},';
                }
                //添加修改删除
                $col .= '{"data":function(obj){return ';
                $col .= '\'<button class="layui-btn layui-btn-small" onclick="layui.dt_edit(\'+obj.id+\')">';
                $col .= '<i class="layui-icon">&#xe642;</i> 编辑</button>';
                $col .= '<button class="layui-btn layui-btn-small" onclick="layui.dt_del(\'+obj.id+\')">';
                $col .= '<i class="layui-icon">&#xe640;</i> 删除</button>\';}}';
                $col .= ']';
                $this->columns = $col;
                return $this;
            }
            else
            {
                return $this->err_msg = '默认列配置与标题对应的数据库字段名！';
            }
        }
    }

    public function edit_url( $edit_url )
    {
        if( $edit_url )
        {
            $this->edit_url = $edit_url;
        }
        return $this;
    }

    public function del_url( $del_url )
    {
        if( $del_url )
        {
            $this->del_url = $del_url;
        }
        return $this;
    }


    public function datatable()
    {
        if( empty( $this->err_msg ) )
        {
            if( empty( $this->edit_url ) )
            {
                $this->edit_url = url( request()->module() . DS . request()->controller() . DS . 'edit_'
                    . strtolower( request()->controller() ), '', false, true );
            }
            if( empty( $this->del_url ) )
            {
                $this->del_url = url( request()->module() . DS . request()->controller() . DS . 'del_'
                    . strtolower( request()->controller() ) );
            }
            $data = array(
                'table' => array(
                    'table_id'    => $this->table_id,
                    'table_class' => $this->table_class,
                    'table_thead' => $this->table_thead
                ),
                'dt' => array(
                    'order'    => $this->order,
                    'aTargets' => $this->aTargets,
                    'ajax'     => $this->ajax,
                    'columns'  => $this->columns,
                ),
                'do' => array(
                    'edit' => $this->edit_url,
                    'del'  => $this->del_url
                )
            );
            return $data;
        }
        else
        {
            abort(404, $this->err_msg);
            exit;
        }
    }

    public function ajax_data( $db_table, $params, $filed, $db_type = 'model' )
    {
        $start = isset( $params['start'] ) ? $params['start'] : 0;
        $length = isset( $params['length'] ) ? $params['length'] : config('LIST_ROWS');
        $order_name = $params['columns'][$params['order'][0]['column']]['data'];
        $order_sort = $params['order'][0]['dir'];
        if( $db_type == 'model' )
        {
            $total = model($db_table)->count();
            $db_data = model($db_table)->field( $filed)->limit($start,$length)->order($order_name,$order_sort)->select();
        }
        else
        {
            $total = db($db_table)->count();
            $db_data = db($db_table)->field( $filed)->limit($start,$length)->order($order_name,$order_sort)->select();
        }

        $data['data'] = $db_data;
        $data['total'] = $total;
        return json_encode($data);
    }
}