layui.define(['jquery','datatable', 'common'], function(exports){
    "use strict";
    var $ = layui.jquery,common = layui.common;

    var DT = function(){
        this.config = {
            lang: {
                sProcessing: "处理中...",
                sLengthMenu: "每页 _MENU_ 项",
                sZeroRecords: "没有匹配结果",
                sInfo: "当前显示第 _START_ 至 _END_ 项，共 _TOTAL_ 项。",
                sInfoEmpty: "当前显示第 0 至 0 项，共 0 项",
                sInfoFiltered: "(由 _MAX_ 项结果过滤)",
                sInfoPostFix: "",
                sSearch: "本地搜索：",
                sUrl: "",
                sEmptyTable: "暂无数据",
                sLoadingRecords: "载入中...",
                sInfoThousands: ",",
                oPaginate:{
                    sFirst: "首页",
                    sPrevious: "上页",
                    sNext: "下页",
                    sLast: "末页",
                    sJump: "跳转"
                },
                oAria: {
                    sSortAscending: ": 以升序排列此列",
                    sSortDescending: ": 以降序排列此列"
                }
            },
            serverSide: true,
            processing: true,
            ajax: undefined,
            columns: undefined,
            elem: undefined,
            aTargets: undefined
        }
    };

    DT.prototype.render = function() {
        var _that = this;
        var _config = _that.config;
        if(_config.elem === undefined) {
            common.throwError('datatables error:请为datatables配置Table ID.')
        }
        if(_config.ajax === undefined) {
            common.throwError('datatables error:请为datatables配置数据源.')
        }
        if(_config.columns === undefined) {
            common.throwError('datatables error:请为datatables配置列信息.')
        }

        if(_config.aTargets === undefined) {
            _config.aTargets = [];
        }

        $('#' + _config.elem).dataTable({
            language: _config.lang,
            serverSide: _config.serverSide,
            processing: _config.processing,
            ajax: _config.ajax,
            aoColumnDefs:[{
                orderable: false,
                aTargets: _config.aTargets
            }],
            columns:_config.columns
        })
    };

    DT.prototype.set = function(options) {
        var that = this;
        $.extend(true, that.config, options);
        return that;
    };

    var datatables = new DT();

    exports('datatables',function(options){
        return datatables.set(options);
    })
});