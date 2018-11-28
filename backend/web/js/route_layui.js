layui.define(function(exports){
    var animateIcon = '<i class="fa fa-refresh fa-spin"></i>';
    var itemType='route';

    function updateRoutes(r) {
        _opts.routes.avaliable = r.avaliable.sort(function(a,b){
            a1=a.indexOf('/')===-1;
            b1=b.indexOf('/')===-1;
            return b1-a1;
        });
        _opts.routes.assigned = r.assigned;
        search('avaliable');
        search('assigned');
    }
    function updateItems(r) {
        _opts.items.avaliable = r.avaliable;
        _opts.items.assigned = r.assigned;
        searchgroup('avaliable');
        searchgroup('assigned');
    }

    function search(target) {
        var $list = $('select.list[data-target="' + target + '"]');
        $list.html('');
        var q = $('.search[data-target="' + target + '"]').val();
        $.each(_opts.routes[target], function () {
            var r = this;
            if (r.indexOf(q) >= 0) {
                $('<option>').text(r).val(r).appendTo($list);
            }
        });
    }

    function searchgroup(target) {
        var $list = $('select.list[data-target="' + target + '"]');
        $list.html('');
        var q = $('.search[data-target="' + target + '"]').val();

        var groups = {
            role: [$('<optgroup label="角色">'), false],
            permission: [$('<optgroup label="权限">'), false]
        };
        $.each(_opts.items[target], function (name, group) {
            if (name.indexOf(q) >= 0) {
                $('<option>').text(name).val(name).appendTo(groups[group][0]);
                groups[group][1] = true;
            }
        });
        $.each(groups, function () {
            if (this[1]) {
                $list.append(this[0]);
            }
        });
    }

    var api = {
        init: function(str){
            itemType=(typeof str==='undefined')? 'route':str;
            if(itemType==='route'){
                _opts.routes.avaliable = _opts.routes.avaliable.sort(function(a,b){
                    a1=a.indexOf('/')===-1;
                    b1=b.indexOf('/')===-1;
                    return b1-a1;
                });
                search('avaliable');
                search('assigned');
            }else{
                searchgroup('avaliable');
                searchgroup('assigned');
            }

            $('.btn-assign').on('click',function () {
                var $this = $(this);
                var html = $this.html();
                var target = $this.data('target');
                var routes = $('select.list[data-target="' + target + '"]').val();
                if (routes && routes.length) {
                    $this.addClass('layui-btn-disabled').html(animateIcon);
                    $.post($this.data('href'), {routes: routes}, function (r) {
                        if(itemType==='route')
                            updateRoutes(r.data);
                        else
                            updateItems(r.data);
                    }).always(function () {
                        $this.removeClass('layui-btn-disabled').html(html);
                    });
                }
                return false;
            });

            $('.search[data-target]').on('keyup',function () {
                search($(this).data('target'));
            });
        }
    };

    exports('route_layui', api);
});  