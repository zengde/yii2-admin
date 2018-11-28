$.extend( true, $.fn.dataTable.Editor.defaults, {
    'i18n':{
        create: {
            button: "添加",
            title:  "添加产品",
            submit: "提交"
        },
        edit: {
            button: "编辑",
            title:  "编辑产品",
            submit: "更新"
        },
        remove: {
            button: "删除",
            title:  "删除产品",
            submit: "删除",
            confirm: {
                _: "确定要删除 %d 个产品吗?",
                1: "确定要删除吗?"
            }
        },
        error: {
            system: "服务器错误"
        },
        datetime: {
            previous: '上一个',
            next:     '下一个',
            months:   [ '1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月' ],
            weekdays: [ '周一', '周二', '周三', '周四', '周五', '周六', '周日' ]
        }
    }
});