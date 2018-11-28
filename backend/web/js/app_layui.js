if(typeof cuslayerconfig==='undefined'){
    cuslayerconfig={};
}

layui.config({
    base: weburl+'js/'
});

layui.use(['layer'], function() {
    var $ = layui.jquery,
        layer = parent.layer === undefined ? layui.layer : parent.layer;

    $('a.btn-edit').on('click', function() {
        url=$(this).attr('href');
        title=$(this).attr('title');
        $.get(url, null, function(content) {
            layer.open($.extend({
                type: 1,
                btn: ['保存', '取消'],
                area: ['700px', '710px'],
                maxmin: true,
                yes: function(index) {
                    ajaxform_file(top.$('.form-ajax'),function(json){
                        if(json.status==1){
                            layer.close(index);
                            location.reload();
                        }else{
                            layer.alert(json.info, {icon: 5});
                        }
                    });
                },
                full: function(elem) {
                    var win = window.top === window.self ? window : parent.window;
                    $(win).on('resize', function() {
                        var $this = $(this);
                        elem.width($this.width()).height($this.height()).css({
                            top: 0,
                            left: 0
                        });
                        elem.children('div.layui-layer-content').height($this.height() - 95);
                    });

                },
                success: function(layero, index){
                    top.layui.use(['form'],function(){
                        var form = top.layui.form();
                        form.render();
                    });
                }
            },{title:title,content:content},cuslayerconfig));
        });
        return false;
    });
    $('a[data-opt="del"]').on('click', function() {
        url=$(this).attr('href');
        msg=$(this).data('confirm')? $(this).data('confirm'):'确定要删除吗?';
        layer.confirm(msg, {icon: 5, title:'提示'}, function(index){
            $.get(url,null,function(data){
                location.reload();
            });
            layer.close(index);
        });
        return false;
    });

    $('.site-table tbody tr,.layui-table tbody tr').on('click', function(event) {
        var $this = $(this);
        if($this.hasClass('selected')){
            $this.removeClass('selected').css('background','none');
        }else{
            $this.parent().find('.selected').css('background','none').removeClass('selected');
            $this.addClass('selected').css('background','#d2d2d2')
        }
    });
});