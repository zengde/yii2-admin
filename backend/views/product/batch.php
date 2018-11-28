<?php

use yii\helpers\Html;

?>
<div class="admin-main">
    <fieldset class="layui-elem-field">
        <legend>产品列表</legend>
        <div class="layui-field-box">
            <table class="display layui-table table-hover" id="example" cellspacing="0">
                <thead>
                <tr>
                    <th width="40">#</th>
                    <th>产品名称</th>
                    <th>价格</th>
                    <th>规格</th>
                    <th>类别</th>
                </tr>
                </thead>
            </table>
        </div>
    </fieldset>
</div>
<?=Html::jsFile('@web/plugins/DataTables/js/jquery.dataTables.min.js')?>
<?=Html::jsFile('@web/js/dataTables.zh-cn.js')?>
<?=Html::cssFile('@web/plugins/DataTables/css/jquery.dataTables.min.css')?>
<?=Html::jsFile('@web/plugins/DataTables/ext/select/dataTables.select.min.js')?>
<?=Html::cssFile('@web/plugins/DataTables/ext/select/select.dataTables.min.css')?>
<?=Html::jsFile('@web/plugins/DataTables/ext/buttons/dataTables.buttons.min.js')?>
<?=Html::cssFile('@web/plugins/DataTables/ext/buttons/buttons.dataTables.min.css')?>
<?=Html::jsFile('@web/plugins/DataTables/ext/editor/dataTables.editor.min.js')?>
<?=Html::cssFile('@web/plugins/DataTables/ext/editor/editor.dataTables.min.css')?>
<?=Html::jsFile('@web/js/dataTables.editor.zh-cn.js')?>
<script>
    var cat_list = <?=\yii\helpers\Json::htmlEncode($cats)?>;
    function list_tree_option(datas,selected,level) {
        var res=[];
        for(var i in datas){
            data=datas[i];
            str=level>0? Array(level).fill("    ")+'├─':'';
            res.push({label:str+data.name,value:data.id});
            if(data.children){
                res=res.concat(list_tree_option(data.children,selected,level+1))
            }
        }
        return res;
    }
    var cat_tree_options=list_tree_option(cat_list,0,0);

    var editor; // use a global for the submit and return data rendering in the examples

    $(document).ready(function() {
        editor = new $.fn.dataTable.Editor( {
            ajax: commonurl+"batch-update",
            idSrc:  'id',
            table: "#example",
            fields: [ {
                label: "产品名称:",
                name: "name"
            }, {
                label: "价格:",
                name: "price"
            }, {
                label: "规格:",
                name: "lwh"
            },{
                label: "类别:",
                name: "catid",
                type:  "select",
                options: cat_tree_options
            }
            ]
        } );
        // Activate an inline edit on click of a table cell
        $('#example').on( 'click', 'tbody td:not(:first-child)', function (e) {
            //console.log('1')
            editor.inline( this, {
                onBlur: 'submit'
            } );
        } );
        //TODO select blur并td click时出现dataTables.editor.min.js:444 Uncaught TypeError: Cannot read property 'contents' of undefined
        $('#example').on('focus change click blur','.DTE_Inline_Field select',function (e) {
            e.stopPropagation();
        });

        $('#example').DataTable( {
            processing: true,
            serverSide: true,
            dom: "Bfrtip",
            ajax:{
                url:commonurl+'batch-list',
                type: "POST"
            },
            columns: [
                {
                    data: null,
                    defaultContent: '',
                    className: 'select-checkbox',
                    orderable: false
                },
                { data: "name" },
                { data: "price", render: $.fn.dataTable.render.number( ',', '.', 0, 'Y' ) },
                { data: "lwh" },
                { data: "catid",render:function ( data, type, row ) {
                    return row.catname;
                } }
            ],
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
            buttons: [
                { extend: "edit",   editor: editor },
                { extend: "remove", editor: editor }
            ]
        } );
    } );
</script>
